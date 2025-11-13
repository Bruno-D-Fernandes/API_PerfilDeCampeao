document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById('cadastro-clube');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const url = '../api/clube/register';

        const formData = new FormData(form);
        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            body: formData,
        })
         .then(res => res.json())
        .then(data => {
            console.log(data);
            const addModal = document.getElementById('addModal');
            if (!data.error) {
                addModal.style.display = 'flex';
                localStorage.setItem('clube_token', data.access_token);
                setTimeout(() => {
                    window.location.href = "/clube/dashboard";
                }, 2000);
                setTimeout(() => {
                    window.location.href = "/clube/dashboard";
                }, 2000);
/*                 alert('deu certo'); */
                
            }
        })
        .catch(e => {
            console.error('ocorreu um erro', e);
        })
    });
})