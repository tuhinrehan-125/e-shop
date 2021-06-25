<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';

    protected $fillable = [
        'name', 'address', 'mobile_no', 'company_name', 'nid_no', 'commission_rate', 'delete_status',

    ];
    public function Payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function Advance()
    {
        return $this->hasMany(Advance::class);
    }
    public function Orders()
    {
        return $this->hasMany(Advance::class);
    }

}
