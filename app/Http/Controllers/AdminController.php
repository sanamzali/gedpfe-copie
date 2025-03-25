<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('AdminDashboard'); // Assurez-vous que la vue existe
    }
}