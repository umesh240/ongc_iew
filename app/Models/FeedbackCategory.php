<?php

namespace App\Models;

 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FeedbackCategory extends Model
{
    use HasFactory;
    protected $fillable = [
          'title',
           
      ];


 
      public function feedbacks()
      {
          return $this->hasMany(Feedback::class ,  'feedback_category_id')->select('feedbacks.fb_id', 'feedbacks.feedback', 'feedbacks.feedback_category_id',  DB::raw('0 as rating'));
      }

}
