<!DOCTYPE html>
<html lang="pt-br">
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Simulado - SimulaEtec</title>


  <link rel="preload" href="css/style.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript>
    <link rel="stylesheet" href="css/style.css">
  </noscript>


  <style>
    @font-face {
      font-family: 'Poppins';
      src: url('<?= HOME_ASSETS ?>fonts/Poppins.ttf') format('truetype');
      font-weight: normal;
      font-style: normal;
    }

    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .css-loaded body {
      opacity: 1;
    }
  </style>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      setTimeout(function() {
        document.documentElement.classList.add('css-loaded');
      }, 100);

      setTimeout(function() {
        if (!document.documentElement.classList.contains('css-loaded')) {
          document.documentElement.classList.add('css-loaded');
        }
      }, 1000);
    });
  </script>
</head>

<body>


  <header id="topo">
    <div class="header-top">

      <!-- Logo -->
      <div class="header-content">
        <img src="<?= HOME_ASSETS ?>imgs/logo.png" alt="Logo SimulaEtec" class="logo">
        <h3><span class="highlight">SIMULA</span>ETEC</h3>
      </div>


      <nav class="categories-nav">
        <ul class="categories-list">
          <li class="category-item1">
            <a href="<?= BASE_URL ?>?page=home" class="category-link1">Home</a>
          </li>
          <li class="category-item">
            <a href="<?= BASE_URL ?>?page=bloqmenuprovas" class="category-link1">Provas anteriores</a>
          </li>

        </ul>
      </nav>


      <div class="login-container">
       <a href="<?= BASE_URL ?>?page=perfil" class="category-link">Voltar</a>
        <img src="<?= HOME_ASSETS ?>imgs/iconp.png" alt="Ícone de perfil" class="icon-img">
      </div>

    </div>
  </header>

  <main class="main-content">



    <div class="prova-list">
      <h2 class="texto-modal">escolha um semestre para iniciar</h2>
      <div class="links-container">

        <a href="<?= BASE_URL ?>?page=prova1" class="category-link">1º semestre/2025</a>
        <a href="<?= BASE_URL ?>?page=prova2" class="category-link">2º semestre/2024</a>
        <a href="<?= BASE_URL ?>?page=prova3" class="category-link">1º semestre/2024</a>
        <a href="<?= BASE_URL ?>?page=prova4" class="category-link">2º semestre/2023</a>

      </div>
    </div>





  </main>


  <footer class="footer">
    <div class="footer-container">
      <div class="footer-bottom">
        <p>© 2025 ETEC Itanhaém. Todos os direitos reservados.</p>
      </div>
  </footer>

  <script>
    // ========== CONFIGURAÇÃO DOS TEMAS ==========
    const ASSETS_BY_PAGE = {
      'home': "<?= HOME_ASSETS ?>",
      'cadastro': "<?= CADASTRO_ASSETS ?>",
      'menuprovas': "<?= MENUPROVAS_ASSETS ?>",
      'prova1': "<?= PROVA1_ASSETS ?>",
      'prova2': "<?= PROVA2_ASSETS ?>",
      'prova3': "<?= PROVA3_ASSETS ?>",
      'default': "<?= ASSETS_URL ?>"
    };

    const temas = {
      "default": "style.css",
      "dark": "darkstyle.css",
      "light": "lightstyle.css"
    };

    const temaOrder = ["default", "dark", "light"];
    let currentTemaIndex = 0;

    // ========== FUNÇÕES DOS TEMAS ==========
    function detectCurrentPage() {
      const urlParams = new URLSearchParams(window.location.search);
      const pageParam = urlParams.get('page') || 'home';
      return pageParam in ASSETS_BY_PAGE ? pageParam : 'default';
    }

    function getSavedTheme() {
      return localStorage.getItem('siteTheme') || 'default';
    }

    function applyTheme(themeName) {
      const currentPage = detectCurrentPage();
      const assetsPath = ASSETS_BY_PAGE[currentPage];
      const themeFile = temas[themeName];
      const fullPath = `${assetsPath}css/${themeFile}`;

      let styleElement = document.getElementById('tema-estilo');
      if (!styleElement) {
        styleElement = document.createElement('link');
        styleElement.id = 'tema-estilo';
        styleElement.rel = 'stylesheet';
        document.head.appendChild(styleElement);
      }

      if (styleElement.href !== fullPath) {
        styleElement.onload = () => {
          // Dispara evento após o CSS carregar
          document.dispatchEvent(new CustomEvent('themeChanged'));
        };
        styleElement.href = fullPath;
      }

      localStorage.setItem('siteTheme', themeName);
      currentTemaIndex = temaOrder.indexOf(themeName);
    }

    function trocarEstilo() {
      if (detectCurrentPage() === 'home') {
        currentTemaIndex = (currentTemaIndex + 1) % temaOrder.length;
        const nextTheme = temaOrder[currentTemaIndex];
        applyTheme(nextTheme);

        if (typeof BroadcastChannel !== 'undefined') {
          const channel = new BroadcastChannel('theme_channel');
          channel.postMessage({
            type: 'themeChanged',
            theme: nextTheme
          });
        }
      }
    }




    // ========== INICIALIZAÇÃO ==========
    document.addEventListener("DOMContentLoaded", function() {
      // 1. Aplica o tema primeiro (síncrono)
      applyTheme(getSavedTheme());

      // 2. Configura os outros efeitos após pequeno delay
      setTimeout(() => {
        setupScrollReveal();
        setupLoginBox();
      }, 50);

      // Sincronização entre abas
      if (typeof BroadcastChannel !== 'undefined') {
        const channel = new BroadcastChannel('theme_channel');
        channel.addEventListener('message', (event) => {
          if (event.data.type === 'themeChanged') {
            applyTheme(event.data.theme);
          }
        });
      }

      window.addEventListener('storage', function(event) {
        if (event.key === 'siteTheme') {
          applyTheme(event.newValue);
        }
      });
    });

    // Evento para quando o tema terminar de carregar
    document.addEventListener('themeChanged', () => {
      if (typeof setupScrollReveal === 'function') {
        setupScrollReveal();
      }
    });
  </script>



  <script>
    // Configurações globais para o php com verificação
    window.SIMULAETEC_CONFIG = {
      ASSETS_URL: '<?= defined('ASSETS_URL') ? ASSETS_URL : '/public/assets/' ?>',
      PROVA_ASSETS: '<?= defined('PROVA_ASSETS') ? MENUPROVAS_ASSETS : '/public/assets/prova/' ?>',
      BASE_URL: '<?= defined('BASE_URL') ? BASE_URL : '/' ?>'
    };


    // teste Debug inicial
    console.log('Configurações:', window.SIMULAETEC_CONFIG);
  </script>


</body>

</html>