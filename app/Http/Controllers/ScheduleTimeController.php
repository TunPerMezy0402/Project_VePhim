<?php

namespace App\Http\Controllers;

use App\Models\Cinema;
use App\Models\ScheduleTime;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ScheduleTimeController extends Controller
{
    public function index(Request $request, $cinemaId)
    {
        $cinema = Cinema::findOrFail($cinemaId);

        $query = ScheduleTime::where('cinema_id', $cinemaId);

        if ($request->filled('search')) {
            $query->where('start_time', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('sort') && in_array($request->sort, ['asc', 'desc'])) {
            $query->orderBy('start_time', $request->sort);
        } else {
            $query->orderBy('start_time', 'asc');
        }

        $scheduleTimes = $query->paginate(10)->withQueryString();

        return view('admin.schedule_times.index', compact('cinema', 'scheduleTimes'));
    }

    public function create($cinemaId)
    {
        $cinema = Cinema::findOrFail($cinemaId);
        return view('admin.schedule_times.create', compact('cinema'));
    }

    public function store(Request $request, $cinemaId)
    {
        // Validate dữ liệu đầu vào
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'hour' => 'required|string|regex:/^\d{1,2}$/|between:0,23',
            'minute' => 'required|string|in:00,05,10,15,20,25,30,35,40,45,50,55', // Chỉ cho phép mỗi 5 phút
        ]);

        // Chuyển đổi string thành integer cho hour
        $hour = (int) $validated['hour'];
        $minute = $validated['minute'];

        // Tạo start_time từ hour và minute
        $startTime = sprintf('%02d:%s:00', $hour, $minute);

        // Kiểm tra trùng tên ca chiếu
        $labelExists = ScheduleTime::where('cinema_id', $cinemaId)
            ->where('label', $validated['label'])
            ->exists();

        if ($labelExists) {
            return back()->withErrors(['label' => 'Tên ca chiếu này đã tồn tại trong rạp.'])->withInput();
        }

        // Kiểm tra trùng giờ bắt đầu
        $timeExists = ScheduleTime::where('cinema_id', $cinemaId)
            ->where('start_time', $startTime)
            ->exists();

        if ($timeExists) {
            return back()->withErrors(['start_time' => 'Giờ bắt đầu này đã tồn tại trong rạp.'])->withInput();
        }

        ScheduleTime::create([
            'cinema_id' => $cinemaId,
            'label' => $validated['label'],
            'start_time' => $startTime,
        ]);

        return redirect()->route('admin.cinemas.schedule_times.index', $cinemaId)
            ->with('success', 'Thêm giờ chiếu thành công!');
    }

    public function show($cinemaId, $scheduleTimeId)
    {
        $cinema = Cinema::findOrFail($cinemaId);
        $scheduleTime = ScheduleTime::where('cinema_id', $cinemaId)->findOrFail($scheduleTimeId);
        return view('admin.schedule_times.show', compact('cinema', 'scheduleTime'));
    }

    public function edit($cinemaId, $scheduleTimeId)
    {
        $cinema = Cinema::findOrFail($cinemaId);
        $scheduleTime = ScheduleTime::where('cinema_id', $cinemaId)->findOrFail($scheduleTimeId);

        // Tách giờ và phút từ start_time để hiển thị trong form
        $time = Carbon::parse($scheduleTime->start_time);
        $scheduleTime->hour = $time->format('H');
        $scheduleTime->minute = $time->format('i');

        return view('admin.schedule_times.edit', compact('cinema', 'scheduleTime'));
    }

    public function update(Request $request, $cinemaId, $scheduleId)
    {
        // Tìm schedule time
        $scheduleTime = ScheduleTime::where('cinema_id', $cinemaId)->findOrFail($scheduleId);

        // Validate dữ liệu đầu vào
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'hour' => 'required|string|regex:/^\d{1,2}$/|between:0,23',
            'minute' => 'required|string|in:00,05,10,15,20,25,30,35,40,45,50,55', // Chỉ cho phép mỗi 5 phút
        ]);

        // Chuyển đổi string thành integer cho hour
        $hour = (int) $validated['hour'];
        $minute = $validated['minute'];

        // Tạo start_time từ hour và minute
        $startTime = sprintf('%02d:%s:00', $hour, $minute);

        // Kiểm tra trùng tên ca chiếu (loại trừ record hiện tại)
        $labelExists = ScheduleTime::where('cinema_id', $cinemaId)
            ->where('label', $validated['label'])
            ->where('id', '!=', $scheduleTime->id)
            ->exists();

        if ($labelExists) {
            return back()->withErrors(['label' => 'Tên ca chiếu này đã tồn tại trong rạp.'])->withInput();
        }

        // Kiểm tra trùng giờ bắt đầu (loại trừ record hiện tại)
        $timeExists = ScheduleTime::where('cinema_id', $cinemaId)
            ->where('start_time', $startTime)
            ->where('id', '!=', $scheduleTime->id)
            ->exists();

        if ($timeExists) {
            return back()->withErrors(['start_time' => 'Giờ bắt đầu này đã tồn tại trong rạp.'])->withInput();
        }

        $scheduleTime->update([
            'label' => $validated['label'],
            'start_time' => $startTime,
        ]);

        return redirect()->route('admin.cinemas.schedule_times.index', $cinemaId)
            ->with('success', 'Cập nhật giờ chiếu thành công!');
    }

    public function destroy($cinemaId, $scheduleTimeId)
    {
        $scheduleTime = ScheduleTime::where('cinema_id', $cinemaId)->findOrFail($scheduleTimeId);
        $scheduleTime->delete();

        return redirect()->route('admin.cinemas.schedule_times.index', $cinemaId)
            ->with('success', 'Đã xoá mềm khung giờ');
    }

    public function trash(Request $request, $cinemaId)
    {
        $cinema = Cinema::findOrFail($cinemaId);

        $query = ScheduleTime::onlyTrashed()->where('cinema_id', $cinemaId);

        if ($request->filled('search')) {
            $query->where('label', 'like', '%' . $request->search . '%');
        }

        $scheduleTimes = $query->orderBy('deleted_at', 'desc')->paginate(15)->withQueryString();

        return view('admin.schedule_times.trash', compact('scheduleTimes', 'cinema', 'cinemaId'));
    }

    public function restore($cinemaId, $scheduleId)
    {
        $cinema = Cinema::findOrFail($cinemaId);

        $scheduleTime = ScheduleTime::onlyTrashed()
            ->where('cinema_id', $cinemaId)
            ->findOrFail($scheduleId);

        // Kiểm tra giờ chiếu có trùng không trước khi khôi phục
        $exists = ScheduleTime::where('cinema_id', $cinemaId)
            ->where('start_time', $scheduleTime->start_time)
            ->exists();

        if ($exists) {
            return redirect()->route('admin.cinemas.schedule_times.trash', $cinemaId)
                ->with('error', 'Không thể khôi phục vì giờ chiếu này đã tồn tại.');
        }

        $scheduleTime->restore();

        return redirect()->route('admin.cinemas.schedule_times.trash', $cinemaId)
            ->with('success', 'Đã khôi phục khung giờ thành công!');
    }



    public function forceDelete($cinemaId, $scheduleId)
    {
        $cinema = Cinema::findOrFail($cinemaId);

        $scheduleTime = ScheduleTime::onlyTrashed()
            ->where('cinema_id', $cinemaId)
            ->findOrFail($scheduleId);

        $scheduleTime->forceDelete();

        return redirect()->route('admin.cinemas.schedule_times.trash', $cinemaId)
            ->with('success', 'Đã xoá vĩnh viễn khung giờ!');
    }
}
