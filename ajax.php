<?php

//error_reporting(0);

$dir = empty($_REQUEST["dir"]) ? __DIR__ : $_REQUEST["dir"];

function getfiles($path)
{
    $file = [];
    $tmp = [];
    foreach (scandir($path) as $afile) {
        if ($afile == '.' || $afile == '..' || $afile == '.git'|| $afile == '.idea'||$afile == 'config' || strpos($afile, '.php') || strpos($afile, '.html')) continue;//这里可以吧要过滤的文件写上
        if (is_dir($path . '/' . $afile)) {
            $tmp['type'] = 'dir';
            $tmp['size'] = '';
        } else if (is_file($path . '/' . $afile)) {
            $tmp['type'] = 'file';
            //文件大小
            $full_path = $path . '/' . $afile ;
            //echo $full_path;die();
            $tmp['size'] = round(filesize($full_path)/1024,2) . 'KB';
        }
        $tmp['dirtext']  = $path . '/' . $afile;
        $tmp['filename'] = $afile;
        $tmp['dirtext2'] = str_replace(__DIR__ . '/', '', $path . '/' . $afile);
        
        // echo 1; die();
        
        $file[] = $tmp;
    }
    $data = [
        'Code' => 200,
        'CountNum' => count($file),
        'List' => $file
    ];
    returnAjax($data);
}

getfiles($dir);

function returnAjax($data)
{
    //header('Content-type:text/json');
    echo json_encode($data);
    exit;
}