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

class FamilyController extends Controller
{
    public function index()
    {
        $categorias = Family::with('childFamilies')->orderBy('order')->get();


        return Inertia::render('Admin/Family', [
            'categorias' => $categorias->map(function ($item,$key) {
                return [
                    'id' => $item->id,
                    'title' => Helpers::getTranslations($item,'title'),
                    'text' => Helpers::getTranslations($item,'text'),
                    'description' => $item->getTranslations('description'),
                    'padre_id' => $item->padre_id,
                    'video' => $item->video,
                    'featured' => $item->featured,
                    'order' => $item->order,
                    'child_families' => $item->childFamilies,
                    'image' => $item->image ? Storage::disk(env('DEFAULT_STORAGE_DISK'))->url($item->image) : '',
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


            $file_save = Helpers::saveImage($request->file('image'), 'familias',$item->image);
            $file_save ? $item->image = $file_save : false;

            $item->setTranslations('title', (array) json_decode($request->title));
            if ($request->text){
                $item->setTranslations('text', (array) json_decode($request->text));

            }else{
                $item->setTranslations('text', ['es' => '']);
            }
            $item->setTranslations('slug', collect(json_decode($request->title))->slug()->toArray());

            $request->order ? $item->order = $request->order : false;
            $item->padre_id   = $request->padre_id;
            $request->featured ? $item->featured = 1 : false;

            $item->save();

            DB::commit();

            session()->flash('message', 'Se guardo correctamente.');
            return Redirect::route('adm.familias.index');

        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('error', 'Se encontraron algunos errores.'.$e->getMessage());
            return Redirect::route('adm.familias.index');
        }
    }

    public function destroy($id)
    {


        $item = Family::find($id);
//        dd('aca');
//        $item->childFamilies()->delete();
        $item->delete();
//        session()->flash('message', 'Se elimino correctamente.');
//        dd('entra y elmina');
//        return redirect('adm/familias/');
        return response()->json([
            'status' => 'success',
            'message' => __('category.store.error-default'),
        ]);
        return Redirect::route('adm.familias.index');

    }
}
