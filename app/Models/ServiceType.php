<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $rules = [
        'title' => 'sometimes|required|title|unique:service_types',
    ];


    public function serviceCategory(){
        return $this->hasMany(ServiceCategory::class);
    }
}
