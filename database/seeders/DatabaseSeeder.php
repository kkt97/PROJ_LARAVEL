<?php

namespace Database\Seeders;

use App\Models\Board\Board;
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
        // \App\Models\User::factory(10)->create();

        if (config('database.default') !== 'sqlite') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
        }

        try {
            User::truncate();
            Board::truncate();
        } catch (\Exception $e){
            dump($e->getMessage());
        }

        $this->call(UserTableSeeder::class);
        $this->call(BoardTableSeeder::class);

        if (config('database.default') !== 'sqlite') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }
    }
}
