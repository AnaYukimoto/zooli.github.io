<?php
session_start(); // Inicie a sessão

// Verifique se o cliente está logado

if (isset($_SESSION['logado']) && $_SESSION['logado'] == true) {
    // Redirecionar para a página de login
    $id_cliente = $_SESSION['idCliente'];
    

    // Verifique se as datas foram enviadas pelo formulário
    if (isset($_POST['dataEntrada']) && isset($_POST['dataSaida'])) {
   
    // Conecte-se ao banco de dados (substitua as informações de acordo com o seu banco de dados)
    $conn = mysqli_connect('localhost', 'root', '', 'dbpets');

$idCuidadores = $_POST['cartid'];

      // Obtenha as datas de entrada e saída do formulário

      $HorarioInicial = isset($_POST['HorarioInicial']) ? $_POST['HorarioInicial'] : "";
      $dataEntrada = isset($_POST['dataEntrada']) ? $_POST['dataEntrada'] : "";
      $HorarioFinal = isset($_POST['HorarioFinal']) ? $_POST['HorarioFinal'] : "";
      $dataSaida = isset($_POST['dataSaida']) ? $_POST['dataSaida'] : "";
      $TotalCuidadores = isset($_POST['total_cuidador']) ? $_POST['total_cuidador'] : "";
      $TotalCuidadores = isset($_POST['total_cuidador']) ? $_POST['total_cuidador'] : "";


       // Converta as datas para o formato adequado antes de inserir no banco de dados
       $dataEntradaFormatada = date('d/m/Y', strtotime($dataEntrada));
       $dataSaidaFormatada = date('d/m/Y', strtotime($dataSaida));

           
        

// Resto do código para inserir os dados no banco de dados

        // Verificar conexão
        if ($conn->connect_error) {
            die("Falha na conexão: " . $conn->connect_error);
        }


        // Inserir as datas no banco de dados, associando ao ID do cliente
        $sql = "INSERT INTO tb_contratar_cuidador (ID_CLIENTE, PERIODO_INICIO_CONTRATAR_CUIDADOR, DTA_INICIO_CONTRATAR_CUIDADOR, PERIODO_FIM_CONTRATAR_CUIDADOR, DTA_FIM_CONTRATAR_CUIDADOR, VALOR_CONTRATAR_CUIDADOR, ID_CUIDADOR) 
        VALUES ('$id_cliente', '$HorarioInicial', '$dataEntradaFormatada', '$HorarioFinal', '$dataSaidaFormatada', '$TotalCuidadores', '$idCuidadores')";
        


        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Agora realize o pagamento'); window.location.href='PagamentoCuidador.php';</script>";

        } else {
            echo "Erro ao finalizar a compra: " . $conn->error;
        }

        $conn->close();
    }
}
else {
    header("Location: login.php");
    exit();
}
?>
