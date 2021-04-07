<?php


namespace Security;


class BotSec
{
    public function __construct()
    {

    }

    public function checkBot($useragent)
    {
        $bot_str  = "Gigabot|AESOP_com_SpiderMan|ah-ha.com|ArchitextSpider|asterias|Atomz|FAST-WebCrawler|Fluffy the spider|";
        $bot_str .= "Freshbot|GalaxyBot|Googlebot|Gulliver|ia_archiver|LNSpiderguy|Lycos_Spider|MantraAgent|Mercator|";
        $bot_str .= "MSNBOT|search.msn.com|NationalDirectory-SuperSpider|roach.smo.av.com|Scooter|Scooter2_Mercator|Scrubby|";
        $bot_str .= "Sidewinder|Slurp/2.0-KiteHourly|Slurp/2.0-OwlWeekly|Slurp/3.0-AU|Speedy Spider|teoma_agent|T-Rex|";
        $bot_str .= "Merc_resh_26_1_D-1.0|UltraSeek|Wget|ZyBorg|Yandex|yandex";
        $bots = explode('|', $bot_str);
        foreach ($bots as $bot)
        {
            if (is_integer(strpos($useragent, $bot)))
                return true;
        }
        return false;
    }
}