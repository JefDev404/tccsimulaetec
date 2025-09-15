<?php
require_once __DIR__ . '/../model/Usuario.php';

class AuthController {

    public function login() {
        // Garante que a sessão foi iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';

            $userId = Usuario::autenticar($email, $senha);
            
            if ($userId) {
                // Garante sessão segura
                session_regenerate_id(true); // Evita fixação de sessão

                $_SESSION['user_id'] = $userId;

                header("Location: " . BASE_URL . "?page=perfil");
                exit();
            } else {
                return "E-mail ou senha inválidos.";
            }
        }
        return null;
    }

    public function logout() {
        // Inicia a sessão caso ainda não esteja
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Limpa todas as variáveis da sessão
        $_SESSION = [];

        // Remove o cookie de sessão
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Destroi a sessão
        session_destroy();

        // Redireciona para a página inicial
        header("Location: " . BASE_URL . "?page=home");
        exit();
    }
}
