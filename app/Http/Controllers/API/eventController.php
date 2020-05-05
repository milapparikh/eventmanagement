<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Event;
use App\Category;
use App\Location;
use Validator;
use Illuminate\Http\Response;

class EventController extends Controller
{
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
            'category_name' => 'required|exists:categorys,name',
            'city_name' => 'required|exists:locatons,city',
            'title' => 'required|string|max:150|regex:/^[A-Za-z0-9\ \s]+$/',
            'description' => 'required|string|max:150|regex:/^[A-Za-z0-9\ \s]+$/',
            'event_date' => 'required|date|date_format:Y-m-d',	
        ]);
	
        $category = Category::where('name',$input['category_name'])->first();
		$input['category_id'] = $category->id;

        $oLocation = Location::where('city',$input['city_name'])->first();
        $input['location_id'] = $oLocation->id;

        if($validator->fails()){
			return response()->json(['status'=>400,'Error.'=>$validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        $oEvents = Event::create($input);        
        return response()->json(['status'=>201,'data' => $oEvents], Response::HTTP_CREATED);
    } 


	/** 
	* details api 
	* 
	* @return \Illuminate\Http\Response 
	*/ 
    public function eventslists() 
    {	
    	$events = Event::all();
        return response()->json(['status'=>200,'data' => $events], Response::HTTP_OK);
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
            'title' => 'required_without_all:description,category_name,event_date,city_name|string| max:150|regex:/^[A-Za-z0-9\ \s]+$/',
            'description' => 'required_without_all:title,category_name,event_date,city_name|string| max:150|regex:/^[A-Za-z0-9\ \s]+$/',
            'category_name' => 'required_without_all:description,title,event_date,city_name|exists:categorys,name',
            'event_date' => 'required_without_all:description,category_name,title,city_name|date|date_format:Y-m-d',   
            'city_name' => 'required_without_all:description,category_name,event_date,title|exists:locations,city'
        ]);

        if($validator->fails()){
            return response()->json(['status'=>400,'Error.'=>$validator->errors()], Response::HTTP_BAD_REQUEST);
        }

    
        if($input['category_name'] && $input['category_name'] != ''){
            $category = Category::where('name',$input['category_name'])->first();
            $input['category_id'] = $category->id;
        }

        if($input['city_name'] && $input['category_name'] != ''){
            $oLocation = Location::where('city',$input['city_name'])->first();
            $input['location_id'] = $oLocation->id;
        }


        $oEvents = Event::findOrFail($id);
        $oEvents->update($input);   
        return response()->json(['status'=>200,'event_id' => $oEvents->id,'data'=>'Event updated successfully.'], Response::HTTP_OK);
    }



    /** 
    * displayed details of particular selected events
    * 
    * @return \Illuminate\Http\Response 
    */ 
    public function details(Request $request,$id) 
    {   
       // $oEvents = Event::findOrFail($id);
        $oEvents = Event::leftJoin('categorys', 'events.category_id', '=', 'categorys.id')
           ->select('events.*', 'categorys.name as c_name')
           ->where('events.id',$id)
           ->get();

        return response()->json(['status'=>200,'data' => $oEvents], Response::HTTP_OK);
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
           return response()->json(['status'=>400,'Error.'=>$validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        Event::find($id)->delete();
        return response()->json(['status'=>200,'data'=>'Event deleted successfully.'], Response::HTTP_OK); 
    }

    /** 
    * search events
    * 
    * @return \Illuminate\Http\Response 
    */ 
    public function search(Request $request) 
    {   
        $oEvent = Event::select('events.*', 'categorys.name as c_name', 'locations.city as l_city');
        $oEvent->leftJoin('categorys', 'categorys.id', '=', 'events.category_id');
        $oEvent->leftJoin('locations', 'locations.id', '=', 'events.location_id');

        if ($request->has('name')) {
            $oEvent->where('title',$request->name);
        }

        if ($request->has('date')) {
            $oEvent->where('event_date',$request->date);
        }

        if ($request->has('category_name')) {                        
            $oEvent->where('categorys.name',$request->category_name);
        }

        if ($request->has('city_name')) {            
            $oEvent->where('locations.city',$request->city_name);
        }
        
        $aEventData = $oEvent->get();
        return response()->json(['status'=>200,'data'=>$aEventData], Response::HTTP_OK); 
    }

}
