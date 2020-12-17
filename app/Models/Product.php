<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Filter\QueryFilter;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $with = ['productImages']; #eager loading

    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    public function productImages(){
        return $this->hasMany(ProductImage::class);
    }

    /**
     * @param Illuminate\Database\Eloquent\Builder  $query
     * @param QueryFilter $filter
     */
    public function scopeFilter($query, QueryFilter $filter){
        $filter->apply($query);
    }
}
