<?php

namespace App\Models;

use App\Models\ConfrenceCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{
    use HasFactory;
    protected $fillable = [
          'name',
          'conference_category_id',
          'name',
          'conference_day',
          'conference_date',
          'conference_time',
          'place'
      ];



    // public function confrence_category()
    // {
    //     return $this->belongsTo(Category::class);
    // }
   

}
