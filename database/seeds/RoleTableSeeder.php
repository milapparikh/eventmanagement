<?php

use Illuminate\Database\Seeder;

use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role();
	    $role->name = 'admin';
	    $role->description = 'allowed to registrer users, allowed to create events';
	    $role->save();    
        unset($role);

	    $role = new Role();
	    $role->name = 'user';
	    $role->description = 'allowed to view events and comments to events';
	    $role->save();
        unset($role);

        $role = new Role();
        $role->name = 'guest';
        $role->description = 'allowed to view events';
        $role->save();
        unset($role);
    }
}
