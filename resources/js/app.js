import './bootstrap';

import Alpine from 'alpinejs';
import { initHomepage, homeApi } from './home-api';

window.Alpine = Alpine;
window.initHomepage = initHomepage;
window.homeApi = homeApi;

Alpine.start();

