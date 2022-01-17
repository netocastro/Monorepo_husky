<?php

function debug($data)
{
    echo"<pre>";
    var_dump($data);
    echo"</pre>";   
}

/**
 * Transforma objetos do tipo DataLayer em arrays
 */

function objectToArray($object): array
{
    $newArray = [];
    if ($object == null) {
        return (array)$newArray;
    }

    if (is_array($object)) {

        foreach ($object as $item => $value) {
            $newArray[] = (array)$value->data();
        }
        return  (array) $newArray;
    } else {
        $newArray = [];
        $newArray[] = (array)$object->data();
        return (array)$newArray;
    }
}