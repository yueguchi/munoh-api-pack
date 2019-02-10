<?php

namespace App\Http\Requests;

class WordsPutCommandRequest extends BaseRequest
{
    /**Ø
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'word' => 'required'
        ];
    }
}
