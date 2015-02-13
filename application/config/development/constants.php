<?php

/*
|--------------------------------------------------------------------------
| Kyuubi Constants
|--------------------------------------------------------------------------
*/

/*
* Application path definition
* Format Date Pattern String
*/

//Retrieve if secure or regular HTTPS connection
$_http = ((isset($_SERVER['SERVER_PORT_SECURE']) && $_SERVER['SERVER_PORT_SECURE'] == 1) || (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on")) ? "https://" : "http://";

define('DOMAIN', 'local.host:8080');
define('REL_BASEURI', '/');
define('BASEURI', $_http . DOMAIN . REL_BASEURI);

/* End of file constants.php */
/* Location: ./application/config/constants.php */