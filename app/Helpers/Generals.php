<?php

if (!function_exists('randomCode'))
{
    /**
     * return random code string
     */
    function randomCode($not_in = [], $length = 6, $capital = true)
    {
        return \App\Helpers\General::randomCode($not_in, $length, $capital);
    }
}

if (!function_exists('sliptWord'))
{
    /**
     * split word
     */
    function sliptWord($word, $get = 0)
    {
        return \App\Helpers\General::sliptWord($word, $get);
    }
}

if (!function_exists('timeElap'))
{
    /**
     * generate time elapsed
     */
    function timeElap($datetime, $full = false)
    {
        return \App\Helpers\General::timeAgo($datetime, $full);
    }
}

if (!function_exists('fileExists'))
{
    /**
     * file exists
     */
    function fileExists($path)
    {
        return \App\Helpers\Upload::exists($path);
    }
}
