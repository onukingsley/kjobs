<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;
    protected $fillable= ['company','title','location','email','tags','website','description','logo'];

    public function scopeFilter($query, array $filters){
        if ($filters['tag']?? false ){
            $query->where('tags', 'like', '%'. request('tag'). '%');
        }
        if ($filters['search']?? false){
            $query->where('description', 'like', '%'.request('search').'%')
                ->orwhere('title', 'like', '%'.request('search').'%')
                ->orwhere('tags', 'like', '%'.request('search').'%');
        }
    }
}



