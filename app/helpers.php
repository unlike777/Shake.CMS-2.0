<?php
/**
 * Created by PhpStorm.
 * User: unlike
 * Date: 12.02.2017
 * Time: 16:08
 */

function pr($p)
{
    echo "<pre>";
    if (is_array($p) || is_object($p)) {
        print_r($p);
    } else if ( is_bool($p) || empty($p) || (is_string($p) && trim($p) == '') ) {
        var_export($p);
    } else {
        print_r($p);
    }
    echo "</pre>";
}
function uncache($url)
{
    $url =  '/' . $url;
    $url = str_replace('//', '/', $url);
    $full_path = public_path() . $url;
    
    $pref = 'not_found';
    if(file_exists($full_path)){
        $pref = filemtime($full_path);
    }
    
    return $url . '?' . $pref;
}
