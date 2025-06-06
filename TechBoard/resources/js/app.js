import './bootstrap';
import { initFavoriteButtons, showToast } from './favoriteHandler';
import { initFavoriteComments } from './favoriteCommentHandler';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

// グローバルで利用できるようにする
window.showToast = showToast;

Alpine.start();

// DOMコンテンツ読み込み後に初期化
document.addEventListener('DOMContentLoaded', function() {
    initFavoriteButtons();
    initFavoriteComments();
});








//仮コードjs
