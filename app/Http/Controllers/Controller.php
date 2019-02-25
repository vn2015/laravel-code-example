<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Get formatting validation errors
     * @param $requestData array
     * @param $rules array
     * @param $messages array
     * @return mixed
     */
    public static function getValidationResponse($requestData, $rules, $messages)
    {
        $validator = Validator::make($requestData,$rules, $messages);

        if ($validator->fails()) {
            $errors = [];
            $add =[];
            $update =[];
            $delete =[];
            $messages = $validator->errors()->getMessages();
            foreach ($messages as $key =>$value) {
                $pieces = explode(".", $key);
                $count = count($pieces);
                switch ($count) {
                    case 1:
                        $arrName = $pieces[0];
                        $$arrName = $value[0];
                        break;
                    case 2:
                        $arrName = $pieces[0];
                        $arrIndex = $pieces[1];
                        $$arrName[$arrIndex] = $value[0];
                        break;
                    case 3:
                        $arrName = $pieces[0];
                        $arrIndex = $pieces[1];
                        $arrField = $pieces[2];
                        $$arrName[$arrIndex][$arrField] = $value[0];
                        break;
                }
            }
            if (count($add)>0) $errors["add"] = $add;
            if (count($update)>0) $errors["update"] = $update;
            if (count($delete)>0) $errors["delete"] = $delete;

            return $errors;
        }

        return false;
    }
}
