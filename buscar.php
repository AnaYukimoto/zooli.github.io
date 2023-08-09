<?php
//conexão do banco com o formulario
$conn = mysqli_connect('localhost', 'root', '', 'dbpets');

// Verifica se a conexão foi bem sucedida
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Executa a consulta SQL para obter os dados do cupom
$sql = "SELECT ID_PROMOCAO, ID_USUARIO_ADM, ID_CATEGORIA, TOKEN_PROMOCAO, VALIDADE_PROMOCAO, VALOR_PROMOCAO, STATUS_PROMOCAO FROM tb_promocao WHERE STATUS_PROMOCAO <> 'Expirado';";
$result = $conn->query($sql);
$cupom = array();

while ($row = $result->fetch_assoc()) {
    $cupom[] = $row;
     
            
}

// Fecha a conexão com o banco de dados
$conn->close();
// Converte o array em JSON e retorna
echo json_encode($cupom);

?>