<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use Illuminate\Http\Request;

class ActorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Actor::query();

        // Tìm kiếm theo tên
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Phân trang
        $actors = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.actors.index', compact('actors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.actors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:actors,name',
        ]);

        Actor::create($validated);

        return redirect()->route('admin.actors.index')->with('success', 'Thêm diễn viên thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $actor = Actor::findOrFail($id);
        return view('admin.actors.show', compact('actor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $actor = Actor::findOrFail($id);
        return view('admin.actors.edit', compact('actor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $actor = Actor::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:actors,name,' . $actor->id,
        ]);

        $actor->update($validated);

        return redirect()->route('admin.actors.index')->with('success', 'Cập nhật diễn viên thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $actor = Actor::findOrFail($id);
        $actor->delete(); // Xóa mềm

        return redirect()->route('admin.actors.index')->with('success', 'Đã xoá mềm diễn viên');
    }

    public function trash(Request $request)
{
    $query = Actor::onlyTrashed(); // chỉ lấy soft-deleted

    // Tìm kiếm theo tên
    if ($request->filled('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    // Phân trang
    $actors = $query->orderBy('deleted_at', 'desc')->paginate(15);

    return view('admin.actors.trash', compact('actors'));
}


    public function restore($id)
    {
        $actor = Actor::onlyTrashed()->findOrFail($id);
        $actor->restore();

        return redirect()->route('admin.actors.trash')->with('success', 'Đã khôi phục diễn viên');
    }

    public function forceDelete($id)
    {
        $actor = Actor::onlyTrashed()->findOrFail($id);
        $actor->forceDelete();

        return redirect()->route('admin.actors.trash')->with('success', 'Đã xoá vĩnh viễn diễn viên');
    }
}
