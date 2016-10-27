<?php
set_time_limit(3600);
include(dirname(__FILE__). '/../autoload.php');
use Uni\WebDav as UW;
UW\WebDavFacade::doWebDav();