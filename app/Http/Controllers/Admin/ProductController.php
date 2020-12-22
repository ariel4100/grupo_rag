<?php

namespace App\Http\Controllers\Admin;

use App\Extensions\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Family;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {

//        dd($categoriasconhijos);
        $productos = Product::get();
//        $productos_aguila = Product::on(env('aguila'))->get();

//        dd($productos);
        return Inertia::render('Admin/Product', [
            'familias' => [],
            'subfamilias' => [],

            'productos' => $productos->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title ? $item->getTranslations('title') : ['es' => ''],
                    'description' => $item->description ? $item->getTranslations('description') : ['es' => ''],
                    'text' => $item->text ? $item->getTranslations('text') : ['es' => ''],
                    'text_video' => $item->text_video ? $item->getTranslations('text_video') : ['es' => ''],
                    'order' => $item->order,
                    'featured' => $item->featured,
                    'video' => $item->video,
                    'gallery' => collect($item->gallery)->map(function ($item) {
                        $url_image =  Storage::disk(env('DEFAULT_STORAGE_DISK'))->url($item);
//                        dd($item);
                        return $url_image;
                    }),
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
                $item = Product::find($request->id);
            }else{
                $item = new Product();
            }


            $file_save = Helpers::saveImage($request->file('archivo'), 'productos',$item->archivo);
            $file_save ? $item->file = $file_save : false;

            if (isset($request->gallery)){
                $images = Helpers::saveMultipleImage($request->gallery, 'productos');
            }

//            dd([$images]);

            $item->setTranslations('title', (array) json_decode($request->title));
            $item->setTranslations('description', (array) json_decode($request->description));
            $item->setTranslations('text', (array) json_decode($request->text));
            $item->setTranslations('text_video', (array) json_decode($request->text_video));
            $item->setTranslations('slug', collect(json_decode($request->title))->slug()->toArray());
            $item->order   = $request->order;
            $item->gallery   = @$images;
            isset($request->featured) ? $item->featured = 1 : $item->featured = 0;
            $item->video   = $request->video;


//            $item->slug    = str::slug($request->title);
            $item->save();

            DB::commit();

            session()->flash('message', 'Se ha guardado correctamente.');
            return Redirect::route('adm.productos.index');

//            return response()->json([
//                'status' => 'success',
//                'message' => __('productos.store.success')
//            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => __('productos.store.error-default'),
                'errors' => [
                    $e->getMessage()
                ]
            ]);
        }
    }

    public function show($id)
    {
        try {
            $item = Product::find($id);
            if ($item) {
                $new = $item->replicate();
                $new->setTranslation('title', 'es', $new->getTranslation('title', 'es'). ' - Copia');
//                $new->slug = '223322';
                $new->save();

//                $new->familias()->sync($item->familias);
//                $item->familias()->sync($familias->pluck('id'));

//                dd([$item,$new->industrias->pluck('id')]);
//                $new->save();
                session()->flash('message', 'Se ha duplicado correctamente.');
                return Redirect::route('adm.productos.index');
            } else {
                session()->flash('errors', 'Ocurrio un error al guardar.');
                return Redirect::route('adm.productos.index');

            }
        } catch (\Exception $e) {
            session()->flash('errors', 'Ocurrio un error al guardar. error:'. $e->getMessage());
            return Redirect::route('adm.productos.index');
        }
    }

    public function destroy($id)
    {
        Product::find($id)->delete();
        return response()->json([
            'status' => 'success',
            'message' => __('category.store.error-default'),
        ]);
//        session()->flash('message', 'Se elimino correctamente.');
//        return Redirect::route('adm.productos.index');
    }
}
