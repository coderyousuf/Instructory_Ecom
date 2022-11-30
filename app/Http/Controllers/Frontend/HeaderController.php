<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HeaderController extends Controller
{
    public function about(){
        return view('frontend.pages.widgets.about');
    }

    public function contact(){
        return view('frontend.pages.widgets.contact');
    }
}
