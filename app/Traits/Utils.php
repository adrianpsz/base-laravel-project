<?php

namespace App\Traits;

trait Utils
{
    /**
     * @param array $elements
     * @param array $array
     *
     * @return bool
     */
    function oneOfInArray(array $elements, array $array)
    {
        $inArray = false;
        foreach ($elements as $e) {
            if (in_array($e, $array)) {
                $inArray = true;
            }
        }

        return $inArray;
    }
}
