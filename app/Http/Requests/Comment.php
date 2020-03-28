<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Comment extends FormRequest
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
            'name' => 'required|max:255',
            'message' => 'required',
            'post_id' => 'required|integer',
            'parent_comment_id' => 'integer',
            'nested_level' => 'integer'
        ];
    }
}
