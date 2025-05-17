<?php
require_once __DIR__ . '/../models/UserModel.php';

class AuthController {
    private $userModel;
    
    public function __construct() {
        $this->userModel = new UserModel();
    }
    
    public function showRegisterForm() {
        require_once __DIR__ . '/../views/cadastro.php';
    }
    
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = trim($_POST['nome']);
            $email = trim($_POST['email']);
            $senha = $_POST['senha'];
            $confirmar_senha = $_POST['confirmar_senha'];
            
            // Validações
            if ($senha !== $confirmar_senha) {
                return $this->showRegisterFormWithError("As senhas não coincidem");
            }
            
            if (strlen($senha) < 6) {
                return $this->showRegisterFormWithError("A senha deve ter pelo menos 6 caracteres");
            }
            
            if ($this->userModel->emailExists($email)) {
                return $this->showRegisterFormWithError("Este e-mail já está cadastrado");
            }
            
            // Cadastrar usuário
            $success = $this->userModel->createUser($nome, $email, $senha);
            
            if ($success) {
                header("Location: /login?registered=1");
                exit();
            } else {
                $this->showRegisterFormWithError("Erro ao cadastrar. Tente novamente.");
            }
        }
    }
    
    private function showRegisterFormWithError($error) {
        $error = $error;
        require_once __DIR__ . '/../views/cadastro.php';
    }
}