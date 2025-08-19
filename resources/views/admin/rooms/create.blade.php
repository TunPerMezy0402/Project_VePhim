@extends('admin.layouts.AdminLayout')

@section('content')
<style>
    :root {
        --primary: #28a745;
        --secondary: #ff6b6b;
        --accent: #fd79a8;
        --warning: #fdcb6e;
        --success: #28a745;
        --error: #e17055;
        --dark: #2d3436;
        --light: #f8f9fa;
        --white: #ffffff;
        --black: #000;
        --border: #ddd;
        --shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        --radius: 8px;
        --transition: all 0.3s ease;
    }

    .page-header {
        background: linear-gradient(135deg, var(--primary), var(--accent));
        color: var(--white);
        padding: 2rem 0;
        margin-bottom: 2rem;
        border-radius: 15px;
        text-align: center;
    }

    .card {
        background: var(--white);
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: var(--shadow);
        transition: var(--transition);
    }

    .card h5 {
        color:#000 ;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        padding: 1.5rem;
        border-radius: 15px;
        text-align: center;
        color: var(--white);
        position: relative;
        overflow: hidden;
        transition: var(--transition);
    }

    .stat-card.single {
        background: linear-gradient(135deg, var(--success), #55a3ff);
    }

    .stat-card.couple {
        background: linear-gradient(135deg, var(--error), var(--secondary));
    }

    .stat-card.vip {
        background: linear-gradient(135deg, var(--accent), var(--warning));
    }

    .stat-card.total {
        background: linear-gradient(135deg, #667eea, #764ba2);
    }

    .control-group {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 2rem;
        padding: 1rem;
        background: var(--light);
        border-radius: var(--radius);
        flex-direction: row;
    }
    .control-buttons {
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 0.5rem;
    }
    .value-display {
        min-width: 32px;
        text-align: center;
        font-weight: 600;
        background: #fff;
        border-radius: 4px;
        padding: 0.25rem 0.75rem;
        border: 1px solid var(--border);
        margin: 0 0.25rem;
    }

    .btn-control {
        width: 40px;
        height: 40px;
        border-radius: var(--radius);
        border: none;
        font-weight: 700;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-control.minus {
        background: var(--secondary);
        color: var(--white);
    }

    .btn-control.plus {
        background: var(--primary);
        color: var(--white);
    }

    .btn-control.small {
        width: 30px;
        height: 30px;
        font-size: 0.9rem;
    }

    .cinema-screen {
        background: linear-gradient(135deg, var(--dark), #636e72);
        color: var(--white);
        height: 50px;
        border-radius: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        margin-bottom: 2rem;
    }

    .seat-area {
        display: flex;
        gap: 12px;
        background: var(--light);
        padding: 1.5rem;
        border-radius: 15px;
        overflow-x: auto;
    }

    .seat {
        width: 40px;
        height: 40px;
        border-radius: var(--radius);
        background: var(--success);
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
        transition: var(--transition);
        box-shadow: var(--shadow);
    }

    .seat.couple {
        width: 86px;
        background: var(--error);
    }

    .seat.vip {
        background: linear-gradient(135deg, var(--accent), var(--warning));
    }

    .seat.selected {
        background: var(--warning);
        transform: scale(1.1);
    }

    .row-label {
        background: linear-gradient(135deg, #667eea, #764ba2);;
        color: var(--white);
        width: 40px;
        height: 40px;
        border-radius: var(--radius);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        cursor: pointer;
    }

    .row-label.vip {
        background: linear-gradient(135deg, var(--accent), var(--warning));
    }

    .btn-action {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: var(--radius);
        font-weight: 600;
        cursor: pointer;
        color: var(--white);
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-action.single {
        background: var(--success);
    }

    .btn-action.couple {
        background: var(--error);
    }

    .btn-action.save {
        background: linear-gradient(135deg, #667eea, #764ba2);
    }

    .notification {
        position: fixed;
        top: 90px;
        right: 20px;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        color: white;
        font-weight: 600;
        z-index: 1000;
        animation: slideIn 0.4s ease;
    }

    .notification-success {
        background: linear-gradient(135deg, #00b894, #00a085);
    }

    .notification-error {
        background: linear-gradient(135deg, #ff6b6b, #ee5a52);
    }

    .notification-warning {
        background: linear-gradient(135deg, #fdcb6e, #e17055);
        color: #2d3436;
    }

    @keyframes slideIn {
        from {
            transform: translateX(100%);
        }

        to {
            transform: translateX(0);
        }
    }

    .form-control1 {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid var(--border);
        border-radius: var(--radius);
        background: var(--white);
        color: #000;
    }

    .row-config-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem;
        background: #f8f9fa;
        border-radius: 8px;
        margin-bottom: 0.5rem;
    }

    .row-controls {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .seats-per-row-display {
        padding: 0.25rem 0.5rem;
        background: white;
        border-radius: 4px;
        min-width: 30px;
        text-align: center;
        font-weight: 600;
    }

    .price-input {
        width: 150px;
        padding: 0.5rem;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        text-align: center;
    }

    .pricing-section {
        background: var(--light);
        padding: 1rem;
        border-radius: var(--radius);
    }

    .price-group {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }

    .error {
        border-color: var(--error) !important;
    }

    .loading {
        opacity: 0.6;
        pointer-events: none;
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .seat {
            width: 30px;
            height: 30px;
            font-size: 10px;
        }

        .seat.couple {
            width: 64px;
        }

        .control-group {
            flex-direction: column;
            gap: 0.5rem;
        }
    }
</style>
<a href="{{ route('admin.cinemas.schedules.index', $cinema->id) }}" class="btn btn-danger btn-sm mb-3">
    <i class="fas fa-arrow-left me-1"></i> Quay lại
</a>
<div class="page-header">
    <h1><i class="fas fa-theater-masks me-3"></i>Quản lý ghế rạp phim</h1>
    <div class="subtitle">Hệ thống quản lý và cấu hình ghế ngồi</div>
</div>

<form id="room-form" method="POST" action="{{ route('admin.cinemas.rooms.store', ['cinema' => $cinema->id]) }}">
    @csrf
    <div class="row">
        <div class="col-lg-8">
            <!-- Statistics -->
            <div class="stats-grid">
                <div class="stat-card single">
                    <h6>Ghế đơn</h6>
                    <h3 id="single-count">0</h3>
                </div>
                <div class="stat-card couple">
                    <h6>Ghế đôi</h6>
                    <h3 id="couple-count">0</h3>
                </div>
                <div class="stat-card vip">
                    <h6>Ghế VIP</h6>
                    <h3 id="vip-count">0</h3>
                </div>
                <div class="stat-card total">
                    <h6>Tổng chỗ ngồi</h6>
                    <h3 id="total-count">0</h3>
                </div>
            </div>

            <!-- Seat Layout -->
            <div class="card">
                <div class="cinema-screen">
                    <i class="fas fa-tv me-2"></i>MÀN HÌNH CHIẾU
                </div>

                <div class="seat-area">
                    <div id="row-labels" style="display: flex; flex-direction: column; gap: 8px;"></div>
                    <div id="seat-container" style="display: flex; flex-direction: column; gap: 8px;"></div>
                </div>

                <div class="mt-3 d-flex justify-content-center gap-2">
                    <button type="button" class="btn-action single" onclick="setSeatType('single')">
                        <i class="fas fa-chair"></i> Ghế đơn
                    </button>
                    <button type="button" class="btn-action couple" onclick="setSeatType('couple')">
                        <i class="fas fa-heart"></i> Ghế đôi
                    </button>
                </div>

                <div class="control-group">
                    <div class="control-buttons">
                        <!-- Điều khiển số hàng -->
                        <button class="btn-control minus" onclick="seatManager.changeRows(-1)" type="button">
                            <i class="fas fa-minus"></i>
                        </button>
                        <div class="value-display" id="rows-display">8</div>
                        <button class="btn-control plus" onclick="seatManager.changeRows(1)" type="button">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <div class="control-buttons">
                        <!-- Điều khiển số ghế trên mỗi hàng cho tất cả các hàng -->
                        <button class="btn-control minus" onclick="seatManager.changeSeatsAllRows(-1)" type="button">
                            <i class="fas fa-minus"></i>
                        </button>
                        <div class="value-display" id="seats-per-row-display">10</div>
                        <button class="btn-control plus" onclick="seatManager.changeSeatsAllRows(1)" type="button">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Room Information -->
            <div class="card">
                <h5><i class="fas fa-info-circle"></i> Thông tin phòng</h5>
                <input type="text" class="form-control1 @error('name') error @enderror" id="room-name" name="name"
                    placeholder="Nhập tên phòng..." value="{{ old('name') }}" required>
                @error('name')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Pricing Section -->
            <div class="card">
                <h5><i class="fas fa-dollar-sign"></i> Cấu hình giá</h5>
                <div class="pricing-section">
                    <div class="price-group">
                        <label>Ghế thường:</label>
                        <input type="number" class="price-input" id="normal-price" name="normal_price"
                            value="{{ old('normal_price', 0) }}" min="0" step="1000">
                    </div>
                    <div class="price-group">
                        <label>Ghế đôi:</label>
                        <input type="number" class="price-input" id="couple-price" name="couple_price"
                            value="{{ old('couple_price', 0) }}" min="0" step="1000">
                    </div>
                    <div class="price-group">
                        <label>Ghế VIP:</label>
                        <input type="number" class="price-input" id="vip-price" name="vip_price"
                            value="{{ old('vip_price', 0) }}" min="0" step="1000">
                    </div>
                    <div class="price-group">
                        <label>Ghế VIP đôi:</label>
                        <input type="number" class="price-input" id="vip-couple-price" name="vip_couple_price"
                            value="{{ old('vip_couple_price', 0) }}" min="0" step="1000">
                    </div>
                </div>
            </div>

            <!-- Row Configuration -->
            <div class="card">
                <h5><i class="fas fa-list"></i> Cấu hình hàng</h5>
                <div id="row-config" style="max-height: 300px; overflow-y: auto;"></div>
            </div>

            <!-- Hidden inputs for form data -->
            <input type="hidden" id="seats-data" name="seats_data">
            <input type="hidden" id="room-config" name="room_config">

            <button type="submit" class="btn-action save w-100 justify-content-center">
                <i class="fas fa-save"></i> Lưu cấu hình
            </button>
        </div>
    </div>
</form>

<script>
    class SeatManager {
    constructor() {
        this.rows = 8;
        this.seatsPerRow = Array(8).fill(10);
        this.selectedSeats = new Set();
        this.seatTypes = {};
        this.vipRows = new Set();
        this.isLoading = false;
        
        this.init();
    }

    init() {
        this.update();
        this.setupEventListeners();
    }

    setupEventListeners() {
        // Keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') this.clearSelection();
            if (e.key === 'Delete') this.deleteSeat();
        });

        // Form submission
        document.getElementById('room-form').addEventListener('submit', (e) => {
            e.preventDefault();
            this.handleSubmit();
        });

        // Price input validation
        document.querySelectorAll('.price-input').forEach(input => {
            input.addEventListener('input', this.validatePrice.bind(this));
        });
    }

    validatePrice(e) {
        const value = parseInt(e.target.value);
        if (value < 0) {
            e.target.value = 0;
        }
    }

    changeRows(delta) {
        if (this.isLoading) return;
        
        const newRows = Math.max(1, Math.min(15, this.rows + delta));
        
        if (newRows !== this.rows) {
            if (newRows > this.rows) {
                // Add new rows
                for (let i = this.rows; i < newRows; i++) {
                    this.seatsPerRow[i] = 10;
                }
            } else {
                // Remove rows and clean up data
                this.seatsPerRow = this.seatsPerRow.slice(0, newRows);
                this.vipRows = new Set([...this.vipRows].filter(row => row < newRows));
                this.cleanupSeatTypes(newRows);
            }
            
            this.rows = newRows;
            this.update();
        }
    }

    changeSeatsAllRows(delta) {
        if (this.isLoading) return;
        let changed = false;
        for (let i = 0; i < this.seatsPerRow.length; i++) {
            const newSeats = Math.max(1, Math.min(20, this.seatsPerRow[i] + delta));
            if (newSeats !== this.seatsPerRow[i]) {
                this.seatsPerRow[i] = newSeats;
                this.cleanupRowSeatTypes(i, newSeats);
                changed = true;
            }
        }
        if (changed) this.update();
    }

    cleanupSeatTypes(maxRows) {
        const keysToDelete = [];
        for (const seatId in this.seatTypes) {
            const [row] = seatId.split('-').map(Number);
            if (row >= maxRows) {
                keysToDelete.push(seatId);
            }
        }
        keysToDelete.forEach(key => delete this.seatTypes[key]);
    }

    changeSeatsInRow(rowIndex, delta) {
        if (this.isLoading) return;
        
        const newSeats = Math.max(1, Math.min(20, this.seatsPerRow[rowIndex] + delta));
        
        if (newSeats !== this.seatsPerRow[rowIndex]) {
            this.seatsPerRow[rowIndex] = newSeats;
            this.cleanupRowSeatTypes(rowIndex, newSeats);
            this.update();
        }
    }

    cleanupRowSeatTypes(rowIndex, maxSeats) {
        const keysToDelete = [];
        for (const seatId in this.seatTypes) {
            const [row, col] = seatId.split('-').map(Number);
            if (row === rowIndex && col >= maxSeats) {
                keysToDelete.push(seatId);
            }
        }
        keysToDelete.forEach(key => delete this.seatTypes[key]);
    }

    toggleSeat(seatId) {
        if (this.isLoading) return;
        
        if (this.selectedSeats.has(seatId)) {
            this.selectedSeats.delete(seatId);
        } else {
            this.selectedSeats.add(seatId);
        }
        this.renderSeats();
    }

    clearSelection() {
        this.selectedSeats.clear();
        this.renderSeats();
    }

    deleteSeat() {
        if (this.selectedSeats.size === 0) return;
        
        this.selectedSeats.forEach(seatId => {
            delete this.seatTypes[seatId];
        });
        
        this.clearSelection();
        this.update();
        this.notify('Đã xóa ghế được chọn', 'success');
    }

    setSeatType(type) {
        if (this.selectedSeats.size === 0) {
            this.notify('Vui lòng chọn ghế trước!', 'warning');
            return;
        }

        this.selectedSeats.forEach(seatId => {
            if (type === 'couple') {
                this.seatTypes[seatId] = 'couple';
            } else {
                delete this.seatTypes[seatId];
            }
        });

        this.clearSelection();
        this.update();
        this.notify(`Đã chuyển thành ghế ${type === 'couple' ? 'đôi' : 'đơn'}`, 'success');
    }

    toggleVipRow(rowIndex) {
        if (this.isLoading) return;
        
        if (this.vipRows.has(rowIndex)) {
            this.vipRows.delete(rowIndex);
        } else {
            this.vipRows.add(rowIndex);
        }
        this.update();
    }

    update() {
        document.getElementById('rows-display').textContent = this.rows;
        this.updateStats();
        this.renderSeats();
        this.renderRowConfig();
        this.updateFormData();
        document.getElementById('seats-per-row-display').textContent = this.seatsPerRow[0];
    }

    updateStats() {
        let single = 0, couple = 0, vip = 0, totalCapacity = 0;
        
        for (let row = 0; row < this.rows; row++) {
            for (let col = 0; col < this.seatsPerRow[row]; col++) {
                const seatId = `${row}-${col}`;
                const isCouple = this.seatTypes[seatId] === 'couple';
                const isVip = this.vipRows.has(row);
                
                if (isCouple) {
                    couple++;
                    totalCapacity += 2; // Couple seats count as 2 people
                } else {
                    single++;
                    totalCapacity += 1;
                }
                
                if (isVip) vip++;
            }
        }
        
        document.getElementById('single-count').textContent = single;
        document.getElementById('couple-count').textContent = couple;
        document.getElementById('vip-count').textContent = vip;
        document.getElementById('total-count').textContent = totalCapacity;
    }

    renderSeats() {
        const container = document.getElementById('seat-container');
        const labels = document.getElementById('row-labels');
        
        container.innerHTML = '';
        labels.innerHTML = '';
        
        // Row labels
        for (let row = 0; row < this.rows; row++) {
            const label = document.createElement('div');
            label.className = `row-label ${this.vipRows.has(row) ? 'vip' : ''}`;
            label.textContent = String.fromCharCode(65 + row);
            label.onclick = () => this.toggleVipRow(row);
            label.title = `Click to toggle VIP for row ${String.fromCharCode(65 + row)}`;
            labels.appendChild(label);
        }
        
        // Seats
        for (let row = 0; row < this.rows; row++) {
            const rowDiv = document.createElement('div');
            rowDiv.style.display = 'flex';
            rowDiv.style.gap = '6px';
            
            for (let col = 0; col < this.seatsPerRow[row]; col++) {
                const seatId = `${row}-${col}`;
                const seat = document.createElement('div');
                seat.className = 'seat';
                seat.textContent = String.fromCharCode(65 + row) + (col + 1).toString().padStart(2, '0');
                seat.onclick = () => this.toggleSeat(seatId);
                
                if (this.seatTypes[seatId] === 'couple') seat.classList.add('couple');
                if (this.vipRows.has(row)) seat.classList.add('vip');
                if (this.selectedSeats.has(seatId)) seat.classList.add('selected');
                
                rowDiv.appendChild(seat);
            }
            
            container.appendChild(rowDiv);
        }
    }

    renderRowConfig() {
        const container = document.getElementById('row-config');
        container.innerHTML = '';
        
        for (let i = 0; i < this.rows; i++) {
            const isVip = this.vipRows.has(i);
            const rowLabel = String.fromCharCode(65 + i);
            
            const item = document.createElement('div');
            item.className = 'row-config-item';
            item.innerHTML = `
                <div>
                    <span style="font-weight: 600;">Hàng ${rowLabel}</span>
                    <span style="padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.8rem; margin-left: 0.5rem; ${isVip ? 'background: #fd79a8; color: white;' : 'background: #ddd;'}">
                        ${isVip ? 'VIP' : 'Thường'}
                    </span>
                </div>
                <div class="row-controls">
                    <button type="button" class="btn-control minus small" onclick="seatManager.changeSeatsInRow(${i}, -1)">-</button>
                    <div class="seats-per-row-display">${this.seatsPerRow[i]}</div>
                    <button type="button" class="btn-control plus small" onclick="seatManager.changeSeatsInRow(${i}, 1)">+</button>
                </div>
            `;
            
            container.appendChild(item);
        }
    }

    updateFormData() {
        // Update hidden form fields
        const seats = this.generateSeatsData();
        const config = this.generateRoomConfig();
        
        document.getElementById('seats-data').value = JSON.stringify(seats);
        document.getElementById('room-config').value = JSON.stringify(config);
    }

    generateSeatsData() {
        const seats = [];
        const prices = this.getPrices();
        
        for (let row = 0; row < this.rows; row++) {
            for (let col = 0; col < this.seatsPerRow[row]; col++) {
                const seatId = `${row}-${col}`;
                const isCouple = this.seatTypes[seatId] === 'couple';
                const isVip = this.vipRows.has(row);
                
                let price = prices.normal;
                if (isVip && isCouple) {
                    price = prices.vipCouple;
                } else if (isVip) {
                    price = prices.vip;
                } else if (isCouple) {
                    price = prices.couple;
                }
                
                seats.push({
                    seat_number: String.fromCharCode(65 + row) + (col + 1).toString().padStart(2, '0'),
                    row: row,
                    column: col,
                    seat_type: isCouple ? 'couple' : 'single',
                    is_vip: isVip,
                    price: price,
                    is_available: true
                });
            }
        }
        
        return seats;
    }

    generateRoomConfig() {
        return {
            total_rows: this.rows,
            seats_per_row: this.seatsPerRow,
            vip_rows: Array.from(this.vipRows),
            seat_types: this.seatTypes,
            pricing: this.getPrices()
        };
    }

    getPrices() {
        return {
            normal: parseInt(document.getElementById('normal-price').value) || 50000,
            couple: parseInt(document.getElementById('couple-price').value) || 120000,
            vip: parseInt(document.getElementById('vip-price').value) || 80000,
            vipCouple: parseInt(document.getElementById('vip-couple-price').value) || 200000
        };
    }

    async handleSubmit() {
        if (this.isLoading) return;
        
        const roomName = document.getElementById('room-name').value.trim();
        if (!roomName) {
            this.notify('Vui lòng nhập tên phòng!', 'error');
            document.getElementById('room-name').focus();
            return;
        }

        this.setLoading(true);
        
        try {
            // Update form data before submission
            this.updateFormData();
            
            // Submit form
            const form = document.getElementById('room-form');
            const formData = new FormData(form);
            
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const result = await response.json();
            
            if (response.ok) {
                this.notify('Lưu cấu hình thành công!', 'success');
                setTimeout(() => {
                    window.location.href = result.redirect || '/admin/rooms';
                }, 1500);
            } else {
                throw new Error(result.message || 'Server error');
            }
        } catch (error) {
            this.notify('Có lỗi xảy ra khi lưu: ' + error.message, 'error');
            console.error('Error:', error);
        } finally {
            this.setLoading(false);
        }
    }

    setLoading(loading) {
        this.isLoading = loading;
        const form = document.getElementById('room-form');
        if (loading) {
            form.classList.add('loading');
        } else {
            form.classList.remove('loading');
        }
    }

    notify(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.textContent = message;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 3000);
    }
}

// Global variables and functions
let seatManager;

document.addEventListener('DOMContentLoaded', () => {
    seatManager = new SeatManager();
});

function setSeatType(type) {
    seatManager.setSeatType(type);
}

// Show old errors if any
@if($errors->any())
    document.addEventListener('DOMContentLoaded', () => {
        @foreach($errors->all() as $error)
            seatManager.notify('{{ $error }}', 'error');
        @endforeach
    });
@endif
</script>

@endsection