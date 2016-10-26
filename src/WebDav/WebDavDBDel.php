<?php
namespace Uni\WebDav;
class WebDavDBDel extends WebDavDBController {
    protected static $instance;
    public function __construct()
    {
        $this->setCommand($this->getDelCommand());
        parent::__construct();
    }
}