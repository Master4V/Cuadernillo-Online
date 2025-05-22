import './bootstrap';

import Alpine from 'alpinejs';

if (!window.AlpineStarted) {
    window.Alpine = Alpine;
    Alpine.start();
    window.AlpineStarted = true;
}
