<?php

namespace Database\Seeders;

use App\Models\Movement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MovementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Movement::insert([
            'type' => 'credit',
            'created_at'=> now(),
            'updated_at'=> now(),
        ]);
        Movement::insert([
            'type' => 'debit',
            'created_at'=> now(),
            'updated_at'=> now(),
        ]);
        Movement::insert([
            'type' => 'reversal',
            'created_at'=> now(),
            'updated_at'=> now(),
        ]);
    }
}
