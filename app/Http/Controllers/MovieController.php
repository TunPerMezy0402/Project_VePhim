<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

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
        // Xác thực dữ liệu đầu vào với custom messages
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:movies,title',
            'description' => 'nullable|string|max:2000',
            'release_date' => 'required|date|before_or_equal:today',
            'duration' => 'required|integer|min:1|max:600', // Từ 1 phút đến 10 tiếng
            'country_id' => 'required|exists:countries,id',
            'director_id' => 'required|exists:directors,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'trailer_url' => 'nullable|url|max:500',
            'is_active' => 'required|boolean',
            'genres' => 'required|array|min:1', // Ít nhất phải chọn 1 thể loại
            'genres.*' => 'exists:genres,id',
            'actors' => 'required|array|min:1', // Ít nhất phải chọn 1 diễn viên
            'actors.*' => 'exists:actors,id',
        ], [
            'title.required' => 'Tên phim là bắt buộc.',
            'title.unique' => 'Tên phim này đã tồn tại.',
            'title.max' => 'Tên phim không được vượt quá 255 ký tự.',
            'description.max' => 'Mô tả không được vượt quá 2000 ký tự.',
            'release_date.required' => 'Ngày phát hành là bắt buộc.',
            'release_date.date' => 'Ngày phát hành phải là một ngày hợp lệ.',
            'release_date.before_or_equal' => 'Ngày phát hành không được sau ngày hôm nay.',
            'duration.required' => 'Thời lượng là bắt buộc.',
            'duration.integer' => 'Thời lượng phải là một số nguyên.',
            'duration.min' => 'Thời lượng phải lớn hơn 0 phút.',
            'duration.max' => 'Thời lượng không được vượt quá 600 phút (10 tiếng).',
            'country_id.required' => 'Vui lòng chọn quốc gia.',
            'country_id.exists' => 'Quốc gia đã chọn không tồn tại.',
            'director_id.required' => 'Vui lòng chọn đạo diễn.',
            'director_id.exists' => 'Đạo diễn đã chọn không tồn tại.',
            'image.image' => 'File phải là một hình ảnh.',
            'image.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif, webp.',
            'image.max' => 'Kích thước hình ảnh không được vượt quá 2MB.',
            'trailer_url.url' => 'URL trailer phải là một đường link hợp lệ.',
            'trailer_url.max' => 'URL trailer không được vượt quá 500 ký tự.',
            'is_active.required' => 'Vui lòng chọn trạng thái phim.',
            'is_active.boolean' => 'Giá trị trạng thái phim không hợp lệ.',
            'genres.required' => 'Vui lòng chọn ít nhất một thể loại.',
            'genres.array' => 'Danh sách thể loại không hợp lệ.',
            'genres.min' => 'Vui lòng chọn ít nhất một thể loại.',
            'genres.*.exists' => 'Thể loại đã chọn không tồn tại.',
            'actors.required' => 'Vui lòng chọn ít nhất một diễn viên.',
            'actors.array' => 'Danh sách diễn viên không hợp lệ.',
            'actors.min' => 'Vui lòng chọn ít nhất một diễn viên.',
            'actors.*.exists' => 'Diễn viên đã chọn không tồn tại.',
        ]);


        // Xử lý trạng thái is_active
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        try {
            // Xử lý lưu ảnh nếu có
            if ($request->hasFile('image')) {
                $image = $request->file('image');

                // Tạo tên file unique để tránh trùng lặp
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                // Lưu ảnh với tên file custom
                $validated['image'] = $image->storeAs('movies', $filename, 'public');
            }

            // Tạo một bộ phim mới trong cơ sở dữ liệu
            $movie = Movie::create($validated);

            // Lưu các thể loại đã chọn (chỉ khi có dữ liệu)
            if (!empty($validated['genres'])) {
                $movie->genres()->sync($validated['genres']);
            }

            // Lưu các diễn viên đã chọn (chỉ khi có dữ liệu)
            if (!empty($validated['actors'])) {
                $movie->actors()->sync($validated['actors']);
            }

            // Chuyển hướng về trang danh sách phim với thông báo thành công
            return redirect()
                ->route('admin.movies.index')
                ->with('success', 'Phim "' . $movie->title . '" đã được thêm thành công!');
        } catch (\Exception $e) {
            // Xử lý lỗi nếu có
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra khi thêm phim. Vui lòng thử lại!');
        }
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

    public function update(Request $request, $id)
    {
        $movie = Movie::findOrFail($id);

        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('movies', 'title')->ignore($id),
            ],
            'description' => 'nullable|string|max:2000',
            'release_date' => 'required|date|before_or_equal:today',
            'duration' => 'required|integer|min:1|max:600',
            'country_id' => 'required|exists:countries,id',
            'director_id' => 'required|exists:directors,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'trailer_url' => 'nullable|url|max:500',
            'is_active' => 'boolean',
            'genres' => 'required|array|min:1',
            'genres.*' => 'exists:genres,id',
            'actors' => 'required|array|min:1',
            'actors.*' => 'exists:actors,id',
        ], [
            'title.required' => 'Tên phim là bắt buộc.',
            'title.unique' => 'Tên phim này đã tồn tại.',
            'title.max' => 'Tên phim không được vượt quá 255 ký tự.',
            'description.max' => 'Mô tả không được vượt quá 2000 ký tự.',
            'release_date.required' => 'Ngày phát hành là bắt buộc.',
            'release_date.date' => 'Ngày phát hành phải là một ngày hợp lệ.',
            'release_date.before_or_equal' => 'Ngày phát hành không được sau ngày hôm nay.',
            'duration.required' => 'Thời lượng là bắt buộc.',
            'duration.integer' => 'Thời lượng phải là một số nguyên.',
            'duration.min' => 'Thời lượng phải lớn hơn 0 phút.',
            'duration.max' => 'Thời lượng không được vượt quá 600 phút (10 tiếng).',
            'country_id.required' => 'Vui lòng chọn quốc gia.',
            'country_id.exists' => 'Quốc gia đã chọn không tồn tại.',
            'director_id.required' => 'Vui lòng chọn đạo diễn.',
            'director_id.exists' => 'Đạo diễn đã chọn không tồn tại.',
            'image.image' => 'File phải là một hình ảnh.',
            'image.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif, webp.',
            'image.max' => 'Kích thước hình ảnh không được vượt quá 2MB.',
            'trailer_url.url' => 'URL trailer phải là một đường link hợp lệ.',
            'trailer_url.max' => 'URL trailer không được vượt quá 500 ký tự.',
            'is_active.boolean' => 'Giá trị trạng thái phim không hợp lệ.',
            'genres.required' => 'Vui lòng chọn ít nhất một thể loại.',
            'genres.array' => 'Danh sách thể loại không hợp lệ.',
            'genres.min' => 'Vui lòng chọn ít nhất một thể loại.',
            'genres.*.exists' => 'Thể loại đã chọn không tồn tại.',
            'actors.required' => 'Vui lòng chọn ít nhất một diễn viên.',
            'actors.array' => 'Danh sách diễn viên không hợp lệ.',
            'actors.min' => 'Vui lòng chọn ít nhất một diễn viên.',
            'actors.*.exists' => 'Diễn viên đã chọn không tồn tại.',
        ]);

        // Đảm bảo trường is_active đúng
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        try {
            // Lưu ảnh cũ
            $oldImage = $movie->image;

            // Nếu có file ảnh mới
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $validated['image'] = $image->storeAs('movies', $filename, 'public');

                // Xóa ảnh cũ nếu tồn tại
                if (!empty($oldImage) && Storage::disk('public')->exists($oldImage)) {
                    Storage::disk('public')->delete($oldImage);
                }
            }

            // Cập nhật dữ liệu phim
            $movie->update($validated);

            // Đồng bộ thể loại
            $movie->genres()->sync($validated['genres']);

            // Đồng bộ diễn viên
            $movie->actors()->sync($validated['actors']);

            return redirect()
                ->route('admin.movies.index')
                ->with('success', 'Phim "' . $movie->title . '" đã được cập nhật thành công!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra khi cập nhật phim. Vui lòng thử lại!');
        }
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
