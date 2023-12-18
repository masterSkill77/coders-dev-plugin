<?php

/**
 * Plugin Name: Coders
 * Author: Koders
 * Version: 2.0.0
 */

require_once dirname(__FILE__) . '/vendor/autoload.php';

use Coders\Coders_CPT;
use Coders\Coders_RESTAPI;
use Coders\Coders_TAXONOMIES;

Coders_CPT::register();
Coders_RESTAPI::register();
Coders_TAXONOMIES::register();
