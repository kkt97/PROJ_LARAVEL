<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Models\Book\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::info(__METHOD__);

        $outs = Book::all();

        Log::info($outs);

        return json_encode($outs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Log::info(__METHOD__);

        Log::info($request);

        $request->validate([
            'name' => 'required',
            'people' => 'required',
            'phone' => 'required|regex:/(01)[0-9]{9}/',
            'email' => 'required|email|max:30'
        ]);

        $outs = Book::create([
            'name' => $request->input('name'),
            'people' => $request->input('people'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'book_time' => $request->input('book_time'),
        ]);

        Log::info($outs);

        return json_encode($outs);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        //
    }
}
