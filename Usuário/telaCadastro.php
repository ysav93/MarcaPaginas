<?php
    include 'cadastro.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cadastrar Usuário</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Isometra&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Isometra&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styleCadUser.css">
    
</head>

<body>


    <!-- Título da página -->
    <div id="cabecalhoCadastro">
        <h3 id="titulo">Cadastrar Usuario</h3>
    </div>

    <!-- Formulário de cadastro -->
        <form id="formulario" method="POST">

        <div class="mb-4">
            <label for="nomeUsuario" class="form-label">
                Nome:
            </label>
            <input type="text" class="form-control" id="nomeUsuario" name="nome" placeholder="Digite o nome do usuario" required>
        </div>

        <div class="mb-4">
            <label for="nomeUser" class="form-label">
                Nome de Usuario:
            </label>
            <input type="text" class="form-control" id="nomeUser" name="usuario" placeholder="Digite o nome do usuario" required>
        </div>

        <div class="mb-4">
            <label for="emailUsuario" class="form-label">
                Email do usuario:
            </label>
            <input type="email" class="form-control" id="emailUsuario" name="email" placeholder="Digite seu email" required>
        </div>

        <div class="mb-3">
            <label for="senha" class="form-label">Senha</label>
            <input type="password" class="form-control" id="senha" name="senha" placeholder="Digite sua senha" required>
        </div>

        <div id="botaoCadastrar">
            <button type="submit" name="cadastrar" class="botoes">
                Cadastrar
            </button>
        </div>

    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>