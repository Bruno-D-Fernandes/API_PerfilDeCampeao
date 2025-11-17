  document.getElementById('logout').addEventListener('submit', function(event) {
        event.preventDefault();

        const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const token = localStorage.getItem('clube_token')
        const url = "../api/clube/logout";

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
            window.location.href = "/clube/login";
          } else {
            alert('Erro ao fazer logout. Tente novamente.');
          }
        })
        .catch(error => {
          console.error('Erro:', error);
          alert('Erro ao fazer logout. Tente novamente.');
        });
      });
