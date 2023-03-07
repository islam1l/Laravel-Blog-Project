<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;


class PostController extends Controller
{
    public function index()
    {
        return view('posts.index',[
            'posts' => Post::latest()->filter(
                request(['search', 'category', 'author']))
                ->paginate(6)->withQueryString()
        ]);
    }

    public function show(Post $post)
    {
        return view('posts.show',[
            'post' => $post
        ]);
    }
    // stick with the seven restful actions
    // index, show, create, store, edit, update, destroy

}
