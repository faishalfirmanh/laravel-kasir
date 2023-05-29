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
        
        if (gettype($data)) {
            $to_str = (string) $data;
            if (strpos($to_str, '[') !== false) { //list
                $count = count($data);
            }else{  
                $count = count(array($data));
            }
        }else{
            $count =  count(array($data));
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
        return response()->json([
            "status"=>"no",
            "msg"=> "no found or error",
            "total_data"=>count(array($data)),
            "data"=>$data
        ],404);
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
        }else{
            $total_column_response = count(get_object_vars($json_data[0]));
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
        if ((int)$total_kolom_set_param == $final_res_column) {
            return $this->responseSucess($final_data_convert);
        }else{
            return $this->responseError($final_data_convert);
        }
    }

}