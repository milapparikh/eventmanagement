<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use Validator; 
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

class CategoryController extends Controller
{

    public $createdStatus = 201;
    public $successStatus = 200;
    public $unAuthorisedStatus = 401;
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
            return response()->json(['status'=>400,'Error.'=>$validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        $oCategory = DB::table('categorys')
                ->select('categorys.name',DB::raw('COUNT(events.id) as totalEvents'))
                ->leftJoin('events', 'events.category_id', '=', 'categorys.id')
                ->where('categorys.id',$category_id)
                ->groupBy('categorys.name')
                ->get();

        return response()->json(['status'=>200,'data' => $oCategory], Response::HTTP_OK);
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
            return response()->json(['status'=>400,'Error.'=>$validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        $oCategory = Category::create($input);
        return response()->json(['status'=>201,'data' => $oCategory], Response::HTTP_CREATED);

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
        return response()->json(['status'=>200,'data' => $oCategoryList], Response::HTTP_OK);
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
            return response()->json(['status'=>400,'Error.'=>$validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        $oCategory = Category::findOrFail($id);
        $oCategory->update($request->all());

        return response()->json(['status'=>200,'category_id'=>$oCategory->id,'data'=>'Category updated successfully.'], Response::HTTP_OK); 
    }

    /** 
     * delete category
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request,$id)
    {
        Category::findOrFail($id)->delete();
        return response()->json(['status'=>200,'data'=>'Category deleted successfully.'], Response::HTTP_OK); 
    }


}
