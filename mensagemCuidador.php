<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->SMTPDebug = 0;
$mail->Host = 'smtp.office365.com';
$mail->Port = 587;
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth = true;

$mail->Username = 'zooli.pets@hotmail.com';
$mail->Password = 'Zooli+pet';
$mail->setFrom('zooli.pets@hotmail.com', 'Zooli');

// Conexão do banco com o formulário
$conn = mysqli_connect('localhost', 'root', '', 'dbpets');

// Processar o formulário
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtém os dados do formulário
    $numeroCartao = $_POST['numero_cartao'];
    $nomeTitular = $_POST['nome_titular'];
    $validadeCartao = $_POST['validade_cartao'];
    $codigoSeguranca = $_POST['codigo_seguranca'];

    // Obtém o ID do cliente (exemplo: 1)
    $idCliente = 1;

    // Consulta o banco de dados para obter o email do cuidador com base no ID do cliente
    $sql = "SELECT EMAIL_CLIENTE
            FROM tb_cliente
            WHERE ID_CLIENTE = $idCliente";
    $resultado = mysqli_query($conn, $sql);

    if (mysqli_num_rows($resultado) == 1) {
        $dados = mysqli_fetch_assoc($resultado);
        $destinatario = $dados['EMAIL_CUIDADOR'];

        if (!empty($destinatario)) {
            // Enviar o email para o cuidador
            try {
                $mail->addAddress($destinatario);
                $mail->Subject = 'Informações do Tutor';
                $mail->Body    = "Número do Cartão: $numeroCartao<br>Nome do Titular: $nomeTitular<br>Validade do Cartão: $validadeCartao<br>Código de Segurança: $codigoSeguranca";
                $mail->AltBody = "Número do Cartão: $numeroCartao\nNome do Titular: $nomeTitular\nValidade do Cartão: $validadeCartao\nCódigo de Segurança: $codigoSeguranca";
                $mail->send();

                echo "<script>alert('Pagamento realizado com sucesso!'); window.location.href='avaliacao.php';</script>";
            } catch (Exception $e) {
                echo "Falha ao enviar o email: {$mail->ErrorInfo}";
            }
        } else {
            echo "O email do cuidador não está definido.";
        }
    } else {
        echo "Não foi possível obter o email do cuidador.";
    }
}
?>
