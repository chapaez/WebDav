<?php
namespace Uni\WebDav;
/**
* Class WebDavResponseJson
* @package Uni\WebDav
*/
class WebDavResponseJson extends WebDavResponse {
    /**
     * @var WebDavResponseJson - "singleton"
     */
    protected static $instance;

    /**
    * @param $data - message
    * @return string json data
    */
    protected function formatData($data)
    {
        return json_encode($data);
    }
}