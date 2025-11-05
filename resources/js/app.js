// resources/js/app.js

import './bootstrap'; // Contains Axios setup and any other initial utilities

import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Initialize Alpine.js
Alpine.start();

// -----------------------------------------------------------------
// ⬇️ ADD THESE LINES TO IMPORT YOUR CUSTOM JAVASCRIPT LOGIC ⬇️
// -----------------------------------------------------------------

// Import global UI logic
import './global-ui';

// Import module-specific scripts (if you move them into resources/js)
// import './modules/tournament-management'; 
// import './modules/game-reviews'; 
// -----------------------------------------------------------------