<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

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
    
    /**
     * バリデーション試行の失敗の処理
     *
     * @param Validator|\Illuminate\Contracts\Validation\Validator $validator
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        abort(400, implode('/', $validator->errors()->all()));
    }
    
    /**
     * URLのpathパラメータ(route parameter)もvalidationターゲットに含める
     *
     * @param array|null $keys
     * @return array
     */
    public function all($keys = null)
    {
        return array_replace_recursive(parent::all(), $this->route()->parameters());
    }
}
