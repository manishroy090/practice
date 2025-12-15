<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ComissionRule;

class ComissionRuleSeeder extends Seeder
{
    public function run(): void
    {
        $commissionRules = [
            [
                'origin' => json_encode(['KTM']),
                'destination' => json_encode(['DEL']),
                'rate' => 5,
                'ratevalue' => 'percentage',
            ],
            [
                'origin' => json_encode(['KTM']),
                'destination' => json_encode(['DXB']),
                'rate' => 7,
                'ratevalue' => 'percentage',
            ],
            [
                'origin' => json_encode(['KTM']),
                'destination' => json_encode(['DOH']),
                'rate' => 600,
                'ratevalue' => 'flat',
            ],
            [
                'origin' => json_encode(['KTM']),
                'destination' => json_encode(['SIN']),
                'rate' => 8,
                'ratevalue' => 'percentage',
            ],
            [
                'origin' => json_encode(['DEL']),
                'destination' => json_encode(['KTM']),
                'rate' => 4,
                'ratevalue' => 'percentage',
            ],
            [
                'origin' => json_encode(['DXB']),
                'destination' => json_encode(['KTM']),
                'rate' => 500,
                'ratevalue' => 'flat',
            ],
            [
                'origin' => json_encode(['KTM']),
                'destination' => json_encode(['BKK']),
                'rate' => 6,
                'ratevalue' => 'percentage',
            ],
            [
                'origin' => json_encode(['KTM']),
                'destination' => json_encode(['HKG']),
                'rate' => 9,
                'ratevalue' => 'percentage',
            ],
            [
                'origin' => json_encode(['KTM']),
                'destination' => json_encode(['LHR']),
                'rate' => 1200,
                'ratevalue' => 'flat',
            ],
        ];

        ComissionRule::insert($commissionRules);
    }
}
