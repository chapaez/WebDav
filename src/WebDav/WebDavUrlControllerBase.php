<?php
namespace Uni\WebDav;
/**
 * Class WebDavUrlControllerBase
 * @package Uni\WebDav
 */
abstract class WebDavUrlControllerBase{
    abstract function checkUrl($url);
}