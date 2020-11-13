<?php
namespace TextFormat;

class WordSelector
{
    public function __construct()
    {

    }

    public function PIPHP_WordSelector($text, $matches, $replace)
    {
        foreach($matches as $match)
        {
            switch($replace)
            {
                case "u":
                case "b":
                case "i":
                    $text = preg_replace("/([^\w]+)($match)([^\w]+)/",
                        "$1<$replace>$2</$replace>$3", $text);
                    break;
                default:
                    $text = preg_replace("/([^\w]+)$match([^\w]+)/",
                        "$1$replace$2", $text);
                    break;
            }
        }
        return $text;
    }
}