<?php
session_start();

if (isset($_SESSION['logadoAdm']) && $_SESSION['logadoAdm'] == true) {
    // Redirecionar para a página de login
    echo "<script> alert('Você já está logado!'); window.location.href = 'cadastrosAdm.php'</script>";
} elseif (isset($_POST['logarAdm'])) {
    $emailAdm = $_POST['emailAdm'];
    $senhaAdm = $_POST['senhaAdm'];
    
    if (!empty($emailAdm) && !empty($senhaAdm)) {
        // Acesso ao banco de dados
        $conexaoAdm = new MySQLi('localhost', 'root', '', 'dbpets');
        $emailAdm = $_POST['emailAdm'];
        $senhaAdm = $_POST['senhaAdm'];
        $consultaAdm = "SELECT * FROM tb_usuario_adm WHERE EMAIL_USUARIO_ADM = '$emailAdm' AND SENHA_USUARIO_ADM = '$senhaAdm'";
        $resultadoAdm = $conexaoAdm->query($consultaAdm) or trigger_error($conexaoAdm->error);
        
        // Verificando
        if (mysqli_num_rows($resultadoAdm) < 1) {
            echo "<script>alert('Usuário não encontrado!');window.location.href = 'loginAdm.php';</script>";
        } else {
            echo "<script>alert('Bem-vindo'); window.location.href = 'cadastrosAdm.php';</script>";
            $_SESSION['logado'] = true;
        }
        
        $conexaoAdm->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Login Admin</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="icon" type="icon" href="img/fotinho.png"/>
</head>
<body>
    <div class="overlay">
        <form action="loginAdm.php" method="post">
            <div class="con">
                <header class="head-form">
                    <img src="img/ZOOLI.png" alt="zoo" width="40%">
                    <p>Entre utilizando seu Email e sua Senha</p>
                </header>
                <input class="form-input" name="emailAdm" id="emailAdm" type="email" placeholder="📧 Digite seu Email">
                <br>
                <input type="password" inputmode="numeric" minlength="4" maxlength="8" size="8" id="senhaAdm" name="senhaAdm" placeholder="🔒 Digite sua Senha" class="form-input">
                <br>
                <button class="log-in" type="submit" name="logarAdm">Entrar</button>
                <button class="Adm"><a href="esqueciSenha.php" rel="esqueci">Esqueci minha Senha</a></button>
            </div>
        </form>
    </div>
</body>
</html>
