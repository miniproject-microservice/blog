<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index () {
        $cat = Category::all();
        return response()->json($cat);
    }

    public function detail ($id) {
        $cat = Category::find($id);
        if(!$cat) return response()->json(["error" => true,"message" => "Category data not found"]);
        return response()->json($cat);
    }

    public function store (Request $request) {
        $validator = Validator::make($request->all(), [
            'cat_name' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $dataCreate = [
            'cat_name' => $request->input('cat_name'),
        ];

        try {
            Category::create($dataCreate);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Create data failed']);
        }
        return response()->json(['message' => 'new category has been created']);
    }

    public function update ($id, Request $request) {
        $checkData = Category::where('id', $id)->first();
        if (!$checkData) return response()->json(["error" => true,"message" => "Category data not found"]);

        $validator = Validator::make($request->all(), [
            'cat_name' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $dataUpdate = [
            'cat_name' => $request->input('cat_name'),
        ];

        try {
            Category::where('id', $id)->update($dataUpdate);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Update data failed']);
        }
        return response()->json(['message' => 'Category has been updated']);
    }

    public function delete($id)
    {   
        $checkData = Category::where('id', $id)->first();
        if (!$checkData) return response()->json(["error" => true,"message" => "Category data not found"]);
        
        try {
            Category::where('id', $id)->delete();
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Delete data failed']);
        }
        return response()->json(['message' => 'Category has been deleted']);
    }
}
