document.addEventListener('DOMContentLoaded', () => {
  const favoriteBtn = document.getElementById('favorite-btn');
  
  if (favoriteBtn) {
      favoriteBtn.addEventListener('click', () => {
          favoriteBtn.classList.toggle('active');
      });
  }
});