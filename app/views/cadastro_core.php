<?php
// Verifica se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Conecta ao banco de dados (crie este arquivo)
    require ROOT_PATH . 'app/config/database.php';
    
    // Processa os dados
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    $confirmar_senha = $_POST['confirmar_senha'];
    
    // Validações
    $errors = [];
    
    if (empty($nome)) $errors[] = "Nome é obrigatório";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "E-mail inválido";
    if (strlen($senha) < 6) $errors[] = "Senha deve ter pelo menos 6 caracteres";
    if ($senha !== $confirmar_senha) $errors[] = "As senhas não coincidem";
    
    if (empty($errors)) {
        // Verifica se email já existe
        // Insere no banco de dados
        // Redireciona para login com mensagem de sucesso
        header("Location: " . BASE_URL . "?page=login&registered=1");
        exit();
    } else {
        // Mostra erros
        $title = "Erro no Cadastro";
        require ROOT_PATH . 'app/views/layout/header.php';
        echo '<div class="container">';
        foreach ($errors as $error) {
            echo '<div class="alert error">' . $error . '</div>';
        }
        echo '<a href="' . BASE_URL . '?page=cadastro class="btn">Voltar</a>';
        echo '</div>';
        require ROOT_PATH . 'app/views/layout/footer.php';
    }
} else {
    header("Location: " . BASE_URL . "?page=cadastro");
    exit();
}