<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Http\Requests\StorePhotoRequest;
use App\Http\Requests\UpdatePhotoRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $photos = Photo::where("user_id",Auth::id())->get();
        return view('photo.index');
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
     * @param  \App\Http\Requests\StorePhotoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePhotoRequest $request)
    {
        $request->validate([
            "post_id" => "required|integer",
            "photos" => "nullable",
            "photos.*" => "file|max:3000|mimes:jpg,png",
        ]);

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
                $photo->post_id = $request->post_id;
                $photo->user_id = Auth::id();
                $photo->save();
            }
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function show(Photo $photo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function edit(Photo $photo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePhotoRequest  $request
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePhotoRequest $request, Photo $photo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photo $photo)
    {
        //delete from file
        Storage::delete('public/photo/'.$photo->name);
        Storage::delete('public/thumbnail/'.$photo->name);
        //delete from db
        $photo->delete();
        return redirect()->back();
    }
}
