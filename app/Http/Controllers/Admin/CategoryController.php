<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        $categorias = Category::where('section','blog')->orderBy('order')->get();

        return Inertia::render('Admin/Category', [
            'categorias' => $categorias->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->getTranslations('title'),
                    'description' => $item->getTranslations('description'),
                    'text' => $item->getTranslations('text'),
                    'section' => $item->section,
                    'order' => $item->order,
                    'image' => $item->image ? Storage::disk(env('DEFAULT_STORAGE_DISK'))->url($item->image) : '',
                    'image_2' => $item->image_2 ? Storage::disk(env('DEFAULT_STORAGE_DISK'))->url($item->image_2) : '',
                    'image_3' => $item->image_3 ? Storage::disk(env('DEFAULT_STORAGE_DISK'))->url($item->image_3) : '',
                ];
            }),

        ]);

    }

    public function industrias()
    {
        $categorias = Category::where('section','industrias')->orderBy('order')->get();

        return Inertia::render('Admin/Industrias', [
            'categorias' => $categorias->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->getTranslations('title'),
                    'description' => $item->getTranslations('description'),
                    'text' => $item->getTranslations('text'),
                    'section' => $item->section,
                    'order' => $item->order,
                    'image' => $item->image ? Storage::disk(env('DEFAULT_STORAGE_DISK'))->url($item->image) : '',
                    'image_2' => $item->image_2 ? Storage::disk(env('DEFAULT_STORAGE_DISK'))->url($item->image_2) : '',
                    'image_3' => $item->image_3 ? Storage::disk(env('DEFAULT_STORAGE_DISK'))->url($item->image_3) : '',
                ];
            }),
            'section' => 'industrias',
        ]);

    }

    public function store(Request $request)
    {
//        dd($request->all());
        try {
            DB::beginTransaction();
            if ($request->id){
                $item = Category::find($request->id);
            }else{
                $item = new Category();
            }
            if (is_string($request->image_2)){
                $item->image_2  =  $item->image_2;
            }else{
                if ($item->image_2 == ''){
                    Storage::disk(env('DEFAULT_STORAGE_DISK'))->delete($item->image_2);
                }
                if ($request->image_2){
                    $item->image_2 = Storage::disk(env('DEFAULT_STORAGE_DISK','public'))->putFileAs('uploads/industrias', $request->file('image_2'),$request->file('image_2')->getClientOriginalName());
//                    $item->image  = $request->file('image')->storeAs('uploads/web',$request->file('image')->getClientOriginalName(),env('DEFAULT_STORAGE_DISK','public'));

                    Storage::disk(env('DEFAULT_STORAGE_DISK'))->setVisibility($item->image_2, 'public');
                }
//                dd([$request->all(),$request->image,$item]);
            }
            if (is_string($request->image_3)){
                $item->image_3  =  $item->image_3;
            }else{
                if ($item->image_3 == ''){
                    Storage::disk(env('DEFAULT_STORAGE_DISK'))->delete($item->image_3);
                }
                if ($request->image_3){
                    $item->image_3 = Storage::disk(env('DEFAULT_STORAGE_DISK','public'))->putFileAs('uploads/industrias', $request->file('image_3'),$request->file('image_3')->getClientOriginalName());
//                    $item->image  = $request->file('image')->storeAs('uploads/web',$request->file('image')->getClientOriginalName(),env('DEFAULT_STORAGE_DISK','public'));

                    Storage::disk(env('DEFAULT_STORAGE_DISK'))->setVisibility($item->image_3, 'public');
                }
//                dd([$request->all(),$request->image,$item]);
            }

            if (is_string($request->image)){
                $item->image  =  $item->image;
            }else{
                if ($item->image == ''){
                    Storage::disk(env('DEFAULT_STORAGE_DISK'))->delete($item->image);
                }
                if ($request->image){
                    $item->image = Storage::disk(env('DEFAULT_STORAGE_DISK','public'))->putFileAs('uploads/industrias', $request->file('image'),$request->file('image')->getClientOriginalName());
//                    $item->image  = $request->file('image')->storeAs('uploads/web',$request->file('image')->getClientOriginalName(),env('DEFAULT_STORAGE_DISK','public'));

                    Storage::disk(env('DEFAULT_STORAGE_DISK'))->setVisibility($item->image, 'public');
                }
//                dd([$request->all(),$request->image,$item]);
            }
            $item->setTranslations('title', (array) json_decode($request->title));
            $item->setTranslations('text', (array) json_decode($request->text));
            $item->setTranslations('description', (array) json_decode($request->description));
            $item->setTranslations('slug', collect(json_decode($request->title))->slug()->toArray());

            $item->order   = $request->order;
            if ($request->section){
                $item->section   = @$request->section;
            }
//            $item->slug    = str::slug($request->title);
            $item->save();

            DB::commit();

            session()->flash('message', 'Se guardo correctamente.');
            if ($item->section == 'industrias'){
                return Redirect::route('adm.categorias.industrias');
            }else{
                return Redirect::route('adm.categorias.index');
            }

        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('error', 'Se encontraron algunos errores.'.$e->getMessage());
            return Redirect::route('adm.categorias.index');

        }
    }

    public function destroy($id)
    {
        $item = Category::find($id);
        session()->flash('success', 'Se elimino correctamente.');
        if ($item->section == 'industrias'){
            $item->delete();
            return Redirect::route('adm.categorias.industrias');
        }else{
            $item->delete();
            return Redirect::route('adm.categorias.index');
        }
    }

}
