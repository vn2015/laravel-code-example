<?php

use Illuminate\Database\Seeder;
use App\Models\AbuseStatus;

class AbuseStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!AbuseStatus::where('id', 1)->first()) {
            AbuseStatus::create([
                'id' => 1,
                'name' => 'Не рассмотрена',
            ]);
        }
        if (!AbuseStatus::where('id', 2)->first()) {
            AbuseStatus::create([
                'id' => 2,
                'name' => 'Рассмотрена',
            ]);
        }

        if (!AbuseStatus::where('id', 3)->first()) {
            AbuseStatus::create([
                'id' => 3,
                'name' => 'Удовлетворена',
            ]);
        }
    }
}
