<?php

namespace App\Http\Controllers;

use App\Models\Cinema;
use App\Models\Room;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function index($cinemaId, Request $request)
    {
        // 1. Lấy thông tin rạp
        $cinema = Cinema::findOrFail($cinemaId);

        

        // 2. Lấy danh sách lịch chiếu của rạp
        $schedules = Schedule::with(['movie', 'room.seatRows', 'room.seats', 'scheduleTime'])
            ->whereHas('room', fn($q) => $q->where('cinema_id', $cinemaId))
            // Lọc theo phòng
            ->when(
                $request->filled('room') && $request->room !== 'all',
                fn($q) => $q->where('room_id', $request->room)
            )
            // Tìm kiếm phim theo tên
            ->when(
                $request->filled('search'),
                fn($q) => $q->whereHas('movie', fn($m) =>
                    $m->where('title', 'like', "%{$request->search}%")
                )
            )
            ->orderBy('day_time')
            ->orderBy('schedule_time_id')
            ->get()
            ->sortBy(fn($s) => $s->scheduleTime->start_time ?? '00:00:00');

        // 3. Chuẩn bị danh sách ngày chiếu có trong DB
        $dates = $schedules->pluck('day_time')->unique()->sort()->values()->map(function ($date) {
            return [
                'value' => Carbon::parse($date)->format('Y-m-d'),
                'label' => Carbon::parse($date)->translatedFormat('l, d/m/Y'),
                'short' => Carbon::parse($date)->format('d/m'),
                'full'  => Carbon::parse($date)->format('Y-m-d'),
                'day'   => Carbon::parse($date)->translatedFormat('l'),
                'date'  => Carbon::parse($date)->format('d/m'),
            ];
        });

        // 4. Xác định ngày đang chọn (mặc định hôm nay)
        $today = now()->format('Y-m-d');
        $selectedDate = $request->input('date', $today);

        // 5. Lấy lịch chiếu theo ngày đã chọn
        $showtimes = $schedules->where('day_time', $selectedDate)->values();
        


        // 6. Lấy danh sách ghế và hàng ghế của phòng hiện tại
        $seats = $currentRoom?->seats ?? collect();
        $seatRows = $currentRoom?->seatRows ?? collect();

        // 7. Thống kê ghế
        $seatStats = [
            'single' => 0, 'couple' => 0,
            'single_vip' => 0, 'couple_vip' => 0
        ];

        $seatRowsStats = [];
        $totalSeats = 0;

        $roomOverview = [
            'total_seats' => 0,
            'available_seats' => 0,
            'booked_seats' => 0,
            'total_rows' => $seatRows->count(),
            'vip_rows' => $seatRows->where('type', 'vip')->count(),
        ];
        $roomOverview['standard_rows'] = $roomOverview['total_rows'] - $roomOverview['vip_rows'];

        foreach ($seatRows as $row) {
            $rowStats = ['single' => 0, 'couple' => 0, 'single_vip' => 0, 'couple_vip' => 0];
            $rowSeats = $seats->filter(fn($s) => str_starts_with($s->seat_number, $row->row_label));

            foreach ($rowSeats as $seat) {
                $type = $seat->seat_chair === 'single' ? 'single' : 'couple';
                $key = $type . ($row->type === 'vip' ? '_vip' : '');

                $seatStats[$key]++;
                $rowStats[$key]++;

                $count = $type === 'couple' ? 2 : 1;
                $totalSeats += $count;

                $roomOverview[$seat->is_available ? 'available_seats' : 'booked_seats'] += $count;
            }

            $seatRowsStats[$row->row_label] = $rowStats;
        }

        $roomOverview['total_seats'] = $totalSeats;
        $roomOverview['occupancy_rate'] = $totalSeats
            ? round(($roomOverview['booked_seats'] / $totalSeats) * 100, 1)
            : 0;

        // 8. Trả dữ liệu ra view
        return view('admin.schedules.index', [
            'cinema' => $cinema,
            'dates' => $dates,
            'showtimes' => $showtimes,
            'seats' => $seats,
            'totalSeats' => $totalSeats,
            'seatRows' => $seatRows,
            'seatStats' => $seatStats,
            'seatRowsStats' => $seatRowsStats,
            'roomOverview' => $roomOverview,
            'currentMovie' => $showtimes->first()?->movie,
            'seatRowsDisplay' => $seatRows,
            'seatInfo' => [],
            'rooms' => Room::where('cinema_id', $cinemaId)->get(),
            'selectedDate' => $selectedDate,
            'selectedRoom' => $request->get('room', 'all'),
        ]);
    }
}
