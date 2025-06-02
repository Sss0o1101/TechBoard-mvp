import { showToast } from './favoriteHandler';

// お気に入りコメント機能のイベント処理を初期化
// モーダルウィンドウでコメントの追加・編集を行う

export function initFavoriteComments() {
    const modal = document.getElementById('commentModal');
    const modalJobTitle = document.getElementById('modal-job-title');
    const modalCompanyName = document.getElementById('modal-company-name');
    const commentText = document.getElementById('commentText');
    const saveCommentBtn = document.getElementById('saveCommentBtn');
    const cancelCommentBtn = document.getElementById('cancelCommentBtn');

    // 要素が存在しない場合は処理しない
    if (!modal || !commentText || !saveCommentBtn || !cancelCommentBtn) return;

    let currentJobId = null;

    // コメント編集ボタンクリック
    document.querySelectorAll('.edit-comment-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const favoriteCard = this.closest('.favorite-card');
            currentJobId = favoriteCard.dataset.jobId;

            // 求人情報をモーダルに設定
            if (modalJobTitle && modalCompanyName) {
                modalJobTitle.textContent = favoriteCard.querySelector('h4').textContent;
                modalCompanyName.textContent = favoriteCard.querySelector('h4 + p').textContent;
            }

            // 既存のコメントがあれば取得
            const commentArea = favoriteCard.querySelector('.comment-area p');
            commentText.value = commentArea ? commentArea.textContent : '';

            // モーダル表示
            modal.classList.remove('hidden');
        });
    });

    // モーダルを閉じる
    function closeModal() {
        modal.classList.add('hidden');
        commentText.value = '';
        currentJobId = null;
    }

    cancelCommentBtn.addEventListener('click', closeModal);

    // モーダル外をクリックで閉じる
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModal();
        }
    });

    // コメント保存
    saveCommentBtn.addEventListener('click', function() {
        if (!currentJobId) return;

        const comment = commentText.value.trim();
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // ボタンを無効化して重複実行を防ぐ
        saveCommentBtn.disabled = true;
        saveCommentBtn.textContent = '保存中...';

        console.log('コメント保存開始:', { jobId: currentJobId, comment: comment });

        fetch(`/favorites/${currentJobId}/comment`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ comment })
        })
        .then(response => {
            console.log('レスポンス受信:', { status: response.status, ok: response.ok });

            if (!response.ok) {
                // エラーレスポンスの詳細を取得
                return response.text().then(text => {
                    let errorMessage = `HTTP ${response.status}: ${response.statusText}`;
                    try {
                        const errorData = JSON.parse(text);
                        errorMessage = errorData.message || errorMessage;
                    } catch (e) {
                        // JSONパースに失敗した場合はHTMLエラーページの可能性
                        if (text.includes('<html>')) {
                            errorMessage = 'サーバーエラーが発生しました';
                        }
                    }
                    throw new Error(errorMessage);
                });
            }
            return response.json();
        })
        .then(data => {
            console.log('JSON解析完了:', data);

            if (data.success) {
                updateCommentDisplay(currentJobId, data);

                // モーダルを閉じて通知を表示
                closeModal();
                showToast(data.message);
            } else {
                throw new Error(data.message || 'コメントの保存に失敗しました');
            }
        })
        .catch(error => {
            console.error('エラー詳細:', error);
            showToast('エラーが発生しました: ' + error.message);
        })
        .finally(() => {
            // ボタンを元に戻す
            saveCommentBtn.disabled = false;
            saveCommentBtn.textContent = '保存する';
        });
    });

    // コメント表示を更新する関数
    function updateCommentDisplay(jobId, data) {
        const favoriteCard = document.querySelector(`.favorite-card[data-job-id="${jobId}"]`);
        if (!favoriteCard) return;

        let commentArea = favoriteCard.querySelector('.comment-area');

        if (data.has_comment && data.favorite.comment) {
            // コメントがある場合
            if (!commentArea) {
                // コメントエリアがない場合は新規作成
                const cardBody = favoriteCard.querySelector('.p-4');
                const newCommentArea = document.createElement('div');
                newCommentArea.className = 'comment-area mt-3 pt-3 border-t border-gray-200';
                newCommentArea.innerHTML = `
                    <div class="flex items-center text-sm text-gray-500 mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                        </svg>
                        <span>メモ</span>
                        <span class="ml-auto text-xs">たった今</span>
                    </div>
                    <p class="text-sm whitespace-pre-line">${escapeHtml(data.favorite.comment)}</p>
                `;
                cardBody.appendChild(newCommentArea);
            } else {
                // 既存のコメントエリアを更新
                const commentTextElement = commentArea.querySelector('p');
                if (commentTextElement) {
                    commentTextElement.textContent = data.favorite.comment;
                }
                const timestamp = commentArea.querySelector('.ml-auto');
                if (timestamp) {
                    timestamp.textContent = 'たった今';
                }
            }
        } else {
            // コメントが空の場合、エリアを削除
            if (commentArea) {
                commentArea.remove();
            }
        }
    }

    // HTMLエスケープ関数
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
}



//仮
