<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category_id'=>'required',
            'title' =>'required',
            'content'=>'required',
        ];
    }

    public function  messages()
    {
        return [
            'category_id.required'=>'请选择一个专栏',
            'title.required'=>'没有写标题哦',
            'content.required'=>'内容不能为空',
        ];
    }
}
