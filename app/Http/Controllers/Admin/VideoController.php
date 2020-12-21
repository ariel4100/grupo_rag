<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Inertia\Inertia;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::orderBy('order')->get();

        return Inertia::render('Admin/Video', [
            'videos' => $videos,

        ]);

    }

    public function store(Request $request)
    {

        try {
            DB::beginTransaction();
            if ($request->id){
                $item = Video::find($request->id);
            }else{
                $item = new Video();
            }

            $item->title   = $request->title;
            $item->order   = $request->order;
            $item->video   = $request->video;
//            $item->slug    = str::slug($request->title);
            $item->save();

            DB::commit();

            session()->flash('message', 'Se guardo correctamente.');
            return Redirect::route('adm.videos.index');
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => __('seller.article.store.error-default'),
                'errors' => [
                    $e->getMessage()
                ]
            ]);
        }
    }

    public function destroy($id)
    {
        Video::find($id)->delete();
        session()->flash('message', 'Se elimino correctamente.');
        return Redirect::route('adm.videos.index');
    }
}
