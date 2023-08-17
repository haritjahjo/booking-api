<?php

namespace App\Models;

use App\Models\FacilityCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Facility extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name'];
 
    public function category()
    {
        return $this->belongsTo(FacilityCategory::class, 'category_id');
    }

    public function apartments()
    {
        return $this->belongsToMany(Apartment::class);
    }

}
