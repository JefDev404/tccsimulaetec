<?php

$dadosDesempenho = Usuario::buscarEstatisticasDesempenho($_SESSION['user_id']);
$estatisticas = $dadosDesempenho['estatisticas'];
$provas = $dadosDesempenho['provas'];

// Cálculos de porcentagem
$totalQuestoes = $estatisticas['total_questoes'] ?? 0;
$taxaAcertos = $totalQuestoes > 0 ? round(($estatisticas['total_acertos'] / $totalQuestoes) * 100) : 0;
$taxaErros = $totalQuestoes > 0 ? round(($estatisticas['total_erros'] / $totalQuestoes) * 100) : 0;

// Inicia a sessão com segurança
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
  header("Location: " . BASE_URL . "?page=login");
  exit();
}

// Carrega a classe de usuário
require_once __DIR__ . '/../../app/model/Usuario.php';

try {
  // Busca os dados do usuário autenticado
  $usuario = Usuario::buscarPorId($_SESSION['user_id']);

  if (!$usuario) {
    // Redireciona para logout se o usuário não for encontrado (evita sessão zumbi)
    header("Location: " . BASE_URL . "?page=logout");
    exit();
  }
} catch (Exception $e) {
  // Em produção, você pode logar o erro ao invés de exibir diretamente
  die("Erro ao carregar o perfil. Tente novamente mais tarde.");
}

?>

<!-- HTML da página de perfil -->

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
        <a href="<?= BASE_URL ?>?page=logout" class="category-link">Home</a>
        </li>
        <li class="category-item">
          <a href="<?= BASE_URL ?>?page=bloqmenuprovas" class="category-link1">Provas anteriores</a>
        </li>
       
      </ul>
    </nav>


    <div class="login-container">
    <a href="<?= BASE_URL ?>?page=logout" class="category-link">Sair</a>
      <img src="<?= HOME_ASSETS ?>imgs/iconp.png" alt="Ícone de perfil" class="icon-img">
    </div>

  </div>
</header>



  <div class="container">

    <div class="intro scroll-reveal">
      <div class="container-perfil">
        <div class="intro scroll-reveal">
          <div class="profile-container">




            <!-- Cabeçalho do perfil -->
            <div class="profile-header">
              <div class="profile-picture-container">
                <img id="user-photo" src="<?= ASSETS_URL ?>imgs/avatar-default.png" alt="Foto do usuário" class="profile-picture">
              </div>
              <div class="profile-name-container">
                <h1 id="user-name" class="profile-name">
                  <?= htmlspecialchars($usuario['nome'] ?? 'Usuário') ?>
                </h1>
                <p class="profile-member-since">
                  Membro desde: <?= date('d/m/Y', strtotime($usuario['criado_em'])) ?>
                </p>
              </div>
            </div>


            <!-- Estatísticas do usuário -->
            <div class="profile-stats">
              <div class="stats-grid">
                <!-- Card 1 - Provas realizadas -->
                <div class="stat-card">
                  <div class="stat-icon">
                    <i class="fas fa-clipboard-list"></i>
                  </div>
                  <div class="stat-info">
                    <h3>Provas Realizadas</h3>
                    <p id="exams-taken" class="stat-value"><?= $estatisticas['total_provas'] ?? 0 ?></p>
                  </div>
                </div>



                <!-- Card 2 - Tempo médio -->
                <div class="stat-card">
                  <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                  </div>
                  <div class="stat-info">
                    <h3>Tempo Médio</h3>

                    <p id="average-time" class="stat-value"><?= isset($estatisticas['tempo_medio']) ? round($estatisticas['tempo_medio'] / 60) . ' min' : '0 min' ?></p>
                  </div>
                </div>

                <!-- Card 3 - Acertos -->
                <div class="stat-card">
                  <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                  </div>
                  <div class="stat-info">
                    <h3>Taxa de Acertos</h3>

                    <p id="correct-answers" class="stat-value"><?= $taxaAcertos ?>%</p>
                  </div>
                </div>

                <!-- Card 4 - Erros -->
                <div class="stat-card">
                  <div class="stat-icon">
                    <i class="fas fa-times-circle"></i>
                  </div>
                  <div class="stat-info">
                    <h3>Taxa de Erros</h3>
                    <p id="wrong-answers" class="stat-value"><?= $taxaErros ?>%</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Tabela de desempenho por prova -->
            <div class="exams-performance">
              <h2>Desempenho por Prova</h2>
              <div class="table-responsive">
                <table class="performance-table">
                  <thead>
                    <tr>
                      <th>Prova</th>
                      <th>Data</th>
                      <th>Acertos</th>
                      <th>Erros</th>
                      <th>Tempo</th>
                      <th>Pontuação</th>
                    </tr>
                  </thead>
                  <tbody id="exams-performance-data">
                  <tbody id="exams-performance-data">
                    <?php if (count($provas) === 0): ?>
                      <tr>
                        <td colspan="6">Nenhuma prova realizada ainda.</td>
                      </tr>
                    <?php else: ?>

                      <?php
                      // Associação manual entre ID da prova e semestre correspondente
                      $semestres = [
                        'Prova 1' => '1º Semestre 2025',
                        'Prova 2' => '2º Semestre 2024',
                        'Prova 3' => '1º Semestre 2024',
                        // adicione mais conforme criar novas provas
                      ];
                      ?>

                      <?php foreach ($provas as $prova): ?>
                        <tr>
                          <td><?= $semestres[$prova['prova']] ?? 'Prova Desconhecida' ?></td>
                          <td><?= date('d/m/Y H:i', strtotime($prova['data_execucao'])) ?></td>
                          <td><?= $prova['acertos'] ?></td>
                          <td><?= $prova['erros'] ?></td>
                          <td><?= gmdate("H\h i\m s\s", $prova['tempo_gasto']) ?></td>
                          <td><?= $prova['pontuacao'] ?></td>
                        </tr>
                      <?php endforeach; ?>

                    <?php endif; ?>


                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="sobre scroll-reveal scroll-right" id="meio">

    </div>



    <div class="sobre scroll-reveal" id="final">

    </div>


  </div>



<footer class="footer">
  <div class="footer-container">
  <div class="footer-bottom">
    <p>© 2025 ETEC Itanhaém. Todos os direitos reservados.</p>
  </div>
</footer>


</body>

<script>
  // ========== CONFIGURAÇÃO DOS TEMAS ==========
  const ASSETS_BY_PAGE = {
    'home': "<?= HOME_ASSETS ?>",
    'cadastro': "<?= CADASTRO_ASSETS ?>",
    'menuprovas': "<?= MENUPROVAS_ASSETS ?>",
    'perfil': "<?= PERFIL_ASSETS ?>",
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









</body>

</html>