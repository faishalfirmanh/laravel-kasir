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
        return response()->json([
            "status"=>"ok",
            "msg"=> "success",
            "data"=> $data
        ],200);
    }

    public function responseError($data){
        return response()->json([
            "status"=>"no",
            "msg"=> "no found or error",
            "data"=>$data
        ],404);
    }

}