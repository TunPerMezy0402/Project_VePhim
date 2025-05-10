<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index(Request $request)
    {
        $query = Genre::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $genres = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.genres.index', compact('genres'));
    }

    public function create()
    {
        return view('admin.genres.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:genres,name',
        ]);

        Genre::create($validated);

        return redirect()->route('admin.genres.index')->with('success', 'Thêm thể loại thành công');
    }

    public function show(string $id)
    {
        $genre = Genre::findOrFail($id);
        return view('admin.genres.show', compact('genre'));
    }

    public function edit(string $id)
    {
        $genre = Genre::findOrFail($id);
        return view('admin.genres.edit', compact('genre'));
    }

    public function update(Request $request, string $id)
    {
        $genre = Genre::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:genres,name,' . $genre->id,
        ]);

        $genre->update($validated);

        return redirect()->route('admin.genres.index')->with('success', 'Cập nhật thể loại thành công');
    }

    public function destroy(string $id)
    {
        $genre = Genre::findOrFail($id);
        $genre->delete();

        return redirect()->route('admin.genres.index')->with('success', 'Đã xoá mềm thể loại');
    }

    public function trash(Request $request)
    {
        $query = Genre::onlyTrashed();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $genres = $query->orderBy('deleted_at', 'desc')->paginate(15);

        return view('admin.genres.trash', compact('genres'));
    }

    public function restore($id)
    {
        $genre = Genre::onlyTrashed()->findOrFail($id);
        $genre->restore();

        return redirect()->route('admin.genres.trash')->with('success', 'Đã khôi phục thể loại');
    }

    public function forceDelete($id)
    {
        $genre = Genre::onlyTrashed()->findOrFail($id);
        $genre->forceDelete();

        return redirect()->route('admin.genres.trash')->with('success', 'Đã xoá vĩnh viễn thể loại');
    }
}
