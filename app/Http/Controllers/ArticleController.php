<?php

namespace App\Http\Controllers;

use App\Articles;
use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Requests\ArticleRequest;
use Illuminate\Support\Facades\Auth;
use App\Tag;
use App\CustomClasses\Foo;

class ArticleController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['only' => 'create']);
    }

    public function index()
    {
        //return \Auth::user()->name;
        $articles = Articles::latest('published_at')->published()->get();

        return view('articles.index', compact('articles'));
    }

    public function show(Articles $article)
    {
        //dd($id);
        //$article = Articles::findOrFail($id);

        //dd($article->created_at->year);
        //dd($article->created_at->addDays(9)->format('Y-m'));
        // dd($article->published_at->addDays(9)->diffForHumans());
        return view('articles.show', compact('article'));
    }

    public function create(Articles $article, Foo $foo)
    {
       // dd($foo->pesho());
        $tags = Tag::lists('name', 'id');
        return view('articles.create', compact('tags', 'article'));
    }

//    public function store(Request $request)
//    {
//        $this->validate($request, ['title' => 'required', 'body' => 'required']);
//        // dd(Request::all());
//        Articles::create($request->all());
////        $article = new Articles();
////        $article->title = $input['title'];
//
//        return redirect('articles');
//    }
//
    public function store(ArticleRequest $request)
    {
         //dd($request->all());
        //Auth::user();
        $article = new Articles($request->all());
        Auth::user()->articles()->save($article);
        //user_id
        $tagsIds = $request->input('tags');
        ///dd($tagsIds);
        $article->tags()->attach($tagsIds);
        //\Session::flash('flash_message', 'Your ads has been created!');
       // \Session::flash('flash_message_important', true);

        //Articles::create($request->all()); // user_id => Auth::user()->id
//        $article = new Articles();
//        $article->title = $input['title'];

        return redirect('articles')->with([
            'flash_message' => 'Your ads has been created!',
            'flash_message_important' => true
        ]);
    }

    public function edit(Articles $article)
    {
        //$article = Articles::findOrFail($id);
        $tags = Tag::lists('name', 'id');
        //dd($article->tagsLists()->toArray());
        return view('articles.edit', compact('article', 'tags'));
    }

    public function update($id, ArticleRequest $request)
    {
        $article = Articles::findOrFail($id);
        $article->update($request->all());

        $tagsIds = $request->input('tags');
       // dd($tagsIds);
        $article->tags()->sync($tagsIds);

        return redirect('articles');
    }
}
