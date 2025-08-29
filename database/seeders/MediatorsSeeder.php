<?php

namespace Database\Seeders;

use App\Models\Mediator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MediatorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Mediator::firstOrCreate([
            'name'=>'ahmad alahmad',
            'contact_info'=>'0987654321',
            'location'=>'damascus',

        ]);

         Mediator::firstOrCreate([
            'name'=>'mohamad alsaeed',
            'contact_info'=>'0978521463',
            'location'=>'aleppo',

        ]);

         Mediator::firstOrCreate([
            'name'=>'ali samer',
            'contact_info'=>'0965478213',
            'location'=>'homs',

        ]);
      
    }
}
