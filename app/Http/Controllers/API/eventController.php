<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Event;
use App\Category;
use Validator;
//use Illuminate\Support\Facades\Validator;

class eventController extends Controller
{
	public $successStatus = 200;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required|string|max:150|regex:/^[A-Za-z0-9\ \s]+$/',
            'description' => 'required|string|max:150|regex:/^[A-Za-z0-9\ \s]+$/',
            'category_name' => 'required|exists:categorys,name',
            'event_date' => 'date|date_format:Y-m-d',	
            'location' => 'required|alpha'
        ]);
	
        $category = Category::where('name',$input['category_name'])->first();
		$input['category_id'] = $category->id;

        if($validator->fails()){
			return response()->json(['Error.'=>$validator->errors()], 403);
        }

        $oEvents = Event::create($input);        
        return response()->json(['event_id' => $oEvents->id], $this-> successStatus); 
    } 


	/** 
	* details api 
	* 
	* @return \Illuminate\Http\Response 
	*/ 
    public function eventslists() 
    {	
    	$events = event::all();
	    return response()->json(['data' => $events], $this-> successStatus); 
	}
}
