<?php
//conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbpets";
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se a conexão foi bem sucedida
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Executa a consulta SQL para obter os dados dos cuidadores e o nome do cliente
$sql = "SELECT c.ID_CUIDADOR, c.VALOR_CUIDADOR,c.IMAGEM_CUIDADOR, c.DESCRICAO_CUIDADOR, cl.NOME_CLIENTE 
        FROM tb_cuidador AS c
        INNER JOIN tb_cliente AS cl 
        ON c.ID_CLIENTE = cl.ID_CLIENTE";
       
$result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        // Verifica se a imagem existe e codifica em base64 apenas se estiver presen
        $cuidadores[] = $row;
    }


$conn->close();


echo json_encode($cuidadores);
?>
