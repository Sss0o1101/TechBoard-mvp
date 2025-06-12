// お気に入り機能のイベント処理を初期化
// お気に入り追加・削除のフォーム送信時に処理を行う

export function initFavoriteButtons() {
    // お気に入り追加・削除のフォーム送信時にフラッシュメッセージを表示
    document.querySelectorAll('form[action^="/favorites/"]').forEach(form => {
        form.addEventListener('submit', function(e) {
            const isDelete = this.method === 'POST' && this.innerHTML.includes('DELETE');
            const message = isDelete ? '求人をお気に入りから削除しました' : '求人をお気に入りに追加しました';

            // ページがリロードされる場合はセッションストレージに保存
            sessionStorage.setItem('favoriteMessage', message);
        });
    });

    // ページ読み込み時にセッションストレージからメッセージを取得して表示
    const storedMessage = sessionStorage.getItem('favoriteMessage');
    if (storedMessage) {
        showToast(storedMessage);
        sessionStorage.removeItem('favoriteMessage');
    }
}

// トースト通知を表示する
//@param {string} message - 表示するメッセージ

/**
 * @param {string} message - 表示するメッセージ
 **/
export function showToast(message) {
    const toast = document.getElementById('toast');
    const toastMessage = document.getElementById('toastMessage');

    if (!toast || !toastMessage) return;

    toastMessage.textContent = message;
    toast.classList.remove('translate-y-full', 'opacity-0');

    setTimeout(() => {
        toast.classList.add('translate-y-full', 'opacity-0');
    }, 3000);
}



//jsコード1
