<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\Country;
use App\Models\Director;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    // Hiển thị danh sách các phim
   public function index(Request $request)
{
    $query = Movie::query();

    // Lọc theo genre (nhiều-nhiều)
    if ($request->filled('genre_id')) {
        $query->whereHas('genres', function ($q) use ($request) {
            $q->where('genres.id', $request->genre_id);
        });
    }

    // Lọc theo actor (nhiều-nhiều)
    if ($request->filled('actor_id')) {
        $query->whereHas('actors', function ($q) use ($request) {
            $q->where('actors.id', $request->actor_id);
        });
    }

    // Lọc theo country (giả sử movie có khóa ngoại country_id)
    if ($request->filled('country_id')) {
        $query->where('country_id', $request->country_id);
    }

    // Lọc theo director (giả sử movie có khóa ngoại director_id)
    if ($request->filled('director_id')) {
        $query->where('director_id', $request->director_id);
    }

    $movies = $query->latest()->paginate(10);

    return view('admin.movies.index', [
        'movies' => $movies,
        'genres' => Genre::all(),
        'countries' => Country::all(),
        'directors' => Director::all(),
        'actors' => Actor::all()
    ]);
}




    // Hiển thị form tạo mới
    public function create()
    {
        $countries = Country::all();
        $directors = Director::all();

        return view('admin.movies.create', compact('countries', 'directors'));
    }

    // Lưu phim mới vào cơ sở dữ liệu
    public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'release_date' => 'nullable|date',
        'duration' => 'nullable|integer',
        'country_id' => 'nullable|exists:countries,id',
        'director_id' => 'nullable|exists:directors,id',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'trailer_url' => 'nullable|url',
    ]);

    // Checkbox không gửi nếu không được check → phải set thủ công
    $validated['is_active'] = $request->has('is_active') ? 1 : 0;

    // Xử lý upload ảnh (nếu có)
    if ($request->hasFile('image')) {
        $validated['image'] = $request->file('image')->store('public/movies');
    }

    Movie::create($validated);

    return redirect()->route('admin.movies.index')->with('success', 'Thêm phim thành công');
}


    // Hiển thị chi tiết phim
    public function show($id)
    {
        $movie = Movie::findOrFail($id);
        return view('admin.movies.show', compact('movie'));
    }

    // Hiển thị form chỉnh sửa phim
    public function edit($id)
    {
        $movie = Movie::findOrFail($id);
        $countries = Country::all();
        $directors = Director::all();

        return view('admin.movies.edit', compact('movie', 'countries', 'directors'));
    }

    // Cập nhật thông tin phim
    public function update(Request $request, $id)
    {
        $movie = Movie::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'release_date' => 'nullable|date',
            'duration' => 'nullable|integer',
            'country_id' => 'nullable|exists:countries,id',
            'director_id' => 'nullable|exists:directors,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'nullable|boolean',
            'trailer_url' => 'nullable|url',
        ]);

        // Xử lý upload ảnh mới nếu có
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public/movies');
        }

        $movie->update($validated);

        return redirect()->route('admin.movies.index')->with('success', 'Cập nhật phim thành công');
    }

    // Xóa phim (soft delete)
    public function destroy($id)
    {
        $movie = Movie::findOrFail($id);
        $movie->delete(); // Xóa mềm

        return redirect()->route('admin.movies.index')->with('success', 'Đã xoá phim');
    }

    // Xem các phim đã xóa mềm
    public function trash(Request $request)
    {
        $query = Movie::onlyTrashed(); // Chỉ lấy các phim đã xóa mềm

        // Tìm kiếm theo tiêu đề
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $movies = $query->orderBy('deleted_at', 'desc')->paginate(15);

        return view('admin.movies.trash', compact('movies'));
    }

    // Khôi phục phim đã xóa mềm
    public function restore($id)
    {
        $movie = Movie::onlyTrashed()->findOrFail($id);
        $movie->restore();

        return redirect()->route('admin.movies.trash')->with('success', 'Đã khôi phục phim');
    }

    // Xóa phim vĩnh viễn
    public function forceDelete($id)
    {
        $movie = Movie::onlyTrashed()->findOrFail($id);
        $movie->forceDelete();

        return redirect()->route('admin.movies.trash')->with('success', 'Đã xoá vĩnh viễn phim');
    }
}
