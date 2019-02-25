<?php

use Illuminate\Database\Seeder;
use App\Models\AbuseType;

class AbuseTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!AbuseType::where('id', 1)->first()) {
            AbuseType::create([
                'id' => 1,
                'name' => 'Публикация',
            ]);
        }
        if (!AbuseType::where('id', 2)->first()) {
            AbuseType::create([
                'id' => 2,
                'name' => 'Комментарий',
            ]);
        }

    }
}
