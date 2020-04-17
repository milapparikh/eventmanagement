<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Event;
use App\Category;
use Validator;
//use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    private $successStatus = 200;
    private $validationStatus = 400;

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
            'event_date' => 'required|date|date_format:Y-m-d',	
            'location' => 'required|alpha'
        ]);
	
        $category = Category::where('name',$input['category_name'])->first();
		$input['category_id'] = $category->id;

        if($validator->fails()){
			return response()->json(['Error.'=>$validator->errors(),'status'=>$this->validationStatus]);
        }

        $oEvents = Event::create($input);        
        return response()->json(['data' => $oEvents,'status'=>$this->successStatus]); 
    } 


	/** 
	* details api 
	* 
	* @return \Illuminate\Http\Response 
	*/ 
    public function eventslists() 
    {	
    	$events = Event::all();
	    return response()->json(['data' => $events], $this-> successStatus); 
	}

    /**
     * update events
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required_without_all:description,category_name,event_date,location|string| max:150|regex:/^[A-Za-z0-9\ \s]+$/',
            'description' => 'required_without_all:title,category_name,event_date,location|string| max:150|regex:/^[A-Za-z0-9\ \s]+$/',
            'category_name' => 'required_without_all:description,title,event_date,location|exists:categorys,name',
            'event_date' => 'required_without_all:description,category_name,title,location|date|date_format:Y-m-d',   
            'location' => 'required_without_all:description,category_name,event_date,title|alpha'
        ]);

        if($validator->fails()){
            return response()->json(['Error.'=>$validator->errors(),'status'=>$this->validationStatus]);
        }

    
        if($input['category_name'] && $input['category_name'] != ''){
            $category = Category::where('name',$input['category_name'])->first();
            $input['category_id'] = $category->id;
        }


        $oEvents = Event::findOrFail($id);
        $oEvents->update($input);    
        return response()->json(['event_id' => $oEvents->id,'data'=>'Event updated successfully.','status'=>$this->successStatus]);
    }


    /**
     * delete category
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request,$id)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'id' => 'required'
        ]);

        if($validator->fails()){
            return response()->json(['Error.'=>$validator->errors(),'status'=>$this->validationStatus]);
        }

        Event::find($id)->delete();
        return response()->json(['data' => 'Event deleted successfully.','status'=>$this->successStatus]); 
    }

}
