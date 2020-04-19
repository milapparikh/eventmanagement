<?php

namespace App\Http\Controllers\API; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Comment;
use App\Event;
use App\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;

class CommentController extends Controller
{
    private $successStatus = 200;
    private $validationStatus = 400;
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
			return response()->json(['Error.'=>$validator->errors(),'status'=>$this->validationStatus]);
        }

        $oComments = Comment::create($input);        
        return response()->json(['comment_id' => $oComments->id,'status'=>$this->successStatus]); 
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

        return response()->json(['data'=>$oComments,'status'=>$this->successStatus]);
    }
}
