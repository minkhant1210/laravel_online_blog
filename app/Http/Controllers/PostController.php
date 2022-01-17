<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //use with for eager loading
        //with local scope
        $posts = Post::search()->latest('id')->paginate(5);

        //without local scope
//        $posts = Post::when(isset(request()->search),function ($query){
//            $search = request()->search;
//            $query->where("title","like","%$search%")->orWhere("description","like","%$search%");
//        })->latest('id')->paginate(5);

        return view('post.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        $request->validate([
           "title" => "required|min:2|unique:posts,title",
           "category" => "required|integer|exists:categories,id",
           "description" => "required|min:10",
           "photo" => "nullable",
           "photo.*" => "file|max:3000|mimes:jpg,png",
            "tags" => "required",
            "tags.*" => "integer|exists:tags,id",
        ]);

        DB::beginTransaction();
        try {

            //posts stored in db
            $post = new Post();
            $post->title = $request->title;
            $post->slug = $request->title;
            $post->description = $request->description;
            $post->excerpt = $request->description;
            $post->category_id = $request->category;
            $post->user_id = Auth::id();
            $post->is_published = true;
            $post->save();

            //attach post and tag in pivot post_tag table
            $post->tags()->attach($request->tags);

            //auto create folder/directory
            if (!Storage::exists('/public/thumbnail')){
                Storage::makeDirectory('/public/thumbnail');
            }

            if ($request->hasFile('photos')){
                foreach ($request->file('photos') as $photo){
                    //save file
                    $newName = uniqid()."_photo.".$photo->extension();
                    $photo->storeAs('public/photo/',$newName);//storage folder

                    //save as thumbnail
                    $img = Image::make($photo);
                    $img->fit(200,200);
                    $img->save('storage/thumbnail/'.$newName); //public folder

                    //save in database
                    $photo = new Photo();
                    $photo->name = $newName;
                    $photo->post_id = $post->id;
                    $photo->user_id = Auth::id();
                    $photo->save();
                }
            }
            DB::commit();

        }catch (\Exception $e){
            DB::rollBack();
            throw $e;
        }

        return redirect()->route('post.index')->with("status"," Post is Added");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('post.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('post.edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $request->validate([
            "title" => "required|min:2|unique:posts,title,$post->id",
            "category" => "required|integer|exists:categories,id",
            "description" => "required|min:10"
        ]);

        $post->title = $request->title;
        $post->slug = Str::slug($request->title);
        $post->description = $request->description;
        $post->excerpt = Str::words($request->description,20);
        $post->category_id = $request->category;
        $post->update();

        //delete from post_tag pivot table
        $post->tags()->detach();

        //Save News tags to pivot table
        $post->tags()->attach($request->tags);

        return redirect()->route('post.index')->with("status"," Category is Updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        foreach ($post->photos as $photo) {
            //delete from file
            Storage::delete('public/photo/'.$photo->name);
            Storage::delete('public/thumbnail/'.$photo->name);
        }

        //delete all records from hasMany
        $post->photos()->delete();

        //delete from post_tag pivot table
        $post->tags()->detach();

        $post->delete();
        return redirect()->route('post.index')->with("status", "Category is Deleted");
    }
}
