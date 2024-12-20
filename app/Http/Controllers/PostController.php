<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $get = Post::all();
        return response()->json([
            'message' => 'Lists of Posts',
            'data' => $get,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required'
        ]);
        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content
        ]);
        return response()->json([
            'message' => 'Data successfully added',
            'data' => $post
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $get = Post::where('id', $id)->first();
        if (empty($get)) {
            return response()->json([
                'message' => 'Data Not Found'
            ], 404);
        }
        return response()->json([
            'data' => $get
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //    dd($request);
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        // Directly set attributes and save
        $post->title = $request->input('title', $post->title);
        $post->content = $request->input('content', $post->content);

        // $product->update();

        // return response()->json(['message' => 'Product updated successfully', 'product' => $product], 200);
        $post->update($request->only(['title', 'content']));

        return response()->json(['message' => 'Product updated successfully', 'post' => $post], 200);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $data = Post::findOrFail($id);
            $data->delete();

            return response()->json([
                'message' => 'Data successfully deleted',
                'data' => $data // Ensure sensitive data isn't included in the response.
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Id not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting the data'
            ], 500);
        }
    }
}
