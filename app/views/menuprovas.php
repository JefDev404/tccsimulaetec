<!DOCTYPE html>
<html lang="pt-br">
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulado - SimulaEtec</title>

    <!-- Pré-carrega o CSS principal -->
    <link rel="preload" href="css/style.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="css/style.css"></noscript>
    
    <!-- CSS Crítico (estilos essenciais que devem aparecer imediatamente) -->
    <style>
        @font-face {
            font-family: 'orbital';
            src: url('<?= HOME_ASSETS ?>fonts/Orbitron-VariableFont_wght.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        /* Estilos de fallback enquanto o CSS carrega */
        body {
            opacity: 0;
            visibility: hidden;
            font-family: 'orbital', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: #560F20;
            color: #ECD8E0;
            transition: opacity 0.3s ease, visibility 0s 0.3s;
        }
        
        .css-loaded body {
            opacity: 1;
            visibility: visible;
        }

        /* Estilos críticos para elementos acima do fold */
        .header-top {
            background-color: #791127;
            width: 100%;
            height: 65px;
            position: fixed;
            top: 0;
            z-index: 15;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .error-msg {
            color: #d9534f;
            text-align: center;
            margin-top: 10px;
            font-weight: bold;
        }
    </style>
    
    <!-- Script para gerenciar a transição -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Adiciona classe quando o CSS estiver carregado
            setTimeout(function() {
                document.documentElement.classList.add('css-loaded');
            }, 100);
            
            // Fallback caso o CSS não carregue em 1 segundo
            setTimeout(function() {
                if (!document.documentElement.classList.contains('css-loaded')) {
                    document.documentElement.classList.add('css-loaded');
                }
            }, 1000);
        });
    </script>
</head>

<body onload="document.body.classList.add('loaded')">

    <div class="header-top">
        <div class="header-content">
                <img src="<?= HOME_ASSETS ?>imgs/logo2.png" class="logo2">
            </div>
            <div class="header-content">
            <a href="<?= BASE_URL ?>?page=home" class="category-link">
                <img src="<?= MENUPROVAS_ASSETS ?>imgs/header.png" alt="Logo Simulado" class="logo">
            </a>
        </div>

     
            <span class="texto-simulado">SIMULADO DE PROVA</span>
        

        <div class="categories-container">
            <nav class="categories-nav">
                <ul class="categories-list">
                    <li class="category-item">
                        <a href="<?= BASE_URL ?>?page=home" class="category-link">voltar</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>


    <main class="main-content">



        <div class="prova-list">
            <h2 class="texto-modal">Selecione uma Prova</h2>
            <div class="links-container">

                <a href="<?= BASE_URL ?>?page=prova1" class="category-link">1º semestre/2025</a>
                <a href="<?= BASE_URL ?>?page=prova2" class="category-link">2º semestre/2024</a>
                <a href="<?= BASE_URL ?>?page=prova3" class="category-link">1º semestre/2024</a>
                <a href="<?= BASE_URL ?>?page=prova4" class="category-link">2º semestre/2023</a>
                <a href="<?= BASE_URL ?>?page=prova5" class="category-link">1º semestre/2023</a>
                <a href="<?= BASE_URL ?>?page=prova6" class="category-link">2º semestre/2022</a>
                <a href="<?= BASE_URL ?>?page=prova7" class="category-link">1º semestre/2022</a>
                <a href="<?= BASE_URL ?>?page=prova8" class="category-link">2º semestre/2021</a>
                <a href="<?= BASE_URL ?>?page=prova9" class="category-link">1º semestre/2021</a>
                <a href="<?= BASE_URL ?>?page=prova10" class="category-link">2º semestre/2020</a>

            </div>
        </div>





    </main>




    <footer class="footer animate-onload">
        <p>SimulaEtec © <?= date('Y') ?></p>
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
        channel.postMessage({ type: 'themeChanged', theme: nextTheme });
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