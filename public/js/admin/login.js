 document.getElementById('formLogin').addEventListener('submit', async function(event) {
            event.preventDefault();

            const url = "/api/admin/login";
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
            })

            const dataToken = await response.json();

            if (!response.ok) {
                alert(dataToken.message || 'Erro ao fazer login.');
                return;
            }

            if(!dataToken.access_token) {
                alert('Login respondeu se token');
                return;
            }

            localStorage.setItem('adm_token', dataToken.access_token);

            alert('Login realizado com sucesso!');
            console.log('Token salvo:', dataToken.access_token);
            window.location.href = '/admin/dashboard';
            
        } catch (error) {
            console.error('Erro de rede:', error);
            alert('Não foi possível conectar ao servidor.');
        }
    });

