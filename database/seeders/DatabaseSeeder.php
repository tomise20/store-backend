<?php

namespace Database\Seeders;

use App\Models\PublicAccount;
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
        $this->call([
            AdminSeeder::class,
        ]);

        \App\Models\Product::factory(1000)->create();
    }
}
