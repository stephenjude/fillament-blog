<?php

namespace Illusive\Blog\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illusive\Blog\Models\Post;
use Illusive\Blog\Resources\PostApiResource;
use Inertia\Inertia;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $posts = Post::query()
            ->paginate(9);

        $posts = PostApiResource::collection($posts);

        return Inertia::render('Post/Index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(string $post)
    {
        $post = Post::where('slug', $post)->first();

        $post = new PostApiResource($post->load('media', 'author.media'));

        $morePosts = Post::query()
            ->whereHas('tags', function (Builder $query) use ($post) {
                $tagIds = collect($post->tags)->pluck('id');

                $query->whereIn('blog_tags.id', $tagIds);
            })->where('id', '!=', $post->id)
            ->take(4)->get();

        $morePosts = PostApiResource::collection($morePosts);

        return Inertia::render('Post/Show', compact('post', 'morePosts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort(404);
    }
}
