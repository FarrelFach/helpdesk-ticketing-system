<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogTicket extends Model
{
    use HasFactory;
    protected $table = "log_tickets";
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
