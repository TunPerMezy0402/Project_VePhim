<?php

namespace App\Http\Controllers;

use App\Models\Cinema;
use App\Models\Movie;
use App\Models\Room;
use App\Models\Schedule;
use Illuminate\Http\Request;

class CinemaController extends Controller
{
    public function index(Request $request)
    {
        $query = Cinema::query();

        if ($request->has('search') && $request->search !== '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $cinemas = $query->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.cinemas.index', compact('cinemas'));
    }


    public function create()
    {
        return view('admin.cinemas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:cinemas,name',
            'address' => 'required|string|max:255',
        ]);

        Cinema::create($validated);

        return redirect()->route('admin.cinemas.index')->with('success', 'Thêm rạp chiếu thành công');
    }

    public function edit(string $id)
    {
        $cinema = Cinema::findOrFail($id);
        return view('admin.cinemas.edit', compact('cinema'));
    }

    public function update(Request $request, string $id)
    {
        $cinema = Cinema::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:cinemas,name,' . $cinema->id,
            'address' => 'required|string|max:255',
        ]);

        $cinema->update($validated);

        return redirect()->route('admin.cinemas.index')->with('success', 'Cập nhật rạp thành công');
    }

    public function destroy(string $id)
    {
        $cinema = Cinema::findOrFail($id);
        $cinema->delete();

        return redirect()->route('admin.cinemas.index')->with('success', 'Đã xoá mềm rạp chiếu');
    }

    public function trash(Request $request)
    {
        $query = Cinema::onlyTrashed();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $cinemas = $query->orderBy('deleted_at', 'desc')->paginate(15);
        return view('admin.cinemas.trash', compact('cinemas'));
    }

    public function restore($id)
    {
        $cinema = Cinema::onlyTrashed()->findOrFail($id);
        $cinema->restore();

        return redirect()->route('admin.cinemas.trash')->with('success', 'Đã khôi phục rạp');
    }

    public function forceDelete($id)
    {
        $cinema = Cinema::onlyTrashed()->findOrFail($id);
        $cinema->forceDelete();

        return redirect()->route('admin.cinemas.trash')->with('success', 'Đã xoá vĩnh viễn rạp');
    }
}
