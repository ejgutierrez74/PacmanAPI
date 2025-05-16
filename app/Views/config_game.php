<!DOCTYPE html>
<html lang="ca">
<head>
  <meta charset="UTF-8">
  <title>Configuració del Joc</title>
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

    label {
      font-size: 12px;
      display: block;
      margin-bottom: 5px;
    }

    select, button {
      padding: 10px;
      font-size: 12px;
      width: 100%;
      margin-bottom: 15px;
      border: 1px solid yellow;
      border-radius: 5px;
      background-color: #222;
      color: yellow;
    }

    button {
      background-color: red;
      cursor: pointer;
    }

    button:hover {
      background-color: yellow;
      color: red;
    }
  </style>
</head>
<body>

  <h1>Configura el Joc</h1>
  <div class="form-container">
    <form id="config-game-form" onsubmit="saveConfig(event)">
      <label for="theme">Tema del joc:</label>
      <select id="theme">
        <option value="clàssic">Clàssic</option>
        <option value="espacial">Espacial</option>
        <option value="dark">Fosc</option>
      </select>

      <label for="music">Música:</label>
      <select id="music">
        <option value="none">Cap</option>
        <option value="8bit">8-bit</option>
        <option value="retro">Retro</option>
      </select>

      <label for="difficulty">Dificultat:</label>
      <select id="difficulty">
        <option value="fàcil">Fàcil</option>
        <option value="normal">Normal</option>
        <option value="difícil">Difícil</option>
      </select>

      <button type="submit">Desar configuració</button>
    </form>
  </div>

  <script>
    function saveConfig(event) {
      event.preventDefault();

      const config = {
        theme: document.getElementById('theme').value,
        music: document.getElementById('music').value,
        difficulty: document.getElementById('difficulty').value
      };

      fetch('/apis/V1/config_game', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': 'Bearer ' + localStorage.getItem('token')  // Important!
        },
        body: JSON.stringify(config)
      })
      .then(res => res.json())
      .then(data => {
        if (data.status === 'ok') {
          alert("Configuració desada correctament!");
          window.location.href = "/app/logged";  // o qualsevol pàgina de redirecció
        } else {
          alert("Error: " + data.message);
        }
      })
      .catch(err => {
        console.error(err);
        alert("Error en desar la configuració");
      });
    }
  </script>

</body>
</html>
