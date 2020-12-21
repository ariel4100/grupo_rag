<?php

namespace App\Http\Controllers\Admin;

use App\Extensions\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Descargas;
use App\Models\Download;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class DescargaController extends Controller
{
    public function index()
    {
        $items = Download::get();

//        $items = Descargas::orderBy('order')->get();

        return Inertia::render('Admin/Descargas', [
            'categorias' => $items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->getTranslations('title'),
                    'order' => $item->order,
                    'image' => $item->image ? Storage::disk(env('DEFAULT_STORAGE_DISK'))->url($item->image) : '',
                    'file' => $item->file ? Storage::disk(env('DEFAULT_STORAGE_DISK'))->url($item->file) : '',
                ];
            }),
        ]);

    }

    public function store(Request $request)
    {
//        dd([$request->all(),auth()->guard('web')->user()]);
        try {
            DB::beginTransaction();
            if ($request->id){
                $item = Download::find($request->id);
            }else{
                $item = new Download();
            }

            $file_save = Helpers::saveImage($request->file('image'), 'descagas',$item->image);
            $file_save ? $item->image = $file_save : false;

            $file_save = Helpers::saveImage($request->file('file'), 'descagas',$item->file);
            $file_save ? $item->file = $file_save : false;

            $item->setTranslations('title', (array) json_decode($request->title));
            $request->order ? $item->order = $request->order : false;

            $item->save();

            DB::commit();

            session()->flash('message', 'Se ha guardado correctamente.');
            return Redirect::route('adm.descargas.index');

        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('error', 'Se encontraron algunos errores.'.$e->getMessage());
            return Redirect::route('adm.descargas.index');
        }
    }

    public function destroy($id)
    {
        Download::find($id)->delete();
        session()->flash('message', 'Se elimino correctamente.');
        return Redirect::route('adm.descargas.index');
    }
}
