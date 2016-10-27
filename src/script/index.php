<?php
include(dirname(__FILE__). '/../autoload.php');
use Uni\WebDav as UW;
if($_POST['command']=='add')
    UW\WebDavFacade::addPostPage();
elseif ($_POST['command']=='del')
    UW\WebDavFacade::delPostPage();