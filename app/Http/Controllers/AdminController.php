<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller; 
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); 
        $this->middleware('role:admin'); // Vérifie que l'utilisateur a le rôle 'admin'
    }

    public function index()
    {   
        

        Log::info('AdminController@index called');
        return view('admin.dashboard');
    }
}
