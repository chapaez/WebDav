<?php
namespace Uni\WebDav;
/**
 * Class WebDavResponse
 * @package Uni\WebDav
 */
class WebDavResponse{
    /**
     * @var WebDavResponse - "singleton"
     */
    protected static $instance;
    /**
     * @var
     */
    private $config;

    /**
     * WebDavResponse constructor.
     */
    protected function __construct()
    {
    }

    /**
     * @param string $type only json atm
     * @return WebDavResponse classes
     */
    public static function getInstance($type = "json"){
        switch ($type){
            case "json":
                return WebDavResponseJson::getInstanceResponse();
                break;
            default:
                return WebDavResponse::getInstanceResponse();
        }
    }

    /**
     * @return WebDavResponse The *Singleton* instance.
     */
    public static function getInstanceResponse(){
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
     * print message with err status wor
     * @param $msg
     */
    public function printErr($msg){
        switch(WebDavConfigurator::getInstance()->getStatus()){
            case "debug":
                static::printMsg($msg,'err');
            default:
                $log = new WebDavLog();
                $log->AddError($msg);
                break;
        }

    }

    /**
     * print message with ok status
     * @param $msg
     */
    public function printOk($msg){
        static::printMsg($msg,'ok');
    }

    /**
     * @param $msg
     * @param $status
     */
    public function printMsg($msg, $status){
        $msg = static::makeMsg($msg);
        $msg['status'] = $status;
        $msg = static::formateData($msg);
        echo $msg;
    }

    /**
     * make array from message to add status and other stuff
     * @param $data
     * @return array
     */
    protected function makeMsg($data){
        return ['message' => $data];
    }

    /**
     * empty gap
     * @param $data
     * @return mixed
     */
    protected function formatData($data){
        return $data;
    }
}

