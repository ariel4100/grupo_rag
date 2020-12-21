<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class MetaController extends Controller
{
    public function index()
    {
        $items = Meta::get();

        return Inertia::render('Admin/Metadatos', [
            'items' => $items

        ]);

    }

    public function store(Request $request)
    {
//        dd($request->all());
        try {
            DB::beginTransaction();
            if ($request->id){
                $item = Meta::find($request->id);
            }else{
                $item = new Meta();
            }

            $item->setTranslations('title', (array) json_decode($request->title));
            $item->setTranslations('keyword', (array) json_decode($request->keyword));
            $item->setTranslations('description', (array) json_decode($request->description));
            $item->section   = $request->section;
            $item->save();

            DB::commit();

            session()->flash('message', 'Se guardo correctamente.');
            return Redirect::route('adm.metas.index');

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => __('category.store.error-default'),
                'errors' => [
                    $e->getMessage()
                ]
            ]);
        }
    }

    public function destroy($id)
    {
        Meta::find($id)->delete();
        session()->flash('success', 'Se elimino correctamente.');
        return Redirect::route('adm.metas.index');

    }


}
