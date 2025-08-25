<?php

namespace Database\Seeders;

use App\Models\MaintenanceWorkShops;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkshopsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
           MaintenanceWorkShops::create([

               'name'=>'Elite Building Repairs',
        'work_type'=>'Painting & Renovation',
        'phone_number'=>'0559876543',
        'location'=>'Jeddah, Tahlia Street, Opposite Arab Mall',
            


        ]);


          MaintenanceWorkShops::create([

               'name'=>'MasterFix Construction',
        'work_type'=>'HVAC & AC Repair',
        'phone_number'=>'0591122334',
        'location'=>'Dammam, Gulf Road, Building 12',
            


        ]);

          MaintenanceWorkShops::create([

               'name'=>'Urban Property Maintenance',
        'work_type'=>'Plumbing & Electrical',
        'phone_number'=>'0501234567',
        'location'=>'Riyadh, Olaya District, King Fahd Street',
            


        ]);


          MaintenanceWorkShops::create([

               'name'=>'ProHome Solutions',
        'work_type'=>'Roofing & Waterproofing',
        'phone_number'=>'0507654321',
        'location'=>'Riyadh, Al Malaz, Prince Sultan Street',
            


        ]);




    }
}
