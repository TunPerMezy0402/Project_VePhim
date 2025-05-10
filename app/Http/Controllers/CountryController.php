<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
     public function index(Request $request)
    {
        $query = Country::query();

        // Tìm kiếm theo tên
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Phân trang
        $countries = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.countries.index', compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.countries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:countries,name',
        ]);

        Country::create($validated);

        return redirect()->route('admin.countries.index')->with('success', 'Thêm quốc gia thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $country = Country::findOrFail($id);
        return view('admin.countries.show', compact('country'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $country = Country::findOrFail($id);
        return view('admin.countries.edit', compact('country'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $country = Country::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:countries,name,' . $country->id,
        ]);

        $country->update($validated);

        return redirect()->route('admin.countries.index')->with('success', 'Cập nhật quốc gia thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $country = Country::findOrFail($id);
        $country->delete(); // Xóa mềm

        return redirect()->route('admin.countries.index')->with('success', 'Đã xoá mềm quốc gia');
    }

    public function trash(Request $request)
{
    $query = Country::onlyTrashed(); // chỉ lấy soft-deleted

    // Tìm kiếm theo tên
    if ($request->filled('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    // Phân trang
    $countries = $query->orderBy('deleted_at', 'desc')->paginate(15);

    return view('admin.countries.trash', compact('countries'));
}


    public function restore($id)
    {
        $country = Country::onlyTrashed()->findOrFail($id);
        $country->restore();

        return redirect()->route('admin.countries.trash')->with('success', 'Đã khôi phục quốc gia');
    }

    public function forceDelete($id)
    {
        $country = Country::onlyTrashed()->findOrFail($id);
        $country->forceDelete();

        return redirect()->route('admin.countries.trash')->with('success', 'Đã xoá vĩnh viễn quốc gia');
    }
}
