<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Validation\Rule;

class AdminPostController extends Controller
{
    public function index()
    {
        return view('admin.posts.index', [
            'posts' => Post::paginate(50)
        ]);
    }
    public function create()
    {
        return view('admin.posts.create');
    }
    public function store()
    {
        auth()->user()->posts()->create(array_merge($this->validatePost(), [
            'thumbnail' => request()->file('thumbnail')->store('thumbnails')
        ]));
        return redirect('/')->with('success', 'Your post has been published.');
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', ['post' => $post]);
    }

    public function update(Post $post)
    {
        $attributes = $this->validatePost($post);

        if(isset($attributes['thumbnail'])){
            $attributes['thumbnail'] = request()->file('thumbnail')->store('thumbnails');
        }

        $post->update($attributes);

        return back()->with('success', 'Post Updated!');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return back()->with('success', 'Post Deleted!');

    }

    protected function validatePost(?Post $post = null): array
    {
        $post ??= new Post();
        return request()->validate([
            'title' => 'required|max:255',
            'thumbnail' => $post->exists ? 'image' : 'required|image',
            'excerpt' => 'required|max:255',
            'body' => 'required|min:3',
            'category_id' => ['required', Rule::exists('categories','id')]
        ]);
    }
}
