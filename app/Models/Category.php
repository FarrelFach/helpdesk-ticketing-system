<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
    ];

    use HasFactory;
    protected $table = "categories";
    protected $primaryKey = 'id';
    public $timestamps = false;
}
