<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $oCategory = new Category();
	    $oCategory->name = 'autocar prmotions';
	    $oCategory->save();    
        unset($oCategory);

        $oCategory = new Category();
	    $oCategory->name = 'clothes exhibition';
	    $oCategory->save();    
        unset($oCategory);

        $oCategory = new Category();
	    $oCategory->name = 'donation events';
	    $oCategory->save();    
        unset($oCategory);

        $oCategory = new Category();
	    $oCategory->name = 'food festivals';
	    $oCategory->save();    
        unset($oCategory);
    }
}
