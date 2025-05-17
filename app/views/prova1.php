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
    <link rel="stylesheet" href="<?= PROVA1_ASSETS ?>styles/prova1style.css">
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
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
    </style>
</head>
<body>
    <!-- CABEÇALHO FIXO -->
    <header>
        <div class="header-top">
            <div class="header-content">
                <a href="<?= BASE_URL ?>?page=home" class="category-link">
                    <img src="<?= PROVA1_ASSETS ?>imgs/header.png" alt="Logo Simulado" class="logo">
                </a>
            </div>
            <p class="category-link">
                <span class="texto-simulado">SIMULADO DE PROVA 1º semestre/2025</span>
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
   document.addEventListener('DOMContentLoaded', function() {
    const config = window.SIMULAETEC_CONFIG || {};
    const PROVA1_ASSETS = config.PROVA1_ASSETS || '';

    const questionsContainer = document.getElementById('questions-container');
    const submitBtn = document.getElementById('enviar-respostas');
    const startBtn = document.getElementById('start-btn');
    const timerDisplay = document.getElementById('timer');

    // Lista de questões
    const questions = [
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/intro.png', requiresAnswer: false },        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest1.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest2.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest3.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest4.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest5.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest6.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest7img.png', requiresAnswer: false },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest7.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest8.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest9.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest10.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest11.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest12a15img.png', requiresAnswer: false },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest12.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest13.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest14.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest15.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest16.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest17.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest18.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest19.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest20.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest21.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest22.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest23.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest24.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest25a26img.png', requiresAnswer: false },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest25.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest26.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest27.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest28a29img.png', requiresAnswer: false },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest28.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest29.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest30.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest31.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest32.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest33.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest34.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest35a36img.png', requiresAnswer: false },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest35.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest36.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest37.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest38.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest39a42img.png', requiresAnswer: false },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest39.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest40.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest41.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest42.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest43.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest44.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest45.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest46a49img.png', requiresAnswer: false },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest46.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest47.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest48.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest49.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/quest50.png', requiresAnswer: true },
        { image: PROVA1_ASSETS + '<?= PROVA1_ASSETS ?>imgs/imgprovas/gabarito.png', requiresAnswer: false }
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
