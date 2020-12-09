<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Subcategory;
use Validator;
use App\Http\Resources\Subcategory as SubcategoryResource;
   
class SubcategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subcategories = Subcategory::all();
    
        return $this->sendResponse(SubcategoryResource::collection($subcategories), 'Subcategories retrieved successfully.');
    }
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
            'category_id' => 'required|exists:categories,id',
            'name' => 'required',
            'slug' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $subcategory = Subcategory::create($input);
   
        return $this->sendResponse(new SubcategoryResource($subcategory), 'Subcategory created successfully.');
    } 
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subcategory = Subcategory::find($id);
  
        if (is_null($subcategory)) {
            return $this->sendError('Subcategory not found.');
        }
   
        return $this->sendResponse(new SubcategoryResource($subcategory), 'Subcategory retrieved successfully.');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subcategory $subcategory)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required',
            'slug' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $subcategory->category_id = $input['category_id'];
        $subcategory->name = $input['name'];
        $subcategory->slug = $input['slug'];
        $subcategory->save();
   
        return $this->sendResponse(new SubcategoryResource($subcategory), 'Subcategory updated successfully.');
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subcategory $subcategory)
    {
        $subcategory->delete();
   
        return $this->sendResponse([], 'Subcategory deleted successfully.');
    }
}