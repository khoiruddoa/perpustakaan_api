<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $book = Book::query()->get();

        return response()->json([

            "status" => true,
            "message" => "data Book",
            "data" => $book
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
        if (!isset($payload['id_category'])) {
            return response()->json([
                'status' => false,
                'message' => 'id category belum ada',
                'data' => null
            ]);
        }
        if (!isset($payload['id_author'])) {
            return response()->json([
                'status' => false,
                'message' => 'id author belum ada',
                'data' => null
            ]);
        }

        if (!isset($payload['title'])) {
            return response()->json([
                'status' => false,
                'message' => 'title belum ada',
                'data' => null
            ]);
        }
        if (!isset($payload['publisher'])) {
            return response()->json([
                'status' => false,
                'message' => 'publisher belum ada',
                'data' => null
            ]);
        }

        if (!isset($payload['publish_year'])) {
            return response()->json([
                'status' => false,
                'message' => 'year harus ada',
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

        $book = Book::query()->create($payload);
        return response()->json([
            'status' => true,
            'message' => 'insert data Book success',
            'data' => $book
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {


        $book = Book::query()
            ->where("id", $id)
            ->first();

        $category = Category::query()->where("id", $book->id_category)
            ->first();
        $author = Author::query()->where("id", $book->id_author)
            ->first();


        $book->category = $category;
        $book->author = $author;

        if ($book == null) {
            return response()->json([
                "status" => false,
                "message" => "data belum tersedia",
                "data" => null
            ]);
        }

        return response()->json([
            "status" => true,
            "message" => "data show",
            "data" => $book
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $book->fill($request->all());
        $photo = $request->file('photo');
        if ($photo != null) {
            $path_old = str_replace($request->getSchemeAndHttpHost(), "", $book->photo);
            $photo_old = public_path($path_old);

            unlink($photo_old);

            $filename = $photo->hashName();
            $photo->move('photo', $filename);
            $book->photo = $request->getSchemeAndHttpHost() . "/photo/" . $filename;
        }

        $book->save();
        return response()->json([
            'status' => true,
            'message' => 'sukses update',
            'data' => $book
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $photo = str_replace(request()->getSchemeAndHttpHost() . '/', "", $book->photo);
        unlink($photo);
        $book->delete();

        if ($book) {
            return response()->json([
                'success' => true,
                'message' => 'Book Berhasil Dihapus!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Post Gagal Dihapus!',
            ], 400);
        }
    }
}
