<?php

namespace App\Http\Traits;

trait ResponseApi{
    
    public function getResponse($data,$helpernya){
        if ($data != NULL) {
            if (intval($helpernya) < 1) {
                return response()->json([
                    "status"=>"ok",
                    "msg"=> "success",
                    "data"=> $data
                ],200);
            }else{
                return response()->json([
                    "status"=>"no",
                    "msg"=> "validated error",
                    "data"=> $data
                ],400);
            }
        }else{
            return response()->json([
                "status"=>"no",
                "msg"=> "no found or error",
                "data"=>null
            ],404);
        }
    }

    public function responseSucess($data){
        
        if (gettype($data) == 'object') {
            $to_str = (string) $data;
            // if (strpos($to_str, '[') !== false) { //list
            //     $count = count($data);
            // }else{  
            //     $count = count(array($data));
            // }
            $cek_first_character = substr($to_str, 0, 1);
            if ($cek_first_character == '[') {
                $count = count($data);
            }else{
                $count = count(array($data));
            }
        }else{ // array
            if (gettype($data) == 'boolean') {
                $count = 1;
            }else{
                $count =  count($data); //count(array($data));
            }
        }
       
       
        //die();
        return response()->json([
            "status"=>"ok",
            "msg"=> "success",
            "total_data"=>$count,//aslinya count(array($data))
            "data"=> $data
        ],200);
    }

    public function responseError($data){

        if (gettype($data) == 'object') {
            $to_str = (string) $data;
            $cek_first_character = substr($to_str, 0, 1);
            if ($cek_first_character == '[') {
                $count = count($data);
            }else{
                $count = count(array($data));
            }
        }else{
            $count = count($data);
        }

        if ($count > 0) { //hanya error saja
            return response()->json([
                "status"=>"no",
                "msg"=> "error",
                "total_data"=>$count,
                "data"=>$data
            ],404);
        }else{
            return $this->responseSucess($data);
        }
    }

    public function generalResponse($data,$total_kolom){
        $total_result_kolom = count(json_decode(json_encode($data), true));
        if ((int)$total_kolom == $total_result_kolom) {
            return $this->responseSucess($data);
        }else{
            return $this->responseError($data);
        }
    }

    public function convertDataToArrayObject($data)
    {
        if (is_object($data)) {
            $final_convert = $data;
        }else{
            $final_convert = array((object)['data' => $data]);
        }
        return $final_convert;
    }

    public function cekTotalColumDataBaseTipeData($json_data)
    {
        if (is_object($json_data)) {
            $p = array($json_data);
            $total_column_response = count(get_object_vars($p[0]));
        }else if(gettype($json_data) == 'array'){
            $arr_empty = array();
            $total_column_response = count( $json_data) < 1 ? count($arr_empty) : count(get_object_vars($json_data[0]));
        }else{
            $total_column_response = array($json_data);
        }
        return $total_column_response;
    }

   
     //property didalam data []->ada berapa, final used, param 
     //total_kolom_set_param -> total didalam data data[ ], kalau 
     //index data [ data { }] / 2 atau 3 nested
    public function generalResponseV2($data, $total_kolom_set_param)
    {
        $final_data_convert = $this->convertDataToArrayObject($data);//cek
        $json_data_ =  json_decode(json_encode($data),false);
        $final_res_column = $this->cekTotalColumDataBaseTipeData($json_data_);
        if ((int)$total_kolom_set_param == (int)$final_res_column) {
            return $this->responseSucess($final_data_convert);
        }else{
            return $this->responseError($final_data_convert);
        }
    }

}