document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('logout');
  if (!form) return;

  form.addEventListener('submit', function (event) {
    event.preventDefault();

    const csrf  = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const token = localStorage.getItem('adm_token');
    const url   = '/api/admin/logout';

    fetch(url, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': csrf,
        'Content-Type': 'application/json',
        'Authorization': token
      }
    })
    .then(response => {
      if (response.ok) {
        localStorage.removeItem('adm_token');
        window.location.href = '/admin/login';
      } else {
        alert('Erro ao fazer logout. Tente novamente.');
      }
    })
    .catch(error => {
      console.error('Erro:', error);
      alert('Erro ao fazer logout. Tente novamente.');
    });
  });
});
