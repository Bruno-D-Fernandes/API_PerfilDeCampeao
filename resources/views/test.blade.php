<!DOCTYPE html>
<head>
  <title>Pusher</title>
  <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
</head>
<body>
  <script>
    const PUSHER_KEY = ""; // Key do Pusher
    const APP_ADDRESS = "127.0.0.1:8000"; // Endereço da API

    const BEARER_TOKEN = ""; // Token da autenticação
    const CLUB_ID = -1;

    var pusher = new Pusher(PUSHER_KEY, {
      cluster: 'sa1',
      authEndpoint: `http://${APP_ADDRESS}/broadcasting/auth`,
      auth: {
        headers: {
          'Authorization': `Bearer ${BEARER_TOKEN}`,
          'Accept': 'application/json',
        }
      }
    });

    // Esperar Conexão ficar pronta
    pusher.connection.bind('connected', function () {
      var channel = pusher.subscribe(`private-notifications.club.${CLUB_ID}`);

      channel.bind('opportunity.applied', function(data) {
        // Sempre que receber dados do canal
        alert(`${data.userApplier.nomeCompletoUsuario} se inscreveu na oportunidade!`)
      });
    });

    // Conexão com erro
    pusher.connection.bind('error', function (err) {
      console.log("Erro de Conexão do Pusher:", err);
    })
  </script>
</body>