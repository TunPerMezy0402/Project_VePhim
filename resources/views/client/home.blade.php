@extends('client.layouts.ClientLayout')

@section('content')
    <style>

        /* Hero Section */
        .hero {
            text-align: center;
            padding: 80px 20px;
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.5)), 
                        url('https://images.unsplash.com/photo-1489599849026-11050ac8e985?w=1920&h=1080&fit=crop') center/cover;
            position: relative;
            overflow: hidden;
            margin-top: 20px;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(255,0,150,0.1), rgba(0,255,255,0.1));
            animation: heroGlow 8s ease-in-out infinite alternate;
        }

        @keyframes heroGlow {
            0% { opacity: 0.1; }
            100% { opacity: 0.3; }
        }

        .hero h1 {
            font-size: 4rem;
            font-weight: 900;
            margin-bottom: 20px;
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4, #45b7d1, #96ceb4);
            background-size: 300% 300%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: gradientShift 4s ease-in-out infinite;
            position: relative;
            z-index: 2;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .hero p {
            font-size: 1.3rem;
            margin-bottom: 40px;
            opacity: 0.9;
            position: relative;
            z-index: 2;
        }

        /* Hero Stats */
        .hero-stats {
            display: flex;
            justify-content: center;
            gap: 60px;
            margin-top: 40px;
            position: relative;
            z-index: 2;
        }

        .stat {
            text-align: center;
            transition: transform 0.3s ease;
        }

        .stat:hover {
            transform: translateY(-10px);
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 900;
            color: #4ecdc4;
            text-shadow: 0 0 20px rgba(78, 205, 196, 0.5);
        }

        .stat-label {
            font-size: 1.1rem;
            opacity: 0.8;
            margin-top: 5px;
        }

        /* Section Titles */
        .section-title {
            text-align: center;
            font-size: 2.5rem;
            margin: 60px 0 40px;
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4);
            border-radius: 2px;
        }

        /* Coming Soon Section */
        .coming-soon {
            padding: 60px 20px;
            text-align: center;
        }

        .coming-soon h2 {
            font-size: 2.5rem;
            margin-bottom: 40px;
            background: linear-gradient(45deg, #ffeaa7, #fab1a0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .coming-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .coming-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 20px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .coming-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(255,107,107,0.1), rgba(78,205,196,0.1));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .coming-card:hover::before {
            opacity: 1;
        }

        .coming-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }

        .coming-poster {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 15px;
            margin-bottom: 15px;
            transition: transform 0.3s ease;
        }

        .coming-card:hover .coming-poster {
            transform: scale(1.05);
        }

        .coming-card h4 {
            font-size: 1.2rem;
            margin-bottom: 10px;
            color: #fff;
        }

        .release-date {
            color: #4ecdc4;
            font-weight: 600;
            font-size: 1rem;
        }

        /* Movies Grid */
        .movies-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 40px;
            padding: 0 20px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .movie-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 25px;
            padding: 30px;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .movie-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255,107,107,0.1), rgba(78,205,196,0.1));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .movie-card:hover::before {
            opacity: 1;
        }

        .movie-card:hover {
            transform: translateY(-15px);
            box-shadow: 0 25px 50px rgba(0,0,0,0.4);
        }

        .movie-poster {
            width: 200px;
            height: 300px;
            object-fit: cover;
            border-radius: 15px;
            float: left;
            margin-right: 25px;
            margin-bottom: 20px;
            transition: transform 0.3s ease;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        .movie-card:hover .movie-poster {
            transform: scale(1.05);
        }

        .movie-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 15px;
            color: #fff;
            position: relative;
            z-index: 2;
        }

        .movie-meta {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }

        .meta-tag {
            background: linear-gradient(45deg, #667eea, #764ba2);
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .movie-rating {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        .stars {
            color: #ffd700;
            font-size: 1.2rem;
            text-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
        }

        .movie-description {
            margin-bottom: 20px;
            line-height: 1.6;
            opacity: 0.9;
            position: relative;
            z-index: 2;
        }

        .showtimes {
            margin-bottom: 25px;
            position: relative;
            z-index: 2;
        }

        .showtimes-label {
            font-weight: 600;
            margin-bottom: 10px;
            color: #4ecdc4;
        }

        .showtimes-list {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .showtime-tag {
            background: linear-gradient(45deg, #ff6b6b, #ee5a52);
            padding: 8px 15px;
            border-radius: 25px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .showtime-tag:hover {
            background: linear-gradient(45deg, #ee5a52, #ff6b6b);
            border-color: rgba(255, 255, 255, 0.3);
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(255, 107, 107, 0.4);
        }

        /* Book Button */
        .book-btn {
            background: linear-gradient(45deg, #4ecdc4, #44a08d);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            z-index: 2;
            width: 100%;
            margin-top: 10px;
        }

        .book-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .book-btn:hover::before {
            left: 100%;
        }

        .book-btn:hover {
            background: linear-gradient(45deg, #44a08d, #4ecdc4);
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(78, 205, 196, 0.4);
        }

        .book-btn:active {
            transform: translateY(-1px);
        }

        /* Animation cho loading */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .loading {
            animation: pulse 1s infinite;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }

            .hero-stats {
                flex-direction: column;
                gap: 30px;
            }

            .movies-grid {
                grid-template-columns: 1fr;
                padding: 0 15px;
            }

            .movie-poster {
                width: 150px;
                height: 225px;
                margin-right: 15px;
            }

            .movie-title {
                font-size: 1.5rem;
            }

            .section-title {
                font-size: 2rem;
            }

            .coming-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 20px;
            }
        }

        @media (max-width: 480px) {
            .hero {
                padding: 50px 15px;
            }

            .hero h1 {
                font-size: 2rem;
            }

            .hero p {
                font-size: 1.1rem;
            }

            .movie-card {
                padding: 20px;
            }

            .movie-poster {
                width: 100%;
                height: 250px;
                float: none;
                margin-right: 0;
                margin-bottom: 15px;
            }

            .showtimes-list {
                justify-content: center;
            }
        }

        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(45deg, #4ecdc4, #44a08d);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(45deg, #44a08d, #4ecdc4);
        }
    </style>
    <!-- Demo content cho preview -->
    <div class="hero">
        <h1>🎬 Cinema Galaxy</h1>
        <p>Trải nghiệm điện ảnh đỉnh cao - Đặt vé nhanh chóng, tiện lợi</p>
        <div class="hero-stats">
            <div class="stat">
                <div class="stat-number">50+</div>
                <div class="stat-label">Phim Hot</div>
            </div>
            <div class="stat">
                <div class="stat-number">12</div>
                <div class="stat-label">Rạp Chiếu</div>
            </div>
            <div class="stat">
                <div class="stat-number">1M+</div>
                <div class="stat-label">Khách Hàng</div>
            </div>
        </div>
    </div>

    <div class="coming-soon">
        <h2>🎬 Phim Mới Nhất</h2>
        <div class="coming-grid">
            <div class="coming-card">
                <img src="https://images.unsplash.com/photo-1478720568477-152d9b164e26?w=300&h=400&fit=crop" alt="Avatar 2" class="coming-poster">
                <h4>Avatar: The Way of Water</h4>
                <div class="release-date">16/12/2024</div>
            </div>
        </div>
    </div>

    <h2 class="section-title">🎥 Phim Đang Chiếu</h2>

    <div class="movies-grid">
        <div class="movie-card">
            <img src="https://images.unsplash.com/photo-1608270586620-248524c67de9?w=400&h=600&fit=crop" alt="Avengers: Endgame" class="movie-poster">
            <h3 class="movie-title">Avengers: Endgame</h3>
            <div class="movie-meta">
                <span class="meta-tag">181 phút</span>
                <span class="meta-tag">Hành động</span>
                <span class="meta-tag">T13</span>
            </div>
            <div class="movie-rating">
                <div class="stars">★★★★★</div>
                <span>9.2/10</span>
            </div>
            <p class="movie-description">
                Sau thảm họa xảy ra trong "Infinity War", các Avengers tập hợp một lần nữa để đảo ngược
                hành động của Thanos và khôi phục lại trật tự của vũ trụ.
            </p>
            <div class="showtimes">
                <div class="showtimes-label">Suất chiếu hôm nay:</div>
                <div class="showtimes-list">
                    <span class="showtime-tag" onclick="selectShowtime(this, '09:00')">09:00</span>
                    <span class="showtime-tag" onclick="selectShowtime(this, '12:30')">12:30</span>
                    <span class="showtime-tag" onclick="selectShowtime(this, '15:45')">15:45</span>
                    <span class="showtime-tag" onclick="selectShowtime(this, '21:00')">21:00</span>
                </div>
            </div>
            <button class="book-btn" onclick="bookMovie('avengers')">Đặt Vé Ngay</button>
        </div>
        <div class="movie-card">
            <img src="https://images.unsplash.com/photo-1608270586620-248524c67de9?w=400&h=600&fit=crop" alt="Avengers: Endgame" class="movie-poster">
            <h3 class="movie-title">Avengers: Endgame</h3>
            <div class="movie-meta">
                <span class="meta-tag">181 phút</span>
                <span class="meta-tag">Hành động</span>
                <span class="meta-tag">T13</span>
            </div>
            <div class="movie-rating">
                <div class="stars">★★★★★</div>
                <span>9.2/10</span>
            </div>
            <p class="movie-description">
                Sau thảm họa xảy ra trong "Infinity War", các Avengers tập hợp một lần nữa để đảo ngược
                hành động của Thanos và khôi phục lại trật tự của vũ trụ.
            </p>
            <div class="showtimes">
                <div class="showtimes-label">Suất chiếu hôm nay:</div>
                <div class="showtimes-list">
                    <span class="showtime-tag" onclick="selectShowtime(this, '09:00')">09:00</span>
                    <span class="showtime-tag" onclick="selectShowtime(this, '12:30')">12:30</span>
                    <span class="showtime-tag" onclick="selectShowtime(this, '15:45')">15:45</span>
                    <span class="showtime-tag" onclick="selectShowtime(this, '21:00')">21:00</span>
                </div>
            </div>
            <button class="book-btn" onclick="bookMovie('avengers')">Đặt Vé Ngay</button>
        </div>
        <div class="movie-card">
            <img src="https://images.unsplash.com/photo-1608270586620-248524c67de9?w=400&h=600&fit=crop" alt="Avengers: Endgame" class="movie-poster">
            <h3 class="movie-title">Avengers: Endgame</h3>
            <div class="movie-meta">
                <span class="meta-tag">181 phút</span>
                <span class="meta-tag">Hành động</span>
                <span class="meta-tag">T13</span>
            </div>
            <div class="movie-rating">
                <div class="stars">★★★★★</div>
                <span>9.2/10</span>
            </div>
            <p class="movie-description">
                Sau thảm họa xảy ra trong "Infinity War", các Avengers tập hợp một lần nữa để đảo ngược
                hành động của Thanos và khôi phục lại trật tự của vũ trụ.
            </p>
            <div class="showtimes">
                <div class="showtimes-label">Suất chiếu hôm nay:</div>
                <div class="showtimes-list">
                    <span class="showtime-tag" onclick="selectShowtime(this, '09:00')">09:00</span>
                    <span class="showtime-tag" onclick="selectShowtime(this, '12:30')">12:30</span>
                    <span class="showtime-tag" onclick="selectShowtime(this, '15:45')">15:45</span>
                    <span class="showtime-tag" onclick="selectShowtime(this, '21:00')">21:00</span>
                </div>
            </div>
            <button class="book-btn" onclick="bookMovie('avengers')">Đặt Vé Ngay</button>
        </div>
    </div>

    <script>
        // Hàm đặt vé phim
        function bookMovie(movieId) {
            const button = event.target;
            
            // Thêm hiệu ứng loading
            button.classList.add('loading');
            button.innerHTML = 'Đang xử lý...';
            button.disabled = true;
            
            // Giả lập việc xử lý đặt vé
            setTimeout(() => {
                alert(`Đang chuyển hướng đến trang đặt vé cho phim: ${movieId}`);
                
                // Reset button
                button.classList.remove('loading');
                button.innerHTML = 'Đặt Vé Ngay';
                button.disabled = false;
                
                // Ở đây bạn có thể chuyển hướng đến trang đặt vé thực tế
                // window.location.href = `/booking/${movieId}`;
            }, 1500);
        }

        // Hàm chọn suất chiếu
        function selectShowtime(element, time) {
            // Bỏ selection từ tất cả showtime tags trong cùng movie card
            const movieCard = element.closest('.movie-card');
            const allShowtimes = movieCard.querySelectorAll('.showtime-tag');
            
            allShowtimes.forEach(tag => {
                tag.style.background = 'linear-gradient(45deg, #ff6b6b, #ee5a52)';
                tag.style.borderColor = 'transparent';
            });
            
            // Highlight showtime được chọn
            element.style.background = 'linear-gradient(45deg, #4ecdc4, #44a08d)';
            element.style.borderColor = 'rgba(255, 255, 255, 0.5)';
            
            // Lưu thời gian được chọn (có thể dùng để đặt vé)
            movieCard.setAttribute('data-selected-time', time);
            
            console.log(`Đã chọn suất chiếu: ${time}`);
        }

        // Animation khi scroll
        function animateOnScroll() {
            const cards = document.querySelectorAll('.movie-card, .coming-card');
            
            cards.forEach(card => {
                const cardTop = card.getBoundingClientRect().top;
                const cardBottom = card.getBoundingClientRect().bottom;
                
                if (cardTop < window.innerHeight && cardBottom > 0) {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }
            });
        }

        // Khởi tạo animation khi trang load
        document.addEventListener('DOMContentLoaded', function() {
            // Set initial state cho animation
            const cards = document.querySelectorAll('.movie-card, .coming-card');
            cards.forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(50px)';
                card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            });
            
            // Chạy animation
            animateOnScroll();
            
            // Lắng nghe sự kiện scroll
            window.addEventListener('scroll', animateOnScroll);
        });

        // Smooth scroll cho các liên kết nội bộ
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Preload images
        function preloadImages() {
            const images = [
                'https://images.unsplash.com/photo-1489599849026-11050ac8e985?w=1920&h=1080&fit=crop',
                'https://images.unsplash.com/photo-1478720568477-152d9b164e26?w=300&h=400&fit=crop',
                'https://images.unsplash.com/photo-1608270586620-248524c67de9?w=400&h=600&fit=crop'
            ];
            
            images.forEach(src => {
                const img = new Image();
                img.src = src;
            });
        }

        // Gọi preload khi trang load
        window.addEventListener('load', preloadImages);

        // Easter egg: Konami Code
        let konamiCode = [];
        const konami = [38, 38, 40, 40, 37, 39, 37, 39, 66, 65]; // Up Up Down Down Left Right Left Right B A
        
        document.addEventListener('keydown', function(e) {
            konamiCode.push(e.keyCode);
            if (konamiCode.length > konami.length) {
                konamiCode.shift();
            }
            
            if (konamiCode.toString() === konami.toString()) {
                // Kích hoạt hiệu ứng đặc biệt
                document.body.style.animation = 'gradientShift 2s ease-in-out';
                setTimeout(() => {
                    alert('🎬 Chúc mừng! Bạn đã khám phá được Easter Egg của Cinema Galaxy!');
                    document.body.style.animation = '';
                }, 2000);
                konamiCode = [];
            }
        });
    </script>
@endsection

