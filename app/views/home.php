<!DOCTYPE html>
<html lang="pt-br">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SimulaEtec</title>

    <style>
        @font-face {
            font-family: 'orbital';
            src: url('<?= HOME_ASSETS ?>fonts/Orbitron-VariableFont_wght.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        body {
            font-family: 'orbital', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f2f5;
            color: #333;
        }
    </style>
    
    
  <link id="tema-estilo" rel="stylesheet" href="">

</head>

<body>
    <header id="topo">
        <div class="header-top">


      


              <div class="header-content">
            
                <img src="<?= HOME_ASSETS ?>imgs/logo2.png" class="logo2">
            </div>
            <div class="header-content">
            
                <img src="<?= HOME_ASSETS ?>imgs/logo.png" alt="Logo SimulaEtec" class="logo">
            </div>

            <div class="login-box">
                <h3 class="login-title">Entrar</h3>
                <form class="login-form" action="<?= BASE_URL ?>login" method="post">
                    <input type="text" placeholder="Login" class="login-input" required>
                    <input type="password" placeholder="Senha" class="login-input" required>
                    <button type="submit" class="login-button">Entrar</button>
                </form>
                <a href="<?= BASE_URL ?>?page=cadastro" class="register-link">Criar nova conta</a>
            </div>

            <div class="categories-container">
                <nav class="categories-nav">
                    <ul class="categories-list">
                        <li class="category-item">
                            <a class="texto-simulado"href="<?= BASE_URL ?>?page=menuprovas" class="category-link">Simulado</a>
                        </li>
                        <li class="category-item">
                            <a href="https://www.cps.sp.gov.br/etec/vestibulinho/" class="category-link" target="_blank">Provas Anteriores</a>
                        </li>
                        <li class="category-item">
                             <a href="https://descomplica.com.br/blog/dicas-de-estudo/" class="category-link" target="_blank">Guia de Estudos</a>
                        </li>
                        <li class="category-item">
                            <a href="<?= BASE_URL ?>login" class="category-link">Login</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <div class="floating-menu">
        <ul class="floating-menu-a">
            <li><a href="#topo">SIMULADO ETEC</a></li>
            <li><a href="#meio">SOBRE O SIMULAETEC</a></li>
            <li><a href="#final">COMO FUNCIONA</a></li>
            <button onclick="trocarEstilo()">Trocar Estilo</button>
        </ul>
    </div>


    <div class="container">


        <div class="intro scroll-reveal">
            <img src="<?= HOME_ASSETS ?>imgs/imgvestbulinho.png" width="600" height="400" alt="Vestibulinho">
            <div class="texto">
                <h2>SIMULADO Etec</h2>
                <p>Prepare-se para o vestibulinho das Etecs com nosso simulado online. Tenha acesso a questões similares às das provas reais e melhore seu desempenho.</p>
            </div>
        </div>

        <div class="sobre scroll-reveal scroll-right" id="meio">
            <div class="texto">
                <h2>SOBRE O SIMULADO</h2>
                <p>Nosso simulado foi desenvolvido com base nas provas anteriores dos vestibulinhos, oferecendo uma experiência realista de teste.</p>
            </div>
            <img src="<?= HOME_ASSETS ?>imgs/imgvestibulinho2.png" width="900" height="900" alt="Estudantes">
        </div>

        <div class="sobre scroll-reveal" id="final">
        <img src="<?= HOME_ASSETS ?>imgs/imgvestibulinho1.png" alt="Simulado">
            <div class="texto">
                <h2>COMO FUNCIONA</h2>
                <p>Cadastre-se, escolha o semestre da prova, inície a prova e responda as questões e acompanhe seu desempenho e estatisticas em seu perfil</p>
            </div>
        </div>
         

    </div>



    <div class="footer">
        <p>SimulaEtec © <?= date('Y') ?> - Todos os direitos reservados</p>
    </div>
 

</body>

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

  // ========== SCROLL REVEAL ==========
  function setupScrollReveal() {
    const elements = document.querySelectorAll(".scroll-reveal");
    let lastScrollTop = window.scrollY;

    function revealOnScroll() {
      const currentScrollTop = window.scrollY;
      const windowHeight = window.innerHeight;
      const middleScreen = windowHeight / 2;

      elements.forEach((element) => {
        const elementTop = element.getBoundingClientRect().top;
        const elementBottom = element.getBoundingClientRect().bottom;

        if (elementTop < middleScreen && elementBottom > middleScreen) {
          element.classList.add("show");
        } else if (currentScrollTop < lastScrollTop) {
          element.classList.remove("show");
        }
      });

      lastScrollTop = currentScrollTop;
    }

    window.addEventListener("scroll", revealOnScroll);
    revealOnScroll();
  }

  // ========== LOGIN BOX ==========
  function setupLoginBox() {
    const loginLink = document.querySelector('.category-item:last-child .category-link');
    
    if (loginLink) {
      const toggleLoginBox = (e) => {
        e.preventDefault();
        const loginBox = document.querySelector('.login-box');
        if (loginBox) {
          loginBox.classList.toggle('show');
          
          if (loginBox.classList.contains('show')) {
            setTimeout(() => {
              document.addEventListener('click', closeOnClickOutside);
            }, 10);
          } else {
            document.removeEventListener('click', closeOnClickOutside);
          }
        }
      };

      const closeOnClickOutside = (e) => {
        const loginBox = document.querySelector('.login-box');
        const isClickInside = loginBox.contains(e.target) || e.target === loginLink;
        
        if (!isClickInside && loginBox.classList.contains('show')) {
          loginBox.classList.remove('show');
          document.removeEventListener('click', closeOnClickOutside);
        }
      };

      loginLink.addEventListener('click', toggleLoginBox);
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
    // Força atualização do scroll reveal após mudança de tema
    if (typeof setupScrollReveal === 'function') {
      setupScrollReveal();
    }
  });
</script>






    
   
</body>
</html>