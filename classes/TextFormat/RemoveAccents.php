<?php


namespace Text_Proc;


class RemoveAccents
{

    public function __construct()
    {

    }

    public function PIPHP_RemoveAccents($text)
    {
        $from = array("ç", "æ", "œ", "á", "é", "í", "ó", "ú", "à", "è",
            "ì", "ò", "ù", "ä", "ë", "ï", "ö", "ü", "ÿ", "â",
            "ê", "î", "ô", "û", "å", "e", "i", "ø", "u", "Ç",
            "Æ", "Œ", "Á", "É", "Í", "Ó", "Ú", "À", "È", "Ì",
            "Ò", "Ù", "Ä", "Ë", "Ï", "Ö", "Ü", "Ÿ", "Â", "Ê",
            "Î", "Ô", "Û", "Å", "Ø");
        $to = array("c", "ae", "oe", "a", "e", "i", "o", "u", "a", "e",
            "i", "o", "u", "a", "e", "i", "o", "u", "y", "a",
            "e", "i", "o", "u", "a", "e", "i", "o", "u", "C",
            "AE", "OE", "A", "E", "I", "O", "U", "A", "E", "I",
            "O", "U", "A", "E", "I", "O", "U", "Y", "A", "E",
            "I", "O", "U", "A", "O");
        return str_replace($from, $to, $text);
    }
}