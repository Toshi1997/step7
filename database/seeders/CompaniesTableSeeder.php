<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->insert([
            [
                'company_name' => 'テスト企業A',
                'street_address' => '東京都渋谷区1-1-1',
                'representative_name' => '田中 太郎',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'company_name' => 'テスト企業B',
                'street_address' => '大阪府大阪市2-2-2',
                'representative_name' => '佐藤 花子',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}