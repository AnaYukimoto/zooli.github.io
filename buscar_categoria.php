<?php
//conexão do banco com o formulario
$conexao = mysqli_connect('localhost', 'root', '', 'dbpets');

// Verificar se a conexão foi bem sucedida
if (!$conexao) {
    die("Conexão falhou: " . mysqli_connect_error());
}

// Obter o ID da categoria via GET
$id = $_GET['id'];

// Consultar o banco de dados
$sql = "SELECT DESCRICAO_CATEGORIA FROM tb_categoria WHERE ID_CATEGORIA = $id";
$resultado = mysqli_query($conexao, $sql);

// Verificar se a consulta retornou resultados
if (mysqli_num_rows($resultado) > 0) {
    // Obter o nome da categoria e exibir na página
    $linha = mysqli_fetch_assoc($resultado);
    $nome_categoria = $linha['DESCRICAO_CATEGORIA'];
    echo $nome_categoria;
} else {
    echo "Categoria não encontrada.";
}

// Fechar a conexão com o banco de dados
mysqli_close($conexao);
?>
