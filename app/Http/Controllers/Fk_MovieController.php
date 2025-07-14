<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cinema;
use App\Models\Actor;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\Country;
use App\Models\Director;

class Fk_MovieController extends Controller
{
    /**
     * Hiển thị danh sách phim được phép chiếu ở rạp này
     */
    public function index(Request $request, $cinemaId)
{
    // 1. Lấy rạp chiếu
    $cinema = Cinema::findOrFail($cinemaId);

    // 2. Lấy danh sách phim liên kết, có tìm kiếm
    $moviesQuery = $cinema->movies()
        ->with(['country'])
        ->withTrashed();

    // Nếu có từ khóa tìm kiếm
    if ($request->filled('q')) {
        $moviesQuery->where('title', 'like', '%' . $request->q . '%');
    }

    $movies = $moviesQuery->paginate(9)->withQueryString();

    return view('admin.fk_movies.index', compact('cinema', 'movies'));
}


    public function create($cinemaId, Request $request)
    {
        $cinema = Cinema::with('movies')->findOrFail($cinemaId);

        $query = Movie::query();

        // Lọc theo thể loại (many-to-many)
        if ($request->filled('genre_id')) {
            $query->whereHas('genres', fn($q) => $q->where('genres.id', $request->genre_id));
        }

        // Lọc theo diễn viên (many-to-many)
        if ($request->filled('actor_id')) {
            $query->whereHas('actors', fn($q) => $q->where('actors.id', $request->actor_id));
        }

        // Lọc theo quốc gia
        if ($request->filled('country_id')) {
            $query->where('country_id', $request->country_id);
        }

        // Lọc theo đạo diễn
        if ($request->filled('director_id')) {
            $query->where('director_id', $request->director_id);
        }

        // Phân trang 6 phần tử mỗi trang
        $movies = $query->latest()->paginate(6)->withQueryString();

        // Lấy danh sách movie_id đã gán cho cinema
        $selectedMovieIds = $cinema->movies->pluck('id')->toArray();

        return view('admin.fk_movies.create', [
            'cinema' => $cinema,
            'movies' => $movies,
            'genres' => Genre::all(),
            'countries' => Country::all(),
            'directors' => Director::all(),
            'actors' => Actor::all(),
            'selectedMovieIds' => $selectedMovieIds,
        ]);
    }


    public function store(Request $request, $cinemaId)
{
    $validated = $request->validate([
        'movies'   => 'nullable|array',
        'movies.*' => 'integer|exists:movies,id',
    ]);

    $cinema = Cinema::findOrFail($cinemaId);

    // Cập nhật lại quan hệ: chỉ giữ các ID được tick
    $cinema->movies()->sync($validated['movies'] ?? []);

    return redirect()
        ->route('admin.cinemas.movies.index', $cinemaId)
        ->with('success', 'Cập nhật phim thành công');
}
}
