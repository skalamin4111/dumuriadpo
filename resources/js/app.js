import Alpine from 'alpinejs';
import Chart from 'chart.js/auto';

window.Alpine = Alpine;
window.Chart = Chart;

Alpine.data('theme', () => ({
  dark: localStorage.theme === 'dark',
  init() {
    this.apply();
  },
  toggle() {
    this.dark = !this.dark;
    localStorage.theme = this.dark ? 'dark' : 'light';
    this.apply();
  },
  apply() {
    document.documentElement.classList.toggle('dark', this.dark);
  },
}));

Alpine.start();
