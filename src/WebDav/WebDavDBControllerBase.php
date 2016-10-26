<?php
namespace Uni\WebDav;
abstract class WebDavDBControllerBase{
    abstract function addUrl($url);
    abstract function delUrl($url);
    abstract function getUrlList();
}