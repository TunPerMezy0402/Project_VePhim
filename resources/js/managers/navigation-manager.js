export class NavigationManager {
  constructor() {
    this.isCollapsed = false;
    this.isMobile = false;
    this.navbar = null;
    this.toggleButton = null;
    this.breakpoint = 992; // Bootstrap lg breakpoint
  }

  init() {
    this.navbar = document.querySelector('.navbar-vertical');
    this.toggleButton = document.querySelector('[data-nav-toggle]');
    
    this.checkScreenSize();
    this.loadStoredState();
    this.setupEventListeners();
    this.applyState();
  }

  checkScreenSize() {
    this.isMobile = window.innerWidth < this.breakpoint;
    this.handleScreenSizeChange();
  }

  handleScreenSizeChange() {
    if (this.isMobile) {
      this.collapse();
    } else {
      // Trên desktop, khôi phục trạng thái đã lưu
      this.loadStoredState();
      this.applyState();
    }
  }

  setupEventListeners() {
    // Toggle button
    if (this.toggleButton) {
      this.toggleButton.addEventListener('click', () => {
        this.toggle();
      });
    }

    // Screen size change
    window.addEventListener('resize', () => {
      const wasMobile = this.isMobile;
      this.checkScreenSize();
      
      if (wasMobile !== this.isMobile) {
        this.handleScreenSizeChange();
      }
    });

    // Click outside to close (mobile)
    document.addEventListener('click', (e) => {
      if (this.isMobile && this.navbar && !this.navbar.contains(e.target) && !this.toggleButton.contains(e.target)) {
        this.collapse();
      }
    });

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && this.isMobile && !this.isCollapsed) {
        this.collapse();
      }
    });
  }

  toggle() {
    if (this.isCollapsed) {
      this.expand();
    } else {
      this.collapse();
    }
  }

  collapse() {
    this.isCollapsed = true;
    this.applyState();
    this.saveState();
  }

  expand() {
    this.isCollapsed = false;
    this.applyState();
    this.saveState();
  }

  applyState() {
    if (!this.navbar) return;

    const html = document.documentElement;
    
    if (this.isCollapsed) {
      html.classList.add('navbar-vertical-collapsed');
      this.navbar.classList.add('collapsed');
      
      // Thêm overlay cho mobile
      if (this.isMobile) {
        this.addOverlay();
      }
    } else {
      html.classList.remove('navbar-vertical-collapsed');
      this.navbar.classList.remove('collapsed');
      
      // Xóa overlay
      if (this.isMobile) {
        this.removeOverlay();
      }
    }

    // Dispatch event
    this.dispatchNavigationEvent();
  }

  addOverlay() {
    if (!document.querySelector('.navbar-overlay')) {
      const overlay = document.createElement('div');
      overlay.className = 'navbar-overlay';
      overlay.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1040;
        opacity: 0;
        transition: opacity 0.3s ease;
      `;
      
      overlay.addEventListener('click', () => {
        this.collapse();
      });
      
      document.body.appendChild(overlay);
      
      // Animate overlay
      setTimeout(() => {
        overlay.style.opacity = '1';
      }, 10);
    }
  }

  removeOverlay() {
    const overlay = document.querySelector('.navbar-overlay');
    if (overlay) {
      overlay.style.opacity = '0';
      setTimeout(() => {
        overlay.remove();
      }, 300);
    }
  }

  loadStoredState() {
    if (!this.isMobile) {
      const stored = localStorage.getItem('isNavbarVerticalCollapsed');
      this.isCollapsed = stored ? JSON.parse(stored) : false;
    }
  }

  saveState() {
    if (!this.isMobile) {
      localStorage.setItem('isNavbarVerticalCollapsed', this.isCollapsed);
    }
  }

  dispatchNavigationEvent() {
    const event = new CustomEvent('navigationChanged', {
      detail: {
        isCollapsed: this.isCollapsed,
        isMobile: this.isMobile
      }
    });
    document.dispatchEvent(event);
  }

  // Utility methods
  isNavbarVisible() {
    return !this.isCollapsed;
  }

  getNavbarElement() {
    return this.navbar;
  }

  // Public API
  toggleCollapse() {
    this.toggle();
  }

  setCollapsed(collapsed) {
    if (collapsed) {
      this.collapse();
    } else {
      this.expand();
    }
  }
} 