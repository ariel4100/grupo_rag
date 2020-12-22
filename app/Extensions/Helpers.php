<?php

namespace App\Extensions;

use Illuminate\Support\Facades\Storage;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Helpers
{

    public static function saveImage($file, $route, $file_before = null, $id = null)
    {
//        dd($file);
        if ($file) {
            if (is_string($file)){
                // 0 para q la condicion no guarde, y lo deje como esta
                return 0;
            }elseif($file->isValid()) {
                if (is_string($file_before) && $file_before != null){
                    Storage::disk(env('DEFAULT_STORAGE_DISK'))->delete($file_before);
                }

                $path = Storage::disk(env('DEFAULT_STORAGE_DISK','public'))->putFileAs("uploads/$route", $file,$file->getClientOriginalName());
//                $path = $file->storeAs("uploads/$route",$file->getClientOriginalName(),env('DEFAULT_STORAGE_DISK'));
                Storage::disk(env('DEFAULT_STORAGE_DISK'))->setVisibility($path, env('DEFAULT_STORAGE_DISK'));
//                dd($path);
                return $path;
            }
        }
        return false;
    }
    public static function saveMultipleImage($items, $route, $model = null, $id = null)
    {
        if($items != null){
            foreach ($items as $key => $value) {
                if ($model){
                    if ($value['id']){
                        $block = $model::findOrFail($value['id']);
                    }else{
                        $block = new $model();
                    }
                    $file_save = Helpers::saveImage($value['image'], $route,$block->image);
                    $file_save ? $block->image = $file_save : false;

                    $block->setTranslations('title', (array) json_decode($value['title']));
                    $block->setTranslations('text', (array) json_decode($value['text']));
                    $value['type'] ?  $block->type = $value['type'] : false;
                    $block->content_id = $id;
                    $block->save();
                }else{
//                    dd($value);
                    $file_save = Helpers::saveImage($value, $route);
                    if ($file_save){
                        $images[$key] = $file_save;
                    }else{
                        //limpio el dominio y obtengo solo el path del file
                        $path = explode('storage/', $value)[1];
                        $images[$key] = $path;
                    }


//                    $images[] = [
//                        'image'      => Helpers::saveImage($value['image'], $route),
//                        'title' => $value['title'] ?? '',
////                        'text'    => (array) json_decode($value['text'] ?? '')
//                    ];
                }


                //productos -> relaciona las soluciones con los porductos


//                    if(is_string($value['image'])) {
//                        $images[] = [
//                            "content_id"  => $item->id,
////                            'image'      => $value['image'] ?? '',
//                            'title' => (array) json_decode($value['title']) ?? '',
//                            'text'    => (array) json_decode($value['text']) ?? ''
//                        ];
////                        $images[$key]['content_id'] =  $item->id;
////                        $images[$key]['image'] = $value['image'] ?? '';
////                        $images[$key]['title'] = (array) json_decode($value['title']) ?? '';
////                        $images[$key]['text'] = (array) json_decode($value['text']) ?? '';
//                    } else {
//                        if($value['image'] == null){
////                    dd($value);
//                            $path = '';
//                        }else{
//                            $path = $value['image']->storeAs('uploads/web',$value['image']->getClientOriginalName(),env('DEFAULT_STORAGE_DISK'));
//                            Storage::disk(env('DEFAULT_STORAGE_DISK'))->setVisibility($path, 'public');
//                        }
//                        $images[] = [
//                            "content_id"  => $item->id,
//                            'image'      => $path,
//                            'title' => (array) json_decode($value['title']) ?? '',
//                            'text'           => (array) json_decode($value['text']) ?? ''
//                        ];
////                        $images[$key]['content_id'] =  $item->id;
////                        $images[$key]['image'] = $path;
////                        $images[$key]['title'] = (array) json_decode($value['title']) ?? '';
////                        $images[$key]['text'] = (array) json_decode($value['text']) ?? '';
//
//                    }
//                    $block = Block::create(current($images));
//                    next($images);
            }
//                dd($images);

//                $block = Block::create([$images]);

        }
        if ($model) {
            return 1;
        }

        return $images;
    }
    public static function saveMultipleImageWithData($items, $route, $model = null, $id = null)
    {
        if($items != null){
            foreach ($items as $key => $value) {
                if ($model){
                    if ($value['id']){
                        $block = $model::findOrFail($value['id']);
                    }else{
                        $block = new $model();
                    }
                    $file_save = Helpers::saveImage($value['image'], $route,$block->image);
                    $file_save ? $block->image = $file_save : false;

                    $block->setTranslations('title', (array) json_decode($value['title']));
                    $block->setTranslations('text', (array) json_decode($value['text']));
                    $value['type'] ?  $block->type = $value['type'] : false;
                    $block->content_id = $id;
                    $block->save();
                }else{
//                    dd($value);
                    $file_save = Helpers::saveImage($value['image'], $route);
                    if (is_string($file_save)){
                        $images[$key]['image'] = $file_save;
                    }else{
                        //limpio el dominio y obtengo solo el path del file
                        if ($value['image']){
                            $path = explode('storage/', $value['image'])[1];
                            $images[$key]['image'] = $path;
                            $images[$key]['title'] = $value['title'];
                        }else{
                            $images[$key]['image'] = '';
                        }
                    }


//                    $images[] = [
//                        'image'      => Helpers::saveImage($value['image'], $route),
//                        'title' => $value['title'] ?? '',
////                        'text'    => (array) json_decode($value['text'] ?? '')
//                    ];
                }


                //productos -> relaciona las soluciones con los porductos


//                    if(is_string($value['image'])) {
//                        $images[] = [
//                            "content_id"  => $item->id,
////                            'image'      => $value['image'] ?? '',
//                            'title' => (array) json_decode($value['title']) ?? '',
//                            'text'    => (array) json_decode($value['text']) ?? ''
//                        ];
////                        $images[$key]['content_id'] =  $item->id;
////                        $images[$key]['image'] = $value['image'] ?? '';
////                        $images[$key]['title'] = (array) json_decode($value['title']) ?? '';
////                        $images[$key]['text'] = (array) json_decode($value['text']) ?? '';
//                    } else {
//                        if($value['image'] == null){
////                    dd($value);
//                            $path = '';
//                        }else{
//                            $path = $value['image']->storeAs('uploads/web',$value['image']->getClientOriginalName(),env('DEFAULT_STORAGE_DISK'));
//                            Storage::disk(env('DEFAULT_STORAGE_DISK'))->setVisibility($path, 'public');
//                        }
//                        $images[] = [
//                            "content_id"  => $item->id,
//                            'image'      => $path,
//                            'title' => (array) json_decode($value['title']) ?? '',
//                            'text'           => (array) json_decode($value['text']) ?? ''
//                        ];
////                        $images[$key]['content_id'] =  $item->id;
////                        $images[$key]['image'] = $path;
////                        $images[$key]['title'] = (array) json_decode($value['title']) ?? '';
////                        $images[$key]['text'] = (array) json_decode($value['text']) ?? '';
//
//                    }
//                    $block = Block::create(current($images));
//                    next($images);
            }
//                dd($images);

//                $block = Block::create([$images]);

        }
        if ($model) {
            return 1;
        }

        return $images;
    }

    public static function saveFile($file, $route, $id = null)
    {
        if ($file) {
            if ($file->isValid()) {
                $path = public_path('files/'.$route.'/');
                $route_file = $route.'_'.$id."_".$file->getClientOriginalName();
                $file->move($path, $route_file);

                return $route_file;
            }
        }
        return false;
    }

    public static function getTranslations($item, $name){
        $idiomas = LaravelLocalization::getSupportedLocales();
        $getIdiomas = collect($idiomas)->map(function ($item, $key) {
            return '';
        })->toArray();
//        dd($getIdiomas);
        $data = $item->toArray();
        if ($data[$name] == null){
            return $getIdiomas;
        }
        return $data[$name];
    }
}
