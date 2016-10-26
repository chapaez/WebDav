<?php
namespace Uni\WebDav;
class WebDavDBAdd extends WebDavDBController {
    protected static $instance;
    public function __construct()
    {
        $this->setCommand($this->getAddCommand());
        parent::__construct();
    }
}