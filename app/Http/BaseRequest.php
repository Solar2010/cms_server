<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 2021/9/3
 * Time: 6:09 PM
 */

namespace App\Http;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function failedValidation(Validator $validator)
    {

        $error= $validator->errors()->all();
        throw  new HttpResponseException(response()->json(['code'=>400,'message'=>$error[0]]));
    }

}