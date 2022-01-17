<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;
    protected $with = ['user','category','photos','tags'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function photos(){
        return $this->hasMany(Photo::class);
    }
    public function tags(){
        return $this->belongsToMany(Tag::class);
    }

    //accessor
//    public function getTitleAttribute($value){
//        return Str::words($value,10);
//    }
    public function getShortTitleAttribute(){
        return Str::words($this->title,10);
    }
    public function getShowTimeAttribute(){
        return "<p class='small mb-0'>
                    <i class='fas fa-calendar text-primary'></i>
                    ".$this->created_at->format('d-M-Y')."
                </p>
                <p class='small mb-0'>
                    <i class='fas fa-clock text-primary'></i>
                    ".$this->created_at->format('h:m A')."
                </p>";
    }
    //Mutator
    public function setSlugAttribute($value){
        $this->attributes['slug'] = Str::slug($value);
    }
    public function setExcerptAttribute($value){
        $this->attributes['excerpt'] = Str::words($value,20);
    }

    //events using closures
//    protected static function booted()
//    {
//        static::deleted(function (){
//            logger("Post is created");
//        });
//    }

    //query scope -> local scope
    public function scopeSearch($query){
        if (isset(request()->search)){
            $search = request()->search;
            return $query->where("title","like","%$search%")->orWhere("description","like","%$search%");
        }
    }

}
