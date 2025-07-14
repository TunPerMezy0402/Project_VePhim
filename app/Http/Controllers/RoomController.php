<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Cinema;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    // Danh sách các phòng thuộc cinema
    public function index(Request $request, Cinema $cinema)
    {
        $query = $cinema->rooms(); // lấy quan hệ rooms của cinema

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $rooms = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.rooms.index', compact('rooms', 'cinema'));
    }

    // Hiển thị form tạo phòng
    public function create(Cinema $cinema)
    {
        return view('admin.rooms.create', compact('cinema'));
    }

    // Lưu phòng mới
    public function store(Request $request, Cinema $cinema)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255|unique:rooms,name',
        'total_seats' => 'required|integer|min:1',
    ]);

    // Tạo room qua quan hệ, tự gán cinema_id
    $cinema->rooms()->create($validated);

    return redirect()->route('admin.cinemas.rooms.index', $cinema->id)
                     ->with('success', 'Thêm phòng chiếu thành công!');
}

    // Chi tiết 1 phòng
    public function show(Cinema $cinema, Room $room)
    {
        return view('admin.rooms.show', compact('room', 'cinema'));
    }

    // Form sửa
    public function edit(Cinema $cinema, Room $room)
    {
        return view('admin.rooms.edit', compact('room', 'cinema'));
    }

    // Cập nhật
    public function update(Request $request, Cinema $cinema, Room $room)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:rooms,name,' . $room->id,
        ]);

        $room->update($validated);

        return redirect()->route('admin.rooms.index', $cinema->id)->with('success', 'Cập nhật phòng chiếu thành công');
    }

    // Xóa mềm
    public function destroy(Cinema $cinema, Room $room)
    {
        $room->delete();

        return redirect()->route('admin.rooms.index', $cinema->id)->with('success', 'Đã xoá phòng chiếu');
    }

    // Danh sách phòng đã xoá
    public function trash(Request $request, Cinema $cinema)
    {
        $query = Room::onlyTrashed()->where('cinema_id', $cinema->id);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $rooms = $query->orderBy('deleted_at', 'desc')->paginate(15);

        return view('admin.rooms.trash', compact('rooms', 'cinema'));
    }

    // Khôi phục phòng
    public function restore(Cinema $cinema, $id)
    {
        $room = Room::onlyTrashed()->where('cinema_id', $cinema->id)->findOrFail($id);
        $room->restore();

        return redirect()->route('admin.rooms.trash', $cinema->id)->with('success', 'Khôi phục phòng chiếu thành công');
    }

    // Xoá vĩnh viễn
    public function forceDelete(Cinema $cinema, $id)
    {
        $room = Room::onlyTrashed()->where('cinema_id', $cinema->id)->findOrFail($id);
        $room->forceDelete();

        return redirect()->route('admin.rooms.trash', $cinema->id)->with('success', 'Đã xoá vĩnh viễn phòng chiếu');
    }
}
