<?php
namespace TextFformat;

class CapsControl
{
    public $text;
    public $type;
    public function __construct()
    {

    }

    function PIPHP_CapsControl($text, $type)
    {
        switch($type)
        {
            case "u": return strtoupper($text);
            case "l": return strtolower($text);
            case "w":
                $newtext = "";
                $words = explode(" ", $text);
                foreach($words as $word)
                    $newtext .= ucfirst(strtolower($word)) . " ";
                return rtrim($newtext);
            case "s":
                $newtext = "";
                $sentences = explode(".", $text);
                foreach($sentences as $sentence)
                    $newtext .= ucfirst(ltrim(strtolower($sentence))) . ". ";
                return rtrim($newtext);
        }
        return $text;
    }
}