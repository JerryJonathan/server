<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mail;
use App\Mail\PostMail;
use App\Mail\UpdateMail;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'NIK', 'image', 'image_name', 'name', 
        'province', 'regency', 'district',
        'village', 'postal',
        // 'agama'
    ];

    public static function boot() {
  
        parent::boot();
  
        static::created(function ($item) {
            $adminEmail = "jerryjochia@gmail.com";
            Mail::to($adminEmail)->send(new PostMail($item, $adminEmail));
        });

        static::updated(function ($item) {
            $adminEmail = "jerryjochia@gmail.com";
            Mail::to($adminEmail)->send(new UpdateMail($item, $adminEmail));
        });
    }
}
