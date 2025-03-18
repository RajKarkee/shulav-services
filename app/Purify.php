<?php
namespace App;
class Purify{
    public $regx='/(<script)|(javascript:)|(on.\*=("|\').*("|\'))/';
    public static  function removeJS($words)
    {
        return  preg_replace('/(<script)|(javascript:)|(on.\\*=("|\').*("|\'))/', '<data',$words);
    }

}