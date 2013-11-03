<?php

require_once 'string_utils.php';

class FileUtils
{
    public static function ReadAllText($fileName)
    {
        return file_get_contents($fileName);
    }
}

class Path
{
    public static $PathDelimiter = '/';

    public static function IsPathDelimiter($character)
    {
        return $character == Path::$PathDelimiter;
    }

    public static function IsAbsolutePath($path)
    {
        if (strlen($path) > 0)
            return Path::IsPathDelimiter($path[0]);
        else
            return false;
    }

    public static function IncludeTralligPathDelimiter($path)
    {
        $result = $path;
        if (!Path::IsPathDelimiter($result[strlen($result) - 1]))
            $result .= Path::$PathDelimiter;
        return $result;
    }

    public static function Combine($prefix, $suffix)
    {
        if (Path::IsAbsolutePath($suffix) || !isset($prefix) || empty($prefix))
            return $suffix;
        else
            return Path::IncludeTralligPathDelimiter($prefix) . $suffix;
    }

    public static function GetFileExtension($filePath)
    {
        return substr($filePath, strrpos($filePath, '.') + 1);
    }

    public static function GetFileTitle($filePath)
    {
        return pathinfo($filePath, PATHINFO_BASENAME);
    }

    public static function ReplaceFileNameIllegalCharacters($fileName, $replaceChar = '_')
    {
        $illegal_charaters = array('\\', '/', ':', '*', '?', '<', '>', '|', '"', '#', ' ');
        $result = $fileName;
        foreach($illegal_charaters as $charater)
            $result = StringUtils::Replace($charater, '_', $result);
        return $result;
    }
}

?>
