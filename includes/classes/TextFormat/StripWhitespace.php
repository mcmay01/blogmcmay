<?php
namespace TextFormat;

class StripWhitespace
{
    public function __construct()
    {
    }

    function PIPHP_StripWhitespace($text)
    {
        return preg_replace('/\s+/', ' ', $text);
    }
}