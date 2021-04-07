<?php
namespace TextFormat;

class ShortenText
{
    public function __construct()
    {

    }
    public function PIPHP_ShortenText($text, $size, $mark)
    {
        $len = strlen($text);
        if ($size >= $len) return $text;
        $a = substr($text, 0, $size / 2 -1);
        $b = substr($text, $len - $size / 2 + 1, $size/ 2 -1);
        return $a . $mark . $b;
    }
}