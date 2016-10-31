<?php
namespace Uni\WebDav;
use \Redisent\Redis;

class WebDavDBController extends WebDavDBControllerBase {
    /**
     * @var WebDavDBController - "singleton"
     */
    protected static $instance;
    private $redis, $prefix,$addCommand='add',$delCommand='del',$urlTable='urls';
    private $busyStatus='busy',$freeStatus='free',$statusTable='status';
    protected $command;

    /**
     * @return mixed
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * @param mixed $command
     */
    public function setCommand($command)
    {
        $this->command = $command;
    }


    /**
     * @param $url
     * @return string safe url
     */
    public function prepareUrl($url){
        $entities = array('%27','');
        $replacements = array("'",' ');
        return str_replace($entities, $replacements, $url);
    }

    /**
     * @param $field
     * @return mixed
     */
    public function getHash($field){
        return $this->getRedis()->hget(
            $this->getUrlTable(),
            $field
        );
    }

    protected function addHash($hash,$params){
        $this->getRedis()->hsetnx(
            $this->getUrlTable(),
            $hash,
            json_encode($params)
        );
    }

    /**
     * @param string $command add or del command
     * @param string $url
     * @param bool $time time when command added to queue
     * @return array params
     */
    function prepareUrlData($command, $url, $time=false){
        if(!$time)
            $time=\time();
        return [
                'command'=>$command,
                'time'=>$time,
                'url'=>$this->prepareUrl($url)
            ];
    }

    /**
     * add Url to cache db table
     * @param $url
     */
    function addUrl($url){
        $this->addHash(
            $this->getCommand().":".$url,
            $this->prepareUrlData($this->getCommand(), $url)
        );
    }

    function delUrl($url){
        $url = $this->prepareUrl($url);
        $this->getRedis()->hdel(
            $this->getUrlTable(),
            $this->getCommand().":".$url
        );
    }
    /**
     * return array of command:url
     * @return array
     */
    function getUrlList(){
        return $this->getRedis()->hkeys($this->getUrlTable());
    }

    /**
     * return array of command:url
     * @return array
     */
    function clearUrlList(){
        return $this->getRedis()->del($this->getUrlTable());
    }

    /**
     * @param $status
     */
    private function setStatus($status){
        $this->getRedis()->set($this->getPrefix().":".$this->getStatusTable(),$status);
    }

    /**
     * set WD status to 'busy'
     */
    function webDavBusy(){
        $this->setStatus($this->getBusyStatus());
    }

    /**
     * set WD status to 'free'
     */
    function webDavFree(){
        $this->setStatus($this->getFreeStatus());
    }

    /**
     * get WD status
     */
    function webDavStatus(){
        $this->getRedis()->get($this->getPrefix().":".$this->getStatusTable());
    }

    /**
     * WebDavApi constructor.
     */
    protected function __construct(){
        $wdConf = WebDavConfigurator::getInstance();
        $composerAutoLoaderPath = $wdConf->getComposerAutoLoader();
        $getDBUrl = $wdConf->getComposerAutoLoader();
        $this->prefix = $wdConf->getDBPrefix();
        //require_once( $wdConf->getDocumentRoot().$composerAutoLoaderPath.'' );
        /** @noinspection PhpUndefinedNamespaceInspection */
        $this->setRedis(new \Redisent\Redis($getDBUrl));
        unset($composerAutoLoaderPath,$getDBUrl);
    }

    /**
     * @return WebDavDBController The *Singleton* instance.
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
     * @return mixed
     */
    public function getDelCommand()
    {
        return $this->delCommand;
    }

    /**
     * @param mixed $delCommand
     */
    public function setDelCommand($delCommand)
    {
        $this->delCommand = $delCommand;
    }

    /**
     * @return mixed
     */
    public function getAddCommand()
    {
        return $this->addCommand;
    }

    /**
     * @param mixed $addCommand
     */
    public function setAddCommand($addCommand)
    {
        $this->addCommand = $addCommand;
    }

    /**
     * @return Redis
     */
    public function getRedis()
    {
        return $this->redis;
    }

    /**
     * @param Redis $redis
     */
    public function setRedis($redis)
    {
        $this->redis = $redis;
    }

    /**
     * @return string
     */
    private function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * @return string
     */
    private function getUrlTable()
    {
        return $this->getPrefix().':'.$this->urlTable;
    }

    /**
     * @param string $prefix
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
    }

    /**
     * @return string
     */
    public function getBusyStatus()
    {
        return $this->busyStatus;
    }

    /**
     * @param string $busyStatus
     */
    public function setBusyStatus($busyStatus)
    {
        $this->busyStatus = $busyStatus;
    }

    /**
     * @return string
     */
    public function getFreeStatus()
    {
        return $this->freeStatus;
    }

    /**
     * @param string $freeStatus
     */
    public function setFreeStatus($freeStatus)
    {
        $this->freeStatus = $freeStatus;
    }

    /**
     * @return string
     */
    public function getStatusTable()
    {
        return $this->statusTable;
    }

    /**
     * @param string $statusTable
     */
    public function setStatusTable($statusTable)
    {
        $this->statusTable = $statusTable;
    }

}