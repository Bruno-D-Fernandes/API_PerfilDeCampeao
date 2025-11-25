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
</head>
<body class="font-sans antialiased h-screen relative">
    {{ $slot }}

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

        function closeModal(drawerId) {
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
    </script>
</body>
</html>