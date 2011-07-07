<?php
namespace WowApi;

class Utilities
{
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

    public static function getIconURL($region, $icon, $size='18')
    {
        return sprintf('http://%s.media.blizzard.com/wow/icons/%d/%s.jpg', $region, $size, $icon);
    }

    public static function getAvatarUrl($region, $avatar)
    {
        return sprintf('http://%s.media.blizzard.com/wow/icons/%d/%s.jpg', $region, $avatar);
    }
}
