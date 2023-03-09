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
$aRESULTs['data'] = [];
$aRESULTs['microtime_start'] = $start_time;

if(empty($params['LANGUAGE'])){
    throw new Exception("ERROR - Parameter not found (LANGUAGE)", 1);
}
if(!in_array($params['LANGUAGE'], ['EN','ES','FR','LATIN'])){
    throw new Exception('ERROR - Parameter not valid (LANGUAGE)', 1);
}

if(empty($params['MODE'])){
    throw new Exception('ERROR - Parameter not found (MODE)', 1);
}
if(!in_array($params['MODE'], ['M1','M2','M3','M4'])){
    throw new Exception('ERROR - Parameter not valid (MODE)', 1);
}

try {

    // Decoding dictionary setup
    $file_handle = fopen('./dictionaries/words_'.$params['LANGUAGE'].'.txt', 'r');
    if(!$file_handle) {
        throw new Exception('Error opening dictionary', 1);
    }

    $aDICTIONARY = [];
    $aDBLSAMECHARSTART = [];
    while (!feof($file_handle)) {

        $line = str_replace([chr(10),chr(13)], '', trim(mb_convert_encoding(fgets($file_handle), 'UTF-8', 'ISO-8859-1')));
        $line_len = strlen($line);

        if($line_len == 0){
            continue;
        }else{

            //Check if the word is in uppercase and enable the word
            if (ctype_upper($line)) {
                continue;
            }
            if(strpos($line, '-') !== false){
                continue;
            }
            if(strpos($line, '.') !== false){
                continue;
            }
            if(strpos($line, ',') !== false){
                continue;
            }
            if(strpos($line, ' ') !== false){
                continue;
            }
            if (preg_match('~[0-9]+~', $line)) {
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

    // print_r($aDICTIONARY);
    // print_r($aDBLSAMECHARSTART);

    // Now I try to interpret the cryptogram ========================================================================================================

    //Definition of the composition of the string to decode
    $aSYMBOLs = [];
    $aSYMBOLs["SYMB_01"] = [ 'type' => 'WRD', 'value' => '' ]; //Triangle pointing down
    $aSYMBOLs["SYMB_02"] = [ 'type' => 'WRD', 'value' => '' ]; //Triangle with downward pointing crossed out
    $aSYMBOLs["SYMB_03"] = [ 'type' => 'WRD', 'value' => '' ]; //Percentage
    $aSYMBOLs["SYMB_04"] = [ 'type' => 'WRD', 'value' => '' ]; //Circle crossed out diagonally
    $aSYMBOLs["SYMB_05"] = [ 'type' => 'WRD', 'value' => '' ]; //Triangle pointing up
    $aSYMBOLs["SYMB_06"] = [ 'type' => 'WRD', 'value' => '' ]; //Down arrow to the left
    $aSYMBOLs["SYMB_07"] = [ 'type' => 'WRD', 'value' => '' ]; //Square with dots on the edges
    $aSYMBOLs["SYMB_08"] = [ 'type' => 'NUM', 'value' => '2' ]; //Cross
    $aSYMBOLs["SYMB_09"] = [ 'type' => 'WRD', 'value' => '' ]; //Two overlapping points
    $aSYMBOLs["SYMB_10"] = [ 'type' => 'WRD', 'value' => '' ]; //C
    $aSYMBOLs["SYMB_11"] = [ 'type' => 'WRD', 'value' => '' ]; //X
    $aSYMBOLs["SYMB_12"] = [ 'type' => 'WRD', 'value' => '' ]; //Square
    $aSYMBOLs["SYMB_13"] = [ 'type' => 'NUM', 'value' => '5' ]; //Double cross
    $aSYMBOLs["SYMB_14"] = [ 'type' => 'WRD', 'value' => '' ]; //Triangle with dots on the edges
    $aSYMBOLs["SYMB_15"] = [ 'type' => 'WRD', 'value' => '' ]; //Horizontally crossed circle
    $aSYMBOLs["SYMB_16"] = [ 'type' => 'WRD', 'value' => '' ]; //Plus
    $aSYMBOLs["SYMB_17"] = [ 'type' => 'WRD', 'value' => '' ]; //Trapeze
    $aSYMBOLs["SYMB_18"] = [ 'type' => 'WRD', 'value' => '' ]; //Circle with dot in the middle
    $aSYMBOLs["SYMB_19"] = [ 'type' => 'WRD', 'value' => '' ]; //Single dot
    $aSYMBOLs["SYMB_20"] = [ 'type' => 'WRD', 'value' => '' ]; //Tall, narrow rectangle

    //For the values ​​that I consider numeric I assign a random number of 1 character at will


    $aPHRASEs = [];

    //Word 7 - Position 6 in $aWORD array
    foreach($aDICTIONARY['WRD_3'] as $key_3_L0 => $aWORD_CHAR_3_L0){

        $valid = false;

        $aWORD = ['','','','','','','','','','','','','','',''];  // Initialize an array just slightly larger than I expect to use

        $aSYMBOLs["SYMB_19"]['value'] = substr($aWORD_CHAR_3_L0, 0, 1); //Single dot
        $aSYMBOLs["SYMB_04"]['value'] = substr($aWORD_CHAR_3_L0, 1, 1); //Circle crossed out diagonally
        $aSYMBOLs["SYMB_09"]['value'] = substr($aWORD_CHAR_3_L0, 2, 1); //Two overlapping points

        $aWORD_6 = $aWORD_CHAR_3_L0;

        //Word 8
        foreach($aDICTIONARY['WRD_4'] as $key_4_L1 => $aWORD_CHAR_4_L1){

            $selector = 'SYMB_04';
            if(empty( $aSYMBOLs[$selector]['value'] )){
                throw new Exception("Empty selector value - $selector: ".$aWORD_CHAR_3_L0, 21);
            }
            $selector = 'SYMB_09';
            if(empty( $aSYMBOLs[$selector]['value'] )){
                throw new Exception("Empty selector value - $selector: ".$aWORD_CHAR_3_L0, 22);
            }

            if(substr($aWORD_CHAR_4_L1, 0, 1) == $aSYMBOLs["SYMB_04"]['value'] && substr($aWORD_CHAR_4_L1, 2, 1) == $aSYMBOLs["SYMB_09"]['value']){
                //Circle crossed out diagonally
                //Two overlapping points

                $aSYMBOLs["SYMB_14"]['value'] = substr($aWORD_CHAR_4_L1, 1, 1); //Triangle with dots on the edges
                $aSYMBOLs["SYMB_20"]['value'] = substr($aWORD_CHAR_4_L1, 3, 1); //Tall, narrow rectangle

                $aWORD_7 = $aSYMBOLs["SYMB_08"]['value'] . $aSYMBOLs["SYMB_08"]['value'] .' '. $aWORD_CHAR_4_L1;
                $valid = true;


                if($valid){
                    // $aWORD[1] = $aWORD_1;
                    // $aWORD[2] = $aWORD_2;
                    // $aWORD[3] = $aWORD_3;
                    // $aWORD[4] = $aWORD_4;
                    $aWORD[6] = $aWORD_6;
                    $aWORD[7] = $aWORD_7;

                    $aPHRASEs[] = implode(' ', $aWORD);
                }
            }
        }
    }

    $aRESULTs['data'] = $aPHRASEs;


} catch (\Throwable $th) {
    $aRESULTs['status'] = 'KO';
    $aRESULTs['error_msg'] = 'Caught Throwable: ' . $th->getMessage();
    $aRESULTs['error_line'] = $th->getLine();
}


$end_time = microtime(true);
$timediff = $end_time - $start_time;

$aRESULTs['dictionary_selected'] = $end_time;
$aRESULTs['microtime_end'] = $end_time;
$aRESULTs['elapsed_time'] = sprintf('%0.2f', $timediff);

header('Content-Type: application/json;');
echo json_encode($aRESULTs);
