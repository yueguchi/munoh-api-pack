<?php

namespace App\Http\Requests;

class MecabGetRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          // コマンドインジェクション対策(弱)
          'word' => 'required'
        ];
    }
}
