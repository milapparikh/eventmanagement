<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use Validator;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
	private $successStatus = 200;
    private $validationStatus = 400;
    /**
     * List the category and count events
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function categoryEvent(Request $request,$category_id)
    {
    	$input = $request->all();

		$validator = Validator::make($input, [
            'category_id' => 'required|exists:categorys,id'
        ]);

        if($validator->fails()){
            return response()->json(['Error.'=>$validator->errors(),'status'=>$this->validationStatus]);
        }

        $oCategory = DB::table('categorys')
                ->select('categorys.name',DB::raw('COUNT(events.id) as totalEvents'))
                ->leftJoin('events', 'events.category_id', '=', 'categorys.id')
                ->where('categorys.id',$category_id)
                ->groupBy('categorys.name')
                ->get();

         return response()->json(['data' => $oCategory,'status'=>$this->successStatus]); 
    }

    /**
     * create category
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|unique:categorys|max:150'
        ]);

        if($validator->fails()){
            return response()->json(['Error.'=>$validator->errors(),'status'=>$this->validationStatus]);
        }

        $oCategory = Category::create($input);
        return response()->json(['data' => $oCategory,'status'=>$this->successStatus]); 
    }

    /**
     * read category
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $oCategoryList = Category::all();
        return response()->json(['data' => $oCategoryList,'status'=>$this->successStatus]); 
    }

    /**
     * update category
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|unique:categorys|max:150'
        ]);

        if($validator->fails()){
            return response()->json(['Error.'=>$validator->errors(),'status'=>$this->validationStatus]);
        }

        $oCategory = Category::findOrFail($id);
        $oCategory->update($request->all());

        return response()->json(['category_id'=>$oCategory->id,'data'=>'Category updated successfully.','status'=>$this->successStatus]); 
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
       /* $validator = Validator::make($input, [
            'id' => 'required'
        ]);

        if($validator->fails()){
            return response()->json(['Error.'=>$validator->errors(),'status'=>$this->validationStatus]);
        }
        */

        Category::findOrFail($id)->delete();
        return response()->json(['data'=>'Category deleted successfully.','status'=>$this->successStatus]); 
    }


}
