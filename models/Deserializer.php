<?php

namespace App\Models;

class Deserializer
{
    /**
     * @param string|array $json
     * @return $this
     */
    public static function deserialize($json)
    {
        $className = get_called_class();
        $classInstance = new $className();
        if (is_string($json))
            $json = json_decode($json);
        foreach ($json as $key => $value)
            if (property_exists($classInstance, $key)){
                $classInstance->{$key} = $value;
            }
        return $classInstance;
    }
}