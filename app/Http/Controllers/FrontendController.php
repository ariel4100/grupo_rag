<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Category;
use App\Models\Content;
use App\Models\Descargas;
use App\Models\Donwload;
use App\Models\Family;
use App\Models\News;
use App\Models\Product;
use App\Models\Slider;
use App\Models\User;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class FrontendController extends Controller
{
    public function home()
    {

        $destacados_productos = Product::where('featured',1)->orderBy('order')->get();
        $sliders = Slider::where('section','inicio')->get();
        $contenido = Content::with('block')->where('section','inicio')->first();
        $clientes = Content::with('block')->where('section','clientes')->first();
        $empresa = Content::with('block')->where('section','empresa')->first();
        $industrias = Content::with('block')->where('section','industrias')->first();
        $industriasMap =  $industrias->Block->map(function ($item) {
            return [
                'title' => $item->title,
                'text' => $item->text,
                'type' => $item->type,
                'image' => $item->image ? Storage::disk(env('DEFAULT_STORAGE_DISK'))->url($item->image) : '',
            ];
        });

        $empresaoMap =  $empresa->Block->map(function ($item) {
            return [
                'title' => $item->title,
                'text' => $item->text,
                'type' => $item->type,
                'image' => $item->image ? Storage::disk(env('DEFAULT_STORAGE_DISK'))->url($item->image) : '',
            ];
        });
        $contenidoMap =  $contenido->Block->map(function ($item) {
            return [
                'title' => $item->title,
                'text' => $item->text,
                'type' => $item->type,
                'image' => $item->image ? Storage::disk(env('DEFAULT_STORAGE_DISK'))->url($item->image) : '',
            ];
        });
        $clientesMap =  $clientes->Block->map(function ($item) {
            return [
                'title' => $item->title,
                'text' => $item->text,
                'type' => $item->type,
                'image' => $item->image ? Storage::disk(env('DEFAULT_STORAGE_DISK'))->url($item->image) : '',
            ];
        });
        //$novedades = News::orderBy('order')->limit(3)->get();
        return Inertia::render('Web/Home', [
            'sliders' => $sliders->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'text' => $item->text,
                    'order' => $item->order,
                    'image' => $item->image ? Storage::disk(env('DEFAULT_STORAGE_DISK'))->url($item->image) : '',
                ];
            }),
            'clientes' => $clientesMap->where('type','img')->values(),
            'bloques' => $contenidoMap->whereNull('type')->values(),
            'texto_imagen' => $contenidoMap->where('type','img')->values(),
            'empresa' => $empresaoMap->where('type','img')->values(),
            'textos' => $contenidoMap->where('type','texto')->values(),
            'industrias' => $industriasMap->where('type','img')->values(),
//            'productos' => $destacados_productos->map(function ($item) {
//                return [
//                    'id' => $item->id,
//                    'title' => $item->title,
//                    'text' => $item->text,
//                    'order' => $item->order,
//                    'ruta' => route('producto',$item->slug),
//                    'image' => $item->gallery ? Storage::disk(env('DEFAULT_STORAGE_DISK'))->url($item->gallery[0]) : '',
//                ];
//            }),

        ]);
    }
    public function empresa()
    {
        $sliders = Slider::where('section','empresa')->get();
        $contenido = Content::with('block')->where('section','empresa')->first();
        $contenidoMap =  $contenido->Block->map(function ($item) {
            return [
                'title' => $item->title,
                'text' => $item->text,
                'type' => $item->type,
                'image' => $item->image ? Storage::disk(env('DEFAULT_STORAGE_DISK'))->url($item->image) : '',
            ];
        });

        return Inertia::render('Web/Empresa', [
            'sliders' => $sliders->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'text' => $item->text,
                    'order' => $item->order,
                    'image' => $item->image ? Storage::disk(env('DEFAULT_STORAGE_DISK'))->url($item->image) : '',
                ];
            }),
            'textos' => $contenidoMap->where('type',null)->values(),
            'texto_imagen' => $contenidoMap->where('type','texto')->values(),


        ]);
    }
    public function calidad()
    {
        $sliders = Slider::where('section','calidad')->get();
        $contenido = Content::with('block')->where('section','calidad')->first();
        $contenidoMap =  $contenido->Block->map(function ($item) {
            return [
                'title' => $item->title,
                'text' => $item->text,
                'type' => $item->type,
                'image' => $item->image ? Storage::disk(env('DEFAULT_STORAGE_DISK'))->url($item->image) : '',
            ];
        });

        return Inertia::render('Web/Calidad', [
            'sliders' => $sliders->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'text' => $item->text,
                    'order' => $item->order,
                    'image' => $item->image ? Storage::disk(env('DEFAULT_STORAGE_DISK'))->url($item->image) : '',
                ];
            }),
            'textos' => $contenidoMap->whereNull('type')->values(),
            'archivos' => $contenidoMap->where('type','img')->values(),
            'contenido' => $contenido,
        ]);
    }

    public function servicios()
    {
        $contenido = Content::with('block')->where('section','servicios')->first();
        $contenidoMap =  $contenido->Block->map(function ($item) {
            return [
                'title' => $item->title,
                'text' => $item->text,
                'type' => $item->type,
                'image' => $item->image ? Storage::disk(env('DEFAULT_STORAGE_DISK'))->url($item->image) : '',
            ];
        });

        return Inertia::render('Web/Servicios', [
            'servicios' => $contenidoMap->where('type','img')->values(),
        ]);
    }

    public function industrias()
    {
        $contenido = Content::with('block')->where('section','industrias')->first();
        $contenidoMap =  $contenido->Block->map(function ($item) {
            return [
                'title' => $item->title,
                'text' => $item->text,
                'type' => $item->type,
                'image' => $item->image ? Storage::disk(env('DEFAULT_STORAGE_DISK'))->url($item->image) : '',
            ];
        });

        return Inertia::render('Web/Industrias', [
            'industrias' => $contenidoMap->where('type','img')->values(),
        ]);
    }
    public function descargas()
    {
        $items = Donwload::orderBy('order')->get();
        $contenidoMap =  $items->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'order' => $item->order,
                'image' => $item->image ? Storage::disk(env('DEFAULT_STORAGE_DISK'))->url($item->image) : '',
                'file' => $item->file ? Storage::disk(env('DEFAULT_STORAGE_DISK'))->url($item->file) : '',
            ];
        });

        return Inertia::render('Web/Descargas', [
            'items' => $contenidoMap->values(),
        ]);
    }
    public function familias($slug = '')
    {
        $lang = app()->getLocale();
        $familias = Family::orderBy('order')->get();

        return Inertia::render('Web/Product/Family', [
            'familias' => $familias->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'ruta' => route('productos',$item->slug),
                    'image' => $item->image ? Storage::disk(env('DEFAULT_STORAGE_DISK'))->url($item->image) : '',
                ];
            }),
        ]);

    }

    public function productos($slug = '')
    {
        $lang = app()->getLocale();
        $familia = Family::where("slug->$lang",$slug)->first();
        $familias = Family::orderBy('order')->get();
        $productos = $familia->productos;
        return Inertia::render('Web/Product/Family', [
            'familia' => $familia->only('title','id','slug'),
            'sidenav' => 1,
            'productos' => $productos->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'text' => $item->text,
                    'order' => $item->order,
                    'ruta' => route('producto',$item->slug),
                    'image' => $item->gallery ? Storage::disk(env('DEFAULT_STORAGE_DISK'))->url($item->gallery[0]) : '',
                ];
            }),
            'familias' => $familias->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'order' => $item->order,
                    'ruta' => route('productos',$item->slug),
                    'image' => $item->image ? Storage::disk(env('DEFAULT_STORAGE_DISK'))->url($item->image) : '',
                    'productos' => $item->productos->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'title' => $item->title,
                            'slug' => $item->slug,
                            'order' => $item->order,
                            'ruta' => route('producto',$item->slug),
                        ];
                    }),
                ];
            }),
        ])->withViewData(['title' => $familia->title]);
    }

    public function producto($slug = '')
    {
        $lang = app()->getLocale();
        $producto = Product::where("slug->$lang",$slug)->first();
        $familia = $producto->family;
        $galeria = collect($producto->gallery)->map(function ($item) {
            return Storage::disk(env('DEFAULT_STORAGE_DISK'))->url($item);
        });

        $familias = Family::orderBy('order')->get();

        return Inertia::render('Web/Product/Product', [
            'familias' => $familias->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'order' => $item->order,
                    'ruta' => route('productos',$item->slug),
                    'productos' => $item->productos->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'title' => $item->title,
                            'slug' => $item->slug,
                            'order' => $item->order,
                            'ruta' => route('producto',$item->slug),
                        ];
                    }),
                ];
            }),
            'familia' => $familia->only('title','id','slug'),
            'gallery' => $galeria,
            'producto' => $producto->only('file','gallery','banner','video','text_video','text','description','title','id','slug'),
        ])->withViewData(['title' => $producto->title]);
    }


    public function contacto()
    {
        $sliders = Slider::where('section','contacto')->get();
        $contenido = Content::with('block')->where('section','contacto')->first();

        return Inertia::render('Web/Contacto', [
            'sliders' => $sliders->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'text' => $item->text,
                    'order' => $item->order,
                    'image' => $item->image ? Storage::disk(env('DEFAULT_STORAGE_DISK'))->url($item->image) : '',
                ];
            }),
            'contenido' => $contenido->only('title'),
        ]);
    }

    public function buscador(Request $request)
    {
        $productName = $request->name;
        if ($request->name){
            $productos_all = Product::get();
//            $productos = Product::where('title', 'LIKE', "%$request->name%")
////                ->orWhere('text', 'LIKE',"%$request->name%")
//                ->get()->map(function ($item) {
//                    return [
//                        'id' => $item->id,
//                        'title' => $item->title,
//                        'text' => $item->description,
//                        'order' => $item->order,
//                        'ruta' => route('producto',$item->slug),
//                        'image' => $item->gallery ? Storage::disk(env('DEFAULT_STORAGE_DISK'))->url($item->gallery[0]) : '',
//                    ];
//                });

            $productos = collect($productos_all)->filter(function ($item) use ($productName) {
                // replace stristr with your choice of matching function

                if (false !== stristr($item->title, $productName)){
                    return $item;
                }
            })->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'text' => $item->description,
                    'order' => $item->order,
                    'ruta' => route('producto',$item->slug),
                    'image' => $item->gallery ? Storage::disk(env('DEFAULT_STORAGE_DISK'))->url($item->gallery[0]) : '',
                ];
            });
        }else{
            $productos = [];
        }


//        dd($productos);
        return Inertia::render('Web/Buscador', [
            'productos' => $productos
        ]);
    }

}
