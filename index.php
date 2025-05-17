<?php
// Configuração de erros
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Definição das constantes
$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https://" : "http://";
$project_folder = 'simulaetec'; 

// URLs base
define('BASE_URL', $protocol . $_SERVER['HTTP_HOST'] . '/' . $project_folder . '/');
define('PUBLIC_URL', BASE_URL . 'public/');
define('ROOT_PATH', realpath(__DIR__) . DIRECTORY_SEPARATOR);

// Caminhos para assets
define('ASSETS_URL', PUBLIC_URL . 'assets/');
define('HOME_ASSETS', ASSETS_URL . 'home/');
define('CADASTRO_ASSETS', ASSETS_URL . 'cadastro/');
define('MENUPROVAS_ASSETS', ASSETS_URL . 'menuprovas/');
define('PROVA1_ASSETS', ASSETS_URL . 'prova1/');
define('PROVA2_ASSETS', ASSETS_URL . 'prova2/');
define('PROVA3_ASSETS', ASSETS_URL . 'prova3/');

// Rotas
$page = $_GET['page'] ?? 'home';
$allowedPages = ['home',  'guia', 'cadastro','menuprovas','prova1','prova2','prova3']; // Adicione as novas páginas

if (in_array($page, $allowedPages)) {
    require ROOT_PATH . "app/views/{$page}.php";
} else {
    header("HTTP/1.0 404 Not Found");
    require ROOT_PATH . "app/views/404.php";
}



?>

