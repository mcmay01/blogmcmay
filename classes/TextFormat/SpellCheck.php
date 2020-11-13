<?php
namespace TextFormat;

class SpellCheck
{

    public function __construct()
    {

    }

    function PIPHP_SpellCheck($text, $action)
    {
        $dictionary = $this->PIPHP_SpellCheckLoadDictionary("dictionary.txt");
        $text .= ' ';
        $newtext = "";
        $offset = 0;
        while ($offset < strlen($text))
        {
            $result = preg_match('/[^\w]*([\w]+)[^\w]+/',
                $text, $matches, PREG_OFFSET_CAPTURE, $offset);
            $word = $matches[1][0];
            $offset = $matches[0][1] + strlen($matches[0][0]);
            if (!PIPHP_SpellCheckWord($word, $dictionary))
                $newtext .= "<$action>$word</$action> ";
            else $newtext .= "$word ";
        }
        return rtrim($newtext);
    }
    function PIPHP_SpellCheckLoadDictionary($filename)
    {
        return explode("\r\n", file_get_contents($filename));
    }
    function PIPHP_SpellCheckWord($word, $dictionary)
    {
        $top = sizeof($dictionary) -1;
        $bot = 0;
        $word = strtolower($word);
        while($top >= $bot)
        {
            $p = floor(($top + $bot) / 2);
            if ($dictionary[$p] < $word) $bot = $p + 1;
            elseif ($dictionary[$p] > $word) $top = $p - 1;
            else return TRUE;
        }
        return FALSE;
    }
}