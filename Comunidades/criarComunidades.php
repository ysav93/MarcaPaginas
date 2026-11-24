<?php
 session_start();
    include ('../BD/conexao.php');

    if(!isset($_SESSION['idUsuario'])){
header("Location:../usuarios/login.php");
exit;
    }
    if(isset($_POST['criar'])){
        $nome=$_POST['descricao'];
        $convite=$_POST['conviteGeral'];

        $idUsuario=$_SESSION['idUsuario'];

        $sql="INSERT INTO comunidades
        (nome,descricao,conviteGeral,Usuario_IdUsuario)
        VALUES (?,?,?,?)";

        $stmt=$conexao -> prepare($sql);
        $stmt -> bind_param("ssii",$nome,$descricao,$convite,$idUsuario);

        if($stmt->execute()){
          
        $idComunidade = $conexao->insert_id;

       
        $sql2 = "INSERT INTO Usuario_Entra_Comunidade
                 (comunidade_idComunidade, Usuario_IdUsuario)
                 VALUES (?, ?)";

        $stmt2 = $conexao->prepare($sql2);
        $stmt2->bind_param("ii", $idComunidade, $idUsuario);
        $stmt2->execute();

        header("Location: listar.php");
        exit;

    }  
        }
    

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Isometra&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Isometra&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #fff8e7;
            margin: 0;
            padding: 0;
        }
        /* Cabeçalho */
        
        #cabecalhoCadastro {
            margin: 100px 30px 30px;
        }
        
        #titulo {
            font-family: "Isometra", serif;
            color: #751020;
            margin: 0;
        }
        /* Formulário */
        
        #formulario {
            background-color: white;
            border: 2px solid #751020;
            border-radius: 15px;
            padding: 30px;
            width: 100%;
            max-width: 600px;
            margin: 0 auto 40px;
        }
        
        .form-label {
            color: #751020;
            margin-bottom: 8px;
        }
        
        .form-control {
            border: 1px solid #d9a3ae;
            border-radius: 8px;
            background-color: #fffdf9;
            padding: 10px;
        }
        
        .form-control:focus {
            border-color: #751020;
            box-shadow: 0 0 0 0.2rem rgba(117, 16, 32, 0.15);
        }
        
        .input-group-text {
            background-color: #f8ccd7;
            color: #751020;
            border-color: #d9a3ae;
        }
        /* Botão */
        
        #botaoCadastrar {
            display: flex;
            justify-content: flex-end;
            margin-top: 25px;
        }
        
        .botoes {
            min-width: 120px;
            height: 50px;
            padding: 5px 15px;
            border: 2px solid #751020;
            border-radius: 30px;
            background-color: #f8ccd7;
            color: #751020;
            font-family: "Isometra", serif;
            cursor: pointer;
            transition: 0.2s;
        }
        
        .botoes:hover {
            background-color: #751020;
            color: white;
        }
        /* Responsividade */
        
        @media (max-width: 500px) {
            #cabecalhoCadastro {
                margin: 90px 15px 25px;
            }
            #formulario {
                width: calc(100% - 30px);
                padding: 20px 15px;
                margin-bottom: 25px;
            }
            #titulo {
                font-size: 22px;
            }
            .input-group-text {
                font-size: 13px;
            }
            .form-control {
                min-width: 0;
                font-size: 14px;
            }
            .botoes {
                height: 45px;
                min-width: 110px;
                font-size: 13px;
            }
        }
    </style>
</head>

<body>
    <div id="cabecalhoCadastro">
        <h3 id="titulo">Criar Comunidade</h3>
    </div>

    <!-- Formulário de cadastro -->

    <form id="formulario" method="POST" action="criarComunidades.php">

        <div class="mb-4">
            <label for="tituloLivro" class="form-label">
                Nome da comunidade
            </label>

            <input type="text" 
            class="form-control"
             id="nome"
              name="nome"
               placeholder="Digite o nome da comunidade" 
               required>
        </div>

        <div class="mb-4">
            <label for="urlCapa" class="form-label">
                URL da imagem da comunidade:
            </label>

            <input type="url"
             class="form-control"
              id="imagem"
               name="imagem" 
               placeholder="https://exemplo.com/capa.jpg" required>
        </div>

        <div class="mb-4">
            <label for="autor" class="form-label">
                breve descrição:
            </label>
<textarea
 class="form-control"
  id="descricao"
   name="descricao"
    placeholder="Digite sua descrição"
     required
></textarea>
            
        </div>



        <div id="botaoCadastrar">
            <button type="submit" class="botoes" >
                Criar
            </button>
        </div>

    </form>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
   
</script>

</html>
 
