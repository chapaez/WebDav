<?php
namespace Uni\WebDav;
    /**
     * Class WebUrlController
     */
class WebDavUrlController extends WebDavUrlControllerBase{
    /**
     * @var WebDavUrlController - "singleton"
     */
    private static $instance;
    protected static $configFile= 'urls.json';
    public $content;
    protected $config,$urls,$urlExpressions;

    /**
     * @return mixed
     */
    public function getUrlExpressions()
    {
        return $this->urlExpressions;
    }

    /**
     * @param mixed $urlExpressions
     */
    public function setUrlExpressions($urlExpressions)
    {
        $this->urlExpressions = $urlExpressions;
    }

    /**
     * @return mixed
     */
    public function getUrls()
    {
        return $this->urls;
    }

    /**
     * @param mixed $urls
     */
    public function setUrls($urls)
    {
        $this->urls = $urls;
    }


    /**
     * @return object
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * WebDavApi constructor.
     */
    protected function __construct()
    {
        $dir_obj = json_decode(file_get_contents(__DIR__.'/'.WebDavConfigurator::getDirNameFile()));
        $configFileContent=file_get_contents($dir_obj->dir.'/'.self::$configFile);
        $this->setContent(json_decode($configFileContent));
        $this->setUrls($this->getContent()->urls);
        $this->setUrlExpressions($this->getContent()->urlExpressions);
    }

    /**
     * @param $url
     * @return bool is Url needed to cache or not
     */
    public function checkUrl($url){
        if($url[0]!='/' || $url[1]=='/')
            return false;

        if(in_array($url,$this->getUrls())){
            return true;
        }

        foreach ($this->getUrlExpressions() as $expression){
            if(preg_match('/'.$expression.'/',$url)!=false)
                return true;
        }

        return false;
    }

    /**
     * @return WebDavUrlController The *Singleton* instance.
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