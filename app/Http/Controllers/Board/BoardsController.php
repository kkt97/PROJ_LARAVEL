<?php

namespace App\Http\Controllers\Board;

use App\Http\Controllers\Controller;
use App\Models\Board\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BoardsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::info(__METHOD__);

        $outs = Board::with('user')->paginate(10);

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
        Log::info($request->all());
        Log::info(__METHOD__);

        $outs = Board::with('user')->create($request->all());
        Log::info($outs);

        if ($request->file('image')){
            try {
                Log::info('0');
                $fileName = time().'_'.$request->file('image')
                        ->getClientOriginalName();
                Log::info('1');
                $path = $request->file('image')->storeAs('/public/images',
                    $fileName);
                Log::info('2');
                $outs->image_name = $fileName;
                $outs->image_path = $path;
                Log::info('3');
            } catch (\Exception $e){
                Log::info($e->getMessage());
            }
        }
        $outs -> save();

        return json_encode($outs);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Board\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function show(Board $board)
    {
        $board->load('user');

        Log::info($board);

        return json_encode($board);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Board\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Board $board)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Board\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function destroy(Board $board)
    {
        Log::info(__METHOD__);

        $outs = $board->delete();

        return json_encode($outs);
    }
}
