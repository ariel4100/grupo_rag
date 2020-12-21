<?php

namespace App\Http\Controllers\Admin;

use App\Extensions\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class NewsController extends Controller
{
    public function index()
    {
        $novedades = News::orderBy('order')->get();
        $categorias = Category::orderBy('order')->get();

        return Inertia::render('Admin/News', [
            'novedades' => $novedades->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title ? $item->getTranslations('title') : ['es' => ''],
                    'text' => $item->text ? $item->getTranslations('text') : ['es' => ''],
                    'order' => $item->order,
                    'featured' => $item->featured,
                    'image' => collect($item->galley)->map(function ($item) {
                        $url_image =  Storage::disk(env('DEFAULT_STORAGE_DISK'))->url($item);
//                        dd($item);
                        return $url_image;
                    }),
                    'category_id' => $item->category_id,
                ];
            }),
            'categorias' => $categorias->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
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

                $item = News::find($request->id);
                if($item->image != null){
                    foreach ($item->image as $key => $value) {

                        if (in_array($value, $request->images ?? [])) {
//                        $gallery[$key] = $value;
                        }else{
                            Storage::disk(env('DEFAULT_STORAGE_DISK'))->delete($value);

                        }
                    }
                }
            }else{
                $item = new News();
            }
            if (isset($request->images)){
                $gallery = Helpers::saveMultipleImage($request->images, 'productos');
            }

            $item->setTranslations('title', (array) json_decode($request->title));
            $item->setTranslations('text', (array) json_decode($request->text));
            $item->setTranslations('slug', collect(json_decode($request->title))->slug()->toArray());
            $item->category_id   = $request->category_id;
            $item->galley   = @$gallery;
            $item->order   = $request->order;
            $request->featured ? $item->featured = 1 : $item->featured = 0;
//            $item->slug    = str::slug($request->title);
            $item->save();

            DB::commit();

            session()->flash('message', 'Se guardo correctamente.');
            return Redirect::route('adm.noticias.index');

        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('error', 'Se encontraron algunos errores.'.$e->getMessage());
            return Redirect::route('adm.noticias.index');

        }
    }

    public function show($id)
    {
        try {
            $item = News::find($id);
            if ($item) {
                $new = $item->replicate();
//                $new->title = '223322';
//                $new->slug = '223322';
//
//                dd($new->getTranslations('title'));
                $new->save();
                session()->flash('message', 'Se ha duplicado correctamente.');
                return Redirect::route('adm.noticias.index');
            } else {
                session()->flash('errors', 'Ocurrio un error al guardar.');
                return Redirect::route('adm.noticias.index');

            }
        } catch (\Exception $e) {
            session()->flash('errors', 'Ocurrio un error al guardar. error:'. $e->getMessage());
            return Redirect::route('adm.noticias.index');
        }
    }
    public function destroy($id)
    {
        News::find($id)->delete();
        session()->flash('message', 'Se elimino correctamente.');
        return Redirect::route('adm.noticias.index');
    }
}
