<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class PageController extends Controller
{
    public function about() {
        $name = '<span style="color:red">Viktor</span>';
        $people = [
            'pet', 'pesho', 'gosho'
        ];
        return view('pages.about')->with([
            'first' => 'Viktor',
            'second' => 'Ivanov',
            'people' => $people
        ]);
    }

    public function contact() {
        return view('pages.contact');
    }
}
