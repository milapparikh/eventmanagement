<?php

use Illuminate\Database\Seeder;
use App\Location;

class LocationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $oLocation = new Location();
	    $oLocation->city = 'ahmedabad';
	    $oLocation->save();    
        unset($oLocation);

        $oLocation = new Location();
	    $oLocation->city = 'surat';
	    $oLocation->save();    
        unset($oLocation);

        $oLocation = new Location();
	    $oLocation->city = 'baroda';
	    $oLocation->save();    
        unset($oLocation);

        $oLocation = new Location();
	    $oLocation->city = 'anand';
	    $oLocation->save();    
        unset($oLocation);
    }
}
