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

if(empty($params['CHECK_ONLY_DICTIONARY'])){
    $params['CHECK_ONLY_DICTIONARY'] = 'N';
}


try {

    // Decoding dictionary setup
    $file_handle = fopen('./dictionaries/words_'.$params['LANGUAGE'].'.txt', 'r');
    if(!$file_handle) {
        throw new Exception('Error opening dictionary', 1);
    }

    $aDICTIONARY = [];
    $dictionary_size = 0;
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

            $dictionary_size++;

            $key = 'WRD_'.$line_len;
            if(empty($aDICTIONARY[$key])){
                $aDICTIONARY[$key] = [];
            }

            // $line = strtoupper($line);

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

    if($params['CHECK_ONLY_DICTIONARY'] == 'Y'){

    }else{
        if($params['MODE'] == 'M1'){

            //Word 2 - Position 1 in $aWORD array
            foreach($aDICTIONARY['WRD_4'] as $key_4_L0 => $aWORD_CHAR_4_L0){

                $valid = false;

                $aWORD = ['','','','','','','','','','','','','','',''];  // Initialize an array just slightly larger than I expect to use

                if(
                    substr($aWORD_CHAR_4_L0, 1, 1) == substr($aWORD_CHAR_4_L0, 2, 1)
                ){

                    $aSYMBOLs["SYMB_01"]['value'] = substr($aWORD_CHAR_4_L0, 0, 1); //Triangle pointing down
                    $aSYMBOLs["SYMB_09"]['value'] = substr($aWORD_CHAR_4_L0, 1, 1); //Two overlapping points
                    $aSYMBOLs["SYMB_09"]['value'] = substr($aWORD_CHAR_4_L0, 2, 1); //Two overlapping points
                    $aSYMBOLs["SYMB_05"]['value'] = substr($aWORD_CHAR_4_L0, 3, 1); //Triangle pointing up

                    $aWORD_1 = $aWORD_CHAR_4_L0;


                    //Word 4 - Position 3 in $aWORD array
                    foreach($aDICTIONARY['WRD_3'] as $key_3_L1 => $aWORD_CHAR_3_L1){

                        $selector = 'SYMB_05';
                        if(empty( $aSYMBOLs[$selector]['value'] )){
                            throw new Exception("Empty selector value - $selector: ".$aWORD_CHAR_4_L0, 1);
                        }

                        if(
                            substr($aWORD_CHAR_3_L1, 0, 1) == $aSYMBOLs["SYMB_05"]['value']
                        ){

                            $aSYMBOLs["SYMB_12"]['value'] = substr($aWORD_CHAR_3_L1, 1, 1); //Square
                            $aSYMBOLs["SYMB_03"]['value'] = substr($aWORD_CHAR_3_L1, 2, 1); //Percentage

                            $aWORD_3 = $aWORD_CHAR_3_L1;


                            //Word 7 - Position 6 in $aWORD array
                            foreach($aDICTIONARY['WRD_3'] as $key_3_L2 => $aWORD_CHAR_3_L2){

                                $selector = 'SYMB_09';
                                if(empty( $aSYMBOLs[$selector]['value'] )){
                                    throw new Exception("Empty selector value - $selector: ".$aWORD_CHAR_4_L0, 2);
                                }

                                if(
                                    substr($aWORD_CHAR_3_L2, 2, 1) == $aSYMBOLs["SYMB_09"]['value']
                                ){
                                    $aSYMBOLs["SYMB_19"]['value'] = substr($aWORD_CHAR_3_L2, 0, 1); //Single dot
                                    $aSYMBOLs["SYMB_04"]['value'] = substr($aWORD_CHAR_3_L2, 1, 1); //Circle crossed out diagonally

                                    $aWORD_6 = $aWORD_CHAR_3_L2;


                                    //Word 1 - Position 0 in $aWORD array
                                    foreach($aDICTIONARY['WRD_6'] as $key_6_L3 => $aWORD_CHAR_6_L3){

                                        $selector = 'SYMB_01';
                                        if(empty( $aSYMBOLs[$selector]['value'] )){
                                            throw new Exception("Empty selector value - $selector: ".$aWORD_CHAR_3_L2, 3);
                                        }

                                        $selector = 'SYMB_03';
                                        if(empty( $aSYMBOLs[$selector]['value'] )){
                                            throw new Exception("Empty selector value - $selector: ".$aWORD_CHAR_3_L2, 4);
                                        }

                                        $selector = 'SYMB_04';
                                        if(empty( $aSYMBOLs[$selector]['value'] )){
                                            throw new Exception("Empty selector value - $selector: ".$aWORD_CHAR_3_L2, 5);
                                        }

                                        $selector = 'SYMB_05';
                                        if(empty( $aSYMBOLs[$selector]['value'] )){
                                            throw new Exception("Empty selector value - $selector: ".$aWORD_CHAR_3_L2, 6);
                                        }

                                        if(
                                                substr($aWORD_CHAR_6_L3, 0, 1) == $aSYMBOLs["SYMB_01"]['value']
                                            &&  substr($aWORD_CHAR_6_L3, 2, 1) == $aSYMBOLs["SYMB_03"]['value']
                                            &&  substr($aWORD_CHAR_6_L3, 3, 1) == $aSYMBOLs["SYMB_04"]['value']
                                            &&  substr($aWORD_CHAR_6_L3, 4, 1) == $aSYMBOLs["SYMB_05"]['value']
                                        ){
                                            $aSYMBOLs["SYMB_02"]['value'] = substr($aWORD_CHAR_6_L3, 1, 1); //Triangle with downward pointing crossed out
                                            $aSYMBOLs["SYMB_06"]['value'] = substr($aWORD_CHAR_6_L3, 5, 1); //Down arrow to the left

                                            $aWORD_0 = $aWORD_CHAR_6_L3;


                                            //Word 3 - Position 2 in $aWORD array
                                            foreach($aDICTIONARY['WRD_4'] as $key_4_L4 => $aWORD_CHAR_4_L4){

                                                $selector = 'SYMB_09';
                                                if(empty( $aSYMBOLs[$selector]['value'] )){
                                                    throw new Exception("Empty selector value - $selector: ".$aWORD_CHAR_6_L3, 7);
                                                }

                                                $selector = 'SYMB_12';
                                                if(empty( $aSYMBOLs[$selector]['value'] )){
                                                    throw new Exception("Empty selector value - $selector: ".$aWORD_CHAR_6_L3, 8);
                                                }

                                                if(
                                                        substr($aWORD_CHAR_4_L4, 0, 1) == $aSYMBOLs["SYMB_09"]['value']
                                                    &&  substr($aWORD_CHAR_4_L4, 3, 1) == $aSYMBOLs["SYMB_12"]['value']
                                                ){
                                                    $aSYMBOLs["SYMB_10"]['value'] = substr($aWORD_CHAR_4_L4, 2, 1); //C
                                                    $aSYMBOLs["SYMB_11"]['value'] = substr($aWORD_CHAR_4_L4, 3, 1); //X

                                                    $aWORD_2 = $aSYMBOLs["SYMB_08"]['value'] .' '. $aWORD_CHAR_4_L4;


                                                    //Word 5 - Position 4 in $aWORD array
                                                    foreach($aDICTIONARY['WRD_6'] as $key_6_L5 => $aWORD_CHAR_6_L5){

                                                        $selector = 'SYMB_10';
                                                        if(empty( $aSYMBOLs[$selector]['value'] )){
                                                            throw new Exception("Empty selector value - $selector: ".$aWORD_CHAR_4_L4, 10);
                                                        }

                                                        $selector = 'SYMB_03';
                                                        if(empty( $aSYMBOLs[$selector]['value'] )){
                                                            throw new Exception("Empty selector value - $selector: ".$aWORD_CHAR_4_L4, 11);
                                                        }

                                                        $selector = 'SYMB_11';
                                                        if(empty( $aSYMBOLs[$selector]['value'] )){
                                                            throw new Exception("Empty selector value - $selector: ".$aWORD_CHAR_4_L4, 12);
                                                        }

                                                        if(
                                                                substr($aWORD_CHAR_6_L5, 1, 1) == $aSYMBOLs["SYMB_10"]['value']
                                                            &&  substr($aWORD_CHAR_6_L5, 2, 1) == $aSYMBOLs["SYMB_10"]['value']
                                                            &&  substr($aWORD_CHAR_6_L5, 4, 1) == $aSYMBOLs["SYMB_03"]['value']
                                                            &&  substr($aWORD_CHAR_6_L5, 5, 1) == $aSYMBOLs["SYMB_11"]['value']
                                                        ){
                                                            $aSYMBOLs["SYMB_14"]['value'] = substr($aWORD_CHAR_6_L5, 0, 1); //Triangle with dots on the edges

                                                            $aWORD_4 = $aSYMBOLs["SYMB_13"]['value'] .' '. $aWORD_CHAR_6_L5;


                                                            //Word 8 - Position 7 in $aWORD array
                                                            foreach($aDICTIONARY['WRD_4'] as $key_4_L6 => $aWORD_CHAR_4_L6){

                                                                $selector = 'SYMB_04';
                                                                if(empty( $aSYMBOLs[$selector]['value'] )){
                                                                    throw new Exception("Empty selector value - $selector: ".$aWORD_CHAR_6_L5, 13);
                                                                }

                                                                $selector = 'SYMB_14';
                                                                if(empty( $aSYMBOLs[$selector]['value'] )){
                                                                    throw new Exception("Empty selector value - $selector: ".$aWORD_CHAR_6_L5, 14);
                                                                }

                                                                $selector = 'SYMB_09';
                                                                if(empty( $aSYMBOLs[$selector]['value'] )){
                                                                    throw new Exception("Empty selector value - $selector: ".$aWORD_CHAR_6_L5, 15);
                                                                }

                                                                if(
                                                                        substr($aWORD_CHAR_4_L6, 0, 1) == $aSYMBOLs["SYMB_04"]['value']
                                                                    &&  substr($aWORD_CHAR_4_L6, 1, 1) == $aSYMBOLs["SYMB_14"]['value']
                                                                    &&  substr($aWORD_CHAR_4_L6, 2, 1) == $aSYMBOLs["SYMB_09"]['value']
                                                                ){
                                                                    $aSYMBOLs["SYMB_20"]['value'] = substr($aWORD_CHAR_4_L6, 3, 1); //Tall, narrow rectangle

                                                                    $aWORD_7 = $aSYMBOLs["SYMB_08"]['value'] . $aSYMBOLs["SYMB_08"]['value'] .' '. $aWORD_CHAR_4_L6;

                                                                    //Word 6 - Position 5 in $aWORD array
                                                                    foreach($aDICTIONARY['WRD_6'] as $key_6_L7 => $aWORD_CHAR_6_L7){

                                                                        $selector = 'SYMB_03';
                                                                        if(empty( $aSYMBOLs[$selector]['value'] )){
                                                                            throw new Exception("Empty selector value - $selector: ".$aWORD_CHAR_4_L6, 16);
                                                                        }

                                                                        $selector = 'SYMB_11';
                                                                        if(empty( $aSYMBOLs[$selector]['value'] )){
                                                                            throw new Exception("Empty selector value - $selector: ".$aWORD_CHAR_4_L6, 17);
                                                                        }

                                                                        if(
                                                                                substr($aWORD_CHAR_6_L7, 1, 1) == $aSYMBOLs["SYMB_03"]['value']
                                                                            &&  substr($aWORD_CHAR_6_L7, 3, 1) == $aSYMBOLs["SYMB_11"]['value']
                                                                        ){
                                                                            $aSYMBOLs["SYMB_15"]['value'] = substr($aWORD_CHAR_4_L6, 3, 1); //Horizontally crossed circle
                                                                            $aSYMBOLs["SYMB_16"]['value'] = substr($aWORD_CHAR_4_L6, 3, 1); //Plus
                                                                            $aSYMBOLs["SYMB_17"]['value'] = substr($aWORD_CHAR_4_L6, 3, 1); //Trapeze
                                                                            $aSYMBOLs["SYMB_18"]['value'] = substr($aWORD_CHAR_4_L6, 3, 1); //Circle with dot in the middle

                                                                            $aWORD_5 = $aWORD_CHAR_4_L6;

                                                                            $aWORD[0] = $aWORD_0;
                                                                            $aWORD[1] = $aWORD_1;
                                                                            $aWORD[2] = $aWORD_2;
                                                                            $aWORD[3] = $aWORD_3;
                                                                            $aWORD[4] = $aWORD_4;
                                                                            $aWORD[5] = $aWORD_5;
                                                                            $aWORD[6] = $aWORD_6;
                                                                            $aWORD[7] = $aWORD_7;

                                                                            if(!in_array(trim(implode(' ', $aWORD)), $aPHRASEs)){
                                                                                $aPHRASEs[] = trim(implode(' ', $aWORD));
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

        }else if($params['MODE'] == 'M2'){

        }
    }

    $aRESULTs['data'] = $aPHRASEs;

} catch (\Throwable $th) {
    $aRESULTs['status'] = 'KO';
    $aRESULTs['error_msg'] = 'Caught Throwable: ' . $th->getMessage();
    $aRESULTs['error_line'] = $th->getLine();
    $aRESULTs['error_code'] = $th->getCode();
}


$end_time = microtime(true);
$timediff = $end_time - $start_time;

$aRESULTs['dictionary_selected'] = $params['LANGUAGE'];
$aRESULTs['dictionary_size'] = $dictionary_size;
$aRESULTs['phrases_count'] = count($aPHRASEs);
$aRESULTs['microtime_end'] = $end_time;
$aRESULTs['elapsed_time'] = sprintf('%0.2f', $timediff);

header('Content-Type: application/json;');
echo json_encode($aRESULTs);
