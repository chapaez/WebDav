<?
include(dirname(__FILE__). '/../../../include_vendor.php');
header('Content-Type: application/json');
use Uni\WebDav as UW;
$urlList = UW\WebDavFacade::clearUrlList();
UW\WebDavResponse::getInstance()->printOk($urlList);