<?php

namespace App\Http\Controllers\Admin;

use App\Extensions\Helpers;
use App\Models\Block;
use App\Models\Content;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ContentController extends Controller
{
    public function index($section)
    {

//        dd($section);
//        $contenido = Content::firstOrCreate(['section' => $section]);
        $contenido = Content::with('block')->firstOrCreate(['section' => $section]);
        $sliders = Slider::where('section', $section)->get();

//        dd($contenido);
        if ($section == 'contacto'){
            return Inertia::render('Admin/Config', [
                'contenido' => $contenido,
                'imagenes' => collect($contenido->image)->map(function ($item) {
                    return [
                        'title' => $item['title'] ?? '',
                        'image' => $item['image'] ? Storage::disk(env('DEFAULT_STORAGE_DISK'))->url($item['image']) : '',
                    ];
                }),

            ]);
        }

        $contenidoMap = $contenido->Block->map(function ($item) {
            $title = $item->toArray()['title'];
            $text = $item->toArray()['text'];
            return [
                'id' => $item->id,
                'title' => $title,
                'text' => $text,
                'section' => $item->section,
                'type' => $item->type,
                'order' => $item->order,
                'image' => $item->image ? Storage::disk(env('DEFAULT_STORAGE_DISK'))->url($item->image) : '',
            ];
        });

//        dd($sliders);
        return Inertia::render('Admin/Section', [
            'contenido' => $contenido,
            'timelines' => $contenidoMap->where('type','texto')->values(),
            'imagenes' => $contenidoMap->where('type','img')->values(),
            'videos' => $contenidoMap->where('type','video')->values(),
            'images' => $contenidoMap->where('type','img')->values(),
            'bloques' => $contenidoMap->whereNull('type')->values(),
            'sliders' => $sliders->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->getTranslations('title'),
                    'text' => $item->getTranslations('text'),
                    'order' => $item->order,
                    'image' => $item->image ? Storage::disk(env('DEFAULT_STORAGE_DISK'))->url($item->image) : '',
                ];
            }),
        ]);
    }

    public function store(Request $request)
    {
//        dd($request->all());
        $item = Content::find($request->id);

//        $item->block()->delete();
        try {
            //Guardo el request de bloques al modelo de block, save title,text,image,type,id del contenido para la relacion y retorna unn 1 como exitosso
            $file_save = Helpers::saveMultipleImage($request->bloques, 'bloques','App\Models\Block',$item->id);
            $file_save == 1 ? false  : $item->image = $file_save;

            //para la seccion de contacto
            if (isset($request->images)){
                $contacto = Helpers::saveMultipleImageWithData($request->images, 'logo');
            }
//            dd($contacto);
            DB::beginTransaction();
            $item->setTranslations('title', (array) json_decode($request->iframe));

//            $item->section   = $request->section;
            $item->image     = @$contacto;


            //SE ENVIA CON FORMDATA X LA IMAGEN Y DECODIFICO EL STRINGIFY DE JAVASCRIPT
            if ($request->images != null){
                $item->data = json_decode($request->contenido);
            }

            $item->save();

            DB::commit();
            session()->flash('message', 'Se guardo correctamente.');
            return Redirect::route('adm.content.index',$item->section);
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('error', 'Se encontraron algunos errores.'.$e->getMessage());
            return Redirect::route('adm.content.index',$item->section);

        }
    }


    public function slider(Request $request)
    {
//        return dd($request->all());

        try {
            DB::beginTransaction();
            if(isset($request->id)){
                $item = Slider::find($request->id);
            } else {
                $item  = new Slider;
            }

            $file_save = Helpers::saveImage($request->file('image'), 'slider',$item->image);
            $file_save ? $item->image = $file_save : false;
            $item->setTranslations('title', (array) json_decode($request->title));
            $item->setTranslations('text', (array) json_decode($request->text));
            $item->order  = $request->order;
            $item->section  = $request->section;
            $item->save();


            DB::commit();
            session()->flash('message', 'Se guardo correctamente.');
            return Redirect::route('adm.content.index',$item->section);
//            return response()->json([
//                'status' => 'success',
//                'message' => __('slider.store.success')
//            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => __('slider.store.error-default'),
                'errors' => [
                    $e->getMessage()
                ]
            ]);
        }
    }

    public function destroy_slider($id)
    {
        try {
            DB::beginTransaction();
            $item = Slider::find($id);
            if ($item->image){
                Storage::disk(env('DEFAULT_STORAGE_DISK'))->delete($item->image);
            }
            $item->delete();
            DB::commit();
            return Redirect::route('adm.content.index',$item->section);
//            return response()->json([
//                'status' => 'success',
//                'message' => __('slider.destroy.success')
//            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => __('slider.destroy.error-default'),
                'errors' => [
                    $e->getMessage()
                ]
            ]);
        }
    }

    public function destroy_block($id)
    {
        try {
            DB::beginTransaction();
            $item = Block::find($id);
            $section = $item->content->section;

            if ($item->image){
                Storage::disk(env('DEFAULT_STORAGE_DISK'))->delete($item->image);
            }
            $item->delete();
            DB::commit();
            session()->flash('message', 'Se elimino correctamente.');

            return Redirect::route('adm.content.index',$section);
//            return response()->json([
//                'status' => 'success',
//                'message' => __('slider.destroy.success')
//            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => __('slider.destroy.error-default'),
                'errors' => [
                    $e->getMessage()
                ]
            ]);
        }
    }

}
