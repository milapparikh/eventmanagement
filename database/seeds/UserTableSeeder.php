<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_role = Role::where('name', 'admin')->first();

		$ousers = new User();
        $ousers->role_id = $admin_role->id;
	    $ousers->name = 'admin';
	    $ousers->email = 'admin@gmail.com';
	    $ousers->password = bcrypt('Admin@123');
	    $ousers->save();
	    //$ousers->roles()->attach($admin_role);
        unset($ousers);

        $user_role = Role::where('name', 'user')->first();

        $ousers = new User();
        $ousers->role_id = $user_role->id;
        $ousers->name = 'test';
        $ousers->email = 'test@gmail.com';
        $ousers->password = bcrypt('Test@123');
        $ousers->save();
        //$ousers->roles()->attach($admin_role);
        unset($ousers);

    }
}
