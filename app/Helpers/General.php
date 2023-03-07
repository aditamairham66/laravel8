<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class General
{
    /**
     * return random code string
     *
     * @param array $not_in
     * @param int $length
     * @param bool $capital
     * @return string
     */
    public static function randomCode($not_in = [], $length = 6, $capital = true)
    {
        $code = Str::random($length);
        if ($capital) {
            $code = Str::upper($code);
        }

        if (in_array($code, $not_in)) {
            $code = self::randomCode();
        }

        return $code;
    }

    /**
     * split word
     *
     * @param $word
     * @param int $get
     * @return mixed
     */
    public static function sliptWord($word, $get = 0)
    {
        $split = str_split($word);
        return $split[$get];
    }

    /**
     * generate time elapsed
     *
     * @param $datetime
     * @param false $full
     * @return string
     * @throws \Exception
     */
    public static function timeAgo($datetime, $full = false)
    {
        return $datetime;

        $now = new \DateTime;
        $ago = new \DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
}
