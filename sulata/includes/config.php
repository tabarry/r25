<?php

/*
 * SULATA FRAMEWORK
 * Version: 25
 * Date: February 2017
 */
//Error reporting
error_reporting("E_ALL & ~E_NOTICE & ~E_DEPRECATED");
//ini_set('display_errors',1);
//Include the language file
include('language.php');
//MISC SETTINGS
define('LOCAL_URL', 'http://localhost/r25/');
define('WEB_URL', 'http://localhost/r25/');
define('SESSION_PREFIX', 'ffe_');
define('UID_LENGTH', 14);
define('OPENID_DOMAIN', $_SERVER['HTTP_HOST']);
define('GOOGLE_LOGOUT_URL', 'https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=');
define('COOKIE_EXPIRY_DAYS', '30');
define('PHP_EXTENSION', ''); //This will add or remove '.php' in file links
//URLs and db settings
//Other settings are in sulata_settings table
//If local
if (!strstr($_SERVER['HTTP_HOST'], ".")) {
    define('DEBUG', TRUE);
    define('BASE_URL', LOCAL_URL);
    define('ADMIN_URL', BASE_URL . '_admin/');
    define('ADMIN_SUBMIT_URL', ADMIN_URL);
    define('PING_URL', BASE_URL . 'static/ping.html');
    define('NOSCRIPT_URL', BASE_URL . 'sulata/static/no-script.html');
    define('ACCESS_DENIED_URL', BASE_URL . 'sulata/static/access-denied.html');
    define('ADMIN_UPLOAD_PATH', '../files/');
    define('PUBLIC_UPLOAD_PATH', 'files/');
    define('LOCAL', TRUE);
    //API Settings
    define('API_URL', BASE_URL . 'phpMyRest/');
    define('API_KEY', 'uLMXrY4RWuVnWqf8LgkG4ptYXHt5vrEV');
    define('API_DEBUG', FALSE);
    //MySQL DB Settings
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'r25');
    define('DB_USER', 'root');
    define('DB_PASSWORD', 'root');
} else {
    define('DEBUG', FALSE);
    define('BASE_URL', WEB_URL);
    define('ADMIN_URL', BASE_URL . '_admin/');
    define('ADMIN_SUBMIT_URL', ADMIN_URL);
    define('PING_URL', BASE_URL . 'sulata/ping.html');
    define('API_URL', BASE_URL . 'phpMyRest/');
    define('NOSCRIPT_URL', BASE_URL . 'sulata/static/no-script.html');
    define('ACCESS_DENIED_URL', BASE_URL . 'sulata/static/access-denied.html');
    define('ADMIN_UPLOAD_PATH', '../files/');
    define('PUBLIC_UPLOAD_PATH', 'files/');
    define('LOCAL', FALSE);
    //API Settings
    define('API_URL', BASE_URL . BASE_URL . 'phpMyRest');
    define('API_KEY', 'uLMXrY4RWuVnWqf8LgkG4ptYXHt5vrEV');
    define('API_DEBUG', FALSE);
    //MySQL Settings
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'r25');
    define('DB_USER', 'root');
    define('DB_PASSWORD', 'root');
}
//Edit delete download access
$editAccess = TRUE;
$duplicateAccess = TRUE;
$deleteAccess = TRUE;
$restoreAccess = TRUE;
$addAccess = TRUE;
$downloadAccessCSV = TRUE;
$downloadAccessPDF = TRUE;
