<!DOCTYPE html>
<html lang="ca">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Menú Principal</title>
  <style>
    body {
      margin: 0;
      font-family: 'Press Start 2P', cursive;
      background-color: #000;
      color: yellow;
      padding: 20px;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    h1 {
      color: red;
      text-align: center;
      margin-bottom: 30px;
    }
    .menu-container {
      background-color: #111;
      padding: 20px;
      border-radius: 10px;
      border: 2px solid yellow;
      max-width: 400px;
      width: 100%;
    }
    ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }
    li {
      margin-bottom: 15px;
    }
    a.button {
      display: block;
      padding: 12px 20px;
      background-color: red;
      color: yellow;
      text-decoration: none;
      text-align: center;
      border-radius: 5px;
      font-size: 14px;
      transition: background-color 0.3s, color 0.3s;
      user-select: none;
    }
    a.button:hover {
      background-color: yellow;
      color: red;
    }
    .info-message {
      text-align: center;
      margin-top: 20px;
      color: orange;
      font-size: 16px;
    }
  </style>
</head>
<body>

<h1>Menú Principal</h1>

<div class="menu-container" id="menu-container">
  <p>Comprovant sessió...</p>
</div>

<script>
  const menuContainer = document.getElementById('menu-container');
  const token = localStorage.getItem('token');

  function crearBotó(text, href) {
    const li = document.createElement('li');
    const a = document.createElement('a');
    a.textContent = text;
    a.href = href;
    a.className = 'button';
    li.appendChild(a);
    return li;
  }

  function mostrarMenuUsuari() {
    menuContainer.innerHTML = '';
    const ul = document.createElement('ul');
    ul.appendChild(crearBotó('Les meves estadístiques', '/app/user_stats'));
    ul.appendChild(crearBotó('Les meves últimes partides', '/app/last_games'));
    ul.appendChild(crearBotó('Top 10 Jugadors', '/app/top_users'));
    ul.appendChild(crearBotó('Actualitza les meves dades', '/app/update_user'));
    ul.appendChild(crearBotó('Configura el joc', '/app/config_game'));
    ul.appendChild(crearBotó('Afegir partida', '/app/add_game'));
    ul.appendChild(crearBotó('Actualitzar la configuració del Joc', '/app/update_config_game'));

    // Botó logout
    const logoutLi = document.createElement('li');
    const logoutBtn = document.createElement('a');
    logoutBtn.href = '#';
    logoutBtn.textContent = 'Tancar sessió';
    logoutBtn.className = 'button';
    logoutBtn.addEventListener('click', async (e) => {
      e.preventDefault();
      try {
        const res = await fetch('/apis/V1/logout', {
          method: 'POST',
          headers: {
            'Authorization': 'Bearer ' + token,
            'Content-Type': 'application/json'
          }
        });
        if (res.ok) {
          localStorage.removeItem('token');
          location.reload();
        } else {
          const data = await res.json();
          alert(data.message || 'Error en tancar sessió');
        }
      } catch (error) {
        alert('Error de xarxa durant logout');
      }
    });
    logoutLi.appendChild(logoutBtn);
    ul.appendChild(logoutLi);

    menuContainer.appendChild(ul);
  }

  function mostrarMenuNoUsuari() {
    menuContainer.innerHTML = '';
    const ul = document.createElement('ul');
    ul.appendChild(crearBotó('Inicia sessió', '/app/login'));
    ul.appendChild(crearBotó('Registra’t', '/app/register'));
    menuContainer.appendChild(ul);

    const info = document.createElement('div');
    info.className = 'info-message';
    info.textContent = 'Per accedir al menú has d’estar identificat.';
    menuContainer.appendChild(info);
  }

  if (!token) {
    mostrarMenuNoUsuari();
  } else {
    fetch('/apis/V1/logged', {
      method: 'GET',
      headers: {
        'Authorization': 'Bearer ' + token,
        'Content-Type': 'application/json',
      }
    })
    .then(res => {
      if (!res.ok) throw new Error('No autenticat');
      return res.json();
    })
    .then(data => {
      if (data.status === 'ok') {
        mostrarMenuUsuari();
      } else {
        mostrarMenuNoUsuari();
      }
    })
    .catch(() => {
      mostrarMenuNoUsuari();
    });
  }
</script>

</body>
</html>
