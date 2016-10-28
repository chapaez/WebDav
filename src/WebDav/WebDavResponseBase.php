<?php
namespace Uni\WebDav;
/**
 * Class WebDavResponseBase
 * @package Uni\WebDav
 */
abstract class WebDavResponseBase{
    /**
     * @param $msg
     * @return mixed
     */
    abstract function logErr($msg);

    /**
     * @param $msg
     * @return mixed
     */
    abstract function pringErr($msg);

    /**
     * @param $msg
     * @return mixed
     */
    abstract function printMsg($msg);

    /**
     * @param $data
     * @return mixed
     */
    abstract protected function formatData($data);

    /**
     * @param $data
     * @return mixed
     */
    abstract protected function makeMsg($data);
}
