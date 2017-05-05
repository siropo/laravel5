<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Route;

class ArticleRequest extends Request
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
        $route = Route::getCurrentRoute()->getName();
        //dd(Route::getCurrentRoute()->getName());
        $rulers = [
            'title' => 'required|min:3',
            'published_at' => 'required|date'
        ];

        if ($route == 'articles.store') {
            $rulers['body'] = 'required';
        }

        return $rulers;
    }

    public function messages()
    {
        return [
            'title.required' => 'Er, you forgot your email address!'
        ];
    }
}
