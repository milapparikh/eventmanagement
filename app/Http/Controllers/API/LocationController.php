<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Location;
use App\Event;
use Validator; 
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
	private $successStatus = 200;
    private $validationStatus = 400;

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
            return response()->json(['Error.'=>$validator->errors(),'status'=>$this->validationStatus]);
        }

        $oLocation = Location::create($input);
        return response()->json(['data' => $oLocation,'status'=>$this->successStatus]); 
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
        return response()->json(['data' => $oLocationList,'status'=>$this->successStatus]); 
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
            return response()->json(['Error.'=>$validator->errors(),'status'=>$this->validationStatus]);
        }

        $oLocation = Location::findOrFail($id);
        $oLocation->update($request->all());

        return response()->json(['location_id'=>$oLocation->id,'data'=>'Location updated successfully.','status'=>$this->successStatus]); 
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
	        return response()->json(['data'=>'Location deleted successfully.','status'=>$this->successStatus]);
        }
        else
        {
        	return response()->json(['data'=>'Location cannot deleted.','status'=>$this->successStatus]);
        }
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
            return response()->json(['Error.'=>$validator->errors(),'status'=>$this->validationStatus]);
        }

        $oLocationsEvents = DB::table('locations')
                ->select('locations.city',DB::raw('COUNT(events.id) as totalEvents'))
                ->leftJoin('events', 'events.location_id', '=', 'locations.id')
                ->where('locations.id',$input['id'])
                ->groupBy('locations.city')
                ->get();

         return response()->json(['data' => $oLocationsEvents,'status'=>$this->successStatus]); 
    }
}
