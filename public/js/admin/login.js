 document.getElementById('formLogin').addEventListener('submit', function(event) {
            event.preventDefault();

            const url = "/api/admin/login";
            const form = event.target;
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());

            const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    
                } else {
                    alert(data.message);
                }
            })
            .catch ((error) => {
                console.error('error:', error);
            })

        })
