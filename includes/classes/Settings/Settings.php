<?php


namespace Settings;


class Settings
{
    public $bg_color;

    public $og_image;
    public $og_image_url;
    public $og_image_width;
    public $og_image_height;
    public $og_image_mime;
    public $og_image_alt;

    public function __construct()
    {

    }

    public static function set_og_details($image_path='', $image_alt=''){
        global $url;
        if (empty($image_path)) return false;
        if (!empty($image_alt)) $image_alt = strip_tags($image_alt);
        $img_full_path = SITE_ROOT.$image_path;
        if (file_exists(SITE_ROOT.$image_path)){
            //if is not image, exit function.
            if (!self::is_image($image_path)) return false;
            //retrieve properties.
            $image = list($width, $height) = getimagesize($img_full_path);
            $og = new namespace\Settings();
            $og->og_image_width = $width;
            $og->og_image_height = $height;
            $og->og_image_mime = $image['mime'];
            $og->og_image_alt = $image_alt;
            //Trim on the left of string "/";
            $image_path = ltrim($image_path, "/");
            $og->og_image_url = "{$url}{$image_path}";
            unset($img_full_path);
            return $og;
        }
        return false;
    }
    private static function is_image($image_path=''){
        if (empty($image_path)) return false;
        $img_full_path = SITE_ROOT.$image_path;
        if (file_exists($img_full_path)) {
            return getimagesize($img_full_path) ? true : false;
        }
    }

}