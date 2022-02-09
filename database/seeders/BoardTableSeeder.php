<?php

namespace Database\Seeders;

use App\Models\Board\Board;
use Illuminate\Database\Seeder;

class BoardTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Board::factory(20)->create();
    }
}
