<?php
namespace Uni\WebDav;
/**
 * Class WebDavCli
 */
class WebDavCli extends WebDavCliBase {
    /**
     * @var WebDavCli - "singleton"
     */
    private static $instance;
    private $curl,$config;





    /**
     * WebDavCli constructor.
     */
    protected function __construct()
    {
        $this->setCurl();
        $config = WebDavConfigurator::getInstance();
        $this->setConfig($config);
        unset($config);
    }

     function __destruct()
     {
         curl_close($this->getCurl());
     }

    /**
     * Sad but mbstring.func_overload is set to 2 ((
     * @param $string
     * @return int
     */
    public function strSizeOf($string) {
        return count(preg_split("`.`", $string)) - 1 ;
    }

    /**
     * upload string to remote file
     * TODO do something with this mobile versions
     * @param $url string
     * @param bool $mobile
     * @return bool - deleted file or not
     */
    public function deleteFile($url,$mobile=false){
        $curl = $this->getCurl();
        $conf = $this->getConfig();

        curl_setopt($curl, CURLOPT_URL,$conf->getProtocol().'://'.$conf->getDomain().'/upload_wd'.$url);
        if($mobile){
            curl_setopt($curl, CURLOPT_URL,$conf->getProtocol().'://'.$conf->getDomain().'/upload_wd_mobile'.$url);
        }
        curl_setopt($curl, CURLOPT_USERPWD, $conf->getWebDavUsername() . ":" . $conf->getWebDavPassword());
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        unset($conf,$curl);
        return $httpCode[0]==2 || $httpCode==404;
    }

    /**
     * upload string to remote file
     * TODO do something with this mobile versions
     * @param $content string
     * @param $url string
     * @param bool $mobile
     * @return bool - uploaded file or not
     */
    public function uploadFile($content, $url,$mobile=false){
        $curl = $this->getCurl();
        $conf = $this->getConfig();
        echo $url;
        var_dump($mobile);
        curl_setopt($curl, CURLOPT_URL, $conf->getProtocol().'://'.$conf->getDomain().'/upload_wd'.$url.'index.html');
        if($mobile){
            curl_setopt($curl, CURLOPT_URL, $conf->getProtocol().'://'.$conf->getDomain().'/upload_wd_mobile'.$url.'index.html');
        }
        curl_setopt($curl, CURLOPT_USERPWD, $conf->getWebDavUsername() . ":" . $conf->getWebDavPassword());
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: text/html; charset=utf-8','Content-Length: ' .  mb_strlen($content, '8bit')));
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($curl, CURLOPT_POSTFIELDS,$content);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, false);
        $out = curl_exec($curl);

        var_dump($out);

        unset($conf,$curl);
        return $out;
    }

    /**
     * @return WebDavCli The *Singleton* instance.
     */
    public static function getInstance(){
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }
    /**
     * Private clone method to prevent cloning of the instance of the
     * *Singleton* instance.
     *
     * @return void
     */
    private function __clone()
    {
    }

    /**
     * Private unserialize method to prevent unserializing of the *Singleton*
     * instance.
     *
     * @return void
     */
    private function __wakeup()
    {
    }

    /**
     * @return resource
     */
    private function getCurl()
    {
        return $this->curl;
    }

    /**
     * @param string $url
     */
    private function setCurl($url = NULL)
    {
        $this->curl = curl_init($url);
    }

    /**
     * @return object
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param object $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }
}