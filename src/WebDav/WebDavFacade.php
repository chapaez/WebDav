<?php
namespace Uni\WebDav;

/**
 * Class WebDavFacade facade with some usefull api :)
 * @package Uni\WebDav
 */
class WebDavFacade{

    /**
     * @param $command
     * @param $url
     * @param bool $recursive
     */
    static function addCommand($command, $url, $recursive=false){
        if($command == 'add'){
            self::addPage($url);
        }elseif ($command == 'del'){
            self::delPage($url,$recursive);
        }else{
            WebDavResponse::getInstance()->logErr("wrong command");
        }
    }
    /**
     * * trying to add page to cache
     * @param $url
     */
    static function addPage($url){
        $err=false;
        try{
            WebDavController::addPage($url);
        }catch (\Exception $e){
            $err = $e->getMessage();
        }
        if($err)
            WebDavResponse::getInstance()->logErr($err);
    }
    /**
     * trying to add page to cache from $_post array
     */
    static function addPostPage(){
        self::addPage($_POST['url']);
    }

    /**
     * get commands from bd and make cache for them
     */
    static function doWebDav(){
        $wdDb = WebDavDBController::getInstance();
        if($wdDb->webDavStatus()!=$wdDb->getBusyStatus()) {
            $wdDb->webDavBusy();
            try {
                WebDavController::layFilesFromTable();
            } catch (\Exception $e) {
                WebDavResponse::getInstance()->logErr($e->getMessage());
            }
            $wdDb->webDavFree();
        }
    }

    /**
     * @param $url
     * @param bool $recursive
     */
    static function delPage($url, $recursive=false){
        $err = false;
        try{
            WebDavController::delPage($url,$recursive=false);
        }catch (\Exception $e){
            $err = $e->getMessage();
        }
        if($err)
            WebDavResponse::getInstance()->logErr($err);
    }

    /**
     * get $_POST url and recursive parameters and trying to remove cache files
     */
    static function delPostPage(){
        self::delPage($_POST['url'],$_POST['recursive']);
    }


    /**
     * get queue of urls
     * @return array
     */
    static function getUrlList(){
        return WebDavController::getUrlList();
    }
}