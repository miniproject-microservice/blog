<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Posts;
use Illuminate\Support\Facades\Validator;

class PostsController extends Controller
{
    public function index () {
        $post = Posts::all();
        return response()->json($post);
    }

    public function store (Request $request) {
        $validator = Validator::make($request->all(), [
            'author_id' => 'required',
            'category_id' => 'required',
            'title' => 'required',
            'desc' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $dataCreate = [
            'author_id' => $request->input('author_id'),
            'category_id' => $request->input('category_id'),
            'title' => $request->input('title'),
            'desc' => $request->input('desc'),
        ];

        try {
            Posts::create($dataCreate);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Create data failed']);
        }
        return response()->json(['message' => 'New posts has been created']);
    }

    public function update ($id, Request $request) {
        $checkData = Posts::where('id', $id)->first();
        if (!$checkData) return response()->json(["error" => true,"message" => "Posts data not found"]);

        $validator = Validator::make($request->all(), [
            'author_id' => 'required',
            'category_id' => 'required',
            'title' => 'required',
            'desc' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $dataUpdate = [
            'author_id' => $request->input('author_id'),
            'category_id' => $request->input('category_id'),
            'title' => $request->input('title'),
            'desc' => $request->input('desc'),
        ];

        try {
            Posts::where('id', $id)->update($dataUpdate);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Update data failed']);
        }
        return response()->json(['message' => 'Posts has been updated']);
    }

    public function delete($id)
    {   
        $checkData = Posts::where('id', $id)->first();
        if (!$checkData) return response()->json(["error" => true,"message" => "Posts data not found"]);
        
        try {
            Posts::where('id', $id)->delete();
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Delete data failed']);
        }
        return response()->json(['message' => 'Posts has been deleted']);
    }
}
