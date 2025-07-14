export class AppConfig {
  constructor() {
    this.defaults = {
      theme: 'light',
      isRTL: false,
      isFluid: false,
      navbarStyle: 'transparent',
      navbarPosition: 'vertical',
      isNavbarVerticalCollapsed: false
    };
    
    this.config = this.loadConfig();
  }

  loadConfig() {
    const config = {};
    
    Object.keys(this.defaults).forEach(key => {
      const storedValue = localStorage.getItem(key);
      config[key] = storedValue !== null ? this.parseValue(storedValue) : this.defaults[key];
    });
    
    return config;
  }

  parseValue(value) {
    if (value === 'true') return true;
    if (value === 'false') return false;
    return value;
  }

  get(key) {
    return this.config[key];
  }

  set(key, value) {
    this.config[key] = value;
    localStorage.setItem(key, value);
    this.applyConfig(key, value);
  }

  applyConfig(key, value) {
    switch (key) {
      case 'theme':
        this.applyTheme(value);
        break;
      case 'isNavbarVerticalCollapsed':
        this.applyNavbarCollapse(value);
        break;
      case 'isRTL':
        this.applyRTL(value);
        break;
    }
  }

  applyTheme(theme) {
    const html = document.documentElement;
    
    if (theme === 'dark') {
      html.setAttribute('data-bs-theme', 'dark');
    } else if (theme === 'auto') {
      const isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
      html.setAttribute('data-bs-theme', isDark ? 'dark' : 'light');
    } else {
      html.setAttribute('data-bs-theme', 'light');
    }
  }

  applyNavbarCollapse(collapsed) {
    const html = document.documentElement;
    if (collapsed) {
      html.classList.add('navbar-vertical-collapsed');
    } else {
      html.classList.remove('navbar-vertical-collapsed');
    }
  }

  applyRTL(isRTL) {
    const html = document.documentElement;
    if (isRTL) {
      html.setAttribute('dir', 'rtl');
      html.classList.add('rtl');
    } else {
      html.setAttribute('dir', 'ltr');
      html.classList.remove('rtl');
    }
  }

  reset() {
    Object.keys(this.defaults).forEach(key => {
      localStorage.removeItem(key);
    });
    this.config = { ...this.defaults };
    this.applyAllConfigs();
  }

  applyAllConfigs() {
    Object.entries(this.config).forEach(([key, value]) => {
      this.applyConfig(key, value);
    });
  }
} 