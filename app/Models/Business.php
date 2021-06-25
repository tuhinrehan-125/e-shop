<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    protected $table = 'business';

    protected $guarded = [];

    public function media()
    {
        return $this->morphOne(File::class, 'fileable');
    }
    
    public static function createBusiness($data)
    {
        $business = Business::create([
            'name' => $data['business_name'],
            'owner_id' => $data['owner_id'],
        ]);

        return $business;
    }
    public static function addLocation($data, $id)
    {
        $businesslocation = BusinessLocation::create([
            'business_id' => $id,
            'name' => $data['name'],
            'country' => $data['country'],
            'state' => $data['state'],
            'city' => $data['city'],
            'zip_code' => $data['zip_code'],
            'mobile' => $data['mobile'],
        ]);

        return $businesslocation;
    }

    public function Location()
    {
        return $this->hasMany(BusinessLocation::class);
    }
   
    public function return()
    {
        return $this->morphMany(SellPurchaseReturn::class,'returnable');
    }


}
