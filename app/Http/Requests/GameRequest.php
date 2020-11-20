<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class GameRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name"=>['required'],
            "app_id"=>['required', 'max:20','unique:games,app_id,'.request()->input("id").',id,deleted_at,NULL'],
            "app_secret"=>['required', 'max:20','unique:games,app_secret,'.request()->input("id").',id,deleted_at,NULL'],
            "category_id"=>['required'],
            "game_short_code"=>['required','min:3','max:6','unique:games,game_short_code,'.request()->input("id").',id,deleted_at,NULL'],
            "game_access_token"=>['required'],
            "game_verify_token"=>['required','max:191'],
        ];
    }
}
