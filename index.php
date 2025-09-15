<?php
// Configuração de erros
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Inicia a sessão
session_start();

// Verifica se há mensagem de erro de login na sessão
if (isset($_SESSION['login_error'])) {
    $mensagem = $_SESSION['login_error'];
    unset($_SESSION['login_error']); // Remove a mensagem após usar
} else {
    $mensagem = null;
}

// Definição das constantes
$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https://" : "http://";
$project_folder = 'simulaetec'; 

// URLs IMPORTANTES!
define('BASE_URL', $protocol . $_SERVER['HTTP_HOST'] . '/' . $project_folder . '/');
define('PUBLIC_URL', BASE_URL . 'public/');
define('ROOT_PATH', realpath(__DIR__) . DIRECTORY_SEPARATOR);

// Caminhos para assets
define('ASSETS_URL', PUBLIC_URL . 'assets/');
define('HOME_ASSETS', ASSETS_URL . 'home/');
define('CADASTRO_ASSETS', ASSETS_URL . 'cadastro/');
define('PERFIL_ASSETS', ASSETS_URL . 'perfil/');
define('MENUPROVAS_ASSETS', ASSETS_URL . 'menuprovas/');
define('BLOQMENUPROVAS_ASSETS', ASSETS_URL . 'bloqmenuprovas/');
define('PROVABLOQ_ASSETS', ASSETS_URL . 'provabloq/');
define('PROVADEMO_ASSETS', ASSETS_URL . 'provademo/');
define('PROVA1_ASSETS', ASSETS_URL . 'prova1/');
define('PROVA2_ASSETS', ASSETS_URL . 'prova2/');
define('PROVA3_ASSETS', ASSETS_URL . 'prova3/');

// Inclui os controladores necessários
require_once ROOT_PATH . 'app/controllers/AuthController.php';
require_once ROOT_PATH . 'app/controllers/CadastroController.php';
require_once ROOT_PATH . 'app/controllers/respostas_prova1Controller.php';
require_once ROOT_PATH . 'app/controllers/respostas_prova2Controller.php';
require_once ROOT_PATH . 'app/controllers/respostas_prova3Controller.php';


// Rotas
$page = $_GET['page'] ?? 'home';
$allowedPages = ['home', 'guia', 'cadastro','perfil','menuprovas', 'bloqmenuprovas','provabloq','provademo','salvar_desempenho_prova1', 'salvar_desempenho_prova2','salvar_desempenho_prova3','prova1', 'prova2', 'prova3', 'login', 'logout'];



// Verifica se a página é permitida
if (!in_array($page, $allowedPages)) {
    header("HTTP/1.0 404 Not Found");
    require ROOT_PATH . "app/views/404.php";
    exit();
}
$paginasProtegidas = ['perfil', 'menuprovas', 'prova1', 'prova2', 'prova3'];
// Verificação centralizada para páginas protegidas
if (in_array($page, $paginasProtegidas) && !isset($_SESSION['user_id'])) {
    // Se tentar acessar prova demo sem login, vai para login
    if ($page === 'provademo') {
        header("Location: " . BASE_URL . "?page=login");
        exit();
    }
    // Para outras provas, mostra a versão bloqueada
    header("Location: " . BASE_URL . "?page=provabloq");
    exit();
}

// Tratamento especial para rotas de autenticação (importante!)

switch ($page) {
    case 'bloqmenuprovas':
    // Se o usuário estiver logado, redireciona para menuprovas
    if (isset($_SESSION['user_id'])) {
        header("Location: " . BASE_URL . "?page=menuprovas");
        exit();
    }
    // Se não estiver logado, mostra a página bloqmenuprovas normalmente
    require ROOT_PATH . "app/views/bloqmenuprovas.php";
    break;
    case 'cadastro':
        $controller = new CadastroController();
        if (isset($_POST['nome']) && isset($_POST['email'])) {
            $resultado = $controller->cadastrar();
            $mensagem = $resultado['mensagem'] ?? null;
            $nomeAluno = $resultado['nome'] ?? null;
            $emailAluno = $resultado['email'] ?? null;
            $senhalAluno = $resultado['senha'] ?? null;
        }
        require ROOT_PATH . "app/views/cadastro.php";
        break;

case 'salvar_desempenho_prova1':
    $controller = new respostas_prova1Controller();
    $controller->salvarDesempenho();
    exit(); 
     break;

case 'salvar_desempenho_prova2':
    $controller = new respostas_prova2Controller();
    $controller->salvarDesempenho();
    exit();
    break;

case 'salvar_desempenho_prova3':
    $controller = new respostas_prova3Controller();
    $controller->salvarDesempenho();
    exit();    

    case 'perfil':
        // Protege a página de perfil
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "?page=login");
            exit();
        }
        require ROOT_PATH . "app/views/perfil.php";
        break;

        
      case 'login':
    $controller = new AuthController();
    $mensagem = $controller->login();

    // Redireciona de volta para home com mensagem de erro se houver
    if ($mensagem && strpos($mensagem, 'inválido') !== false) {
        $_SESSION['login_error'] = $mensagem;
        header("Location: " . BASE_URL . "?page=home");
        exit();
    } else {
        // Se o login for bem sucedido, redireciona para o perfil
        header("Location: " . BASE_URL . "?page=perfil");
        exit();
    }
    break;

case 'logout':
    $controller = new AuthController();
    $controller->logout();
    break;
    
default:
    // Verifica se a página precisa de autenticação
    if (in_array($page, $paginasProtegidas) && !isset($_SESSION['user_id'])) {
        header("Location: " . BASE_URL . "?page=login");
        exit();
    }

    require ROOT_PATH . "app/views/{$page}.php";
    break;

}


