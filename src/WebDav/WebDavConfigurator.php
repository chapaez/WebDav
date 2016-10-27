<?php
namespace Uni\WebDav;
    /**
     * Class WebDavConfigurator
     */
class WebDavConfigurator{
    /**
     * @var WebDavConfigurator - "singleton"
     */
    private static $instance;
    protected static $configFile= 'config.json';
    protected static $dirNameFile= 'scriptdir.json';
    public $content;
    protected $config;
    protected $wdDir;

    /**
     * @return mixed
     */
    public function getWdDir()
    {
        return $this->wdDir;
    }

    /**
     * @param mixed $wdDir
     */
    public function setWdDir($wdDir)
    {
        $this->wdDir = $wdDir;
    }

    /**
     * @return mixed
     */
    public function getSalt()
    {
        return $this->getConfig()->salt;
    }

    /**
     * @return mixed
     */
    public function getScriptFolder()
    {
        return $this->getConfig()->scriptFolder;
    }

    /**
     * @return object
     */
    public function getConfig()
    {
        return $this->getContent()->config;
    }

    /**
     * @return object
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * WebDavApi constructor.
     */
    protected function __construct()
    {
        $dir = json_decode(file_get_contents(__DIR__.'/'.self::$dirNameFile));
        $this->setWdDir($dir->dir);
        $configFileContent=file_get_contents($this->getWdDir.'/'.self::$configFile);
        $this->setContent(json_decode($configFileContent));
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getDomain(){
        return $this->getConfig()->domain;
    }

    /**
     * @return string
     */
    public function getDocumentRoot(){
        return $this->getConfig()->documentRoot;
    }

    /**
     * @return string
     */
    public function getWebDavUsername(){
        return $this->getConfig()->webDavUsername;
    }

    /**
     * @return string
     */
    public function getWebDavPassword(){
        return $this->getConfig()->webDavPassword;
    }

    /**
     * @return string
     */
    public function getLogFolder(){
        return $this->getConfig()->logFolder;
    }

    /**
     * @return boolean
     */
    public function getMobile(){
        return $this->getConfig()->mobile == 'true';
    }

    /**
     * @return boolean
     */
    public function getMobileSameDomain(){
        return $this->getConfig()->mobileSameDomain == 'true';
    }

    /**
     * @return string
     */
    public function getStatus(){
        return $this->getConfig()->status;
    }

    /**
     * @return string
     */
    public function getProtocol(){
        return $this->getConfig()->protocol;
    }

    /**
     * @return object
     */
    public function getDB(){
        return $this->getConfig()->db;
    }

    /**
     * @return string
     */
    public function getDBUrl(){
        return $this->getDB()->url;
    }


    /**
     * @return string
     */
    public function getDBPrefix(){
        return $this->getDB()->prefix;
    }

    /**
     * @return string
     */
    public function getComposerAutoLoader(){
        return $this->getConfig()->composerAutoLoader;
    }

    /**
     * @return WebDavConfigurator The *Singleton* instance.
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