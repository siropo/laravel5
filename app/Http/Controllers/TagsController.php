<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;

use App\Http\Requests;

class TagsController extends Controller
{

    public function show(Tag $tag)
    {
        $articles = $tag->articles;

        return view('articles.index', compact('articles'));
    }
}
