<?php

namespace App\Http\Controllers;

use App\Models\Director;
use Illuminate\Http\Request;

class DirectorController extends Controller
{
    public function index(Request $request)
    {
        $query = Director::query();

        // Tìm kiếm theo tên
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Phân trang
        $directors = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.directors.index', compact('directors'));
    }

    public function create()
    {
        return view('admin.directors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:directors,name',
        ]);

        Director::create($validated);

        return redirect()->route('admin.directors.index')->with('success', 'Thêm đạo diễn thành công');
    }

    public function show(string $id)
    {
        $director = Director::findOrFail($id);
        return view('admin.directors.show', compact('director'));
    }

    public function edit(string $id)
    {
        $director = Director::findOrFail($id);
        return view('admin.directors.edit', compact('director'));
    }

    public function update(Request $request, string $id)
    {
        $director = Director::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:directors,name,' . $director->id,
        ]);

        $director->update($validated);

        return redirect()->route('admin.directors.index')->with('success', 'Cập nhật đạo diễn thành công');
    }

    public function destroy(string $id)
    {
        $director = Director::findOrFail($id);
        $director->delete(); // Xóa mềm

        return redirect()->route('admin.directors.index')->with('success', 'Đã xoá mềm đạo diễn');
    }

    public function trash(Request $request)
    {
        $query = Director::onlyTrashed();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $directors = $query->orderBy('deleted_at', 'desc')->paginate(15);

        return view('admin.directors.trash', compact('directors'));
    }

    public function restore($id)
    {
        $director = Director::onlyTrashed()->findOrFail($id);
        $director->restore();

        return redirect()->route('admin.directors.trash')->with('success', 'Đã khôi phục đạo diễn');
    }

    public function forceDelete($id)
    {
        $director = Director::onlyTrashed()->findOrFail($id);
        $director->forceDelete();

        return redirect()->route('admin.directors.trash')->with('success', 'Đã xoá vĩnh viễn đạo diễn');
    }
}
