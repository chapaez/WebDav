<?php
namespace Uni\WebDav;

/**
 * Class WebDavFacade
 * @package Uni\WebDav
 * facade with some usefull api :)
 */
class WebDavFacade{
    /**
     * trying to add page to cache
     */
    static function addPostPage(){
        $err=false;
        try{
            WebDavController::addPage($_POST['url']);
        }catch (\Exception $e){
            $err = $e->getMessage();
        }
        if($err)
            WebDavResponse::getInstance()->printErr($err);
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
                WebDavResponse::getInstance()->printErr($e->getMessage());
            }
            $wdDb->webDavFree();
        }
    }

    /**
     * get $_POST url and recursive parameters and trying to remove cache files
     */
    static function delPostPage(){
        $err = false;
        try{
            WebDavController::delPage($_POST['url'],$_POST['recursive']);
        }catch (\Exception $e){
            $err = $e->getMessage();
        }
        if($err)
            WebDavResponse::getInstance()->printErr($err);
    }


    /**
     * get queue of urls
     * @return array
     */
    static function getUrlList(){
        return WebDavController::getUrlList();
    }
}