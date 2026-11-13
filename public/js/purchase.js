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

          // ※ routes/api.php を使用している場合は '/api/product/...` にしてください
          // web.php のままであれば '/product/...' のままで大丈夫です
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
document.addEventListener('DOMContentLoaded', () => {
    const keywordInput = document.querySelector('#search-keyword');
    const minPriceInput = document.querySelector('#search-min-price');
    const maxPriceInput = document.querySelector('#search-max-price');
    const productListContainer = document.querySelector('#product-list');

    const fetchSearchResults = async () => {
        const keyword = keywordInput ? keywordInput.value : '';
        const minPrice = minPriceInput ? minPriceInput.value : '';
        const maxPrice = maxPriceInput ? maxPriceInput.value : '';

        const params = new URLSearchParams({
            keyword: keyword,
            min_price: minPrice,
            max_price: maxPrice
        });

        try {
            const response = await fetch(`/home?${params.toString()}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (response.ok) {
                const html = await response.text();
                if (productListContainer) {
                    productListContainer.innerHTML = html; // 非同期でテーブル部分だけを書き換える
                }
            }
        } catch (error) {
            console.error('非同期検索エラー:', error);
        }
    };

    // 文字入力や価格変更（input）のたびに非同期検索を実行
    if (keywordInput) keywordInput.addEventListener('input', fetchSearchResults);
    if (minPriceInput) minPriceInput.addEventListener('input', fetchSearchResults);
    if (maxPriceInput) maxPriceInput.addEventListener('input', fetchSearchResults);
});