<?
header('Content-Type: application/json');
\Uni\WebDav\WebDavFacade::addCommand($_POST['command'],$_POST['url'],$_POST['recursive']);
