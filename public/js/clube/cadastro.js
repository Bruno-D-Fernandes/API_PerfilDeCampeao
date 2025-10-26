document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById('cadastro-clube');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const url = '/api/clube/register';

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
            if (!data.error && !data.errors) {
                alert('deu certo');
                localStorage.setItem('club_token', data.access_token);
            }
        })
        .catch(e => {
            console.error('ocorreu um erro', e);
        })
    });
})