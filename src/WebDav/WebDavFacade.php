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
            if(self::addPage($url))
                WebDavResponse::getInstance()->printOk("added");
            else
                WebDavResponse::getInstance()->printErr("not added");
        }elseif ($command == 'del'){
            if(self::delPage($url,$recursive))
                WebDavResponse::getInstance()->printOk("added");
            else
                WebDavResponse::getInstance()->printErr("not added");
        }else{
            WebDavResponse::getInstance()->logErr("wrong command ".$command." url=".$url." recursive=".$recursive);
            WebDavResponse::getInstance()->printErr("wrong command");
        }
    }

    /**
     * * trying to add page to cache
     * @param $url
     * @return bool true if added and false otherwise
     */
    static function addPage($url){
        $err=false;
        try{
            WebDavController::addPage($url);
        }catch (\Exception $e){
            $err = $e->getMessage();
        }
        if($err) {
            WebDavResponse::getInstance()->logErr($err);
            return false;
        }else{
            return true;
        }
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
     * @return bool true if added and false otherwise
     */
    static function delPage($url, $recursive=false){
        $err = false;
        try{
            WebDavController::delPage($url,$recursive);
        }catch (\Exception $e){
            $err = $e->getMessage();
        }
        if($err){
            WebDavResponse::getInstance()->logErr($err);
            return false;
        }else{
            return true;
        }

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

    static function clearUrlList(){
        return WebDavController::clearUrlList();
    }
}