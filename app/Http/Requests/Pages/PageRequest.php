<?php

namespace App\Http\Requests\Pages;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return  request()->isMethod('GET') || Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return request()->isMethod('GET')? []: [
            //
            'title' => 'required',
            'link' => 'required|unique:pages',
            'label' => 'required',
            'view' => 'required',
            'layout' => 'required',
        ];
    }
}
