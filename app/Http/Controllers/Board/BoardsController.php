<?php

namespace App\Http\Controllers\Board;

use App\Http\Controllers\Controller;
use App\Models\Board\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BoardsController extends Controller
{
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


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $outs = Board::with('user')->paginate(10);

        return json_encode($outs);
    }
    public function search(Request $request){
        Log::info(__METHOD__);
        Log::info($request);

        $search = $request->get('q');

        Log::info($search);

        $outs = Board::query();
        $outs->with('user')->paginate(10);
        Log::info($outs->toSql());

        if($search) {
            $outs->where(function ($q) use ($search) {
                $q->orWhere('title', 'like', '%'.$search.'%');
                $q->orWhere('content', 'like', '%'.$search.'%');
                $q->orWhereHas('user', function ($user) use ($search) {
                    $user->where('name', 'like', '%'.$search.'%');
                });
            });
        }
        $outs = $outs->get();
        Log::info($outs);
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

        return json_encode($board);
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

        Log::info($request->file());

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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Board\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Board $board)
    {
        Log::info(__METHOD__);
        Log::info($request->all());
        Log::info($request->file());

        $modeFileDelete = $request->modeFileDelete;
        Log::info($modeFileDelete);

        if($modeFileDelete) {

            $image_path = $request->image_path;

            Storage::disk('')->delete($image_path);

            $outs = $board->update([
                'image_name' => NULL,
                'image_path' => NULL,
            ]);

        } else {
            $outs = $board->update($request->all());
        }
        return json_encode($outs);
    }


    public function upload(Request $request, $id){
        Log::info($request->all());

        $board = Board::find($id);
        Log::info($board);

        if ($request->file('image')){
            try {
                Log::info('0');
                $fileName = time().'_'.$request->file('image')
                        ->getClientOriginalName();
                Log::info('1');
                $path = $request->file('image')->storeAs('/public/images',
                    $fileName);
                Log::info('2');
                $board->image_name = $fileName;
                $board->image_path = $path;
                Log::info('3');
            } catch (\Exception $e){
                Log::info($e->getMessage());
            }
        }
        $board->update([
            'image_name'
        ]);

        return json_encode($board);

    }
}
