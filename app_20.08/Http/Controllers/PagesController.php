<?php

namespace App\Http\Controllers;

class PagesController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function partners()
    {
        return view('pages.partners');
    }
	
    public function support()
    {
        return view('pages.support');
    }
	
}
