<?php

namespace App\Http\Controllers\API; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Comment;
use App\Event;
use App\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;

class commentController extends Controller
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
        $user = Auth::user(); 

        $validator = Validator::make($input, [
            'event_id' => 'required|exists:events,id',
            'comment' => 'required'
        ]);
	        
		$input['user_id'] = $user->id;

        if($validator->fails()){
			return response()->json(['Error.'=>$validator->errors()]);
        }

        $oComments = Comment::create($input);        
        return response()->json(['comment_id' => $oComments->id], $this-> successStatus); 
    } 

}
