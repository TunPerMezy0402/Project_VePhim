<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $query = Movie::query();
        $movies = $query->with(['genres', 'actors', 'country', 'director'])
                ->latest()
                ->paginate(6)
                ->withQueryString();
        
        return view('client.home');
    }

    public function movies()
    {
        return view('client.menu.movies.movie');
    }

    public function show()
    {
        return view('client.menu.movies.show');
    }

    public function showtimes()
    {
        return view('client.menu.movies.showtime');
    }
}
