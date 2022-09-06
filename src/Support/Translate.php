<?php

namespace Masoudi\Nova\Tool\Support;

trait Translate
{
    /**
     * Translate array item value
     * 
     * @param string $key
     * @param array $array
     */
    public function transArrayValue($key, &$array)
    {
        if (array_key_exists($key, $array)) {
            $array[$key] = trans($array[$key]);
        }
    }
}
