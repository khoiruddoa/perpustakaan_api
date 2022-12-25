<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::query()->get();

        return response()->json([

            "status" => true,
            "message" => "data Category",
            "data" => $category
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $payload = $request->all();
        if (!isset($payload['category_name'])) {
            return response()->json([
                'status' => false,
                'message' => 'Category belum ada nama',
                'data' => null
            ]);
        }
        if (!isset($payload['description'])) {
            return response()->json([
                'status' => false,
                'message' => 'deskripsi belum  diisi',
                'data' => null
            ]);
        }

        $category = Category::query()->create($payload);
        return response()->json([
            'status' => true,
            'message' => 'insert data Category success',
            'data' => $category
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::query()
            ->where("id", $id)
            ->first();
        if ($category == null) {
            return response()->json([
                "status" => false,
                "message" => "data belum tersedia",
                "data" => null
            ]);
        }

        return response()->json([
            "status" => true,
            "message" => "data show",
            "data" => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $category->fill($request->all());


        $category->save();
        return response()->json([
            'status' => true,
            'message' => 'sukses update',
            'data' => $category
        ]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        if ($category) {
            return response()->json([
                'success' => true,
                'message' => 'Category Berhasil Dihapus!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'category Gagal Dihapus!',
            ], 400);
        }
    }
}
