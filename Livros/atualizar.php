<?php
    include ('cadastro_atualizacao.php');
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Atualizar Livro</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Isometra&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Isometra&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styleAtualizar.css">
    
</head>

<body>

    <!-- Título da página -->
    <div id="cabecalhoCadastro">
        <h3 id="titulo">Atualizar Livro</h3>
    </div>

    <!-- Formulário de cadastro -->
    <form id="formulario" method="post">

        <div class="mb-4">
            <label for="tituloLivro" class="form-label">
                Nome do livro:
            </label>
            <input type="text" class="form-control" id="tituloLivro" name="tituloLivro" placeholder="Digite o nome do livro" required>
        </div>

        <div class="mb-4">
            <label for="urlCapa" class="form-label">
                URL da capa do livro:
            </label>
            <input type="url" class="form-control" id="urlCapa" name="urlCapa" placeholder="https://exemplo.com/capa.jpg" required>
        </div>

        <div class="mb-4">
            <label for="autor" class="form-label">
                Autor do livro:
            </label>
            <input type="text" class="form-control" id="autor" name="autor" placeholder="Digite o nome do autor" required>
        </div>

        <div class="mb-4">
            <label for="editora" class="form-label">
                Editora do livro:
            </label>
            <input type="text" class="form-control" id="editora" name="editora" placeholder="Digite o nome do autor" required>
        </div>

        <div class="mb-3">
            <label for="paginas" class="form-label">
                Número de páginas:
            </label>
            <input type="number" class="form-control" id="paginas" name="paginas" placeholder="Digite o número de páginas" min="1" required>
        </div>
        
        <div class="mb-3">
            <label for="paginas" class="form-label">
                Total de páginas lidas:
            </label>
            <input type="number" class="form-control" id="paginas" name="paginas" placeholder="Digite o número de páginas" min="1" required>
        </div>

        <div class="mb-4">
            <label for="estadoLivro" class="form-label">
                Estado do livro:
            </label>
            <select class="form-select" id="estadoLivro" name="estadoLivro" required>
                <option value="" selected disabled>Selecione o estado do livro</option>
                <option value="lido">Lido</option>
                <option value="lendo">Lendo</option>
                <option value="queroLer">Quero ler</option>
            </select>
        </div>

        <div id="avaliacao">
            <div class="estrelas">
                <input type="radio" id="estrela1" name="avaliacao" value="1">
                <label for="estrela1">&#9733;</label>

                <input type="radio" id="estrela2" name="avaliacao" value="2">
                <label for="estrela2">&#9733;</label>

                <input type="radio" id="estrela3" name="avaliacao" value="3">
                <label for="estrela3">&#9733;</label>

                <input type="radio" id="estrela4" name="avaliacao" value="4">
                <label for="estrela4">&#9733;</label>

                <input type="radio" id="estrela5" name="avaliacao" value="5">
                <label for="estrela5">&#9733;</label>
            </div>
        </div>

        <div id="botaoCadastrar">
            <button type="submit" class="botoes">
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