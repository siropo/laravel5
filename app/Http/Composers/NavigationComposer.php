<?php

namespace App\Http\Composers;

use Illuminate\Contracts\View\View;

class NavigationComposer
{

    public function compose(View $view)
    {
        // dd(Articles::latest()->first());
        $lastest = \App\Articles::latest()->first();
        if (!$lastest) {
            $lastest = 'no latest';
        }
        $view->with('latest', \App\Articles::latest()->first());
    }
}