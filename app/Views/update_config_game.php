<!DOCTYPE html>
<html lang="ca">
<head>
  <meta charset="UTF-8">
  <title>Actualitza la Configuració</title>
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

    .form-container {
      background-color: #111;
      padding: 20px;
      border-radius: 10px;
      border: 2px solid yellow;
      max-width: 400px;
      margin: 0 auto;
    }

    label, select {
      font-size: 18px;
      display: block;
      margin-bottom: 10px;
    }

    select {
      padding: 10px;
      width: 100%;
      background-color: #222;
      color: yellow;
      border: 1px solid yellow;
      border-radius: 5px;
    }

    button {
      padding: 10px 20px;
      background-color: red;
      border: none;
      border-radius: 5px;
      color: yellow;
      font-size: 18px;
      cursor: pointer;
      width: 100%;
    }

    button:hover {
      background-color: yellow;
      color: red;
    }
  </style>
  <script>
    function updateConfig(event) {
      event.preventDefault();

      const theme = document.getElementById('theme').value;
      const music = document.getElementById('music').value;
      const difficulty = document.getElementById('difficulty').value;

      // Només afegeix els camps que l'usuari ha seleccionat
      const body = {};
      if (theme !== '') body.theme = theme;
      if (music !== '') body.music = music;
      if (difficulty !== '') body.difficulty = difficulty;

      fetch('/apis/V1/update_config_game', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': 'Bearer ' + localStorage.getItem('token')
        },
        body: JSON.stringify(body)
      })
      .then(res => res.json())
      .then(data => {
        if (data.status === 'ok') {
          alert('Configuració actualitzada correctament!');
        } else {
          alert('Error: ' + data.message);
        }
      })
      .catch(err => {
        console.error(err);
        alert('Error de connexió amb el servidor.');
      });
    }
  </script>
</head>
<body>
  <h1>Actualitza la Configuració</h1>
  <div class="form-container">
    <form onsubmit="updateConfig(event)">
      <label for="theme">Tema del Joc:</label>
      <select id="theme">
        <option value="">-- No canviar --</option>
        <option value="dark">Fosc</option>
        <option value="light">Clar</option>
        <option value="retro">Retro</option>
      </select>

      <label for="music">Música:</label>
      <select id="music">
        <option value="">-- No canviar --</option>
        <option value="on">Activada</option>
        <option value="off">Desactivada</option>
      </select>

      <label for="difficulty">Dificultat:</label>
      <select id="difficulty">
        <option value="">-- No canviar --</option>
        <option value="easy">Fàcil</option>
        <option value="medium">Mitjana</option>
        <option value="hard">Difícil</option>
      </select>

      <br><br>
      <button type="submit">Actualitzar Configuració</button>
    </form>
  </div>
</body>
</html>
