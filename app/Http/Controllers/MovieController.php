<?php

namespace App\Http\Controllers;

use Storage;
use App\Models\Actor;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\Country;
use App\Models\Director;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index(Request $request)
    {
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

        // Phân trang 10 phần tử mỗi trang
        $movies = $query->latest()->paginate(6)->withQueryString();

        return view('admin.movies.index', [
            'movies' => $movies,
            'genres' => Genre::all(),
            'countries' => Country::all(),
            'directors' => Director::all(),
            'actors' => Actor::all(),
        ]);
    }

    // Hiển thị form tạo mới
    public function create()
    {
        $countries = Country::all();
        $directors = Director::all();
        $genres = Genre::all(); // Lấy tất cả thể loại từ cơ sở dữ liệu
        $actors = Actor::all(); // Thêm danh sách actors vào view

        // Truyền thêm genres và actors vào view
        return view('admin.movies.create', compact('countries', 'directors', 'genres', 'actors'));
    }

    // Lưu phim mới vào cơ sở dữ liệu
    public function store(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'release_date' => 'nullable|date',
            'duration' => 'nullable|integer',
            'country_id' => 'nullable|exists:countries,id',
            'director_id' => 'nullable|exists:directors,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'trailer_url' => 'nullable|url',
            'genres' => 'nullable|array', // Xác thực cho genres, phải là mảng
            'genres.*' => 'exists:genres,id', // Kiểm tra từng giá trị trong genres có tồn tại trong bảng genres
            'actors' => 'nullable|array', // Thêm xác thực cho actors
            'actors.*' => 'exists:actors,id', // Kiểm tra từng giá trị trong actors có tồn tại trong bảng actors
        ]);

        // Xử lý trạng thái is_active
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        // Xử lý lưu ảnh nếu có
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('movies', 'public');
        }

        // Tạo một bộ phim mới trong cơ sở dữ liệu
        $movie = Movie::create($validated);

        // Lưu các thể loại đã chọn
        if ($request->has('genres')) {
            $movie->genres()->sync($request->input('genres')); // Liên kết phim với các thể loại đã chọn
        }

        // Lưu các diễn viên đã chọn
        if ($request->has('actors')) {
            $movie->actors()->sync($request->input('actors')); // Liên kết phim với các diễn viên đã chọn
        }

        // Chuyển hướng về trang danh sách phim với thông báo thành công
        return redirect()->route('admin.movies.index')->with('success', 'Thêm phim thành công');
    }






    // Hiển thị chi tiết phim

    public function show($id)
    {
        $movie = Movie::with(['genres', 'actors', 'country', 'director'])->findOrFail($id);

        $url = $movie->trailer_url;

        if (Str::contains($url, 'watch?v=')) {
            $videoId = explode('v=', $url)[1];
            $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
        } elseif (Str::contains($url, 'youtu.be/')) {
            $videoId = explode('youtu.be/', $url)[1];
            $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
        } else {
            $embedUrl = $url; // Assume it's already embed format
        }

        return view('admin.movies.show', compact('movie', 'embedUrl'));
    }

   public function showTrash($id)
{
    // Lấy phim đã bị xóa mềm kèm các quan hệ liên quan
    $movie = Movie::onlyTrashed()
        ->with(['genres', 'actors', 'country', 'director'])
        ->findOrFail($id);

    // Xử lý trailer_url thành embed URL
    $url = $movie->trailer_url;
    $embedUrl = $url; // Mặc định giữ nguyên

    if (Str::contains($url, 'watch?v=')) {
        $videoId = explode('v=', $url)[1];
        $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
    } elseif (Str::contains($url, 'youtu.be/')) {
        $videoId = explode('youtu.be/', $url)[1];
        $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
    }

    // Nếu view có sử dụng các danh sách này (ví dụ trong form), truyền kèm
    $genres = Genre::all();
    $actors = Actor::all();
    $countries = Country::all();
    $directors = Director::all();

    // Trả dữ liệu về view
    return view('admin.movies.showTrash', [
        'movie'     => $movie,
        'embedUrl'  => $embedUrl,
        'genres'    => $genres,
        'actors'    => $actors,
        'countries' => $countries,
        'directors' => $directors,
    ]);
}




    // Hiển thị form chỉnh sửa phim
    public function edit($id)
    {
        $movie = Movie::findOrFail($id); // Lấy phim cần chỉnh sửa
        $countries = Country::all();
        $directors = Director::all();
        $genres = Genre::all();
        $actors = Actor::all();

        return view('admin.movies.edit', compact('movie', 'countries', 'directors', 'genres', 'actors'));
    }



    // Cập nhật thông tin phim
    public function update(Request $request, $id)
    {
        $movie = Movie::findOrFail($id); // Tìm phim theo ID

        // Xác thực dữ liệu đầu vào
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'release_date' => 'nullable|date',
            'duration' => 'nullable|integer',
            'country_id' => 'nullable|exists:countries,id',
            'director_id' => 'nullable|exists:directors,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'trailer_url' => 'nullable|url',
            'genres' => 'nullable|array',
            'genres.*' => 'exists:genres,id',
            'actors' => 'nullable|array',
            'actors.*' => 'exists:actors,id',
        ]);

        // Xử lý trạng thái is_active
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        // Nếu có ảnh mới thì lưu ảnh
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('movies', 'public');
        }

        // Cập nhật phim
        $movie->update($validated);

        // Cập nhật các thể loại
        if ($request->has('genres')) {
            $movie->genres()->sync($request->input('genres'));
        }

        // Cập nhật các diễn viên
        if ($request->has('actors')) {
            $movie->actors()->sync($request->input('actors'));
        }

        return redirect()->route('admin.movies.index')->with('success', 'Cập nhật phim thành công');
    }



    // Xóa phim (soft delete)
    public function destroy($id)
    {
        $movie = Movie::findOrFail($id);
        $movie->delete(); // Xóa mềm

        return redirect()->route('admin.movies.index')->with('success', 'Đã xoá mềm phim thành công');
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

        return redirect()->route('admin.movies.trash')->with('success', 'Đã khôi phục phim thành công');
    }

    // Xóa phim vĩnh viễn
    public function forceDelete($id)
    {
        $movie = Movie::onlyTrashed()->findOrFail($id);
        $movie->forceDelete();

        return redirect()->route('admin.movies.trash')->with('success', 'Đã xoá vĩnh viễn phim');
    }
}
