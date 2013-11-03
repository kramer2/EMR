<?php

class SystemUtils
{
    public static function DisableMagicQuotesRuntime()
    {
        if (function_exists('set_magic_quotes_runtime'))
        {
            try
            {
                set_magic_quotes_runtime(false);
            }
            catch (Exception $e)
            { }
        }
    }
}

class ImageUtils
{
    public static function GetImageSize($fileName)
    {
        list($width, $height, $type, $attr) = getimagesize($fileName);
        return array($width, $height);
    }

    public static function CheckImageSize($fileName, $maxWidth, $maxHeight)
    {
        list($width, $height) = ImageUtils::GetImageSize($fileName);
        if (($width > $maxWidth) || ($height > $maxHeight))
            return false;
        else
            return true;
    }
}

class DebugUtils
{
    public static function PrintArray(array $array)
    {
        echo '<pre>';
        print_r($array);
        echo '</pre>';
    }

    public static function PrintCallStack()
    {
        $trace = debug_backtrace();
        echo '<pre>';
        foreach($trace as $traceItem)
        {
            echo sprintf(
                "%s.%s\t\t(%s:%d)\n",
                $traceItem['class'], 
                $traceItem['function'],
                $traceItem['file'],
                $traceItem['line']
                );
        }
        echo '</pre>';
    }
}

class Random
{
    public static function GetIntRandom($min = 0, $max = -1)
    {
        if ($max == -1)
            return mt_rand($min, mt_getrandmax());
        else
            return mt_rand($min, $max);
    }
}

?>