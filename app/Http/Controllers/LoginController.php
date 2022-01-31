<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    
    public function login()
    {
        // si esta logueaod que lo rediriga a aoacall
        if (Session::get('key') != null) {
            return redirect()->route('aoacall');
        }
        else {
            // de lo contrario al inicio
            return view('login');
        }
    }
    // autenticacion
    public function auth(Request $request)
    {
        $response = Http::post(env('PRODUCTION_URL').'/callcenter/login', [
            'usuario' => $request->usuario,
            'clave' => $request->clave,
            'token' => '876d7aea36089672b11e1cd60e9ccaec'
        ]);
        $response = json_decode($response);
        if ($response ===  null) {
            return back()->withErrors([
                'message' => "¡Credenciales incorrectas!"
            ]);
        }
        else {
            
            if (isset($response->{'datosAdmin'})) {
                session(['key' => $response->{'datosAdmin'}]);
                session(['admin' => "si"]);
                return redirect()->to('aoacall');
            }
            else {
            session(['key' => $response->{'datos'}]);
            session(['permiso' => $response->{'permiso'}]);
            return redirect()->to('aoacall');
            }
            
        }
        
    }
    public function auth1(Request $request,$nombre,$siniestro)
    {
        $des = openssl_decrypt($nombre,"AES-128-ECB","a");
        
        $response = Http::post(env('PRODUCTION_URL').'/callcenter/login1', [
            'usuario' => $des,
            'token' => '876d7aea36089672b11e1cd60e9ccaec'
        ]);
        $response = json_decode($response);
        if ($response ===  null) {
            return back()->withErrors([
                'message' => "¡Credenciales incorrectas!"
            ]);
        }
        else {
            
            if (isset($response->{'datosAdmin'})) {
                session(['key' => $response->{'datosAdmin'}]);
                session(['admin' => "si"]);
                if ($siniestro) {
                    session(['siniestro' => $siniestro]);
                }
                return redirect()->to('aoacall');
            }
            else {
            session(['key' => $response->{'datos'}]);
            session(['permiso' => $response->{'permiso'}]);
            session(['auth1' => "si"]);
            if ($siniestro) {
                session(['siniestro' => $siniestro]);
            }
            return redirect()->to('aoacall');
            }
            
        }
        
    }
}
