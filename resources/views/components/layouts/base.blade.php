<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }} | {{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="font-sans antialiased h-screen relative">
    {{ $slot }}

    @stack('scripts')
    <script>
        let currentSortCol = null;
        let currentSortDir = 'neutral';

        function handleSort(columnName) {
            let newDirection = 'asc';

            if (currentSortCol === columnName) {
                if (currentSortDir === 'asc') {
                    newDirection = 'desc';
                } else if (currentSortDir === 'desc') {
                    newDirection = 'neutral';
                }
            }

            document.querySelectorAll('.sortable-column').forEach(th => {
                const name = th.getAttribute('data-col');
                updateIcons(name, 'neutral'); 
            });

            if (newDirection !== 'neutral') {
                updateIcons(columnName, newDirection);
                currentSortCol = columnName;
                currentSortDir = newDirection;
            } else {
                currentSortCol = null;
                currentSortDir = 'neutral';
            }
        }

        function updateIcons(colName, state) {
            const neutral = document.getElementById(`icon-neutral-${colName}`);
            const asc = document.getElementById(`icon-asc-${colName}`);
            const desc = document.getElementById(`icon-desc-${colName}`);

            if(!neutral) return; 

            neutral.classList.add('hidden');
            asc.classList.add('hidden');
            desc.classList.add('hidden');

            if (state === 'asc') asc.classList.remove('hidden');
            else if (state === 'desc') desc.classList.remove('hidden');
            else neutral.classList.remove('hidden');
        }

        let currentPage = 1;
        let itemsPerPage = 10;

        function handlePageChange(newPage) {
            if (newPage === currentPage) return;
            
            currentPage = newPage;
        }

        function handlePerPageChange(newLimit) {
            itemsPerPage = newLimit;
            currentPage = 1;
        }

        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        function openDrawer(drawerId) {
            document.getElementById(`${drawerId}-overlay`).classList.remove('hidden');
            document.getElementById(`${drawerId}-panel`).classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeDrawer(drawerId) {
            document.getElementById(`${drawerId}-overlay`).classList.add('hidden');
            document.getElementById(`${drawerId}-panel`).classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
        
        document.addEventListener('keydown', function(event) {
            if (event.key === "Escape") {
                document.querySelectorAll('[role="dialog"]').forEach(modal => {
                    modal.classList.add('hidden');
                });
                document.body.classList.remove('overflow-hidden');
            }
        });

        const form = document.querySelector("#login-form");

        if (form) {
            form.addEventListener("submit", async (e) => {
                const formData = new FormData(form);

                try {
                    const response = await fetch(form.action, {
                        method: "POST",
                        body: formData,
                        headers: {
                            "Accept": "application/json"
                        }
                    });

                    if (!response.ok) {
                        e.preventDefault();
                        const data = await response.json();
                        showToast("error", "Erro de Acesso", data.message ?? "Erro inesperado.");
                    }
                } catch (err) {
                    e.preventDefault();
                    showToast("error", "Erro de Conexão", "Não foi possível conectar ao servidor.");
                }
            });
        }

        const signupForm = document.querySelector("#signup-form");

        if (signupForm) {
            signupForm.addEventListener("submit", async (e) => {
                e.preventDefault();

                const formData = new FormData(signupForm);

                for (let [key, value] of formData.entries()) {
                    console.log(key, value);
                }

                try {
                    const response = await fetch(signupForm.action, {
                        method: "POST",
                        body: formData,
                        headers: {
                            "Accept": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });

                    if (!response.ok) {
                        const data = await response.json();
                        showToast("error", "Erro no cadastro", data.message ?? "Erro inesperado.");
                        return;
                    }

                    const data = await response.json();
                    showToast("success", "Cadastro realizado", data.message ?? "Conta criada com sucesso!");
                    signupForm.reset();

                } catch (err) {
                    showToast("error", "Erro de conexão", "Não foi possível conectar ao servidor.");
                }
            });
        }

        function showToast(type, title, message) {
            const colors = { success: "emerald", error: "red", warning: "amber", info: "sky" };
            const color = colors[type] ?? "sky";

            const toast = document.createElement("div");
            toast.className = `toast-alert flex items-start p-3 mb-3 rounded-lg border bg-${color}-50 border-${color}-400 shadow transition-all animate-fade-in-up w-[420px]`;
            toast.innerHTML = `
                <div class="inline-flex items-center justify-center flex-shrink-0 w-6 h-6 mt-0.5 text-${color}-600">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ms-3 text-sm font-medium flex-1">
                    <div class="font-semibold text-${color}-800 mb-0.5">${title}</div>
                    <div class="text-${color}-700">${message}</div>
                </div>
                <button onclick="this.parentElement.remove()" 
                    class="cursor-pointer ms-auto -mx-1 -my-1 focus:outline-none rounded-lg p-1 
                    inline-flex items-center justify-center h-7 w-7 text-${color}-500 hover:bg-${color}-100">
                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            `;

            let container = document.getElementById("toast-container");

            container.appendChild(toast);
            setTimeout(() => toast.remove(), 4000);
        }
    </script>
</body>
</html>