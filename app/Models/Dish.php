<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    use HasFactory;

    protected $fillable =[
       'id',
       'name',
       'price',
       'descraption',
       'photo',
       'cat_id',
      
    ];
    //This fuction to find path of the photo store in project to delete it when i delete its row
    public function getPhotoPathAttribute()
    {  
        return  "app/public/images/". $this->photo; // Adjust this to your actual path logic
    }

    public function oderers()
    {
       return $this->belongsToMany(Order::class);
    }
 
    public function category()
    {
       return $this->belongsTo(Category::class,'cat_id');
    }
}
