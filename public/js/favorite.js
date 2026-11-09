document.addEventListener('DOMContentLoaded', function () {
  const favoriteBtn = document.getElementById('favorite-btn');
  console.log('favoriteBtn:', favoriteBtn);

  if (favoriteBtn) {
      favoriteBtn.addEventListener('click', function () {
        console.log('ボタンがクリックされました！');
          const productId = this.getAttribute('data-product-id');
          const svgElement = this.querySelector('.favorite-svg');

          // LaravelのCSRFトークンを取得
          const token = document.querySelector('meta[name="csrf-token"]');
          if (!token) {
              console.error('CSRF token not found');
              return;
          }

          // 非同期通信（Fetch API）でいいねのトグル処理を呼び出す
          fetch(`/products/${productId}/like`, {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': token.getAttribute('content')
              },
              body: JSON.stringify({})
          })
          .then(response => {
              if (!response.ok) {
                  throw new Error('Network response was not ok');
              }
              return response.json();
          })
          .then(data => {
              // サーバーからの返却値（liked: true / false）に応じてクラスを切り替える
              if (data.liked) {
                  svgElement.classList.add('active'); // 色を赤にする
              } else {
                  svgElement.classList.remove('active'); // 色をグレーに戻す
              }
          })
          .catch(error => {
              console.error('Error:', error);
          });
      });
  }
});
