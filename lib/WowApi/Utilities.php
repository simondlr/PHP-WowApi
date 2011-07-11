<?php
namespace WowApi;

//Not sure if this is needed. Will keep just in case.
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
}
