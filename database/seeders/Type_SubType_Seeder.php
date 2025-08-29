<?php

namespace Database\Seeders;

use App\Models\PropertySubType;
use App\Models\PropertyType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Type_SubType_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PropertyType::create([
           'type'=>'cmmercial',
        ]);

         PropertyType::create([
           'type'=>'residential',
         ]);

         PropertyType::create([
           'type'=>
              'industrial',
         ]);
         PropertyType::create([
         
              'type'=>'agricultural'
         ]);

      



        PropertySubType::create([
          'type_id'=>2,
           'subtype'=>'house',
        ]);
        

         PropertySubType::create([
                    'type_id'=>2,

           'subtype'=>'apartment',
         ]);

         PropertySubType::create([
          'type_id'=>4,
           'subtype'=>
              'land',
         ]);
         PropertySubType::create([
          
               'type_id'=>2,
              'subtype'=> 'villa',
         ]);
         
         PropertySubType::create([
               'type_id'=>3,
              'subtype'=> 'factory',
         ]);
         PropertySubType::create([
               'type_id'=>1,
              'subtype'=> 'office',
         ]);
         PropertySubType::create([
               'type_id'=>1,
              'subtype'=> 'store',
         ]);
         PropertySubType::create([
               'type_id'=>1,
              'subtype'=> 'hotel',
         ]);
         PropertySubType::create([
               'type_id'=>1,
              'subtype'=> 'resturant',
         ]);
         PropertySubType::create([
               'type_id'=>3,
              'subtype'=> 'warehouse',
         ]);
         
           PropertySubType::create([
               'type_id'=>4,
              'subtype'=> 'farm',
         ]);
         
           PropertySubType::create([
               'type_id'=>4,
              'subtype'=> 'greenhouse',
         ]);
         
         

        


    }
}
