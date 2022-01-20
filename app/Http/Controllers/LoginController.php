<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function login()
    {
        if (Session::get('key') != null) {
            return redirect()->route('aoacall');
        }
        else {
            return view('login');
        }
    }
    public function auth(Request $request)
    {
        $response = Http::post('http://127.0.0.1:8000/api/callcenter/login', [
            'usuario' => $request->usuario,
            'clave' => $request->clave,
            'token' => '876d7aea36089672b11e1cd60e9ccaec'
        ]);
        $response = json_decode($response);
        if ($response->{'Msj'} === "¡Credenciales incorrectas!") {
            return back()->withErrors([
                'message' => $response->Msj
            ]);
        }
        else {
            session(['key' => $response->{'datos'}]);
            session(['permiso' => $response->{'permiso'}]);
            return redirect()->to('aoacall');
            // dd([Session::get('key')]);
        }
        
    }
}
