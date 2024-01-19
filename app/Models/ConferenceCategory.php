<?php

namespace App\Models;

 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConferenceCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        
    ];


 

    public function conferences()
    {
        return $this->hasMany(Conference::class ,  'conference_category_id' );
    }
   
}
