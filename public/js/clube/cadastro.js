document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById('cadastro');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const url = '/api/clube/register';

        const formData = new FormData(form);
        formData.append('categoria_id', 1);
        formData.append('esporte_id', 1);

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
            
            if (!data.error) {
                alert('deu certo');
            }
        })
        .catch(e => {
            console.error('ocorreu um erro', e);
        })
    });
})