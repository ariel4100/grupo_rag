<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ClientController extends Controller
{
    public function index()
    {
        $items = Client::all();

        return Inertia::render('Admin/Clientes', [
            'items' => $items,

        ]);

    }

    public function store(Request $request)
    {
//        dd($request->all());
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255','unique:clients'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:clients'],
            'password' => ['required', 'string', 'min:4',],
        ]);
        try {
            DB::beginTransaction();
            if ($request->id){
                $item = Client::find($request->id);
            }else{
                $item = new Client();
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

            session()->flash('message', 'Se ha guardado correctamente.');

            return Redirect::route('adm.clientes.index');
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('errors', 'Fallo en el sistema.');

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
        Client::find($id)->delete();
        session()->flash('message', 'Se ha eliminado correctamente.');
        return Redirect::route('adm.clientes.index');
    }
}
