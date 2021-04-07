<?php


namespace Text_Proc;


class Friendly_Text
{
    public function __construct()
    {

    }

    public function PIPHP_FriendlyText($text, $emphasis)
    {
        $misc = array("let us", "let's", "i\.e\.", "for example",
            "e\.g\.", "for example", "cannot", "can't", "can not",
            "can't", "shall not", "shan't", "will not", "won't");
        $nots = array("are", "could", "did", "do", "does", "is",
            "had", "has", "have", "might", "must", "should", "was",
            "were", "would");
        $haves = array("could", "might", "must", "should", "would");
        $who = array("he", "here", "how", "I", "it", "she", "that",
            "there", "they", "we", "who", "what", "when", "where",
            "why", "you");
        $what = array("am", "are", "had", "has", "have", "shall",
            "will", "would");
        $contractions = array("m", "re", "d", "s", "ve", "ll", "ll",
            "d");
        for ($j = 0; $j < sizeof($misc); $j += 2) {
            $from = $misc[$j];
            $to = $misc[$j + 1];
            $text = PIPHP_FT_FN1($from, $to, $text, $emphasis);
        }
        for ($j = 0; $j < sizeof($nots); ++$j) {
            $from = $nots[$j] . " not";
            $to = $nots[$j] . "n't";
            $text = PIPHP_FT_FN1($from, $to, $text, $emphasis);
        }
        for ($j = 0; $j < sizeof($haves); ++$j) {
            $from = $haves[$j] . " have";
            $to = $haves[$j] . "'ve";
            $text = PIPHP_FT_FN1($from, $to, $text, $emphasis);
        }
        for ($j = 0; $j < sizeof($who); ++$j) {
            for ($k = 0; $k < sizeof($what); ++$k) {
                $from = "$who[$j] $what[$k]";
                $to = "$who[$j]'$contractions[$k]";
                $text = PIPHP_FT_FN1($from, $to, $text, $emphasis);
            }
        }
        $to = "'s";
        $u1 = $u2 = "";
        if ($emphasis) {
            $u1 = "<u>";
            $u2 = "</u>";
        }
        return preg_replace("/([\w]*) is([^\w]+)/", "$u1$1$to$u2$2",
            $text);
    }

    function PIPHP_FT_FN1($f, $t, $s, $e)
    {
        $uf = ucfirst($f);
        $ut = ucfirst($t);
        if ($e) {
            $t = "<u>$t</u>";
            $ut = "<u>$ut</u>";
        }
        $s = preg_replace("/([^\w]+)$f([^\w]+)/", "$1$t$2", $s);
        return preg_replace("/([^\w]+)$uf([^\w]+)/", "$1$ut$2", $s);
    }
}