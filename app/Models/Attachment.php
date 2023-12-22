<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;
    protected $table = "attachments";
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }
}
