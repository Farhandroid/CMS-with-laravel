<?php

namespace App\Http\Controllers;

use App\Http\Requests\Posts\CreatePostRequest;
use App\Http\Requests\posts\UpdatePostRequest;
use App\Post;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
 

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('posts.index')->with('posts',Post::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create')->with('categories',Category::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostRequest $request)
    {
    
        $image= $request->image->store('posts');
        $data=request()->all();
        $post=new Post();
        $post->title=$data['title'];
        $post->description=$data['description'];
        $post->content=$data['content'];
        $post->image=$image;
        $post->published_at=$data['published_at'];
        $post->category_id=$data['category']; /*because in create.blade,php category is dropdown menu . Whose id is category*/
        $post->save();
        session()->flash('success','Post Created successfully');
        return redirect(route('posts.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('posts.create')->with('post',$post)->with('categories',Category::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $data=$request->only(['title','description','published_at','content']);
        if($request->hasFile('image'))
        {
            $image= $request->image->store('posts');
            Storage::delete($post->image);
            $post->image=$image;
            $post->forceDelete();
        }
        $post->title=$data['title'];
        $post->description=$data['description'];
        $post->content=$data['content'];
        $post->published_at=$data['published_at'];
        $post->category_id=$data['category'];
        $post->save();
        session()->flash('success','Post Updated succesfully successfully');
        return redirect(route('posts.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post=Post::withTrashed()->where('id',$id)->firstOrFail();

        if ($post->trashed()) {
            Storage::delete($post->image);
            $post->forceDelete();
        } else {
            $post->delete();
        }
        session()->flash('success','Post deleted successfully');
        return redirect(route('posts.index'));
    }

       /**
     * Return trashed posts from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash()
    {
        $trashed=Post::onlyTrashed()->get();
        return view('posts.index')->with('posts',$trashed);
    }

    public function restore($id)
    {
        $post=Post::withTrashed()->where('id',$id)->firstOrFail();
        $post->restore();
        session()->flash('success','Post restored successfully');
        return redirect()->back();
    }
}
