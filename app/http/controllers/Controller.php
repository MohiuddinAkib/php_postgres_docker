<?php

namespace App\http\controllers;

abstract class Controller
{
    protected function jsonify($data, $status = 200)
    {
        return response()->json($data, $status);
    }

    protected function send_json_collection(
        int $num,
        array $collection,
        string $msg = "no collection found"
    ) {
        if ($num > 0) {
            $collection_arr = [];

            $collection_arr['data'] = array_reduce($collection, function ($v1, $v2) {
                array_push($v1, $v2);
                return $v1;
            }, []);

            $this->jsonify($collection_arr, 404);
        } else {
            $this->jsonify($msg, 404);
        }
    }

    protected function send_json_resource(
        int $num,
        array $resource,
        string $msg = "no reource found"
    ) {
        if ($num > 0) {
            $resource_arr = [];

            $resource_arr['data'] = $resource[0];

            $this->jsonify($resource_arr, 404);
        } else {
            $this->jsonify($msg, 404);
        }
    }
}