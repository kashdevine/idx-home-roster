<?php

namespace IDXHOME;

use IDXHOME\Api\Agents\AgentsAPI;
use IDXHOME\Shortcode\IDXHOMERosterShortCode;

require_once plugin_dir_path(__FILE__) . './shortcode/roster-shortcode.php';
require_once plugin_dir_path(__FILE__) . './api/agents-api.php';


class ActivateRoster{

    public function __construct()
    {
        $this->instantiate_classes();
    }

    public function instantiate_classes(){
        new IDXHOMERosterShortCode();
        new AgentsAPI();
    }
}