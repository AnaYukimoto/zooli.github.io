<?php
session_start();

if (isset($_SESSION['logado']) && $_SESSION['logado'] == true) {
    // Redirecionar para a página de login
    $idcliente = $_SESSION['idCliente'];
    echo"<script> alert('Você já está logado!')
    window.location.href='home.php'</script>";
}

if (isset($_REQUEST['valor']) && $_REQUEST['valor'] == 'enviado') {
    $emailCliente = $_POST['emailCliente'];
    $senhaCliente = $_POST['senhaCliente'];

    // Acesso ao banco de dados
    $conexao = mysqli_connect('localhost', 'root', '', 'dbpets');
    $consulta = "SELECT * FROM tb_cliente WHERE EMAIL_CLIENTE = '$emailCliente'";
    $resultado = $conexao->query($consulta) or trigger_error($conexao->error);

    // Verificando
    if ($resultado->num_rows == 1) {
        $row = $resultado->fetch_assoc();
        $hashSenha = $row['SENHA_CLIENTE'];
    // Obtenha o ID_CLIENTE a partir do resultado da consulta


    // Armazena o ID do cliente na sessão para uso posterior
    $_SESSION['idCliente'] =  $row['ID_CLIENTE'];
        if (password_verify($senhaCliente, $hashSenha)) {
            $_SESSION['logado'] = true;

        
            echo "<script>alert('Bem-vindo');window.location.href='home.php';</script>";
        } else {
            echo "<script>alert('Por favor, verifique o email e a senha digitados!'); window.location.href='login.php';</script>";
        }
    } else {
        echo "<script>alert('Por favor, verifique o email e a senha digitados!'); window.location.href='login.php';</script>";
    }

    $conexao->close();
} else {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="icon" type="icon" href="img/fotinho.png"/>
</head>
<body>
    <div class="overlay">
        <form action="login.php?valor=enviado" method="post">
           <div class="con">
            <header class="head-form">
                <a href="index.php"><img src="img/ZOOLI.png" alt="zoo" width="30%"></a>
                <p>Entre utilizando seu Email e sua Senha</p>
            </header>
                <input class="form-input" name="emailCliente" id="emailCliente" type="email" placeholder="📧 Digite seu Email...">
                <br>
                <input id="senhaCliente" type="password" inputmode="numeric" minlength="4" maxlength="8" size="8" name="senhaCliente" placeholder="🔒 Digite sua Senha..." class="form-input">
                <br>
                <button class="log-in" href="">
                    Entrar<input type="submit" id="logarCliente" name="logarClienter">
                </button>
                <button class="submits frgt-pass"><a href="esqueciSenha.php" rel="esqueci">Esqueci minha Senha</a></button>
                <button class="submits sign"><a href="cadastroCliente.php" rel="Cadastrar-se"> Cadastrar-se</a></button>
                
          </div>
        </form>
    </div>
</body>
</html>
<?php
}
?>
