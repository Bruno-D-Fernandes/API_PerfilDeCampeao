document.getElementById('formLogin').addEventListener('submit', async function(event) {
    event.preventDefault(); 

    const url = "../api/clube/login";
    const form = event.target;
    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());
    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf,
            },
            body: JSON.stringify(data)
        });

        const dataToken = await response.json();

        if (!response.ok) {
                    const ecxModal = document.getElementById('creModal');
        console.error('Erro de rede:', error);
        ecxModal.style.display = 'flex';
        setTimeout(() => {
        ecxModal.style.display = 'none';
        }, 1000);
            return;
        }

        if (!dataToken.access_token) {
            alert('Login respondeu sem token. Verifica o controller.');
            return;
        }
const addModal = document.getElementById('addModal');

addModal.style.display = 'flex';
        setTimeout(() => {
            addModal.style.display = 'none';
        window.location.href = '/clube/dashboard';
        }, 2000);
        localStorage.setItem('clube_token', dataToken.access_token);
        console.log('Token salvo:', dataToken.access_token);
/*         window.location.href = '/clube/dashboard'; */
    } catch (error) {
        const ecxModal = document.getElementById('deleteModal');
        console.error('Erro de rede:', error);
        ecxModal.style.display = 'flex';
        setTimeout(() => {
        ecxModal.style.display = 'none';
        }, 2000);

    }
});