<x-layouts.clube title="Perfil" :breadcrumb="['Dashboard' => route('clube.dashboard'), 'Perfil' => null]">
    @php
        $clube = auth()->guard('club')->user();
        $oportunidades = $clube->oportunidades;
    @endphp
    
    <div id="profile-page" class="w-full h-full">
        @include('clube.partials.profile-page', ['clube' => $clube, 'oportunidades' => $oportunidades, 'categorias' => $categorias])
    </div>

    <div id="profile-loading" class="absolute inset-0 bg-white/50 backdrop-blur-sm z-50 flex items-center justify-center hidden rounded-[0.42vw]">
        <svg class="animate-spin h-[1.67vw] w-[1.67vw] text-emerald-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    </div>
        
    <script>
        function showProfileLoading() {
            document.getElementById('profile-loading').classList.remove('hidden');
        }

        function hideProfileLoading() {
            document.getElementById('profile-loading').classList.add('hidden');
        }

        function previewImage(input, imgId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById(imgId).setAttribute('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function consultarCep() {
            let cepInput = document.getElementById('evt-cep');
            let cep = cepInput.value.replace(/\D/g, '');
            if (cep != "") {
                let validacep = /^[0-9]{8}$/;
                if(validacep.test(cep)) {
                    document.getElementById('clube-endereco').value = "Carregando...";
                    document.getElementById('clube-cidade').value = "...";
                    
                    fetch(`https://viacep.com.br/ws/${cep}/json/`)
                    .then(response => response.json())
                    .then(data => {
                        if (!("erro" in data)) {
                            document.getElementById('clube-endereco').value = data.logradouro + ", " + data.bairro;
                            document.getElementById('clube-cidade').value = data.localidade;
                            document.getElementById('clube-estado').value = data.uf;
                        } else {
                            alert("CEP não encontrado.");
                            document.getElementById('clube-endereco').value = "";
                        }
                    })
                    .catch(error => { console.error(error); alert("Erro ao buscar CEP."); });
                } else { alert("Formato de CEP inválido."); }
            }
        }

        async function submitAjax(formId, url, method, modalName, callbackName, sTitle, sMsg, eTitle, eMsg) {
            
            const form = document.getElementById(formId);
            
            if (!form) return;
            
            const btn = document.querySelector(`[onclick*="${formId}"]`);
            const originalBtnText = btn ? btn.innerText : 'Salvar';
            
            if(btn) { 
                btn.disabled = true; 
                btn.innerText = 'Salvando...'; 
                btn.classList.add('opacity-50', 'cursor-not-allowed'); 
            }

            const formData = new FormData(form);
            
            if (method.toUpperCase() === 'PUT') { 
                if (!formData.has('_method')) formData.append('_method', 'PUT'); 
            }

            showProfileLoading();

            try {
                
                const response = await fetch(url, {
                    method: 'POST',
                    headers: { 
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), 
                        'Accept': 'application/json' 
                    },
                    body: formData
                });
                
                const data = await response.json();

                if (response.ok) {
                    document.querySelector('#profile-page').innerHTML = data.data.html;
                } else {
                    
                    if (response.status === 422) {
                        let errorMessages = "";
                        for (const [field, msgs] of Object.entries(data.errors || {})) { 
                            errorMessages += `• ${msgs[0]}\n`; 
                        }
                        alert("Verifique os campos:\n" + errorMessages);
                    } else { 
                        alert(`${eTitle}\n${eMsg}`); 
                    }
                }

            } catch (error) { 
                console.error(error); 
                alert('Erro de conexão.'); 
            } finally { 
                hideProfileLoading();

                if(btn) { 
                    btn.disabled = false; 
                    btn.innerText = originalBtnText; 
                    btn.classList.remove('opacity-50', 'cursor-not-allowed'); 
                } 
            }
        }
    </script>
</x-layouts.clube>