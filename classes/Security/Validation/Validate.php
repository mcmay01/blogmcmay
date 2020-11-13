<?php


namespace Security\Validation;


class Validate
{
    public function __construct()
    {
    }
    public function validate_number($input)
    {
        if (is_integer($input)){
            return true;
        }
        return false;
    }
    public function format_money($amount=''){
        if (empty($amount) | !is_numeric($amount)) return false;
        return number_format($amount, 0, 0, ',');
    }
    public function e_tags($text)
    {
        $text = strip_tags($text);
        $text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
        return $text;
    }

    public function escape_message($msg = '')
    {
        if (!empty($msg)) {
            $escaped_str = strip_tags($msg);
            $escaped_str = htmlentities($escaped_str);
            return nl2br($escaped_str);
        }
    }
    public function cmp_str($string1, $string2)
    {
        $string1 = trim($string1);
        $string2 = trim($string2);
        if (strcmp($string1, $string2) == 0) {
            return true;
        } else {
            return false;
        }
    }
    public function validate_io_data($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    public static function is_email($email=''){
        if (empty($email)) return false;
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return false;
        return true;
    }
    public function is_website($url=''){
        if (empty($url)) return false;
        if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $url)) return false;
    }
}