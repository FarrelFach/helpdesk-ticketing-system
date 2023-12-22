<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;
    protected $table = "histories";
    protected $primaryKey = 'id';
    protected $fillable = [
            'action',
            'model',
            'model_id',
            'field',
            'old_value',
            'new_value',
    ];
}
