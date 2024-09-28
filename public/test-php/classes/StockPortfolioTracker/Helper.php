<?php

namespace StockPortfolioTracker;

use Exception;

/**
 * Class Helper - helper functions
 * @package StockPortfolioTracker
 */
class Helper
{
    /**
     * Print message or array/object
     * @param $msg
     */
    public static function p($msg)
    {
        if (is_array($msg) || is_object($msg)) {
            print '<pre>' . print_r($msg, TRUE) . '</pre>';
        } else {
            print $msg;
        }
    }

    /**
     * Check if given cache file exists and is not expired
     *
     * @param $fileName
     * @param $cacheTime
     * @return bool
     */
    public static function cacheExists($fileName, $cacheTime)
    {
        $filePath = SPT_ROOT_DIR . DIRECTORY_SEPARATOR . $fileName;
        return file_exists($filePath) && (time() - filemtime($filePath) < $cacheTime);
    }

    /**
     * Read JSON file and return its contents as object
     *
     * @param $fileName
     * @return array|mixed|null|object
     */
    public static function readJson($fileName)
    {
        return file_exists(SPT_ROOT_DIR . DIRECTORY_SEPARATOR . $fileName) ?
            json_decode(file_get_contents(SPT_ROOT_DIR . DIRECTORY_SEPARATOR . $fileName)) :
            NULL;
    }

    /**
     * Save JSON to a file
     *
     * @param $fileName
     * @param $contents
     * @return int
     */
    public static function saveJson($fileName, $contents)
    {
        return file_put_contents(SPT_ROOT_DIR . DIRECTORY_SEPARATOR . $fileName, json_encode($contents, JSON_PRETTY_PRINT));
    }

    public static function log($msg)
    {
        error_log(is_string($msg) ? $msg : print_r($msg, TRUE));
    }

    public static function isCurrencySymbol($symbol)
    {
        return substr($symbol, -2) == '=X';
    }

    /**
     * Get nested property of an object by its path, e.g. getProperty({x: {y: 1}}, 'x.y').
     * Numeric keys can also be provided to get data from array, e.g. 'x.y.1.property' (where 1 is array index)
     *
     * @param $object
     * @param $path
     * @return mixed
     */
    public static function getObjectProperty($object, $path)
    {
        return array_reduce(explode('.', $path), function ($carry, $item) {
            // check whether current key is an integer
            return ctype_digit($item) ?
                (isset($carry[$item]) ? $carry[$item] : NULL) :
                (isset($carry->$item) ? $carry->$item : NULL);
        }, $object);
    }

    /**
     * Clean JSON string from non-printable characters before using json_decode()
     *
     * @param $jsonString
     * @return mixed|string
     */
    public static function cleanString($jsonString)
    {
        if (!is_string($jsonString) || !$jsonString) return '';

        // Remove unsupported characters
        // Check http://www.php.net/chr for details
        for ($i = 0; $i <= 31; ++$i)
            $jsonString = str_replace(chr($i), "", $jsonString);

        $jsonString = str_replace(chr(127), "", $jsonString);

        // Remove the BOM (Byte Order Mark)
        // It's the most common that some file begins with 'efbbbf' to mark the beginning of the file. (binary level)
        // Here we detect it and we remove it, basically it's the first 3 characters.
        if (0 === strpos(bin2hex($jsonString), 'efbbbf')) $jsonString = substr($jsonString, 3);

        return $jsonString;
    }

    public static function decode($string)
    {
        try {
            $result = json_decode($string);
        } catch (Exception $e) {
            $result = json_decode(self::cleanString($string));
        }

        return $result;
    }
}
