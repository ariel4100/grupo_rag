<?php

namespace App\Http\Controllers\Admin;

use App\Extensions\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Family;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class SubfamilyController extends Controller
{
    public function index()
    {
        $items = Family::where('padre_id','!=',null)->get();
        $familias = Family::where('padre_id',null)->get();


        return Inertia::render('Admin/Subfamily', [
            'items' => $items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->getTranslations('title'),
                    'text' => $item->getTranslations('text'),
                    'description' => $item->getTranslations('description'),
                    'padre_id' => $item->padre_id,
                    'video' => $item->video,
                    'order' => $item->order,
                    'child_families' => $item->childFamilies,
                    'image' => $item->image ? Storage::disk(env('DEFAULT_STORAGE_DISK'))->url($item->image) : '',
                ];
            }),
            'familias' => $familias->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'padre_id' => $item->padre_id,
                    'child_families' => $item->childFamilies,
                ];
            }),

        ]);

    }

    public function store(Request $request)
    {
//        dd($request->all());
        try {
            DB::beginTransaction();
            if ($request->id){
                $item = Family::find($request->id);
            }else{
                $item = new Family();
            }

            $file_save = Helpers::saveImage($request->file('image'), 'subfamilias',$item->image);
            $file_save ? $item->image = $file_save : false;

            $item->setTranslations('title', (array) json_decode($request->title));
            if ($request->text){
                $item->setTranslations('text', (array) json_decode($request->text));

            }else{
                $item->setTranslations('text', ['es' => '']);
            }
            $item->setTranslations('slug', collect(json_decode($request->title))->slug()->toArray());

            if($request->order){
                $item->order   = $request->order;

            }
            $item->padre_id   = $request->padre_id;

//            if($request->hijo){
//                $item->padre_id   = $request->hijo;
//            }else{
//                $item->padre_id   = $request->padre_id;
//            }
//            $item->slug    = str::slug($request->title);
            $item->save();

            DB::commit();

            session()->flash('message', 'Se ha guardado correctamente.');


            return Redirect::route('adm.subfamilias.index');


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

    //DUPLICAR
    public function show($id)
    {
        try {
            $item = Family::find($id);
            if ($item) {
                $new = $item->replicate();
                $new->setTranslation('title', 'es', $new->getTranslation('title', 'es'). ' - Copia');
//                $new->title = '223322';
//                $new->slug = '223322';
//
//                dd($new->getTranslations('title'));
                $new->save();
                session()->flash('message', 'Se ha duplicado correctamente.');
                return Redirect::route('adm.subfamilias.index');
            } else {
                session()->flash('errors', 'Ocurrio un error al guardar.');
                return Redirect::route('adm.subfamilias.index');

            }
        } catch (\Exception $e) {
            session()->flash('errors', 'Ocurrio un error al guardar. error:'. $e->getMessage());
            return Redirect::route('adm.noticias.index');
        }
    }

    public function destroy($id)
    {
        $item = Family::with('childFamilies')->find($id);

//        dd('aca');
//        $item->childFamilies()->delete();
        $item->delete();
        session()->flash('message', 'Se elimino correctamente.');
        return Redirect::route('adm.subfamilias.index');
    }
}
