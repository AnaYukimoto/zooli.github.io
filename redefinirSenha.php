<?php
//conexão do banco com o formulario
$conn = mysqli_connect('localhost', 'root', '', 'dbpets');

// Processar o formulário
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = isset($_GET['email']) ? $_GET['email'] : "";
    $token = isset($_GET['token']) ? $_GET['token'] : "";
    $password = isset($_POST['senhaCliente']) ? $_POST['senhaCliente'] : "";

    // Verificar se o token de redefinição de senha é válido
    $sql = "SELECT * FROM tb_cliente WHERE EMAIL_CLIENTE = '$email' AND TOKEN_CLIENTE = '$token'";
    $resultado = mysqli_query($conn, $sql);

    if (mysqli_num_rows($resultado) == 1) {
        // Gerar o hash da nova senha
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Atualizar a senha do usuário no banco de dados
        $sql = "UPDATE tb_cliente SET SENHA_CLIENTE = '$password_hash', TOKEN_CLIENTE = NULL WHERE EMAIL_CLIENTE = '$email'";
        mysqli_query($conn, $sql);

        echo "Sua senha foi atualizada com sucesso.";
    } else {
        echo "Token inválido.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/form.css">
    <link rel="icon" type="icon" href="img/fotinho.png"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="js/scripts.js"></script>
    <title>Redefinir Senha</title>
</head>
<body>
    <div class="form-box">
        <h1>Redefinir Senha</h1>
        <h3>Preencha o campo para alterar a sua senha 😉</h3>
        <br>
        <form method="post" action="redefinirSenha.php?email=<?php echo $_GET['email']; ?>&token=<?php echo $_GET['token']; ?>">
            <div class="input-group">
                <label for="senhaCliente">Nova Senha:</label>
                <input type="password" name="senhaCliente" id="senhaCliente" placeholder="Digite uma nova senha" minlength="4" maxlength="8" size="8" required></input>
            </div>
            <br>
            <button class="buttonSenha" type="submit">Redefinir</button>
        </form>
        <br>
        Lembrou? <a href="login.php">Clique aqui</a> para logar!
    </div>
</body>
</html>
