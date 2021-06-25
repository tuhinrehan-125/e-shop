<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\Currency;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(CurrencySeeder::class);
        $this->call(PermissionsTableSeeder::class);
        // DB::table('users')->insert([
        //     'surname' => 'MR',
        //     'first_name' => 'Imtiaz',
        //     'last_name' => 'ahmed',
        //     'username' => 'admin',
        //     'email' => 'admin@gmail.com',
        //     'password' => bcrypt('admin1234'),
        // ]);

        // DB::table('business')->insert([
        //     'name' => 'Xyz',
        //     'currency_id' => Currency::first()->id,
        //     'owner_id' => User::first()->id
        // ]);
        // $user = User::first();
        // $user->business_id = Business::first()->id;
        // $user->save();
    }
}
