<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $items = User::all();

        return Inertia::render('Admin/Usuarios', [
            'items' => $items,

        ]);

    }


    public function store(Request $request)
    {
//        dd($request->all());
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255','unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:3',],
        ]);
        try {
            DB::beginTransaction();
            if ($request->id){
                $item = User::find($request->id);
            }else{
                $item = new User();
            }

            $item->name   = $request->name;
            $item->username   = $request->username;
            $item->email   = $request->email;
            if ($request->password)
            {
                $item->password = Hash::make($request->password);
            }
//            $item->slug    = str::slug($request->title);
            $item->save();

            DB::commit();

            session()->flash('success', 'Se ha creado correctamente.');

            return Redirect::route('adm.usuarios.index');
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('error', 'Fallo en el sistema.');

            return Redirect::route('adm.usuarios.index');
//            return response()->json([
//                'status' => 'error',
//                'message' => __('category.store.error-default'),
//                'errors' => [
//                    $e->getMessage()
//                ]
//            ]);
        }
    }

    public function destroy($id)
    {
        User::find($id)->delete();
        return response()->json([
            'status' => 'success',
            'message' => __('category.store.error-default'),
        ]);
    }
}
