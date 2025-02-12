<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $rules = [
        'title' => 'sometimes|required|title|unique:service_categories',
    ];

    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
