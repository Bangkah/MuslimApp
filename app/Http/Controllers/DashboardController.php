<?php

namespace App\Http\Controllers;

use App\Models\Ayah;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $ayahs = Ayah::all();
        return view('Dashboard', compact('ayahs'));
    }
}
