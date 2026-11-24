<?php

include("../BD/conexao.php");

// Verifica se o usuário está logado
if (!isset($_SESSION['idUsuario'])) {
    header("Location: ../usuarios/login.php");
    exit;
}

$idUsuario = $_SESSION['idUsuario'];

// Busca as comunidades
$sql = "SELECT comunidades.*,
        usuario.nome AS criador,

        (SELECT COUNT(*)
         FROM Usuario_Entra_Comunidade
         WHERE comunidade_idComunidade = comunidades.id
        ) AS participantes,

        (SELECT COUNT(*)
         FROM Usuario_Entra_Comunidade
         WHERE comunidade_idComunidade = comunidades.id
         AND Usuario_IdUsuario = ?) AS participa

        FROM comunidades

        INNER JOIN usuario
        ON comunidades.Usuario_IdUsuario = usuario.id";

$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $idUsuario);
$stmt->execute();

$resultado = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Comunidades</title>

    <link href="https://fonts.googleapis.com/css2?family=Isometra&family=Bebas+Neue&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

     <link rel="stylesheet" href="styleComunidades.css">
</head>

<body>

    <div id="cabecalho">

        <h2 id="titulo">Comunidades</h2>

        <a href="criar.php" id="botaoCriar">
            Criar comunidade
        </a>

    </div>


    <div class="container mb-5">

        <div class="row g-4">

            <?php if ($resultado->num_rows > 0) { ?>

                <?php while ($comunidade = $resultado->fetch_assoc()) { ?>

                    <div class="col-md-6 col-lg-4">

                        <div class="card-comunidade">

                            <?php if (!empty($comunidade['imagem'])) { ?>

                                <img
                                    src="<?php echo htmlspecialchars($comunidade['imagem']); ?>"
                                    alt="Imagem da comunidade"
                                >

                            <?php } else { ?>

                                <div style="height:180px; background-color:#f8ccd7;"
                                class="d-flex justify-content-center align-items-center">

                                    <span style="color:#751020;">
                                        Sem imagem
                                    </span>

                                </div>

                            <?php } ?>


                            <div class="p-3">

                                <h5>
                                    <?php echo htmlspecialchars($comunidade['nome']); ?>
                                </h5>

                                <p>
                                    <?php echo htmlspecialchars($comunidade['descricao']); ?>
                                </p>

                                <p>
                                    Criador:
                                    <?php echo htmlspecialchars($comunidade['criador']); ?>
                                </p>

                                <p>
                                    Participantes:
                                    <?php echo $comunidade['participantes']; ?>
                                </p>


                                <?php if ($comunidade['participa'] > 0) { ?>

                                    <p>Você já participa desta comunidade!</p>

                                    <form action="sair.php" method="POST">

                                        <input type="hidden" name="id"
                                        value="<?php echo $comunidade['id']; ?>">

                                        <button type="submit" name="sair" class="botao">
                                            Sair
                                        </button>

                                    </form>

                                <?php } elseif ($comunidade['conviteGeral'] == 1) { ?>

                                    <form action="entrar.php" method="POST">

                                        <input type="hidden" name="id"
                                        value="<?php echo $comunidade['id']; ?>">

                                        <button type="submit" name="entrar" class="botao">
                                            Entrar
                                        </button>

                                    </form>

                                <?php } else { ?>

                                    <p>Comunidade restrita!</p>

                                <?php } ?>

                            </div>

                        </div>

                    </div>

                <?php } ?>

            <?php } else { ?>

                <div class="col-12 text-center">

                    <h5 style="color:#751020;">
                        Ainda não existem comunidades cadastradas.
                    </h5>

                </div>

            <?php } ?>

        </div>

    </div>

</body>
</html>
