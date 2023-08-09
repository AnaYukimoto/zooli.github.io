<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
if (isset($_REQUEST['valor']) && $_REQUEST['valor'] == 'enviado') {


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
    // Após autenticar o usuário e obter os valores de id_cuidador e id_cliente

    

    $_SESSION['idCliente'];

    // Consulta o banco de dados para obter o email do cuidador com base no ID do cuidador
    $queryClientePet = "SELECT c.EMAIL_CLIENTE, t.NOME_TUTORPET, t.IDADE_TUTORPET, t.RACA_TUTORPET, t.PESO_TUTORPET, t.DESCRICAO_TUTORPET
                    FROM tb_cliente c
                    JOIN tb_tutor t ON c.ID_CLIENTE = t.ID_CLIENTE
                    WHERE c.ID_CLIENTE = ?";

        $stmt = mysqli_prepare($conn, $queryClientePet);
        mysqli_stmt_bind_param($stmt, "i", $idCliente);
        mysqli_stmt_execute($stmt);

        $emailResultClientePet = mysqli_stmt_get_result($stmt);

        if ($emailResultClientePet) {
            if (mysqli_num_rows($emailResultClientePet) > 0) {
                $emailRowClientePet = mysqli_fetch_assoc($emailResultClientePet);

                $destinatarioClientePet = $emailRowClientePet['EMAIL_CLIENTE'];
                $nomePet = $emailRowClientePet['NOME_TUTORPET'];
                $idadePet = $emailRowClientePet['IDADE_TUTORPET'];
                $racaPet = $emailRowClientePet['RACA_TUTORPET'];
                $pesoPet = $emailRowClientePet['PESO_TUTORPET'];
                $descricaoPet = $emailRowClientePet['DESCRICAO_TUTORPET'];

            if (!empty($destinatarioCuidador)) {
                // Enviar o email para o cuidador
                try {
                    $mail->addAddress($destinatarioCuidador);
                    $mail->Subject = 'Novo Cliente';
                    $mail->Body    = "Aqui estão os dados do seu cliente pet:<br>Nome do pet: $nomePet<br>Idade do pet: $idadePet<br>Raça do pet: $racaPet<br>Peso do pet: $pesoPet<br>Descrição do pet: $descricaoPet";
                    $mail->AltBody = "Nome do Pet: $nomePet\nIdade do pet: $idadePet\nRaça do pet: $racaPet\nPeso do pet: $pesoPet\nDescrição do pet: $descricaoPet";
                    $mail->send();

                    echo "<script>alert('Pagamento realizado com sucesso!'); window.location.href='avaliacao.php';</script>";
                } catch (Exception $e) {
                    echo "Falha ao enviar o email: {$mail->ErrorInfo}";
                }
            } else {
                echo "O email do cuidador não está definido.";
            }
        } else {
            echo "Nenhum resultado encontrado para o ID do cliente: $idCliente";
        }
    } else {
        echo "Erro na consulta SQL: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
}
}

else{
?>

<!DOCTYPE html>
<html>
<head>

    <link rel="stylesheet" href="css/estilo.css">
    <link rel="stylesheet" href="css/form.css">
    <link rel="icon" type="icon" href="img/fotinho.png"/>
    <script src="js/scripts.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <title>Pagamento</title>
</head>
<body>
    <div class="responsive-bar">
        <div class="logo">
          <img src="img/ZOOLI.png" alt="LOGO" >
        </div>
        <div class="menu">
          <h1>≡</h1>
        </div>            
        </div>
      
    
    </div>
    <script>
    


</script>
    <form method="POST" action="PagamentoCuidador.php?valor=enviado" class="form-box">
    <h2>Preencha os Dados de Pagamento:</h2>
    <br>
        <div class="input-group">
        <label for="numero_cartao">Número do Cartão:</label>
        <input type="text" name="numero_cartao" id="numero_cartao" placeholder="0000.0000.0000.0000" maxlength="17"required ><br>
        </div>

        <div class="input-group">
        <label for="nome_titular">Nome do Titular:</label>
        <input type="text" name="nome_titular" id="nome_titular" placeholder="Digite o Nome do Titular..." required><br>
        </div>
        
        <div class="input-group">
        <label for="validade_cartao">Validade do Cartão:</label>
        <input type="month" name="validade_cartao" id="validade_cartao" required><br>
        </div>
        
        <div class="input-group">
        <label for="codigo_seguranca" >Código de Segurança:</label>
        <input type="text" name="codigo_seguranca" id="codigo_seguranca" placeholder="CVC" minlength="3" maxlength="5" required><br>
        </div>

      
        <?php

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "dbpets";

        // Estabelecer conexão
        $conn = mysqli_connect($servername, $username, $password, $dbname);

        // Verificar a conexão
        if (!$conn) {
            die("Falha na conexão: " . mysqli_connect_error());
        }

        // Executar a consulta
        $query = "SELECT * FROM tb_contratar_cuidador";
        $result = mysqli_query($conn, $query);
        if ($row = mysqli_fetch_assoc($result)) {
            echo '<span style="color:rgb(13, 184, 254);">Total da compra: R$ </span>' . $row['VALOR_CONTRATAR_CUIDADOR'];
        }

        // Fechar a conexão
        mysqli_close($conn);
        ?>
        <br>
        <input type="submit" value="Pagar"><button class="button"  style="font-size: 16px;" > Realizar Pagamento</button></input>
    </form>
  
</body>
</html>
<?php }
?>