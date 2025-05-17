<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulado - SimulaEtec</title>

    <link rel="stylesheet" href="<?= MENUPROVAS_ASSETS ?>styles/menustyle.css">

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
        // Configurações globais para o php com verificação
        window.SIMULAETEC_CONFIG = {
            ASSETS_URL: '<?= defined('ASSETS_URL') ? ASSETS_URL : '/public/assets/' ?>',
            PROVA_ASSETS: '<?= defined('PROVA_ASSETS') ? MENUPROVAS_ASSETS : '/public/assets/prova/' ?>',
            BASE_URL: '<?= defined('BASE_URL') ? BASE_URL : '/' ?>'
        };


        // teste Debug inicial
        console.log('Configurações:', window.SIMULAETEC_CONFIG);
    </script>

    <script src="<?= MENUPROVAS_ASSETS ?>scripts/script.js?v=<?= time() ?>"></script>
</body>

</html>