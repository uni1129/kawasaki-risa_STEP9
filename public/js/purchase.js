document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('purchase-form');
  const modal = document.getElementById('purchase-modal');
  const modalConfirm = document.getElementById('modal-confirm');
  const modalCancel = document.getElementById('modal-cancel');

  if (!form || !modal) return;

  form.addEventListener('submit', function(e) {
      e.preventDefault();
      modal.style.display = 'flex'; // モーダルを表示
  });

  modalCancel.addEventListener('click', function() {
      modal.style.display = 'none';
  });

  modalConfirm.addEventListener('click', async function() {
      modal.style.display = 'none';

      const productId = form.getAttribute('data-product-id');
      const mypageUrl = form.getAttribute('data-mypage-url');
      const quantity = document.getElementById('quantity').value;
      const token = document.querySelector('input[name="_token"]').value;

      // デバッグ用（F12のコンソールでIDが取れているか確認できます）
      console.log('Product ID:', productId);

      try {
          // ★ URLから「/api」を削除し、通常のWebルートへリクエストを送る
          const response = await fetch(`/product/${productId}/buy`, {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': token,
                  'Accept': 'application/json'
              },
              body: JSON.stringify({ quantity: quantity })
          });

          const data = await response.json();

          if (response.ok && data.success) {
              alert(data.message);
              window.location.href = mypageUrl;
          } else {
              alert(data.message || '購入処理に失敗しました。');
          }
      } catch (error) {
          console.error('通信エラー:', error);
          alert('通信エラーが発生しました。');
      }
  });
});