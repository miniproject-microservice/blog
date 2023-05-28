<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tags;
use Illuminate\Support\Facades\Validator;

class TagsController extends Controller
{
    public function index () {
        $tag = Tags::all();
        return response()->json($tag);
    }

    public function detail ($id) {
        $tag = Tags::find($id);
        if(!$tag) return response()->json(["error" => true,"message" => "Tags data not found"]);
        return response()->json($tag);
    }

    public function store (Request $request) {
        $validator = Validator::make($request->all(), [
            'tag_name' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $dataCreate = [
            'tag_name' => $request->input('tag_name'),
        ];

        try {
            Tags::create($dataCreate);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Create data failed']);
        }
        return response()->json(['message' => 'new tags has been created']);
    }

    public function update ($id, Request $request) {
        $checkData = Tags::where('id', $id)->first();
        if (!$checkData) return response()->json(["error" => true,"message" => "Tags data not found"]);

        $validator = Validator::make($request->all(), [
            'tag_name' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $dataUpdate = [
            'tag_name' => $request->input('tag_name'),
        ];

        try {
            Tags::where('id', $id)->update($dataUpdate);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Update data failed']);
        }
        return response()->json(['message' => 'Tags has been updated']);
    }

    public function delete($id)
    {   
        $checkData = Tags::where('id', $id)->first();
        if (!$checkData) return response()->json(["error" => true,"message" => "Tags data not found"]);
        
        try {
            Tags::where('id', $id)->delete();
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Delete data failed']);
        }
        return response()->json(['message' => 'Tags has been deleted']);
    }
}
