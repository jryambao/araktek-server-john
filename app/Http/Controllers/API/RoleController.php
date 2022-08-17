<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    //view all rolw
    public function index() {
        $role = Role::all();
        return response()->json([
            'status' => 200,
            'role' => $role
        ]); 
    }

    //passing role data to edit
    public function edit($id) {
        $role = Role::find($id);
        if ($role) {
            
            return response()->json([
                'status' => 200,
                'role' => $role
            ]);
        }
        else {
            return response()->json([
                'status' => 404,
                'message' => 'No Role Id Found'
            ]);
        }
    }

    //store role
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:30'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator.messages()
            ]);
        } 
        else {

            $role = new Role;
            $role->name = $request->input('name');

            $role->save();

            return response()->json([
                'status' => 200,
                'message' => 'Role Added Succesfully',
            ]);
        }
    }

    //update role
    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:30',
        ]);

        if ($validator -> fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ]);
        }
        else {

            $role = Role::find($id);
            if ($role) {

                $role->name = $request->input('name');
        
                $role->save();

                return response()->json([
                    'status' => 200,
                    'message' => 'Role Updated Succesfully',
                ]);
            }
            else {
                return response()->json([
                    'status' => 404,
                    'message' => 'No Role Id Found',
                ]);
            }
        }
    }

    //delete role
    public function destroy($id) {
        $role = Role::find($id);

        if($role) {
            $role->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Role Deleted Succesfully',
            ]);
        }
        else {
            return response()->json([
                'status' => 404,
                'message' => 'No Role Id Found',
            ]);
        }
    }
}
