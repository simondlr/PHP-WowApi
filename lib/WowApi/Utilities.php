<?php
namespace WowApi;

class Utilities
{
    /**
     * @static
     * @param $region Region
     * @param $thumbnail Thumbnail path from API
     * @return string
     */
    public static function getThumbnailUrl($region, $thumbnail)
    {
        return sprintf('http://%1$s.battle.net/static-render/%1$s/%2$s', $region, $thumbnail);
    }

    /**
     * @static
     * @throws \InvalidArgumentException
     * @param $region Region
     * @param $icon Icon path from API
     * @param string $size Icon size (Allowed sizes: 18, 36, 56)
     * @return string
     */
    public static function getIconURL($region, $icon, $size = '36')
    {
        if(!in_array($size, array(18, 36, 56))) {
            throw new \InvalidArgumentException("That size is not allowed.");
        }
        return sprintf('http://%s.media.blizzard.com/wow/icons/%d/%s.jpg', $region, $size, $icon);
    }





    public static function normalize($string)
    {
        return \Normalizer::normalize($string, \Normalizer::FORM_KC);
    }

    public static function urlencode($input)
    {
        return urlencode(self::encode($input));
    }

    public static function encode($input)
    {
        if(is_object($input)) {
            $output = new \stdClass();
            foreach ($input as $key => $value) {
                $output->$key = self::encode($value);
            }
        } elseif(is_array($input)) {
            $output = array();
            foreach ($input as $key => $value) {
                $output[$key] = self::encode($value);
            }
        } else {
            $output = utf8_encode(self::normalize($input));
        }
        return $output;
    }

    public static function decode($input)
    {
        if(is_object($input)) {
            $output = new \stdClass();
            foreach ($input as $key => $value) {
                $output->$key = self::decode($value);
            }
        } elseif(is_array($input)) {
            $output = array();
            foreach ($input as $key => $value) {
                $output[$key] = self::decode($value);
            }
        } else {
            $output = utf8_decode($input);
        }
        return $output;
    }
}
