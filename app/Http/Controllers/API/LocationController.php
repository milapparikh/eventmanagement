<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Location;
use App\Event;
use Validator; 
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

class LocationController extends Controller
{
    /**
     * create locations
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'city' => 'required|unique:locations|max:250|alpha'
        ]);

        if($validator->fails()){
            return response()->json(['status'=>400,'Error.'=>$validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        $oLocation = Location::create($input);
        return response()->json(['status'=>201,'data' => $oLocation], Response::HTTP_CREATED);
    }

    /**
     * read locations
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $oLocationList = Location::all(); 
        return response()->json(['status'=>200,'data' => $oLocationList], Response::HTTP_OK);
    }

    /**
     * update location
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'city' => 'required|unique:locations|max:250|alpha'
        ]);


        if($validator->fails()){
            return response()->json(['status'=>400,'Error.'=>$validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        $oLocation = Location::findOrFail($id);
        $oLocation->update($request->all());
        return response()->json(['status'=>200,'location_id'=>$oLocation->id,'data'=>'Location updated successfully.'], Response::HTTP_OK);
    }

    /** 
     * delete location
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request,$id)
    {
        $eventListCount = Event::where('location_id',$id)->count();

        if($eventListCount == 0){
	        Location::findOrFail($id)->delete();
            return response()->json(['status'=>200,'data'=>'Location deleted successfully.'], Response::HTTP_OK); 
        }
        else
            return response()->json(['status'=>400,'Error.'=>'Location cannot deleted.'], Response::HTTP_BAD_REQUEST);
    }

    /**
     * List the Location and count events
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function locationwiseEvents(Request $request)
    {
    	$input = $request->all();

		$validator = Validator::make($input, [
            'id' => 'required|exists:locations,id'
        ]);

        if($validator->fails()){
            return response()->json(['status'=>400,'Error.'=>$validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        $oLocationsEvents = DB::table('locations')
                ->select('locations.city',DB::raw('COUNT(events.id) as totalEvents'))
                ->leftJoin('events', 'events.location_id', '=', 'locations.id')
                ->where('locations.id',$input['id'])
                ->groupBy('locations.city')
                ->get();

        return response()->json(['status'=>200,'data' => $oLocationsEvents], Response::HTTP_OK);
    }
}
