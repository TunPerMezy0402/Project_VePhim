@extends('client.layouts.ClientLayout')

@section('content')
    <div class="contact-content">
    <div class="contact-form">
        <div class="form-header">
            <h2>📝 Gửi Tin Nhắn</h2>
            <p>Điền thông tin bên dưới để gửi yêu cầu của bạn</p>
        </div>

        <div class="success-message" id="successMessage">
            ✅ Cảm ơn bạn! Tin nhắn đã được gửi thành công. Chúng tôi sẽ phản hồi trong vòng 24 giờ.
        </div>

        <form id="contactForm">
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Họ và tên *</label>
                    <input type="text" class="form-input" id="fullName" required placeholder="Nhập họ tên của bạn">
                </div>
                <div class="form-group">
                    <label class="form-label">Số điện thoại *</label>
                    <input type="tel" class="form-input" id="phone" required placeholder="Nhập số điện thoại">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Email *</label>
                <input type="email" class="form-input" id="email" required placeholder="Nhập địa chỉ email">
            </div>

            <div class="form-group">
                <label class="form-label">Chủ đề liên hệ *</label>
                <select class="form-select" id="subject" required>
                    <option value="">Chọn chủ đề</option>
                    <option value="booking">Đặt vé & Showtimes</option>
                    <option value="technical">Sự cố kỹ thuật</option>
                    <option value="refund">Hoàn tiền & Đổi vé</option>
                    <option value="membership">Thẻ thành viên</option>
                    <option value="facilities">Cơ sở vật chất</option>
                    <option value="feedback">Góp ý & Phản hồi</option>
                    <option value="partnership">Hợp tác kinh doanh</option>
                    <option value="other">Khác</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Mức độ ưu tiên</label>
                <div class="priority-tags">
                    <div class="priority-tag" data-priority="low">🟢 Thấp</div>
                    <div class="priority-tag active" data-priority="medium">🟡 Trung bình</div>
                    <div class="priority-tag" data-priority="high">🟠 Cao</div>
                    <div class="priority-tag" data-priority="urgent">🔴 Khẩn cấp</div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Nội dung tin nhắn *</label>
                <textarea class="form-textarea" id="message" required
                    placeholder="Mô tả chi tiết vấn đề hoặc yêu cầu của bạn..."></textarea>
            </div>

            <button type="submit" class="submit-btn" id="submitBtn">
                Gửi tin nhắn
            </button>
        </form>
    </div>

    <div class="contact-info">
        <div class="info-card">
            <h3>📞 Thông Tin Liên Hệ</h3>

            <div class="info-item">
                <div class="info-icon">📱</div>
                <div class="info-text">
                    <div class="info-label">Hotline 24/7</div>
                    <div class="info-value">1900 6017</div>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon">✉️</div>
                <div class="info-text">
                    <div class="info-label">Email hỗ trợ</div>
                    <div class="info-value">support@cinemagalaxy.vn</div>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon">📧</div>
                <div class="info-text">
                    <div class="info-label">Email kinh doanh</div>
                    <div class="info-value">business@cinemagalaxy.vn</div>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon">📍</div>
                <div class="info-text">
                    <div class="info-label">Trụ sở chính</div>
                    <div class="info-value">123 Nguyễn Huệ, Q.1, TP.HCM</div>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon">🕐</div>
                <div class="info-text">
                    <div class="info-label">Giờ làm việc</div>
                    <div class="info-value">8:00 - 22:00 (Hàng ngày)</div>
                </div>
            </div>
        </div>

        <div class="info-card">
            <h3>🌐 Kết Nối Với Chúng Tôi</h3>
            <p style="color: #666; margin-bottom: 1.5rem; text-align: center;">
                Theo dõi chúng tôi để cập nhật những tin tức mới nhất
            </p>
            <div class="social-links">
                <a href="#" class="social-link" title="Facebook">📘</a>
                <a href="#" class="social-link" title="Instagram">📷</a>
                <a href="#" class="social-link" title="YouTube">📺</a>
                <a href="#" class="social-link" title="TikTok">🎵</a>
                <a href="#" class="social-link" title="Zalo">💬</a>
            </div>
        </div>
    </div>
</div>

<div class="faq-section">
    <div class="faq-header">
        <h3>❓ Câu Hỏi Thường Gặp</h3>
        <p style="color: #666;">Những câu hỏi được hỏi nhiều nhất từ khách hàng</p>
    </div>

    <div class="faq-item">
        <div class="faq-question" onclick="toggleFAQ(0)">
            <span>Làm thế nào để đặt vé online?</span>
            <span class="faq-toggle">▼</span>
        </div>
        <div class="faq-answer">
            <p>Bạn có thể đặt vé trực tuyến thông qua website hoặc app di động. Chọn phim, suất chiếu, ghế ngồi và
                thanh toán online. Vé sẽ được gửi qua email hoặc SMS.</p>
        </div>
    </div>

    <div class="faq-item">
        <div class="faq-question" onclick="toggleFAQ(1)">
            <span>Chính sách hoàn tiền như thế nào?</span>
            <span class="faq-toggle">▼</span>
        </div>
        <div class="faq-answer">
            <p>Bạn có thể hoàn tiền trước giờ chiếu 2 tiếng với phí 10%. Trường hợp đặc biệt như hủy suất chiếu,
                chúng tôi hoàn tiền 100%.</p>
        </div>
    </div>

    <div class="faq-item">
        <div class="faq-question" onclick="toggleFAQ(2)">
            <span>Có thể mang đồ ăn từ ngoài vào không?</span>
            <span class="faq-toggle">▼</span>
        </div>
        <div class="faq-answer">
            <p>Theo quy định, không được mang đồ ăn từ bên ngoài. Tuy nhiên, chúng tôi có nhiều combo bắp nước hấp
                dẫn với giá cả hợp lý.</p>
        </div>
    </div>

    <div class="faq-item">
        <div class="faq-question" onclick="toggleFAQ(3)">
            <span>Làm thế nào để trở thành thành viên VIP?</span>
            <span class="faq-toggle">▼</span>
        </div>
        <div class="faq-answer">
            <p>Đăng ký tài khoản và tích lũy điểm qua việc mua vé. Thành viên VIP sẽ được ưu đãi giảm giá, ưu tiên
                đặt vé và nhiều quyền lợi khác.</p>
        </div>
    </div>
</div>
@endsection