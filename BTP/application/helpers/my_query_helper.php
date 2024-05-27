<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
function fetch_array($query){
    $result=$query->result_array();
    $array=array();
    foreach($result as $row){
        $array[]=$row;
    }
    return $array;
}
?>