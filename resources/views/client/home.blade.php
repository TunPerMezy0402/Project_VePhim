@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Trang Chủ</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }
    header {
      background-color: #007bff;
      color: white;
      padding: 1rem;
      text-align: center;
    }
    nav {
      background-color: #f8f9fa;
      padding: 0.5rem;
      text-align: center;
    }
    nav a {
      margin: 0 15px;
      text-decoration: none;
      color: #007bff;
      font-weight: bold;
    }
    main {
      padding: 2rem;
      text-align: center;
    }
    footer {
      background-color: #343a40;
      color: white;
      text-align: center;
      padding: 1rem;
      position: fixed;
      width: 100%;
      bottom: 0;
    }
  </style>
</head>


<body>

  <header>
    <h1>Chào mừng đến với Trang Chủ</h1>
  </header>

  <nav>
    <a href="#">Trang Chủ</a>
    <a href="#">Giới Thiệu</a>
    <a href="#">Dịch Vụ</a>
    <a href="#">Liên Hệ</a>
  </nav>

  <main>
    <h2>Nội dung chính</h2>
    <p>Đây là trang chủ của website. Bạn có thể thêm thông tin, hình ảnh, sản phẩm hoặc các bài viết tại đây.</p>
  </main>

  <footer>
    &copy; 2025 - Thiết kế bởi Bạn
  </footer>

</body>
</html>
