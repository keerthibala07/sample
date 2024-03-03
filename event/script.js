document.querySelectorAll('input').forEach(item => {
  item.addEventListener('input', event => {
      const errorId = item.id + 'Error';
      const errorElement = document.getElementById(errorId);
      if (errorElement) {
          errorElement.textContent = '';
      }
  });
});
