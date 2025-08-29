<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        

        Bank::firstOrCreate([


           'name'=>'Albaraka',
           'account_number'=>'1722040058001',

        ]);

        
        Bank::firstOrCreate([


           'name'=>'ALsham',
           'account_number'=>'55222047614464',

        ]);


        
        Bank::firstOrCreate([


           'name'=>'Bimo',
           'account_number'=>'698755243861455',

        ]);
    }
}
