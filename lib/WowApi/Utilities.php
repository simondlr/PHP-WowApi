<?php
namespace WowApi;

class Utilities
{
    protected static $normalizedChars = array(
        'Š'=>'S', 'š'=>'s', 'Ð'=>'Dj','Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A',
        'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I',
        'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U',
        'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss','à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a',
        'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i',
        'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u',
        'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'ƒ'=>'f'
    );

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

    public static function encodeUrlParam($param)
    {
        //Encode spaces separately
        $param = str_replace(' ', '-', $param);
        $param = str_replace('--', '-', $param);

        return urlencode($param);
    }
}
