<?php

use Illuminate\Database\Seeder;

use App\Event;
use App\Category;

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

		$oEvent = new Event();
	    $oEvent->title = 'Women wedding selection';
	    $oEvent->description = 'Wonderful Wedding Clothes Exhibition';
	    $oEvent->category_id = $categoryAuto->id;
	    $oEvent->event_date = '2020-05-10';
	    $oEvent->location = 'Ahmedabad';
	    $oEvent->save();
        unset($oEvent);

		$oEvent = new Event();
	    $oEvent->title = 'Summerware specials';
	    $oEvent->description = 'Wonderful Summer Special Exhibition';
	    $oEvent->category_id = $categoryAuto->id;
	    $oEvent->event_date = '2020-05-10';
	    $oEvent->location = 'Ahmedabad';
	    $oEvent->save();
        unset($oEvent);

		$oEvent = new Event();
	    $oEvent->title = 'Auto expo 2020';
	    $oEvent->description = 'four wheeler and two wheeler exhibition';
	    $oEvent->category_id = $categoryAuto->id;
	    $oEvent->event_date = '2020-05-20';
	    $oEvent->location = 'Baroda';
	    $oEvent->save();
        unset($oEvent);

		$oEvent = new Event();
	    $oEvent->title = 'auto three whelers';
	    $oEvent->description = 'Bajaj newly launch wheeler exhibition';
	    $oEvent->category_id = $categoryAuto->id;
	    $oEvent->event_date = '2020-05-20';
	    $oEvent->location = 'Baroda';
	    $oEvent->save();
        unset($oEvent);

		$oEvent = new Event();
	    $oEvent->title = 'food festival';
	    $oEvent->description = 'traditional food festival';
	    $oEvent->category_id = $categoryFood->id;
	    $oEvent->event_date = '2020-05-23';
	    $oEvent->location = 'Surat';
	    $oEvent->save();
        unset($oEvent);

    }
}
