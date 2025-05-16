/**
 * Main JavaScript entry point
 * This file will be processed by Vite and will include all other JS modules
 */

// Import CSS
import '../css/style.css';

// Import modules
import { setupMenu } from './modules/Menu';
import { setupPopup } from './modules/Popup';
import { setupOverlay } from './modules/Overlay';
import { preloader } from './modules/utils/preloader';
import { setupScrollEvents } from './modules/utils/scrollEvents';
import { initWow } from './modules/utils/wow';

// Initialize components when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
  // Initialize preloader
  preloader();
  
  // Initialize menu
  setupMenu();
  
  // Initialize popup
  setupPopup();
  
  // Initialize overlay
  setupOverlay();
  
  // Initialize scroll events
  setupScrollEvents();
  
  // Initialize WOW.js animations
  initWow();
  
  console.log('Application initialized');
});