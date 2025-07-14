<header class="header">
    <div class="header-content">
        <a href="#" class="logo">
            <span>🎬</span>
            Cinema Galaxy
        </a>

        <nav>
            <ul class="nav" id="nav">
                <li><a href="{{ route('home') }}">Trang Chủ</a></li>
                <li><a href="{{ route('client.movies') }}">Phim</a></li>
                <li><a href="{{ route('client.showtimes') }}">Lịch Chiếu</a></li>
                <li><a href="#contact">Liên Hệ</a></li>
            </ul>
        </nav>

        <div class="header-right">
            <div class="search-box">
                <input type="text" class="search-input" placeholder="Tìm phim...">
                <button class="search-btn">🔍</button>
            </div>

            <div class="user-actions">
                @if (Auth::check())
                <div class="user-profile" id="userProfile">
                    <button class="profile-btn" onclick="toggleDropdown()">
                        <div class="user-avatar" id="userAvatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <span id="userName">{{ Auth::user()->name }}</span>
                        <span>▼</span>
                    </button>
                    <div class="dropdown-menu" id="dropdownMenu">
                        <div class="user-info">
                            <div class="user-name" id="userNameDropdown">{{ Auth::user()->name }}</div>
                            <div class="user-email" id="userEmail">{{ Auth::user()->email }}</div>
                        </div>
                        <a href="#" class="dropdown-item">👤 Hồ sơ cá nhân</a>
                        <a href="#" class="dropdown-item">🎫 Vé của tôi</a>
                        <a href="#" class="dropdown-item">⭐ Điểm thưởng</a>
                        <a href="#" class="dropdown-item">⚙️ Cài đặt</a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('logout') }}" class="dropdown-item"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            🚪 Đăng xuất
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
                @else
                <!-- Nút đăng nhập/đăng ký (hiển thị khi chưa đăng nhập) -->
                <div class="auth-buttons" id="authButtons">
                    <button class="login-btn" onclick="showLogin()">
                        👤 Đăng nhập
                    </button>
                    <button class="register-btn" onclick="showRegister()">
                        ✨ Đăng ký
                    </button>
                </div>
                @endif
            </div>


        </div>
    </div>
</header>