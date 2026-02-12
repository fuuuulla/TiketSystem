<?php

namespace App\Http\Controllers;

use App\Models\Hosting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $hostings = Hosting::all();
        return view('home', compact('hostings')); // Affiche la vue home avec les hébergements
    }
}