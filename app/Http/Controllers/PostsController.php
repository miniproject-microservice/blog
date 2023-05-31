<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Posts;
use App\Models\Tags;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class PostsController extends Controller
{
    public function index () {
        $post = Posts::with(['category'])->get();
        return response()->json($post);
    }

    public function detail ($id) {
        $post = Posts::find($id);
        if(!$post) return response()->json(["error" => true,"message" => "Posts data not found"]);
        return response()->json($post);
    }

    public function store (Request $request) {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'title' => 'required',
            'desc' => 'required',
            'tags' => 'required'
        ]);
        //return $request;

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $checkCategory = Category::where('id', $request->category_id)->first();
        if (!$checkCategory) return response()->json(["error" => true,"message" => "Category data not found"]);

        try {
            $dataCreate = [
                'category_id' => $request->input('category_id'),
                'title' => $request->input('title'),
                'desc' => $request->input('desc'),
                'tags' => implode(', ', $request->input('tags')),
            ];
            Posts::create($dataCreate);
        } catch (\Throwable $th) {
            return $th;
            return response()->json(['message' => 'Create data failed']);
        }
        return response()->json(['message' => 'New posts has been created']);
    }

    public function update ($id, Request $request) {
        $checkData = Posts::where('id', $id)->first();
        if (!$checkData) return response()->json(["error" => true,"message" => "Posts data not found"]);

        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'title' => 'required',
            'desc' => 'required',
            'tags' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $checkCategory = Category::where('id', $request->category_id)->first();
        if (!$checkCategory) return response()->json(["error" => true,"message" => "Category data not found"]);

        $dataUpdate = [
            'category_id' => $request->input('category_id'),
            'title' => $request->input('title'),
            'desc' => $request->input('desc'),
            'tags' => implode(', ', $request->input('tags')),
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
