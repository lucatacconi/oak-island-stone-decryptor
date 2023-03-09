<?php

//Display all errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


//Star time
$start_time = microtime(true);

$params = array_merge($_GET,$_POST);
$params = array_change_key_case($params, CASE_UPPER);

$aRESULTs = [];
$aRESULTs['status'] = 'OK';
$aRESULTs['microtime_start'] = $start_time;

if(empty($params['LANGUAGE'])){
    throw new Exception("ERROR - Parameter not found (LANGUAGE)", 1);
}
if(!in_array($params['LANGUAGE'], ['EN','ES','FR','LATIN'])){
    throw new Exception("ERROR - Parameter not valid (LANGUAGE)", 1);
}

if(empty($params['MODE'])){
    throw new Exception("ERROR - Parameter not found (MODE)", 1);
}
if(!in_array($params['MODE'], ['M1','M2','M3','M4'])){
    throw new Exception("ERROR - Parameter not valid (MODE)", 1);
}


try {

    // Decoding dictionary setup
    $file_handle = fopen("./words_en.txt", "r");
    if(!$file_handle) {
        throw new Exception("Error opening dictionary", 1);
    }

    $aDICTIONARY = [];
    $aDBLSAMECHARSTART = [];
    while (!feof($file_handle)) {

        $line = str_replace([chr(10),chr(13)], '', trim(mb_convert_encoding(fgets($file_handle), 'UTF-8', "ISO-8859-1")));
        $line_len = strlen($line);

        if($line_len == 0){
            continue;
        }else{

            //Check if the word is in uppercase and enable the word
            if (ctype_upper($line)) {
                continue;
            }
            if(strpos('-', $line) !== false){
                continue;
            }
            if(strpos('.', $line) !== false){
                continue;
            }
            if(strpos(' ', $line) !== false){
                continue;
            }

            $key = 'WRD_'.$line_len;
            if(empty($aDICTIONARY[$key])){
                $aDICTIONARY[$key] = [];
            }

            $line = strtoupper($line);

            $aDICTIONARY[$key][] = $line;

            if(substr($line, 0, 1) == substr($line, 1, 1)){
                $aDBLSAMECHARSTART[] = $line;
            }
        }
    }

    fclose($file_handle);

} catch (\Throwable $th) {
    $aRESULTs["status"] = 'KO';
    $aRESULTs['error_msg'] = 'Caught Throwable: ' . $th->getMessage();
    $aRESULTs['error_line'] = $th->getLine();
}


$end_time = microtime(true);
$timediff = $end_time - $start_time;

$aRESULTs["dictionary_selected"] = $end_time;
$aRESULTs["microtime_end"] = $end_time;
$aRESULTs["elapsed_time"] = sprintf('%0.2f', $timediff);

header('Content-Type: application/json;');
echo json_encode($aRESULTs);
