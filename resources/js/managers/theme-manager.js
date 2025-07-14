export class ThemeManager {
  constructor() {
    this.themes = ['light', 'dark', 'auto'];
    this.currentTheme = 'light';
    this.mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
  }

  init() {
    this.currentTheme = this.getStoredTheme();
    this.applyTheme(this.currentTheme);
    this.setupMediaQueryListener();
  }

  getStoredTheme() {
    return localStorage.getItem('theme') || 'light';
  }

  setStoredTheme(theme) {
    localStorage.setItem('theme', theme);
  }

  applyTheme(theme) {
    const html = document.documentElement;
    
    // Xóa tất cả theme classes cũ
    html.classList.remove('theme-light', 'theme-dark');
    
    if (theme === 'auto') {
      const isDark = this.mediaQuery.matches;
      html.setAttribute('data-bs-theme', isDark ? 'dark' : 'light');
      html.classList.add(isDark ? 'theme-dark' : 'theme-light');
    } else {
      html.setAttribute('data-bs-theme', theme);
      html.classList.add(`theme-${theme}`);
    }
    
    this.currentTheme = theme;
    this.setStoredTheme(theme);
    
    // Dispatch custom event
    this.dispatchThemeChangeEvent(theme);
  }

  toggleTheme() {
    const currentIndex = this.themes.indexOf(this.currentTheme);
    const nextIndex = (currentIndex + 1) % this.themes.length;
    const nextTheme = this.themes[nextIndex];
    
    this.applyTheme(nextTheme);
  }

  setTheme(theme) {
    if (this.themes.includes(theme)) {
      this.applyTheme(theme);
    } else {
      console.warn(`Invalid theme: ${theme}`);
    }
  }

  setupMediaQueryListener() {
    this.mediaQuery.addEventListener('change', (e) => {
      if (this.currentTheme === 'auto') {
        this.applyTheme('auto');
      }
    });
  }

  dispatchThemeChangeEvent(theme) {
    const event = new CustomEvent('themeChanged', {
      detail: { theme, previousTheme: this.currentTheme }
    });
    document.dispatchEvent(event);
  }

  getCurrentTheme() {
    return this.currentTheme;
  }

  isDarkMode() {
    if (this.currentTheme === 'auto') {
      return this.mediaQuery.matches;
    }
    return this.currentTheme === 'dark';
  }

  // Utility methods
  addThemeClass(element, className) {
    element.classList.add(`${className}-${this.currentTheme}`);
  }

  removeThemeClass(element, className) {
    this.themes.forEach(theme => {
      element.classList.remove(`${className}-${theme}`);
    });
  }
} 