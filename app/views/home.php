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
    
    
    <link id="tema-estilo" rel="stylesheet" href="<?= HOME_ASSETS ?>css/styles.css">
    
    

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
                            <a href="<?= BASE_URL ?>?page=guia" class="category-link">Guia de Estudos</a>
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
                <p>Cadastre-se, escolha o semestre da prova, inície a prova e responda as questões e acompanhe seu desempenho e estatisticas em seu ferfil</p>
            </div>
        </div>
         

    </div>



    <div class="footer">
        <p>SimulaEtec © <?= date('Y') ?> - Todos os direitos reservados</p>
    </div>
 

</body>


<script>
  const HOME_ASSETS = "<?= HOME_ASSETS ?>";
  const temas = [
    "css/styles.css",
    "css/2stylesinvertido.css",
    "css/1styles.css"
    
  ];
  let indiceTema = 0;

  function trocarEstilo() {
    indiceTema = (indiceTema + 1) % temas.length;
    document.getElementById("tema-estilo").href = HOME_ASSETS + temas[indiceTema];
  }
</script>




    <script src="<?= HOME_ASSETS ?>scripts/script.js?v=<?= time() ?>"></script>
    
   
</body>
</html>