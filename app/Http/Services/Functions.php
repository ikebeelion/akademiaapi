<?php
namespace App\Http\Services;

function multiply($a, $b){
    return $a*$b;
}

function multiplyArrays($array1, $array2){
    $computed = [];
    for($index = 0; $index < count($array1); $index++){
        array_push($computed, multiply($array1[$index], $array2[$index]));
    }
    return array_sum($computed);
}
