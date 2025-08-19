<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Cinema;
use App\Models\Seat;
use App\Models\SeatRow;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    // Danh sách các phòng thuộc cinema
    public function index(Request $request, Cinema $cinema)
    {
        $query = $cinema->rooms();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $rooms = $query->orderBy('created_at', 'desc')->with('seats')->paginate(15);

        // Các loại ghế mặc định cần hiển thị
        $defaultTypes = [
            'single' => 0,
            'couple' => 0,
            'single_vip' => 0,
            'couple_vip' => 0,
        ];

        // Thêm thống kê số lượng từng loại ghế cho mỗi room
        $seatTypeKeys = ['single', 'couple', 'single_vip', 'couple_vip'];
        foreach ($rooms as $room) {
            // Chuẩn bị mảng đếm tổng số ghế theo loại cho cả phòng
            $totalStats = array_fill_keys($seatTypeKeys, 0);
            // Chuẩn bị mảng đếm cho từng hàng
            $rowSeatStats = [];
            foreach ($room->seatRows as $row) {
                $rowStats = array_fill_keys($seatTypeKeys, 0);
                $rowSeats = $room->seats->filter(function ($seat) use ($row) {
                    return strpos($seat->seat_number, $row->row_label) === 0;
                });
                foreach ($rowSeats as $seat) {
                    // Xác định loại ghế (đơn/đôi)
                    $isSingle = $seat->seat_chair === 'single';
                    $isCouple = $seat->seat_chair === 'couple';
                    // Xác định VIP hay thường dựa vào row->type
                    if ($row->type === 'vip') {
                        if ($isSingle) {
                            $rowStats['single_vip']++;
                            $totalStats['single_vip']++;
                        } elseif ($isCouple) {
                            $rowStats['couple_vip']++;
                            $totalStats['couple_vip']++;
                        }
                    } else {
                        if ($isSingle) {
                            $rowStats['single']++;
                            $totalStats['single']++;
                        } elseif ($isCouple) {
                            $rowStats['couple']++;
                            $totalStats['couple']++;
                        }
                    }
                }
                $rowSeatStats[$row->row_label] = $rowStats;
            }
            $room->seat_stats = $totalStats;
            $room->row_seat_stats = $rowSeatStats;
        }

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
        // Lấy dữ liệu từ form (dạng JSON string)
        $seatsData = $request->input('seats_data');
        $roomConfig = $request->input('room_config');
        $roomName = $request->input('name');

        // Parse JSON
        $seats = json_decode($seatsData, true);
        $config = json_decode($roomConfig, true);

        // Validate cơ bản
        if (!$roomName || !$seats || !$config) {
            return response()->json(['message' => 'Thiếu dữ liệu cấu hình phòng hoặc ghế!'], 422);
        }

        // Tính tổng số ghế thực tế (ghế đơn + 2*ghế đôi)
        $totalSeats = 0;
        foreach ($seats as $seat) {
            $totalSeats += ($seat['seat_type'] === 'couple') ? 2 : 1;
        }

        // Tạo phòng chiếu
        $room = Room::create([
            'cinema_id' => $cinema->id,
            'name' => $roomName,
            'total_seats' => $totalSeats,
        ]);

        // Lưu hàng ghế
        foreach ($config['seats_per_row'] as $rowIndex => $seatCount) {
            $isVip = in_array($rowIndex, $config['vip_rows'] ?? []);
            $rowLabel = chr(65 + $rowIndex);
            \App\Models\SeatRow::create([
                'room_id' => $room->id,
                'row_label' => $rowLabel,
                'type' => $isVip ? 'vip' : 'standard',
                'total_seats' => $seatCount
            ]);
        }

        // Lưu từng ghế
        foreach ($seats as $seat) {
            // Tìm row_label từ seat_number (ví dụ: 'A01' => 'A')
            $rowLabel = substr($seat['seat_number'], 0, 1);
            // Tìm SeatRow theo room_id và row_label
            $seatRow = \App\Models\SeatRow::where('room_id', $room->id)
                ->where('row_label', $rowLabel)
                ->first();

            \App\Models\Seat::create([
                'room_id' => $room->id,
                'row_id' => $seatRow ? $seatRow->id : null, // Thêm dòng này để liên kết ghế với hàng
                'seat_number' => $seat['seat_number'],
                'seat_chair' => $seat['seat_type'], // 'single' hoặc 'couple'
                'price' => $seat['price'] ?? 0,
                'is_available' => $seat['is_available'] ?? 1,
            ]);
        }

        return response()->json([
            'message' => 'Đã tạo phòng và lưu cấu hình ghế thành công!',
            'redirect' => route('admin.cinemas.rooms.index', $cinema->id)
        ]);
    }

    // Hiển thị chi tiết 1 phòng
    public function show(Cinema $cinema, Room $room)
    {
        // Lấy danh sách ghế + hàng ghế
        $room->load(['seats', 'seatRows']);

        // Các loại ghế mặc định
        $seatTypeKeys = ['single', 'couple', 'single_vip', 'couple_vip'];
        $totalStats = array_fill_keys($seatTypeKeys, 0);
        $rowSeatStats = [];

        foreach ($room->seatRows as $row) {
            $rowStats = array_fill_keys($seatTypeKeys, 0);

            $rowSeats = $room->seats->filter(function ($seat) use ($row) {
                return strpos($seat->seat_number, $row->row_label) === 0;
            });

            foreach ($rowSeats as $seat) {
                $isSingle = $seat->seat_chair === 'single';
                $isCouple = $seat->seat_chair === 'couple';

                if ($row->type === 'vip') {
                    if ($isSingle) {
                        $rowStats['single_vip']++;
                        $totalStats['single_vip']++;
                    } elseif ($isCouple) {
                        $rowStats['couple_vip']++;
                        $totalStats['couple_vip']++;
                    }
                } else {
                    if ($isSingle) {
                        $rowStats['single']++;
                        $totalStats['single']++;
                    } elseif ($isCouple) {
                        $rowStats['couple']++;
                        $totalStats['couple']++;
                    }
                }
            }

            $rowSeatStats[$row->row_label] = $rowStats;
        }

        $room->seat_stats = $totalStats;
        $room->row_seat_stats = $rowSeatStats;

        return view('admin.rooms.show', compact('cinema', 'room'));
    }

    // Hiển thị form chỉnh sửa phòng
public function edit(Cinema $cinema, Room $room)
{
    // load sẵn seats + rows để đưa vào form
    $room->load(['seats', 'seatRows']);

    return view('admin.rooms.edit', compact('cinema', 'room'));
}

// Cập nhật thông tin phòng
public function update(Request $request, Cinema $cinema, Room $room)
{
    $seatsData = $request->input('seats_data');
    $roomConfig = $request->input('room_config');
    $roomName = $request->input('name');

    $seats = json_decode($seatsData, true);
    $config = json_decode($roomConfig, true);

    if (!$roomName || !$seats || !$config) {
        return response()->json(['message' => 'Thiếu dữ liệu cấu hình phòng hoặc ghế!'], 422);
    }

    // Tính lại tổng số ghế
    $totalSeats = 0;
    foreach ($seats as $seat) {
        $totalSeats += ($seat['seat_type'] === 'couple') ? 2 : 1;
    }

    // Cập nhật thông tin phòng
    $room->update([
        'name' => $roomName,
        'total_seats' => $totalSeats,
    ]);

    // Xóa cấu hình cũ (rows + seats)
    \App\Models\SeatRow::where('room_id', $room->id)->delete();
    \App\Models\Seat::where('room_id', $room->id)->delete();

    // Lưu lại hàng ghế mới
    foreach ($config['seats_per_row'] as $rowIndex => $seatCount) {
        $isVip = in_array($rowIndex, $config['vip_rows'] ?? []);
        $rowLabel = chr(65 + $rowIndex);
        \App\Models\SeatRow::create([
            'room_id' => $room->id,
            'row_label' => $rowLabel,
            'type' => $isVip ? 'vip' : 'standard',
            'total_seats' => $seatCount
        ]);
    }

    // Lưu lại ghế mới
    foreach ($seats as $seat) {
        $rowLabel = substr($seat['seat_number'], 0, 1);
        $seatRow = \App\Models\SeatRow::where('room_id', $room->id)
            ->where('row_label', $rowLabel)
            ->first();

        \App\Models\Seat::create([
            'room_id' => $room->id,
            'row_id' => $seatRow ? $seatRow->id : null,
            'seat_number' => $seat['seat_number'],
            'seat_chair' => $seat['seat_type'],
            'price' => $seat['price'] ?? 0,
            'is_available' => $seat['is_available'] ?? 1,
        ]);
    }

    return response()->json([
        'message' => 'Cập nhật phòng và sơ đồ ghế thành công!',
        'redirect' => route('admin.cinemas.rooms.index', $cinema->id)
    ]);
}

}
