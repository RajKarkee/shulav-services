<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: X-Requested-With,Content-Type,accept,Authorization");
header("memtest: ". (memory_get_peak_usage(true)/(11024*1024))."MB");
if($_REQUEST['_token']=='123456'){
    $file=$_REQUEST['q'].'.php';
    if(file_exists($file)) {
        $data=include($file);
        echo $data;
    } else {
        http_response_code(404);
        echo json_encode(['msg'=>"URL Not Found"]);
        die();
    }
}else{
    http_response_code(404);
    echo json_encode(['msg'=>"URL Not Found"]);
    die();
}
?>