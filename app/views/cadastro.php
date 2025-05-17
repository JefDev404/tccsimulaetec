<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulado - SimulaEtec</title>

    <link rel="stylesheet" href="<?= CADASTRO_ASSETS ?>/css/cadastrostyle.css">

    <style>
        @font-face {
            font-family: 'orbital';
            src: url('<?= HOME_ASSETS ?>fonts/Orbitron-VariableFont_wght.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
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
                <img src="<?= CADASTRO_ASSETS ?>imgs/logo.png" alt="Logo Simulado" class="logo">
            </a>
        </div>

        <p class="category-link">
            <span class="textocad">CADASTRO</span>
        </p>

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



    <main class="main-content animate-onload">

        <div class="container animate-onload">
            <h1>Cadastro de Usuário</h1>

            <?php if (isset($_GET['success']) && $_GET['success'] == '1'): ?>
                <p class="success">Cadastro realizado com sucesso!</p>
            <?php endif; ?>

            <form action="processa_cadastro.php" method="POST">
                <div class="form-group">
                    <label for="nome">Nome Completo:</label>
                    <input type="text" id="nome" name="nome" required>
                </div>

                <div class="form-group">
                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha" required>
                </div>

                <div class="form-group">
                    <label for="confirmar_senha">Confirmar Senha:</label>
                    <input type="password" id="confirmar_senha" name="confirmar_senha" required>
                </div>

                <button class="btn-submit" type="submit">Cadastrar</button>
            </form>
        </div>

    </main>



    <footer class="footer">
        <p>SimulaEtec © <?= date('Y') ?></p>
    </footer>



</body>

</html>