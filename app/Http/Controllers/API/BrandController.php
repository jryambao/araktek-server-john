<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{


    //view all brand
    public function index() {
        $brand = Brand::all();
        return response()->json([
            'status' => 200,
            'brand' => $brand
        ]); 
    }

    //passing brand data to edit
    public function edit($id) {
        $brand = Brand::find($id);
        if ($brand) {
            
            return response()->json([
                'status' => 200,
                'brand' => $brand
            ]);
        }
        else {
            return response()->json([
                'status' => 404,
                'message' => 'No Brand Id Found'
            ]);
        }
    }

    //storing brand data
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:191',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator.messages()
            ]);
        } 
        else {

            $brand = new Brand;
            $brand->name = $request->input('name');

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() .'.'.$extension;
                $file->move('uploads/brand/', $filename);
                $brand->image = 'uploads/brand/'.$filename;
            }

            $brand->save();

            return response()->json([
                'status' => 200,
                'message' => 'Brand Added Succesfully',
            ]);
        }
    }

    //update brand
    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:191',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator -> fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ]);
        }
        else {

            $brand = Brand::find($id);
            if ($brand) {

                $brand->name = $request->input('name');

                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() .'.'.$extension;
                    $file->move('uploads/brand/', $filename);
                    $brand->image = 'uploads/brand/'.$filename;
                }

                $brand->save();

                return response()->json([
                    'status' => 200,
                    'message' => 'Brand Updated Succesfully',
                ]);
            }
            else {
                return response()->json([
                    'status' => 404,
                    'message' => 'No Brand Id Found',
                ]);
            }
        }
    }

    public function destroy($id) {
        $brand = Brand::find($id);

        if($brand) {
            $brand->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Brand Deleted Succesfully',
            ]);
        }
        else {
            return response()->json([
                'status' => 404,
                'message' => 'No Brand Id Found',
            ]);
        }
    }
}
