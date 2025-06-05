<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;
class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            'Acme Inc.',
            'Beta Corp.',
            'Gamma Solutions',
            'Delta Traders',
            'Epsilon Group',
            'Zeta Holdings',
            'Eta Logistics',
            'Theta Limited',
            'Iota Enterprises',
            'Kappa Partners',
        ];

        foreach ($customers as $name) {
            Customer::create(['name' => $name]);
        }
    }
}
