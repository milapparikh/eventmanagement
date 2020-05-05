<?php

namespace App\Http\Controllers\API; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Comment;
use App\Event;
use App\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    /**
     * Store a newly created comments.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $user = Auth::user(); 

        $validator = Validator::make($input, [
            'event_id' => 'required|exists:events,id',
            'comment' => 'required'
        ]);
	        
		$input['user_id'] = $user->id;

        if($validator->fails()){
			return response()->json(['status'=>400,'Error.'=>$validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        $oComments = Comment::create($input);        
        return response()->json(['status'=>200,'data' => $oComments], Response::HTTP_OK);
    } 


    /**
     * get all comments by events id
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function comments(Request $request,$event_id)
    {
        $oComments = Event::leftJoin('comments', 'events.id', '=', 'comments.event_id')
           ->select('events.*', 'comments.*')
           ->where('events.id',$event_id)
           ->get();

        return response()->json(['status'=>200,'data' => $oComments], Response::HTTP_OK);
    }
}
