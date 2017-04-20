<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Genre;
use Session;

class GenreController extends Controller
{     
	public function store(Request $request)
    {

        $genres = new Genre;

        $genres->name = $request->name;
        $genres->save();

        $genres = Genre::all();

 		return redirect('settings/#3a')->with('genres', $genres);
      
    }

    public function remove($id) {

    	Genre::destroy($id);

    	$genres = Genre::all();

        Session::flash('genre', 'Genre deleted!');
        Session::flash('alert_type', 'alert-danger');

    	return redirect('settings/#3a')->with('genres', $genres);

    }
}
