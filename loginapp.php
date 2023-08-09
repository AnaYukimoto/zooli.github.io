<?php
$loginx = $_POST["usuario"];
$senhax = $_POST["senha"];

$con = mysqli_connect('localhost', 'root', '', 'dbpets');
$comando = "SELECT * FROM tb_cliente WHERE EMAIL_CLIENTE = '$loginx'";
$resulta = mysqli_query($con, $comando);

if ($resulta && mysqli_num_rows($resulta) == 1) {
    $row = mysqli_fetch_assoc($resulta);
    $hashSenha = $row['SENHA_CLIENTE'];

    if (password_verify($senhax, $hashSenha)) {
        $dados = array("status" => "ok", "EMAIL_CLIENTE" => $row['EMAIL_CLIENTE'], "SENHA_CLIENTE" => $row['SENHA_CLIENTE']);
    } else {
        $dados = array("status" => "error", "message" => "Invalid password");
    }
} else {
    $dados = array("status" => "error", "message" => "User not found");
}

mysqli_close($con);
echo json_encode($dados);
?>
