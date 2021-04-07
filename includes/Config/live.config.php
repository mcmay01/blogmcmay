<?php
//LOG SECURE ENVIRONMENT
ini_set("display_errors", false);
ini_set("log_errors", true);
ini_set("error_log", "/var/log/php.log");
//online/live
$url = "http://www.blogmcmay.com/";
//database constants online
define('DB_HOST', 'localhost');
define('DB_USER', 'user_mcmay');
define('DB_PASS', 'Mc.Blog.1999');
define('DB_NAME', 'blogmcmay_db');

//APP DIRECTORY CONFIGURATION
$ROOT_PATH = $_SERVER['DOCUMENT_ROOT'];
//INCLUDES PATH
$INCLUDE_DIR = $ROOT_PATH . $REL_APP_PATH . "/include";
//CLASS PATH
$CLASS_DIR = $INCLUDE_DIR . "/classes";

define('DS', DIRECTORY_SEPARATOR);
define('SITE_ROOT', $ROOT_PATH );

function my_error_handler($e_number, $e_message, $e_file, $e_line, $e_vars)
{
    global $debug, $contact_email;
    // Build the error message.
    $message = "An error occurred in script '$e_file' on line $e_line: \n<br />$e_message\n<br/>";
    // Add the date and time.
    $message .= "Date/Time: " . date('n-j-Y H:i:s') . "\n<br />";
    // Append $e_vars to the $message.
    $message .= "<pre>" . print_r($e_vars, 1) . "</pre>\n<br />";
    if ($debug) {
        echo '<p class="error">' . $message . '</p>';
    } else {
        // Log the error:
        error_log($message, 1, $contact_email); // Send email.
        // Only print an error message if the error isn't a notice or strict.
        if (($e_number != E_NOTICE) && ($e_number < 2048)) {
            echo '<p class="error">A system error occurred. We apologize for the inconvenience.</p>';
        }

    }
}

set_error_handler('my_error_handler');
