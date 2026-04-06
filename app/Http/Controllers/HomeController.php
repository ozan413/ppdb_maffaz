<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomepageSetting;
use App\Models\Program;

class HomeController extends Controller
{
    /**
     * Show the landing page
     */
    public function index()
    {
        $settings = HomepageSetting::getSettings();
        $programs = Program::active()->get();

        return view('home', compact('settings', 'programs'));
    }
}
