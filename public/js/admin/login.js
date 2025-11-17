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
              const login = document.getElementById('erroModal')
         console.log('Token salvo:', dataToken.access_token);
  login.style.display='flex'
  setTimeout(() => {
    login.style.display = 'none';
return;
  }, 2000);
           /*  alert(dataToken.message || 'Erro ao fazer login.'); */
            
        }

        if(!dataToken.access_token) {
         console.log('Token salvo:', dataToken.access_token);
  login.style.display='flex'
  setTimeout(() => {
    login.style.display = 'none';
return;
  }, 2000);
            /* alert('Login respondeu se token'); */
        }

        localStorage.setItem('adm_token', dataToken.access_token);

         const login = document.getElementById('loginModal')
         console.log('Token salvo:', dataToken.access_token);
  login.style.display='flex'
  setTimeout(() => {
    login.style.display = 'none';
    window.location.href = '/admin/dashboard'; 
  }, 2000);
        console.log('Token salvo:', dataToken.access_token);
        
    } catch (error) {
        console.error('Erro de rede:', error);
          console.log('Token salvo:', dataToken.access_token);
  login.style.display='flex'
  setTimeout(() => {
    login.style.display = 'none';
return;
  }, 2000);
/*         alert('Não foi possível conectar ao servidor.'); */
    }
});