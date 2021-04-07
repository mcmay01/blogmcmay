<?php
function callback($b){
    $mobile = "m.blogmcmay.com";
    $web_domain = "www.blogmcmay.com";
    if ($_SERVER['SERVER_NAME'] == $mobile){
        //replace www.... with m....
        $b = str_replace($web_domain, $mobile, $b);
        // replace all hyperlinked imgs with regular links, using the alt text
        $b = preg_replace('/(<a[^>]*>)(<img[^>]+alt=")([^"]*)("[^>]*>)(<\/a>)/i' ,'<p class="link">$1$3$5</p>' , $b);
        // replace imgs with paragraph tags
        $b = preg_replace('/(<img[^>]+alt=")([^"]*)("[^>]*>)/' , '<p class="image">[$2]</p>' , $b);
        // strip out stylesheet calls
        $b = preg_replace('/(<link[^>]+rel="[^"]*stylesheet"[^>]*>|style="[^"]*")/i' , '' , $b);
        //remove scripts
        $b = preg_replace('/<script[^>]*>.*?<\/script>/i' , '' , $b);
        // remove style tags and comments
        $b = preg_replace('/<style[^>]*>.*?<\/style>|<!--.*?-->/i' , '' , $b);
        // add robots nofollow directive to keep the search engines out!
        $b = preg_replace('/<\/head>/i' , '<meta name="robots" content="noindex, nofollow"></head>' , $b);

    }
    return $b;
}
ob_start("callback");