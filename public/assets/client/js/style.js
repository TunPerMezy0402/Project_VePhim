function toggleMenu() {
    document.getElementById('nav').classList.toggle('active');
}

function bookMovie(movieId) {
    alert(`Đặt vé cho phim: ${movieId}. Chức năng sẽ được phát triển!`);
}

function showEasterEgg() {
    alert('🎉 Surprise! Code giảm giá: CINEMA2024 (-20%)');
}

// Search functionality
document.querySelector('.search-btn').addEventListener('click', function () {
    const searchTerm = document.querySelector('.search-input').value;
    if (searchTerm.trim()) {
        alert(`Tìm kiếm: "${searchTerm}"`);
    }
});

// Newsletter
document.querySelector('.newsletter-btn').addEventListener('click', function () {
    const email = document.querySelector('.newsletter-input').value;
    if (email && email.includes('@')) {
        alert('Cảm ơn bạn đã đăng ký nhận tin! 📧');
        document.querySelector('.newsletter-input').value = '';
    } else {
        alert('Vui lòng nhập email hợp lệ!');
    }
});

const cinemaData = [
    {
        id: 1,
        name: "CGV Vincom Center",
        brand: "CGV",
        area: "quan1",
        address: "72 Lê Thánh Tôn, Quận 1, TP.HCM",
        distance: "0.8 km",
        rating: 4.5,
        reviews: 2456,
        features: ["IMAX", "4DX", "Gold Class", "Sweetbox"],
        movies: [
            {
                name: "Avengers: Endgame",
                id: "avengers",
                duration: "181 phút",
                rating: "T13",
                showtimes: ["09:00", "12:30", "16:00", "19:30", "22:45"]
            },
            {
                name: "Spider-Man: No Way Home",
                id: "spiderman",
                duration: "148 phút",
                rating: "T13",
                showtimes: ["10:15", "13:45", "17:20", "20:50"]
            }
        ]
    },
    {
        id: 2,
        name: "Galaxy Nguyễn Du",
        brand: "Galaxy Cinema",
        area: "quan1",
        address: "116 Nguyễn Du, Quận 1, TP.HCM",
        distance: "1.2 km",
        rating: 4.3,
        reviews: 1892,
        features: ["Premium", "VIP", "Gold"],
        movies: [
            {
                name: "The Batman",
                id: "batman",
                duration: "176 phút",
                rating: "T16",
                showtimes: ["08:30", "12:00", "15:30", "19:00", "22:30"]
            },
            {
                name: "Top Gun: Maverick",
                id: "topgun",
                duration: "131 phút",
                rating: "T13",
                showtimes: ["09:45", "14:15", "18:45", "21:30"]
            }
        ]
    },
    {
        id: 3,
        name: "Lotte Cinema Diamond Plaza",
        brand: "Lotte Cinema",
        area: "quan1",
        address: "34 Lê Duẩn, Quận 1, TP.HCM",
        distance: "1.5 km",
        rating: 4.6,
        reviews: 3241,
        features: ["Super Plex G", "Premium", "VIP"],
        movies: [
            {
                name: "Avengers: Endgame",
                id: "avengers",
                duration: "181 phút",
                rating: "T13",
                showtimes: ["08:00", "11:30", "15:00", "18:30", "22:00"]
            }
        ]
    },
    {
        id: 4,
        name: "BHD Star Bitexco",
        brand: "BHD Star",
        area: "quan1",
        address: "36 Hồ Tùng Mậu, Quận 1, TP.HCM",
        distance: "0.9 km",
        rating: 4.4,
        reviews: 1567,
        features: ["IMAX", "Gold Class"],
        movies: [
            {
                name: "Spider-Man: No Way Home",
                id: "spiderman",
                duration: "148 phút",
                rating: "T13",
                showtimes: ["09:30", "13:00", "16:30", "20:00"]
            }
        ]
    },
    {
        id: 5,
        name: "CGV Aeon Bình Tân",
        brand: "CGV",
        area: "binhtan",
        address: "1 Đường Số 17A, Bình Tân, TP.HCM",
        distance: "8.5 km",
        rating: 4.2,
        reviews: 987,
        features: ["4DX", "Sweetbox", "Gold Class"],
        movies: [
            {
                name: "The Batman",
                id: "batman",
                duration: "176 phút",
                rating: "T16",
                showtimes: ["10:00", "13:30", "17:00", "20:30"]
            },
            {
                name: "Top Gun: Maverick",
                id: "topgun",
                duration: "131 phút",
                rating: "T13",
                showtimes: ["11:15", "15:45", "19:15", "22:00"]
            }
        ]
    },
    {
        id: 6,
        name: "Galaxy Landmark 81",
        brand: "Galaxy Cinema",
        area: "quan7",
        address: "720A Điện Biên Phủ, Quận 7, TP.HCM",
        distance: "12.3 km",
        rating: 4.7,
        reviews: 4123,
        features: ["IMAX", "Premium", "VIP", "Gold"],
        movies: [
            {
                name: "Avengers: Endgame",
                id: "avengers",
                duration: "181 phút",
                rating: "T13",
                showtimes: ["08:45", "12:15", "15:45", "19:15", "22:45"]
            },
            {
                name: "Spider-Man: No Way Home",
                id: "spiderman",
                duration: "148 phút",
                rating: "T13",
                showtimes: ["10:30", "14:00", "17:30", "21:00"]
            }
        ]
    }
];

let filteredCinemas = [...cinemaData];

function renderCinemas(cinemas) {
    const grid = document.getElementById('cinemaGrid');

    if (cinemas.length === 0) {
        grid.innerHTML = `
                    <div class="no-results">
                        <div style="font-size: 4em; margin-bottom: 20px;">🎬</div>
                        <h3>Không tìm thấy rạp phù hợp</h3>
                        <p>Thử thay đổi bộ lọc hoặc từ khóa tìm kiếm</p>
                    </div>
                `;
        return;
    }

    grid.innerHTML = cinemas.map(cinema => `
                <div class="cinema-card">
                    <div class="cinema-header">
                        <div>
                            <div class="cinema-name">${cinema.name}</div>
                            <div class="cinema-address">
                                📍 ${cinema.address}
                            </div>
                            <div class="cinema-distance">${cinema.distance}</div>
                            <div class="rating">
                                <span class="stars">${'★'.repeat(Math.floor(cinema.rating))}${'☆'.repeat(5 - Math.floor(cinema.rating))}</span>
                                <span class="rating-text">${cinema.rating}/5 (${cinema.reviews.toLocaleString()} đánh giá)</span>
                            </div>
                        </div>
                        <div class="cinema-brand">${cinema.brand}</div>
                    </div>
                    
                    <div class="cinema-features">
                        ${cinema.features.map(feature => `<span class="feature-tag">${feature}</span>`).join('')}
                    </div>

                    <div class="movies-section">
                        <div class="section-title">🎥 Phim đang chiếu</div>
                        <div class="movie-list">
                            ${cinema.movies.map(movie => `
                                <div class="movie-item">
                                    <div class="movie-info">
                                        <div class="movie-name">${movie.name}</div>
                                        <div class="movie-details">${movie.duration} • ${movie.rating}</div>
                                        <div class="showtime-grid">
                                            ${movie.showtimes.map(time =>
        `<button class="showtime-btn" onclick="bookTicket('${cinema.id}', '${movie.id}', '${time}')">${time}</button>`
    ).join('')}
                                        </div>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                </div>
            `).join('');
}

function filterCinemas() {
    const areaFilter = document.getElementById('areaFilter').value;
    const brandFilter = document.getElementById('brandFilter').value;
    const movieFilter = document.getElementById('movieFilter').value;
    const sortFilter = document.getElementById('sortFilter').value;

    filteredCinemas = cinemaData.filter(cinema => {
        const matchArea = !areaFilter || cinema.area === areaFilter;
        const matchBrand = !brandFilter || cinema.brand.toLowerCase().includes(brandFilter);
        const matchMovie = !movieFilter || cinema.movies.some(movie => movie.id === movieFilter);

        return matchArea && matchBrand && matchMovie;
    });

    // Sắp xếp
    if (sortFilter === 'rating') {
        filteredCinemas.sort((a, b) => b.rating - a.rating);
    } else if (sortFilter === 'name') {
        filteredCinemas.sort((a, b) => a.name.localeCompare(b.name));
    } else if (sortFilter === 'distance') {
        filteredCinemas.sort((a, b) => parseFloat(a.distance) - parseFloat(b.distance));
    }

    renderCinemas(filteredCinemas);
}

function searchCinemas() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();

    if (!searchTerm) {
        filteredCinemas = [...cinemaData];
    } else {
        filteredCinemas = cinemaData.filter(cinema => {
            const matchName = cinema.name.toLowerCase().includes(searchTerm);
            const matchAddress = cinema.address.toLowerCase().includes(searchTerm);
            const matchMovie = cinema.movies.some(movie =>
                movie.name.toLowerCase().includes(searchTerm)
            );

            return matchName || matchAddress || matchMovie;
        });
    }

    renderCinemas(filteredCinemas);
}

function bookTicket(cinemaId, movieId, showtime) {
    const cinema = cinemaData.find(c => c.id == cinemaId);
    const movie = cinema.movies.find(m => m.id === movieId);

    alert(`Đặt vé thành công!\n\nRạp: ${cinema.name}\nPhim: ${movie.name}\nSuất chiếu: ${showtime}\n\nBạn sẽ được chuyển đến trang chọn ghế...`);
}

function toggleMap() {
    alert('Tính năng bản đồ sẽ được cập nhật sớm!\n\nHiện tại bạn có thể xem danh sách rạp theo khoảng cách.');
}

// Xử lý tìm kiếm khi nhấn Enter
document.getElementById('searchInput').addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
        searchCinemas();
    }
});

// Khởi tạo trang
document.addEventListener('DOMContentLoaded', function () {
    setTimeout(() => {
        renderCinemas(cinemaData);
    }, 1000);
});

// Form submission
document.getElementById('contactForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const submitBtn = document.getElementById('submitBtn');
    const successMessage = document.getElementById('successMessage');

    // Show loading state
    submitBtn.classList.add('loading');
    submitBtn.disabled = true;

    // Simulate API call
    setTimeout(() => {
        // Show success message
        successMessage.classList.add('show');

        // Reset form
        this.reset();

        // Reset priority tags
        document.querySelectorAll('.priority-tag').forEach(tag => {
            tag.classList.remove('active');
        });
        document.querySelector('[data-priority="medium"]').classList.add('active');

        // Reset button
        submitBtn.classList.remove('loading');
        submitBtn.disabled = false;

        // Hide success message after 5 seconds
        setTimeout(() => {
            successMessage.classList.remove('show');
        }, 5000);

    }, 2000);
});

// Priority tag selection
document.querySelectorAll('.priority-tag').forEach(tag => {
    tag.addEventListener('click', function () {
        document.querySelectorAll('.priority-tag').forEach(t => t.classList.remove('active'));
        this.classList.add('active');
    });
});

// FAQ toggle
function toggleFAQ(index) {
    const faqItems = document.querySelectorAll('.faq-item');
    const currentItem = faqItems[index];
    const answer = currentItem.querySelector('.faq-answer');
    const toggle = currentItem.querySelector('.faq-toggle');

    // Close all other FAQs
    faqItems.forEach((item, i) => {
        if (i !== index) {
            item.querySelector('.faq-answer').classList.remove('active');
            item.querySelector('.faq-toggle').classList.remove('active');
        }
    });

    // Toggle current FAQ
    answer.classList.toggle('active');
    toggle.classList.toggle('active');
}

// Form validation
document.querySelectorAll('.form-input, .form-select, .form-textarea').forEach(input => {
    input.addEventListener('blur', function () {
        if (this.hasAttribute('required') && !this.value.trim()) {
            this.style.borderColor = '#e74c3c';
        } else {
            this.style.borderColor = '#e8f4fd';
        }
    });

    input.addEventListener('input', function () {
        if (this.style.borderColor === 'rgb(231, 76, 60)') {
            this.style.borderColor = '#667eea';
        }
    });
});

// Phone number formatting
document.getElementById('phone').addEventListener('input', function (e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length > 10) value = value.substr(0, 10);

    if (value.length >= 6) {
        value = value.replace(/(\d{4})(\d{3})(\d{3})/, '$1 $2 $3');
    } else if (value.length >= 4) {
        value = value.replace(/(\d{4})(\d{0,3})/, '$1 $2');
    }

    e.target.value = value;
});

// Auto-resize textarea
document.getElementById('message').addEventListener('input', function () {
    this.style.height = 'auto';
    this.style.height = Math.min(this.scrollHeight, 200) + 'px';
});

let selectedShowtime = null;
let selectedSeats = [];
let ticketPrice = 0;

// Khởi tạo bản đồ ghế
function initSeatMap() {
    const seatMap = document.getElementById('seatMap');
    const rows = ['A', 'B', 'C', 'D', 'E', 'F'];
    const seatsPerRow = 12;

    // Ghế đã được đặt (mô phỏng)
    const occupiedSeats = ['A5', 'A6', 'B3', 'B8', 'B9', 'C7', 'D2', 'D11', 'E6', 'E7', 'F4'];

    rows.forEach(row => {
        const seatRow = document.createElement('div');
        seatRow.className = 'seat-row';

        for (let i = 1; i <= seatsPerRow; i++) {
            const seat = document.createElement('button');
            const seatId = row + i;
            seat.className = 'seat';
            seat.textContent = seatId;
            seat.dataset.seatId = seatId;

            if (occupiedSeats.includes(seatId)) {
                seat.classList.add('occupied');
                seat.disabled = true;
            } else {
                seat.classList.add('available');
                seat.addEventListener('click', () => toggleSeat(seatId, seat));
            }

            seatRow.appendChild(seat);
        }

        seatMap.appendChild(seatRow);
    });
}

// Chọn/bỏ chọn ghế
function toggleSeat(seatId, seatElement) {
    if (!selectedShowtime) {
        alert('Vui lòng chọn suất chiếu trước!');
        return;
    }

    if (seatElement.classList.contains('selected')) {
        seatElement.classList.remove('selected');
        seatElement.classList.add('available');
        selectedSeats = selectedSeats.filter(seat => seat !== seatId);
    } else {
        if (selectedSeats.length >= 8) {
            alert('Bạn chỉ có thể chọn tối đa 8 ghế!');
            return;
        }
        seatElement.classList.remove('available');
        seatElement.classList.add('selected');
        selectedSeats.push(seatId);
    }

    updateBookingSummary();
}

// Xử lý chọn suất chiếu
document.getElementById('showtimeGrid').addEventListener('click', (e) => {
    const btn = e.target.closest('.showtime-btn');
    if (!btn) return;

    // Bỏ chọn suất chiếu cũ
    document.querySelectorAll('.showtime-btn').forEach(b => b.classList.remove('selected'));

    // Chọn suất chiếu mới
    btn.classList.add('selected');
    selectedShowtime = {
        time: btn.dataset.time,
        price: parseInt(btn.dataset.price)
    };
    ticketPrice = selectedShowtime.price;

    // Reset ghế đã chọn
    selectedSeats = [];
    document.querySelectorAll('.seat.selected').forEach(seat => {
        seat.classList.remove('selected');
        seat.classList.add('available');
    });

    updateBookingSummary();
});

// Cập nhật thông tin đặt vé
function updateBookingSummary() {
    const summary = document.getElementById('bookingSummary');
    const bookBtn = document.getElementById('bookBtn');

    if (selectedShowtime && selectedSeats.length > 0) {
        summary.style.display = 'block';

        document.getElementById('selectedTime').textContent = selectedShowtime.time;
        document.getElementById('selectedSeats').textContent = selectedSeats.join(', ');
        document.getElementById('ticketCount').textContent = selectedSeats.length;
        document.getElementById('totalPrice').textContent = (selectedSeats.length * ticketPrice).toLocaleString() + 'đ';

        bookBtn.disabled = false;
        bookBtn.textContent = 'Đặt Vé Ngay';
    } else if (selectedShowtime && selectedSeats.length === 0) {
        summary.style.display = 'block';
        document.getElementById('selectedTime').textContent = selectedShowtime.time;
        document.getElementById('selectedSeats').textContent = '-';
        document.getElementById('ticketCount').textContent = '0';
        document.getElementById('totalPrice').textContent = '0đ';

        bookBtn.disabled = true;
        bookBtn.textContent = 'Chọn ghế để tiếp tục';
    } else {
        summary.style.display = 'none';
        bookBtn.disabled = true;
        bookBtn.textContent = 'Chọn suất chiếu và ghế';
    }
}

// Xử lý đặt vé
document.getElementById('bookBtn').addEventListener('click', () => {
    if (!selectedShowtime || selectedSeats.length === 0) return;

    const bookingDetails = document.getElementById('bookingDetails');
    bookingDetails.innerHTML = `
                <strong>Chi tiết đặt vé:</strong><br>
                Phim: Avengers: Endgame<br>
                Suất chiếu: ${selectedShowtime.time}<br>
                Ghế: ${selectedSeats.join(', ')}<br>
                Số lượng: ${selectedSeats.length} vé<br>
                Tổng tiền: ${(selectedSeats.length * ticketPrice).toLocaleString()}đ<br>
                Mã đặt vé: #BK${Date.now().toString().slice(-6)}
            `;

    document.getElementById('successModal').style.display = 'block';
});

// Đóng modal
function closeModal() {
    document.getElementById('successModal').style.display = 'none';

    // Reset trang
    selectedShowtime = null;
    selectedSeats = [];
    ticketPrice = 0;

    document.querySelectorAll('.showtime-btn').forEach(btn => btn.classList.remove('selected'));
    document.querySelectorAll('.seat.selected').forEach(seat => {
        seat.classList.remove('selected');
        seat.classList.add('available');
    });

    updateBookingSummary();
}

// Khởi tạo trang
document.addEventListener('DOMContentLoaded', () => {
    initSeatMap();
});

// Đóng modal khi click bên ngoài
document.getElementById('successModal').addEventListener('click', (e) => {
    if (e.target.id === 'successModal') {
        closeModal();
    }
});