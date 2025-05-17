<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulado - SimulaEtec</title>

    <link rel="stylesheet" href="<?= PROVA3_ASSETS ?>styles/provastyle.css">

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



        .error-msg {
            color: #d9534f;
            text-align: center;
            margin-top: 10px;
            font-weight: bold;
        }
    </style>
</head>

<body onload="document.body.classList.add('loaded')">

    <div class="header-top">
        <div class="header-content">
            <a href="<?= BASE_URL ?>?page=home" class="category-link">
                <img src="<?= PROVA3_ASSETS ?>imgs/header.png" alt="Logo Simulado" class="logo">
            </a>
        </div>

        <p class="category-link">
            <span class="texto-simulado">SIMULADO DE PROVA 1ºsemestre/2024</span>
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


    <main class="main-content">
        <div class="exam-container">

            <!-- Área da questão com container  -->
            <div class="question-section animate-onload">
                <div class="prova-img">
                    <img id="questImage" src="<?= PROVA3_ASSETS ?>imgs/imgprova1/intro.png" alt="Questão">
                </div>
            </div>


            <div class="controls-section">
                <div id="timer" class="timer-display animate-onload">00:00:00</div>
                <button id="nextQuestBtn" class="animate-onload">PRÓXIMA QUESTÃO</button>
            </div>

            <!-- Seção de respostas -->
            <div class="answer-section">
                <div class="answer-form">
                    <p>RESPOSTA</p>
                    <form class="alternative-answers">
                        <div class="answer-option">
                            <input type="radio" id="option-a" name="answer" value="A">
                            <label for="option-a">(A)</label>
                        </div>
                        <div class="answer-option">
                            <input type="radio" id="option-b" name="answer" value="B">
                            <label for="option-b">(B)</label>
                        </div>
                        <div class="answer-option">
                            <input type="radio" id="option-c" name="answer" value="C">
                            <label for="option-c">(C)</label>
                        </div>
                        <div class="answer-option">
                            <input type="radio" id="option-d" name="answer" value="D">
                            <label for="option-d">(D)</label>
                        </div>
                        <div class="answer-option">
                            <input type="radio" id="option-e" name="answer" value="E">
                            <label for="option-e">(E)</label>
                        </div>
                    </form>

                    <button id="gerarBtn" onclick="gerarArquivo()" style="display: none;">GERAR ESTATÍSTICAS</button>
                    <div id="respostasPrint" style="display: none;"></div>
                    
                </div>

        

            </div>
        </div>


    </main>

    <div id="quiz"></div>


    <footer class="footer animate-onload">
        <p>SimulaEtec © <?= date('Y') ?></p>
    </footer>

    <script>
        // Configurações globais para o php com verificação
        window.SIMULAETEC_CONFIG = {
            ASSETS_URL: '<?= defined('ASSETS_URL') ? ASSETS_URL : '/public/assets/' ?>',
            PROVA3_ASSETS: '<?= defined('PROVA3_ASSETS') ? PROVA3_ASSETS : '/public/assets/prova/' ?>',
            BASE_URL: '<?= defined('BASE_URL') ? BASE_URL : '/' ?>'
        };


        // teste Debug inicial
        console.log('Configurações:', window.SIMULAETEC_CONFIG);
    </script>

    <script src="<?= PROVA3_ASSETS ?>scripts/script.js?v=<?= time() ?>"></script>
</body>

</html>