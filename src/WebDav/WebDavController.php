<?php
namespace Uni\WebDav;

/**
 * Class WebDavController
 * @package Uni\WebDav
 */
class WebDavController{

    /**
     * @param url - page to be cached
     * @param bool $recursive - remove directory or file
     * @throws \Exception
     */
    static function delPage($url,$recursive=false){
        //little security check
        if(!WebDavSecurity::checkSalt())
            throw new \Exception('wrong salt');
        //do we need to cache?
        if(!WebDavUrlController::getInstance()->checkUrl($url))
            throw new \Exception('url not in list');

        if(!$recursive)
            $url.='index.html';
        //ok lets save it in DB
        WebDavDBDel::getInstance()->addUrl($url);
    }

    /**
     * @param url - page to be cached
     * @throws \Exception
     */
    static function addPage($url){
        //little security check
        if(!WebDavSecurity::checkSalt())
            throw new \Exception('wrong salt');
        //do we need to cache?
        if(!WebDavUrlController::getInstance()->checkUrl($url))
            throw new \Exception('url not in list');
        //ok lets save it in DB
        WebDavDBAdd::getInstance()->addUrl($url);
    }

    /**
     * gets remote content that we want to cache
     * @param $url
     * @param bool $mobile
     * @return string
     * @throws \Exception
     */
    static function getRemoteContent($url,$mobile = false){
        $conf = WebDavConfigurator::getInstance();
        if($mobile){
            $options  = array($conf->getProtocol() => array('user_agent' => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; BOLT/2.340) AppleWebKit/530+ (KHTML, like Gecko) Version/4.0 Safari/530.17 UNTRUSTED/1.0 3gpp-gba'));
        }else{
            $options  = array($conf->getProtocol() => array('user_agent' => 'Mozilla/5.0 (compatible; MSIE 8.0; Windows NT 6.0; SV1; Crazy Browser 9.0.04)'));
        }

        $context  = stream_context_create($options);
        $full_url = $conf->getProtocol()
                        .'://'
                        .$conf->getDomain()
                        .$url;

        if (!($file = \file_get_contents($full_url, false, $context)))
            throw new \Exception('no remote file '.$full_url.' exists');

        unset($full_url);
        return $file;
    }
//do you
    /**
     * gets url from db and send this files to front
     * TODO do something with this mobile versions
     */
    static function layFilesFromTable()
    {
        $wdDB = WebDavDBController::getInstance();
        $wdConf = WebDavConfigurator::getInstance();
        $urlArr = $wdDB->getUrlList();
        foreach ($urlArr as $urlHash) {
            $urlHashArray = explode(':', $urlHash);
            $command = $urlHashArray[0];
            $url = $urlHashArray[1];
            try {
                if ($command == $wdDB->getAddCommand()) {
                    $content = static::getRemoteContent($url);
                    if (!WebDavCli::getInstance()->uploadFile($content, $url))
                        throw new \Exception('file ' . $url . ' not uploaded');
                    if($wdConf->getMobile() && $wdConf->getMobileSameDomain()){
                        $content = static::getRemoteContent($url,true);
                        if (!WebDavCli::getInstance()->uploadFile($content, $url,true))
                            throw new \Exception('file ' . $url . ' not uploaded');
                    }
                    WebDavDBAdd::getInstance()->delUrl($url);
                }elseif($command == $wdDB->getDelCommand()){
                    if (!WebDavCli::getInstance()->deleteFile($url))
                        throw new \Exception('file ' . $url . ' not deleted');
                    if($wdConf->getMobile() && $wdConf->getMobileSameDomain()){
                        if (!WebDavCli::getInstance()->deleteFile($url,true))
                            throw new \Exception('file ' . $url . ' not deleted');
                    }
                    WebDavDBDel::getInstance()->delUrl($url);
                }
            }catch (\Exception $e){
                $log = new WebDavLog();
                $log->AddError($e->getMessage());
                unset($log);
            }
        }
        unset($urlArr,$wdDB,$content);
    }
}