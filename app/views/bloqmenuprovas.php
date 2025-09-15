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
    background-image: url('<?= BLOQMENUPROVAS_ASSETS ?>imgs/fundo.svg');
    background-repeat: no-repeat;   /* não repete */
    background-position: center;    /* centraliza */
    background-size: cover;         /* cobre toda a tela sem distorcer */
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
      <div class="header-content">
              <img src="<?= BLOQMENUPROVAS_ASSETS ?>imgs/Vector.svg" alt="Ícone de perfil" class="icon-img">

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
          <li class="category-item2">
            <a href="<?= BASE_URL ?>?page=bloqmenuprovas" class="category-link1">Guia de estudos</a>
          </li>
        </ul>
      </nav>


      <div class="login-container">
<img src="<?= BLOQMENUPROVAS_ASSETS ?>imgs/marinho.svg" alt="Ícone de perfil" class="icon-img">
      </div>

    </div>
  </header>

  <main class="main-content">
    <div class="prova-list">

    <div class="textos">
<h1>Simulados <span class="etec">ETEC</span></h1>
      <h2 class="texto-modal"> Faça o login para ter acesso a todas provas.<br></h2>
</div>
      
     <div class="links-container prova-list">
  <a href="<?= BASE_URL ?>?page=provademo" class="category-link active-link">
    <div class="ano-semestre">
      <img src="<?= BLOQMENUPROVAS_ASSETS ?>/imgs/Today.svg" class="icon">
      <span>2022</span>
    </div>
    <span class="TxtSemestres">1º Semestre</span>
  </a>

  <a href="<?= BASE_URL ?>?page=provabloq" class="category-link">
    <div class="ano-semestre">
      <img src="<?= BLOQMENUPROVAS_ASSETS ?>/imgs/Today.svg" class="icon">
      <span>2023</span>
    </div>
    <span class="TxtSemestres">1º Semestre</span>
  </a>

  <a href="<?= BASE_URL ?>?page=provabloq" class="category-link">
    <div class="ano-semestre">
      <img src="<?= BLOQMENUPROVAS_ASSETS ?>/imgs/Today.svg" class="icon">
      <span>2023</span>
    </div>
    <span class="TxtSemestres">1º Semestre</span>
  </a>

  <a href="<?= BASE_URL ?>?page=provabloq" class="category-link">
    <div class="ano-semestre">
      <img src="<?= BLOQMENUPROVAS_ASSETS ?>/imgs/Today.svg" class="icon">
      <span>2023</span>
    </div>
    <span class="TxtSemestres">1º Semestre</span>
  </a>
</div>

    </div>
  </main>
  <script>
    // ========== CONFIGURAÇÃO DOS TEMAS ==========
    const ASSETS_BY_PAGE = {
      'home': "<?= HOME_ASSETS ?>",
      'cadastro': "<?= CADASTRO_ASSETS ?>",
      'bloqmenuprovas': "<?= BLOQMENUPROVAS_ASSETS ?>",
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
      applyTheme(getSavedTheme());

      setTimeout(() => {
        if (typeof setupScrollReveal === 'function') setupScrollReveal();
        if (typeof setupLoginBox === 'function') setupLoginBox();
      }, 50);

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

    document.addEventListener('themeChanged', () => {
      if (typeof setupScrollReveal === 'function') {
        setupScrollReveal();
      }
    });
  </script>

  <script>
    window.SIMULAETEC_CONFIG = {
      ASSETS_URL: '<?= defined('ASSETS_URL') ? ASSETS_URL : '/public/assets/' ?>',
      PROVA_ASSETS: '<?= defined('PROVA_ASSETS') ? BLOQMENUPROVAS_ASSETS : '/public/assets/prova/' ?>',
      BASE_URL: '<?= defined('BASE_URL') ? BASE_URL : '/' ?>'
    };
    console.log('Configurações:', window.SIMULAETEC_CONFIG);
  </script>
</body>

</html>