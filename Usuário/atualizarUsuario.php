<?php
    include ('atualizacaoUsuario.php');
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Atualizar perfil</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Isometra&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Isometra&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../Livros/styleAtualizar.css">
    
</head>

<body>

    <!-- Título da página -->
    <div id="cabecalhoCadastro">
        <h3 id="titulo">Atualizar Perfil</h3>
    </div>

    <!-- Formulário de cadastro -->
    <form id="formulario" method="post">

        <div class="mb-4">
            <label for="nome" class="form-label">
                Nome:
            </label>
            <input type="text" class="form-control" id="nome" name="nome" 
                placeholder="Digite seu nome" value="<?php echo $usuario['nome']; ?>" required>
        </div>

        <div class="mb-4">
            <label for="usuario" class="form-label">
                Nome de usuário:
            </label>
            <input type="text" class="form-control" id="usuario" name="usuario" 
                placeholder="Digite seu nome de usuário" value="<?php echo $usuario['nomeDeUsuario']; ?>" required>
        </div>

        <div class="mb-4">
            <label for="email" class="form-label">
                E-mail:
            </label>
            <input type="text" class="form-control" id="email" name="email"
                placeholder="Digite seu e-mail" value="<?php echo $usuario['email']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="senha" class="form-label">
                Senha (nova ou atual):
            </label>
            <input type="number" class="form-control" id="senha" name="senha" 
                placeholder="Digite o número de páginas" value="" min="1" required>
        </div>

        <div id="atualizar">
            <button name="atualizar" type="submit" class="botoes">
                Atualizar
            </button>
        </div>

    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
        function atualizar() {
            window.history.back;
        }
    </script>

</body>

</html>