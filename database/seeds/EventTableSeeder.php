<?php

use Illuminate\Database\Seeder;

use App\Event;
use App\Category;
use App\Location;

class EventTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$categoryAuto = Category::where('name', 'autocar prmotions')->first();
    	$categoryClothes = Category::where('name', 'clothes exhibition')->first();
    	$categoryFood = Category::where('name', 'food festivals')->first();

    	$oLocationAbad = Location::where('city', 'ahmedabad')->first();
    	$oLocationSurat = Location::where('city', 'surat')->first();
    	$oLocationBaroda = Location::where('city', 'baroda')->first();

		$oEvent = new Event();
	    $oEvent->category_id = $categoryAuto->id;
	    $oEvent->location_id = $oLocationAbad->id;
	    $oEvent->title = 'Women wedding selection';
	    $oEvent->description = 'Wonderful Wedding Clothes Exhibition';
	    $oEvent->event_date = '2020-05-10';
	    $oEvent->save();
        unset($oEvent);

		$oEvent = new Event();
	    $oEvent->category_id = $categoryAuto->id;
	    $oEvent->location_id = $oLocationAbad->id;
	    $oEvent->title = 'Summerware specials';
	    $oEvent->description = 'Wonderful Summer Special Exhibition';
	    $oEvent->event_date = '2020-05-10';
	    $oEvent->save();
        unset($oEvent);

		$oEvent = new Event();
	    $oEvent->category_id = $categoryAuto->id;
	    $oEvent->location_id = $oLocationBaroda->id;
	    $oEvent->title = 'Auto expo 2020';
	    $oEvent->description = 'four wheeler and two wheeler exhibition';
	    $oEvent->event_date = '2020-05-20';
	    $oEvent->save();
        unset($oEvent);

		$oEvent = new Event();
	    $oEvent->category_id = $categoryAuto->id;
	    $oEvent->location_id = $oLocationBaroda->id;
	    $oEvent->title = 'auto three whelers';
	    $oEvent->description = 'Bajaj newly launch wheeler exhibition';
	    $oEvent->event_date = '2020-05-20';
	    $oEvent->save();
        unset($oEvent);

		$oEvent = new Event();
	    $oEvent->category_id = $categoryFood->id;
	    $oEvent->location_id = $oLocationSurat->id;
	    $oEvent->title = 'food festival';
	    $oEvent->description = 'traditional food festival';
	    $oEvent->event_date = '2020-05-23';
	    $oEvent->save();
        unset($oEvent);

    }
}
