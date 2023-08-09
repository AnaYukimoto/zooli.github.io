<?php
// Conexão com o banco de dados
$conn = new mysqli("localhost", "id20884837_root", "Zooli+pets123", "id20884837_dbpets");

// Verificar se a conexão foi estabelecida corretamente
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// Consulta para obter os produtos do banco de dados, incluindo o token
$query = "SELECT c.descricao_categoria, p.valor_promocao, p.TOKEN_PROMOCAO
          FROM tb_promocao p
          INNER JOIN tb_categoria c ON p.id_categoria = c.id_categoria";
$result = $conn->query($query);

// Array para armazenar os produtos
$produtos = array();

// Loop através dos resultados e adicionar ao array
while ($row = $result->fetch_assoc()) {
    $nome = $row["descricao_categoria"] . " " . $row["valor_promocao"];
    $token = $row["TOKEN_PROMOCAO"];

    $produto = array(
        "nome" => $nome,
        "token" => $token
    );
    array_push($produtos, $produto);
}

// Converter o array em JSON e retornar como resposta
header("Content-Type: application/json");
echo json_encode($produtos);

// Fechar a conexão com o banco de dados
$conn->close();
?>
