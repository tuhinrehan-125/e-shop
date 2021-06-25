<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advance extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function Client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
    public function Bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }
    public function Mode()
    {
        return $this->belongsTo(Mode::class, 'select_mode');
    }
    public function Payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
