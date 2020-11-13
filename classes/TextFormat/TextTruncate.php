<?php
namespace TextFormat;

class TextTruncate
{
    public $text;
    public $max;
    public $symbol;
    public $temp;
    public $last;
    private $wholeText;

    public function __construct()
    {

    }

    public function TextTruncate($text, $max, $symbol)
    {
        $this->temp = substr($text, 0, $max);
        $this->last = strrpos($this->temp, " ");
        $this->temp = substr($this->temp, 0, $this->last);
        $this->temp = preg_replace("/([^\w])$/", "", $this->temp);
        $this->wholeText = $this->temp.$symbol;
        return $this->wholeText;
    }
}
