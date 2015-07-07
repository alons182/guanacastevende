<?php

function errors_for($attribute, $errors)
{
    return $errors->first($attribute,'<span class="error label label-warning">:message</span>');
}

function link_to_profile($text = 'Profile')
{
    return link_to_route('profile', $text, Auth::user()->username,['class'=>'btn-profile']);
}

function get_depth($depth)
{
    return str_repeat('<span class="depth">—</span>', $depth);
}

function money($amount, $symbol = '$')
{
    return (!$symbol) ? number_format($amount, 0, ".", ",") : $symbol . number_format($amount, 0, ".", ",");
}
function number($amount)
{
    return preg_replace("/([^0-9\\.])/i", "", $amount);
}
function percent($amount, $symbol = '%')
{
    return $symbol . number_format($amount, 0, ".", ",");
}

function set_active($path, $active = 'active' )
{
    return Request::is($path) ? $active : '';
}
function dir_photos_path($dir)
{
    return public_path() . '/media/'. $dir .'/';
}
function dir_downloads_path($dir = null)
{
    return ($dir) ? public_path() . '/downloads_files/'. $dir .'/' : public_path() . '/downloads_files/' ;
}

function photos_path($dir)
{
    return '/media/'. $dir .'/';
}
function existDataArray($data, $index)
{
    if(isset($data[$index]))
    {
        $array = array_where($data[$index], function($key, $value)
        {
            if(trim($value) != "")
                return $value;
        });

    }else
    {
        $array = [];
    }

    return $array;
}



