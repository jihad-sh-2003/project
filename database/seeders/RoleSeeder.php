<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $superAdminRole=Role::firstOrCreate(['name'=>'super_admin']);
       $adminRole=Role::firstOrCreate(['name'=>'admin']);
       $userRole=Role::firstOrCreate(['name'=>'user']);

/*
       Permission::create(['name'=>'approve']);
 

       */


       $superAdminRole->givePermissionTo(permission::all());
      // $adminRole->givePermissionTo(['approve','']);
       //$userRole->givePermissionTo(['','']);

       $superAdmin=User::create([

        'name'=>'jihad',
        'email'=>'jihadkhalilsh@gmail.com',
        'password'=>hash::make('17023207'),
        'phone_number'=>'963954426402',
        'otp'=>null,
        'otp_expiry'=>null,
        'is_verified'=>1,

       ]);
       $superAdmin->assignRole($superAdminRole);
       

       $admin=User::create([
        'name'=>'ahmad',
        'email'=>'ahmad@gmail.com',
        'password'=>hash::make('123456789'),
        'phone_number'=>'987654321000',
        'otp'=>null,
        'otp_expiry'=>null,
        'is_verified'=>1,
       ]);

       $admin->assignRole($adminRole);

    }
}
