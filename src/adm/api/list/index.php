<?
header('Content-Type: application/json');
include(dirname(__FILE__). '/../../../include_vendor.php');
use Uni\WebDav as UW;
$urlList = UW\WebDavFacade::getUrlList();

echo json_encode($urlList);
