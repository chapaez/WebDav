<?php
namespace Uni\WebDav;

abstract class WebDavCliBase{
    abstract function uploadFile($file, $url);
    abstract function deleteFile($url);
    static function getInstance(){}
}