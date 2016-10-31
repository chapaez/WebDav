<?
include(dirname(__FILE__). '/../../../include_vendor.php');
header('Content-Type: application/json');
\Uni\WebDav\WebDavFacade::addCommand($_POST['command'],$_POST['url'],$_POST['section']);
