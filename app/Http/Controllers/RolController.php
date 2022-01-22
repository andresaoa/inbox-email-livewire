<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RolController extends Controller
{
    public function index()
    {
        if (Session::get('admin')) {
            return view('rol.index');
        }
        else {
            return redirect()->to('/');
        }
    }
}
