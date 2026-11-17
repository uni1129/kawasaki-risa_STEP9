document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('purchase-form');
  const modal = document.getElementById('purchase-modal');
  const modalCancel = document.getElementById('modal-cancel');
  const modalConfirm = document.getElementById('modal-confirm');

  if (!form) return;

  const productId = form.getAttribute('data-product-id');

  // 「購入する」ボタン押下時（モーダルを表示するクラスを付与）
  form.addEventListener('submit', function (e) {
      e.preventDefault();
      if (modal) {
          modal.classList.add('is-active'); // CSSのクラスで表示を制御
      }
  });

  // モーダルの「キャンセル」押下時
  if (modalCancel) {
      modalCancel.onclick = function () {
          if (modal) {
              modal.classList.remove('is-active'); // クラスを外して非表示に
          }
      };
  }

  // モーダルの「購入する（確定）」押下時
  if (modalConfirm) {
    modalConfirm.onclick = function () {
        const quantityInput = document.getElementById('quantity');
        const quantity = quantityInput ? quantityInput.value : 1;

        const tokenElement = document.querySelector('input[name="_token"]');
        const csrfToken = tokenElement ? tokenElement.value : '';

        fetch(`/product/${productId}/buy`, { 
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                quantity: quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                window.location.href = data.redirect_url || '/home';
            } else {
                alert(data.message || '購入処理に失敗しました。');
                if (modal) {
                    modal.classList.remove('is-active');
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('通信エラーが発生しました。');
            if (modal) {
                modal.classList.remove('is-active');
            }
        });
    };
}
});



// 検索バー
document.addEventListener('DOMContentLoaded', function () {
    const searchForm = document.getElementById('search-form');
    const keywordInput = document.getElementById('search-keyword');
    const minPriceInput = document.getElementById('search-min-price');
    const maxPriceInput = document.getElementById('search-max-price');

    // 共通の非同期検索を実行する関数
    function executeSearch() {
        const keyword = keywordInput ? keywordInput.value : '';
        const minPrice = minPriceInput ? minPriceInput.value : '';
        const maxPrice = maxPriceInput ? maxPriceInput.value : '';

        // クエリパラメータを組み立てる
        const params = new URLSearchParams({
            keyword: keyword,
            min_price: minPrice,
            max_price: maxPrice
        });

        // 非同期通信（Fetch API）でサーバーにリクエスト
        fetch(`/home?${params.toString()}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html'
            }
        })
        .then(response => response.text())
        .then(html => {
            // 取得したHTMLから商品一覧部分を抽出して差し替える
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newProductList = doc.getElementById('product-list');

            const currentProductList = document.getElementById('product-list');
            if (newProductList && currentProductList) {
                currentProductList.innerHTML = newProductList.innerHTML;
            }
        })
        .catch(error => {
            console.error('非同期検索エラー:', error);
        });
    }

    // 検索ボタンを押したとき（非同期検索）
    if (searchForm) {
        searchForm.addEventListener('submit', function (e) {
            e.preventDefault();
            executeSearch();
        });
    }

    // キーワード欄に文字を入力したとき
    if (keywordInput) {
        keywordInput.addEventListener('input', function () {
            executeSearch();
        });
    }

    // 最低価格が変更されたとき
    if (minPriceInput) {
        minPriceInput.addEventListener('input', function () {
            executeSearch();
        });
    }

    // 最高価格が変更されたとき
    if (maxPriceInput) {
        maxPriceInput.addEventListener('input', function () {
            executeSearch();
        });
    }
});