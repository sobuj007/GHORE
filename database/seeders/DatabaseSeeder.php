<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\BodyPart;
use App\Models\City;
use App\Models\Location;
use App\Models\ServiceProduct;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;
use Database\Seeders\CategorySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UsersTableSeeder::class);
        $this->call(CategorySeeder::class);


        City::factory(10)->create();
        Location::factory(10)->create();
        Subcategory::factory(10)->create();
        BodyPart::factory(10)->create();
        ServiceProduct::factory(50)->create();


        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

    }
}