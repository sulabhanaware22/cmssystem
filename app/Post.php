<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    public $table='post';
    protected $fillable=['name','description','url','user_id'];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function scopegetPost($query){
      return $query->where('deleted_flag',0)
                   ->where('status',1)
                   ->orderBy('id','desc');
    }
    public function geturlAttribute($value)
    {
      //  return 'http://127.0.0.1:8000/storage/'.$value;
      return config('constants.IMAGE_PATH').$value;
    }
    
}
