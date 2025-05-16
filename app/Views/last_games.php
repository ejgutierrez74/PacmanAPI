<!DOCTYPE html>
<html lang="ca">
<head>
  <meta charset="UTF-8">
  <title>Últimes partides</title>
  <style>
    body {
      margin: 0;
      font-family: 'Press Start 2P', cursive;
      background-color: #000;
      color: yellow;
      padding: 20px;
    }

    h1 {
      color: red;
      text-align: center;
    }

    .games-container {
      max-width: 800px;
      margin: 0 auto;
      background-color: #111;
      padding: 20px;
      border: 2px solid yellow;
      border-radius: 10px;
    }

    .game {
      border-bottom: 1px solid yellow;
      padding: 10px 0;
    }

    .game:last-child {
      border-bottom: none;
    }
  </style>
</head>
<body>
  <h1>Últimes Partides</h1>
  <div class="games-container" id="games-list">Carregant...</div>

  <script>
    async function carregarPartides() {
      const token = localStorage.getItem('token');
      const res = await fetch('/apis/V1/get_user_last_games', {
        method: 'GET',
        headers: {
          'Authorization': 'Bearer ' + token
        }
      });

      const result = await res.json();
      const list = document.getElementById('games-list');

      if (!res.ok) {
        list.innerHTML = result.message;
        return;
      }

      if (result.partides.length === 0) {
        list.innerHTML = '<p>No tens cap partida guardada.</p>';
        return;
      }

      list.innerHTML = '';
      result.partides.forEach(game => {
        const div = document.createElement('div');
        div.classList.add('game');
        div.innerHTML = `
          <p><strong>Data:</strong> ${new Date(game.played_at).toLocaleString()}</p>
          <p><strong>Guanyada:</strong> ${game.won ? 'Sí' : 'No'}</p>
          <p><strong>Puntuació:</strong> ${game.score}</p>
          <p><strong>Duració:</strong> ${game.duration} segons</p>
        `;
        list.appendChild(div);
      });
    }

    carregarPartides();
  </script>
</body>
</html>
