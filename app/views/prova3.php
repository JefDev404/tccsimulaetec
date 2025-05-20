<?php
// Configuração de erros
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
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



<body>
    <!-- CABEÇALHO FIXO -->
    <header>
          <div class="header-top">
            <div class="header-content">
                           <img src="<?= HOME_ASSETS ?>imgs/logo2.png" class="logo2">
            </div>
                <a href="<?= BASE_URL ?>?page=home" class="category-link">
                    <img src="<?= PROVA1_ASSETS ?>imgs/header.png" alt="Logo Simulado" class="logo">
                </a>
                 <p class="category-link">
                <span class="texto-simulado">SIMULADO DE PROVA 1º semestre/2024</span>
            </p>
            <div class="categories-container">
                <nav class="categories-nav">
                    <ul class="categories-list">
                        <li class="category-item">
                            <a href="<?= BASE_URL ?>?page=menuprovas" class="category-link">voltar</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
     
    </header>

    <div class="timer-box">   
         <div id="timer" class="timer-display animate-onload">00:00:00</div>
    </div>


    <!-- CONTEÚDO PRINCIPAL -->

    <main class="scrollable-content animate-onload" >
  
    <button id="start-btn" class="start-btn">Iniciar Prova</button>

        <section class="post-section" id="questions-container">

        </section>
        <button id="enviar-respostas" class="submit-btn">Enviar Respostas</button>
    </main>

    <footer class="site-footer">
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



 <script>
   document.addEventListener('DOMContentLoaded', function() {
    const config = window.SIMULAETEC_CONFIG || {};
    const PROVA3_ASSETS = config.PROVA3_ASSETS || '';

    const questionsContainer = document.getElementById('questions-container');
    const submitBtn = document.getElementById('enviar-respostas');
    const startBtn = document.getElementById('start-btn');
    const timerDisplay = document.getElementById('timer');

 // Lista de questões 
const questions = [
   
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/intro.png', requiresAnswer: false },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest1a2img.png', requiresAnswer: false},
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest1.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest2.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest3.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest4.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest5a7img.png', requiresAnswer: false },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest5.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest6.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest7.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest8.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest9a11img.png', requiresAnswer: false },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest9.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest10.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest11.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest12.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest13a15img.png', requiresAnswer: false },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest13.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest14.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest15.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest16a17img.png', requiresAnswer: false },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest16.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest17.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest18.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest19a21img.png', requiresAnswer: false },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest19.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest20.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest21.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest22.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest23.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest24.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest25.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest25a27img.png', requiresAnswer: false },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest26.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest27.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest28a29img.png', requiresAnswer: false },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest28.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest29.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest30.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest31.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest32.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest33.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest34.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest35.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest36.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest37.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest38.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest39a42img.png', requiresAnswer: false },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest39.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest40.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest41.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest42.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest43.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest44.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest45.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest46.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest47.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest48.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest49.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/quest50.png', requiresAnswer: true },
         { image: PROVA3_ASSETS + '<?= PROVA3_ASSETS ?>imgs/imgprovas/gabarito.png', requiresAnswer: false }
];




     // Classe para criar questões
     class QuestionBuilder {
        constructor(questions) {
            this.questions = questions;
        }

        buildQuestions(container) {
            this.questions.forEach((question, index) => {
                const questaoNumero = index + 1;

                const article = document.createElement('article');
                article.classList.add('post');
                article.dataset.questao = questaoNumero;

                const postContent = document.createElement('div');
                postContent.classList.add('post-content');

                const img = document.createElement('img');
                img.src = question.image;
                img.alt = `Questão ${questaoNumero}`;
                img.classList.add('quest-image');
                postContent.appendChild(img);

                article.appendChild(postContent);

                if (question.requiresAnswer) {
                    const answerSection = document.createElement('div');
                    answerSection.classList.add('answer-section');

                    const form = document.createElement('form');
                    form.id = `form-questao-${questaoNumero}`;
                    form.classList.add('alternative-answers');

                    const options = ['A', 'B', 'C', 'D', 'E'];

                    options.forEach((option) => {
                        const answerOption = document.createElement('div');
                        answerOption.classList.add('answer-option');

                        const input = document.createElement('input');
                        input.type = 'radio';
                        input.id = `option-${option.toLowerCase()}-${questaoNumero}`;
                        input.name = `answer-${questaoNumero}`;
                        input.value = option;

                        const label = document.createElement('label');
                        label.setAttribute('for', input.id);
                        label.textContent = `(${option})`;

                        answerOption.appendChild(input);
                        answerOption.appendChild(label);

                        form.appendChild(answerOption);
                    });

                    answerSection.appendChild(form);
                    article.appendChild(answerSection);
                }

                container.appendChild(article);
            });
        }

        renderAllQuestions(container) {
            this.buildQuestions(container);
        }
    }

    class Timer {
    constructor(displayElement) {
        this.display = displayElement;
        this.totalTime = 14400; // 4 horas em segundos (60*60*4)
        this.initialTime = this.totalTime;
        this.interval = null;
        this.timeExpired = false;
    }
    
    start() {
        if (!this.interval) {
            this.interval = setInterval(() => this.update(), 1000);
        }
    }
    
    stop() {
        clearInterval(this.interval);
        this.interval = null;
    }
    
    update() {
        const hours = Math.floor(this.totalTime / 3600);
        const minutes = Math.floor((this.totalTime % 3600) / 60);
        const seconds = this.totalTime % 60;
        
        this.display.textContent = 
            `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        
        // Atualiza a cor conforme o tempo restante
        const percentage = this.totalTime / this.initialTime;
        
        if (percentage <= 0.1) {
            this.display.style.color = "red";
        } else if (percentage <= 0.5) {
            this.display.style.color = "yellow";
        } else {
            this.display.style.color = "green  rgb(6, 243, 6)";
        }
        
        // Verifica se o tempo acabou
        if (this.totalTime <= 0 && !this.timeExpired) {
            this.timeExpired = true;
            this.stop();
            this.display.textContent = "Tempo excedido";
            this.display.style.color = "red";
            // Aqui você pode adicionar outras ações quando o tempo acabar
        } else {
            this.totalTime--;
        }
    }
    
    reset() {
        this.stop();
        this.totalTime = this.initialTime;
        this.timeExpired = false;
        this.display.style.color = "green";
        this.update();
    }
}

    // Classe para gerenciar o simulado
    class SimuladoManager {
        constructor(questions, container, submitButton, startButton, timer) {
            this.questions = questions;
            this.container = container;
            this.submitButton = submitButton;
            this.startButton = startButton;
            this.timer = timer;
            this.questionBuilder = new QuestionBuilder(questions);
            this.respostas = [];
            this.started = false;
        }

        init() {
            // Mostra apenas a primeira questão inicialmente
            this.renderFirstQuestionOnly();
            this.setupEventListeners();
        }

        renderFirstQuestionOnly() {
            // Limpa o container
            this.container.innerHTML = '';
            
            // Cria apenas a primeira questão
            const firstQuestion = [this.questions[0]];
            const tempBuilder = new QuestionBuilder(firstQuestion);
            tempBuilder.buildQuestions(this.container);
            
            // Esconde o botão de enviar respostas inicialmente
            this.submitButton.style.display = 'none';
        }

        startSimulado() {
            if (this.started) return;
            
            this.started = true;
            
            // Esconde o botão de iniciar
            this.startButton.style.display = 'none';
            
            // Mostra o botão de enviar respostas
            this.submitButton.style.display = 'block';
            
            // Renderiza todas as questões
            this.container.innerHTML = '';
            this.questionBuilder.renderAllQuestions(this.container);
            
            // Inicia o timer
            this.timer.start();
        }

        setupEventListeners() {
            this.submitButton.addEventListener('click', () => this.processarRespostas());
            this.startButton.addEventListener('click', () => this.startSimulado());
        }

        processarRespostas() {
            this.respostas = [];
            this.container.querySelectorAll('[data-questao]').forEach(questao => {
                const numQuestao = questao.dataset.questao;
                if (!numQuestao) return;

                const formId = `form-questao-${numQuestao}`;
                const form = document.getElementById(formId);
                let resposta = null;

                if (form) {
                    const checkedInput = form.querySelector('input[type="radio"]:checked');
                    resposta = checkedInput ? checkedInput.value : null;
                }

                this.respostas.push({
                    questao: numQuestao,
                    resposta: resposta
                });
            });

            console.log('Respostas:', this.respostas);
            //  enviar as respostas para o servidor
        }
    }

    // Inicializa o simulado
    const timer = new Timer(timerDisplay);
    const simulado = new SimuladoManager(
        questions, 
        questionsContainer, 
        submitBtn, 
        startBtn,
        timer
    );
    simulado.init();
});
</script>




   
</body>
</html>
