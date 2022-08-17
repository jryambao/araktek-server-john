<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{

    public function index() {
        $review = Review::all();
        return response()->json([
            'status' => 200,
            'review' => $review
        ]);
    }

    public function edit($id) {
        $review = Review::find($id);
        if ($review) {
            
            return response()->json([
                'status' => 200,
                'review' => $review
            ]);
        }
        else {
            return response()->json([
                'status' => 404,
                'message' => 'No Id Found'
            ]);
        }
    }

    public function store(Request $request) {

        $validator = Validator::make($request->all(), [
            'message' => 'required'
        ]);

        if ($validator -> fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->messages(),
            ]);
        }
        else {

            $review = new Review;
            $review->message = $request->input('message');
             
            $review->save();

            return response()->json([
                'status' => 200,
                'message' => 'Your Review has been sent',
            ]);
        }

    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'message' => 'required'
        ]);

        if ($validator -> fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->messages(),
            ]);
        }
        else {

            $review = Review::find($id);
            if ($review) {

                $review->message = $request->input('message');
             
                $review->save();

                return response()->json([
                    'status' => 200,
                    'message' => 'Your Review Updated Succesfully',
                ]);
            }
            else {
                return response()->json([
                    'status' => 404,
                    'message' => 'No Id Found',
                ]);
            }
        }
    }

    public function destroy($id) {
        $review = Review::find($id);

        if($review) {
            $review->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Your Review Deleted Succesfully',
            ]);
        }
        else {
            return response()->json([
                'status' => 404,
                'message' => 'No Id Found',
            ]);
        }
    }
}
