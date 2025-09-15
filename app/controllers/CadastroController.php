<?php

require_once __DIR__ . '/../model/Usuario.php';

class CadastroController
{
  
    
        public function cadastrar()
        {
            $nome = trim($_POST['nome'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $senha = $_POST['senha'] ?? '';
            $confirmar_senha = $_POST['confirmar_senha'] ?? '';
    
            $errors = [];
    
            // Validações básicas
            if (empty($nome)) {
                $errors[] = "Nome é obrigatório";
            }
    
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "formato de email inválido";
            }
    
            if (strlen($senha) < 6) {
                $errors[] = "Senha deve ter pelo menos 6 caracteres";
            }
    
            if ($senha !== $confirmar_senha) {
                $errors[] = "As senhas não coincidem";
            }
    
            // Se houver erros, mostra o alert e volta
            if (count($errors) > 0) {
                $mensagem = implode("\\n", $errors); // Quebra de linha no alert
                echo "<script>alert('Erro(s):\\n$mensagem'); window.history.back();</script>";
                exit();
            }
    
            // Se passou nas validações, tenta cadastrar
            try {
                $usuario = new Usuario($nome, $email, $senha);
                $resultado = $usuario->salvar();
    
                if ($resultado === true) {
                    echo "<script>alert('Usuário cadastrado com sucesso! Faça o login para continuar.'); window.location.href='" . BASE_URL . "?page=home';</script>";
                    exit();
                } elseif ($resultado === "EMAIL_DUPLICADO") {
                    echo "<script>alert('Erro: este email já está cadastrado!'); window.history.back();</script>";
                    exit();
                } else {
                    echo "<script>alert('Erro ao cadastrar: usuario e/ou email já cadastrados!'); window.history.back();</script>";
                    exit();
                }
    
            } catch (Exception $e) {
                echo "<script>alert('Erro no formato de email: " . addslashes($e->getMessage()) . "'); window.history.back();</script>";
                exit();
            }
        }
    
    
  
}    
