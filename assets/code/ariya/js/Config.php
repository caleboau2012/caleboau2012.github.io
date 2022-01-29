<?php
/**
 * Database Configuration
 * Author: Generaleye
 */

if ($_SERVER["SERVER_NAME"]=="localhost") {
    define('DB_HOST', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', 'admin');
    define('DB_NAME', 'ariya');
    define('VERIFY_ACCOUNT_URL', 'http://localhost/ariya/verifyaccount.php');
    define('FORGOT_PASSWORD_URL', 'http://localhost/ariya/forgotpassword.php');
    define('IMAGE_URL_USERS','http://localhost/ariya/images/users/');
    define('IMAGE_URL_PROPERTIES','http://localhost/ariya/images/properties/');
    define("PATH", 'http://localhost/ariya');

} elseif ($_SERVER["SERVER_NAME"]=="code.caleb.com.ng") {
    define('DB_HOST', 'localhost');
    define('DB_USERNAME', 'calebcom_a_root');
    define('DB_PASSWORD', 'a_root@PASSWORD');
    define('DB_NAME', 'calebcom_ariya');
    define('VERIFY_ACCOUNT_URL', 'http://code.caleb.com.ng/ariya/verifyaccount.php');
    define('FORGOT_PASSWORD_URL', 'http://code.caleb.com.ng/ariya/forgotpassword.php');
    define('IMAGE_URL_USERS','http://code.caleb.com.ng/ariya/images/users/');
    define('IMAGE_URL_PROPERTIES','http://code.caleb.com.ng/ariya/images/properties/');
    define("PATH", 'http://code.caleb.com.ng/ariya');

}elseif ($_SERVER["SERVER_NAME"]=="www.ariya.ng") {
    define('DB_HOST', 'localhost');
    define('DB_USERNAME', 'ariyang_root');
    define('DB_PASSWORD', 'ariyang_9a');
    define('DB_NAME', 'ariyang_ariya');
    define('VERIFY_ACCOUNT_URL', 'http://www.ariya.ng/verifyaccount.php');
    define('FORGOT_PASSWORD_URL', 'http://www.ariya.ng/forgotpassword.php');
    define('IMAGE_URL_USERS','http://www.ariya.ng/images/users/');
    define('IMAGE_URL_PROPERTIES','http://www.ariya.ng/images/properties/');
    define("PATH", 'www.ariya.ng');

} elseif ($_SERVER["SERVER_NAME"]=="api.ariya.ng") {
    define('DB_HOST', 'localhost');
    define('DB_USERNAME', 'ariyang_root');
    define('DB_PASSWORD', 'ariyang_9a');
    define('DB_NAME', 'ariyang_ariya');
    define('VERIFY_ACCOUNT_URL', 'http://www.ariya.ng/verifyaccount.php');
    define('FORGOT_PASSWORD_URL', 'http://www.ariya.ng/forgotpassword.php');
    define('IMAGE_URL_USERS','http://www.ariya.ng/images/users/');
    define('IMAGE_URL_PROPERTIES','http://www.ariya.ng/images/properties/');
    define("PATH", 'www.ariya.ng');
}

define('SENDGRID_USERNAME', 'generaleye');
define('SENDGRID_PASSWORD', 'sendgrid_password');
define('SENDGRID_FROM_EMAIL', 'info@ariya.ng');
define('SENDGRID_FROM_NAME', 'Ariya');

define('REGISTRATION_SUCCESSFUL', 0);
define('REGISTRATION_FAILED', 1);
define('EMAIL_ALREADY_EXISTS', 2);
define('USER_NOT_VERIFIED', 3);
define('LOGIN_SUCCESSFUL', 4);
define('UNSUCCESSFUL_LOGIN', 5);

define("MERCHANTID", "506364616");
define("SERVICETYPEID", "486241699");
define("APIKEY", "253847");
define("GATEWAYURL", "https://login.remita.net/remita/ecomm/split/init.reg");
define("GATEWAYRRRPAYMENTURL", "https://login.remita.net/remita/ecomm/finalize.reg");
define("CHECKSTATUSURL", "https://login.remita.net/remita/ecomm");

//define("PATH", 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']));

define("ARIYA_ACCOUNT_NAME", 'Oshadami Mke');
define("ARIYA_ACCOUNT_NUMBER", '3455665434');
define("ARIYA_BANK_CODE", '011');

