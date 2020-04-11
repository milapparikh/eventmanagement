<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use Validator;
use Illuminate\Support\Facades\DB;

class categoryController extends Controller
{
	public $successStatus = 200;
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function categoryEvent(Request $request)
    {
    	$input = $request->all();

		$validator = Validator::make($input, [
            'category_id' => 'required|exists:categorys,id'
        ]);

		$oCategory = DB::table('categorys')
                ->select( 'categorys.id','categorys.name',DB::raw('COUNT(events.id) as totalEvents'))
                ->leftJoin('events', 'events.category_id', '=', 'categorys.id')
                ->groupBy('events.category_id')
                ->get();

         return response()->json(['data' => $oCateg], $this-> successStatus); 
    }    
}
