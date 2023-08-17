<?php

namespace App\Models;

use App\Models\Facility;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FacilityCategory extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function facilities()
    {
        return $this->hasMany(Facility::class, 'category_id');
    }
}
