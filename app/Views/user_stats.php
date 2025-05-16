<!DOCTYPE html>
<html lang="ca">
<head>
  <meta charset="UTF-8">
  <title>Estadístiques d'Usuari</title>
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

    .stats-container {
      max-width: 600px;
      margin: 0 auto;
      background-color: #111;
      padding: 20px;
      border: 2px solid yellow;
      border-radius: 10px;
    }

    .stat {
      margin: 10px 0;
    }

    .label {
      color: orange;
    }
  </style>
</head>
<body>
  <h1>Les Teves Estadístiques</h1>
  <div class="stats-container" id="stats">Carregant...</div>

  <script>
    async function carregarEstadistiques() {
      const token = localStorage.getItem('token');
      const res = await fetch('/apis/V1/get_user_stats', {
        method: 'GET',
        headers: {
          'Authorization': 'Bearer ' + token
        }
      });

      const data = await res.json();
      const cont = document.getElementById('stats');

      if (!res.ok) {
        cont.innerHTML = data.message;
        return;
      }

      cont.innerHTML = `
        <div class="stat"><span class="label">Total de partides:</span> ${data.total}</div>
        <div class="stat"><span class="label">Guanyades:</span> ${data.guanyades}</div>
        <div class="stat"><span class="label">Perdudes:</span> ${data.perdudes}</div>
        <div class="stat"><span class="label">Percentatge de victòries:</span> ${data.percentatge_victories}%</div>
        <div class="stat"><span class="label">Mitjana de punts:</span> ${data.mitjana_punts}</div>
        <div class="stat"><span class="label">Mitjana de durada:</span> ${data.mitjana_durada} segons</div>
      `;
    }

    carregarEstadistiques();
  </script>
</body>
</html>
