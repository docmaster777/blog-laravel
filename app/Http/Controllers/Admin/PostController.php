<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Post\StoreRequest;
use App\Http\Requests\Admin\Post\UpdateRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\Storage;
use mysql_xdevapi\Exception;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('admin.post.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.post.create', compact('categories', 'tags'));
    }

    public function store(StoreRequest $request)
    {
        try {
            $data = $request->validated();
            $tag_ids = $data['tag_ids'];
            unset($data['tag_ids']);
            $data['preview_image'] = Storage::disk('public')->put('/images', $data['preview_image']);
            $data['main_image'] = Storage::disk('public')->put('/images', $data['main_image']);

            $post = Post::firstOrCreate($data);
            $post->tags()->attach($tag_ids);
        } catch (Exception $exception) {
            abort('404');
        }

        return redirect()->route('admin.post.index');
    }

    public function show(Post $post)
    {
        return view('admin.post.show', compact('post'));
    }

    public function edit(Post $post)
    {

        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.post.edit', compact('post', 'categories', 'tags'));
    }

    public function update(UpdateRequest $request, Post $post)
    {
        $data = $request->validated();

        $tag_ids = $data['tag_ids'];
        unset($data['tag_ids']);


        if (isset($data['preview_image'])) {
            $data['preview_image'] = Storage::disk('public')->put('/images', $data['preview_image']);
        }
        if (isset($data['main_image'])) {
            $data['main_image'] = Storage::disk('public')->put('/images', $data['main_image']);
        }

        $post->update($data);

        $post->tags()->sync($tag_ids);


        return redirect()->route('admin.post.show', $post->id);
    }

    public function delete(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.post.index');
    }
}
