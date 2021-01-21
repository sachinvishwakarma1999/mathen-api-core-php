<?php

require_once '../Payment/config/Config.php';
include('../config.php'); 
$conn->set_charset('utf8');
class ConfigTest
{
    private $config;

    public function __construct()
    {
        $this->config = new Config();
    }

    public function testConfig()
    {
        if ($this->config->site_id == "TODO") {
            echo('Please set your shopID (site_id) in the config/Config');
            exit();
        }

        if ($this->config->site_id == "TODO") {
            echo('Please set your PRODUCTION site key in the config/Config.php');
            exit();
        }
    }


}

