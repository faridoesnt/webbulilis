<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call(LocationsSeeder::class);

        // $this->call(IndoRegionProvinceSeeder::class);
        // $this->call(IndoRegionRegencySeeder::class);
        // $this->call(IndoRegionDistrictSeeder::class);
        // $this->call(IndoRegionVillageSeeder::class);
    }
}
