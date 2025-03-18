<?php

    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST");
    header("Access-Control-Allow-Headers: X-Requested-With,Content-Type,accept,Authorization");

    $version=10;
    if($version==(isset($_REQUEST["v"])?$_REQUEST["v"]:0)){
        $data=[
            "s"=>true,
            "v"=>$version,
            "d"=>null,
        ];
    }else{
        $data=[
            "s"=>false,
            "v"=>$version,
            "d"=> json_decode(require("data.php")),
        ];
    }
    echo json_encode($data);