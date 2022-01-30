<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Type;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MovimentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = Type::all();
        $categories = Category::all();

        for($i = 1; $i <= 10; $i++)
        {
            DB::table('moviments')->insert([
                'description' => "Movimentação {$i}",
                'value' => rand(1,999),
                'date' => date('Y-m-d'),
                'types_id' => $types->random()->id,
                'categories_id' => $categories->random()->id,
            ]);
        }

    }
}
