<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $author = Author::query()->get();

        return response()->json([

            "status" => true,
            "message" => "data author",
            "data" => $author
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
        if (!isset($payload['author_name'])) {
            return response()->json([
                'status' => false,
                'message' => 'Author belum ada nama',
                'data' => null
            ]);
        }
        if (!isset($payload['address'])) {
            return response()->json([
                'status' => false,
                'message' => 'alamat belum ada',
                'data' => null
            ]);
        }

        if (!isset($payload['telephone'])) {
            return response()->json([
                'status' => false,
                'message' => 'telephon belum ada',
                'data' => null
            ]);
        }
        if (!isset($payload['email'])) {
            return response()->json([
                'status' => false,
                'message' => 'alamat email belum ada',
                'data' => null
            ]);
        }

        if (!isset($payload['bio'])) {
            return response()->json([
                'status' => false,
                'message' => 'alamat belum ada nama',
                'data' => null
            ]);
        }
        if (!isset($payload['photo'])) {
            return response()->json([
                'status' => false,
                'message' => 'harus ada photo',
                'data' => null
            ]);
        }




        $photo = $request->file('photo');
        $filename = $photo->hashName();
        $photo->move('photo', $filename);
        $payload['photo'] = $request->getSchemeAndHttpHost() . "/photo/" . $filename;

        $author = Author::query()->create($payload);
        return response()->json([
            'status' => true,
            'message' => 'insert data author success',
            'data' => $author
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $author = Author::query()
            ->where("id", $id)
            ->first();
        if ($author == null) {
            return response()->json([
                "status" => false,
                "message" => "data belum tersedia",
                "data" => null
            ]);
        }

        return response()->json([
            "status" => true,
            "message" => "data show",
            "data" => $author
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Author $author)
    {
        $author->fill($request->all());
        $photo = $request->file('photo');
        if ($photo != null) {
            $filename = $photo->hashName();
            $photo->move('photo', $filename);
            $author->photo = $request->getSchemeAndHttpHost() . "/photo/" . $filename;
        }

        $author->save();
        return response()->json([
            'status' => true,
            'message' => 'sukses update',
            'data' => $author
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $author = Author::findOrFail($id);
        $author->delete();

        if ($author) {
            return response()->json([
                'success' => true,
                'message' => 'author Berhasil Dihapus!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Post Gagal Dihapus!',
            ], 400);
        }
    }
}
