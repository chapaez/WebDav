<?php
namespace Uni\WebDav;
/**
 * Class WebDavApi
 */
class WebDavApi{
    /**
     * @var WebDavApi - "singleton"
     */
    private static $instance;
    private $config;

    /**
     * WebDavApi constructor.
     */
    protected function __construct()
    {
        $config = WebDavConfigurator::getInstance();
        $this->setConfig($config);
        unset($config);
    }

    /**
     * @param  $url string url - local address to webpage or file address to cache
     * @param string $task add or del
     * @param bool $recursive true if deleting folder
     */
    public function addTask($url,$task='add',$recursive=false){

        if( $curl = curl_init() ) {

            var_dump($url);
            $handle = fopen('log.tmp', 'w');
            curl_setopt($curl, CURLOPT_VERBOSE, 1);
            curl_setopt($curl, CURLOPT_STDERR, $handle);
            curl_setopt($curl, CURLOPT_URL, 'http://'.$this->getConfig()->getDomain().$this->getConfig()->getScriptFolder());
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
            curl_setopt($curl, CURLOPT_POSTFIELDS, [
                                                        "salt" => $this->getConfig()->getSalt(),
                                                        "url"  => $url,
                                                        "command" => $task,
                                                        "recursive" => $recursive
                                                   ]
                        );
            $out = curl_exec($curl);
            echo 'out=';
            echo($out);
            curl_close($curl);
            unset($out);
        }
    }

    /**
     * @return object
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param mixed $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * @return WebDavApi The *Singleton* instance.
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
}

