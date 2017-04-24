<?php

namespace App\Http\Controllers;

use App\Article;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    //
 public function create(){
     return view('article/create');
 }

 public function store(){
     $article = new Article();

//     dd(Auth::id());
//    dd($article);
     $input = $_REQUEST;
     $input['published_at']=Carbon::now();
     $input['user_id'] = Auth::id();
//     dd($input);
    if($article->save($input)){
        echo 'true';
    }
 }
}
