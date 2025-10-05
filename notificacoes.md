# Como usar as notificações via Pusher:

## 1. Logando no Pusher:

- Acesse o site oficial do Pusher (pusher.com)
- Faça login usando a conta google da norven (`norventcc@gmail.com`)
- Entrar no canal do Perfil de Campeão e pegar as App Keys

## 2. Alterando ```.env```

Com as App Keys em mãos é só alterar os seguintes trechos:

```
PUSHER_APP_ID= // app_id
PUSHER_APP_KEY= // key
PUSHER_APP_SECRET= // secret
PUSHER_HOST= // Não alterar
PUSHER_PORT=443 // Não alterar
PUSHER_SCHEME=https // Não alterar
PUSHER_APP_CLUSTER= // cluster
```

**Importante**: Após salvar, limpar cache do Laravel:

```
php artisan config:clear
```

## Usando na Web e em React Native

### Web (JS puro):

- Primeiro use o script do Pusher no final do body da View:

```
<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
```

- Utilize este código em JS para receber as notificações:

```

const PUSHER_KEY = ""; // Key do Pusher
const APP_ADDRESS = ""; // Endereço da API

const BEARER_TOKEN = ""; // Token da autenticação do Sanctum
const CLUB_ID = ""; // Id do clube logado

var pusher = new Pusher(PUSHER_KEY, {
    cluster: 'sa1',
    authEndpoint: `${APP_ADDRESS}/broadcasting/auth`,
    auth: {
    headers: {
        'Authorization': `Bearer ${BEARER_TOKEN}`,
        'Accept': 'application/json',
    }
    }
});

// Esperar Conexão ficar pronta
pusher.connection.bind('connected', function () {
    var channel = pusher.subscribe(`private-notifications.club.${CLUB_ID}`); // Canal de notificações pro clube

    channel.bind('club.followed', function(data) {
    // Sempre que receber dados do canal (aqui poderia estar a chamada da função que cria a div de notificação)
        alert(`${data.follower.nomeCompletoUsuario} começou a seguir você!`)
    });
});

// Conexão com erro
pusher.connection.bind('error', function (err) {
    console.log("Erro de Conexão do Pusher:", err);
})
```

### React Native:

- Para facilitar crie um context pra gerenciar as notificações (`NotificationContext.js`):

```
import { createContext, useState, useContext } from 'react';

const NotificationContext = createContext();

export const useNotifications = () => useContext(NotificationContext);

export const NotificationProvider = ({ children }) => {
  const [notifications, setNotifications] = useState([]);  // UseState com as notificações

  const addNotification = (newNotification) => {
    setNotifications((prevNotifications) => [newNotification, ...prevNotifications]);
  }; // Adicionando uma nova notificação

  return (
    <NotificationContext.Provider value={{ notifications, addNotification }}>
      {children}
    </NotificationContext.Provider>
  );
};
```

- Ouvinte Pusher (`PusherListener.js`) que ao receber o evento, adiciona a notificação ao estado global:

```
import React, { useEffect } from 'react';
import Pusher from 'pusher-js/react-native';
import { useNotifications } from './NotificationContext'; // Importe o hook

const PusherListener = ({ authToken, userId }) => {
  const { addNotification } = useNotifications(); // Pegue a função para adicionar notificações

  useEffect(() => {
    if (!authToken || !userId) return; // Se não tiver logado

    const PUSHER_KEY = 'sua_app_key_aqui'; // app_key
    const PUSHER_CLUSTER = 'sa1';
    const API_URL = 'endereco_api';

    const pusher = new Pusher(PUSHER_KEY, {
      cluster: PUSHER_CLUSTER,
      authEndpoint: `${API_URL}/api/broadcasting/auth`,
      auth: { headers: { 'Authorization': `Bearer ${authToken}`, 'Accept': 'application/json' } },
    });

    let channel;

    pusher.connection.bind('connected', () => {
      console.log(`Pusher Conectado! Ouvindo canal private-notifications.${userId}`);
      channel = pusher.subscribe(`private-notifications.user.${userId}`);

      channel.bind('user.followed', (data) => {
        console.log('Notificação "user.followed" recebida:', data);
        addNotification(data); // Adiciona a notificação ao estado global
      });
    });

    pusher.connection.bind('error', (err) => console.error("Erro de Conexão do Pusher:", err));

    return () => {
      if (channel) channel.unbind();
      pusher.unsubscribe(`private-notifications.user.${userId}`);
      pusher.disconnect();
    };
  }, [authToken, userId]);

  return null; // O componente não renderiza nada
};

export default PusherListener;
```

- Componente pra listar as notificações (`NotificationList.js`):

```
import { View, Text, FlatList, StyleSheet } from 'react-native';
import { useNotifications } from './NotificationContext';

const NotificationList = () => {
  const { notifications } = useNotifications();

  if (notifications.length === 0) {
    return (
      <View style={styles.container}>
        <Text style={styles.emptyText}>Nenhuma notificação ainda.</Text>
      </View>
    );
  }

  return (
    <FlatList
      data={notifications}
      keyExtractor={(item, index) => `${item.follower.id}-${index}`}
      renderItem={({ item }) => (
        <View style={styles.notificationItem}>
          <Text style={styles.notificationText}>
            <Text style={{ fontWeight: 'bold' }}>{item.follower.nomeCompletoUsuario}</Text> começou a seguir você!
          </Text>
        </View>
      )}
      style={styles.container}
    />
  );
};

const styles = StyleSheet.create({
  container: { flex: 1, backgroundColor: '#f0f0f0' },
  notificationItem: {
    backgroundColor: 'white',
    padding: 15,
    borderBottomWidth: 1,
    borderBottomColor: '#e0e0e0',
  },
  notificationText: { fontSize: 16 },
  emptyText: { textAlign: 'center', marginTop: 50, fontSize: 18, color: 'gray' },
});

export default NotificationList;
```

- Depois só criar a tela juntando tudo (ex: `app.js`):

```
import { SafeAreaView, StyleSheet } from 'react-native';
import { NotificationProvider } from './NotificationContext';
import PusherListener from './PusherListener';
import NotificationList from './NotificationList';

const App = () => {autenticação
  const authToken = 'seu_token_sanctum_aqui'; // Deve puxar AsyncStorage ou AuthContext
  const userId = 1; // Id do usuário

  return (
    <NotificationProvider>
      <SafeAreaView style={styles.container}>
        {/* O Listener fica ativo em segundo plano */}
        <PusherListener authToken={authToken} userId={userId} />
        
        {/* A tela que exibe as notificações recebidas */}
        <NotificationList />
      </SafeAreaView>
    </NotificationProvider>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
  },
});

export default App;
```