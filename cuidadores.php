<?php
session_start();
// Autenticação bem-sucedida

if (isset($_SESSION['logado']) && $_SESSION['logado'] == true) {
    // Redirecionar para a página de login
    $_SESSION['idCliente'];
} else {
    header("Location: login.php");
    exit();
}

//conexão do banco com o formulario
$conn = mysqli_connect('localhost', 'root', '', 'dbpets');

// Verifique se a conexão foi bem sucedida
if (!$conn) {
    die('Erro ao conectar ao banco de dados: ' . mysqli_connect_error());
}

$query = "SELECT * FROM tb_cuidador";

$result = mysqli_query($conn, $query);

if ($result) {
} else {
    echo "Erro ao adicionar o cuidador! ";
}

if (!$result) {
    die('Erro ao executar a consulta: ');
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuidadores</title>
    <link rel="stylesheet" href="css/estilo.css">
    <link rel="stylesheet" href="css/cuidadores.css">
    <link rel="icon" type="icon" href="img/fotinho.png" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/scripts.js"></script>
    <script src="js/models.js"></script>
    <link href="" rel="shortcut icon">
</head>

<body>
    <header>
        <div class="header-content clearfix">
            <div class="logo">
                <img src="img/ZOOLI.png" alt="LOGO">
            </div>
            <nav>
                <ul>
                    <li><a href="home.php">Inicial</a></li>
                    <li><a href="cuidadores.php">Cuidadores</a></li>
                    <li><a href="produtos.php">Compras</a></li>
                    <li><a href="contato.php">Contato</a></li>
                    <li><a href="sair.php"><img src="img/icones/sair.png" width="25px" height="25px"></a></li>
                    <li>
                        <div class="menu-openner">
                            <span>0</span>
                            <span class="material-icons-outlined">pets</span>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="models">

        <?php

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="models-item">';
            echo '<a href="">';
            echo '<div class=""><img src="img/people/' . $row['IMAGEM_CUIDADOR'] . '" width="220" height="210"></div>';
            echo '<div class="models-item--add">+</div>';
            echo '</a>';
            echo '<div class="models-item--price">R$ --</div>';
            echo '<div class="models-item--name" id="nomeCuidador" name="nomeCuidador">--</div>';
            echo '<div class="models-item--desc">--</div>';
            echo '</div>';
        }

        ?>
        var_dump( $row['IMAGEM_CUIDADOR']);


        <div class="cart--item">
            <div class="cart--item-nome" id="nomeCuidador" name="nomeCuidador"></div>
            <div class="cart--item--qtarea">
                <div class="cart--item-qtmenos">voltar</div>
                <div class="cart--item--qt" style="display: none;"></div>

                <script>
                    document.getElementById("cart--item-qtmenos").addEventListener("click", () => {
                        saveCart();
                        window.location.href = 'cuidadores.php';

                    });
                </script>

                <script>
                    document.getElementById("cart--item-qtmais").addEventListener("click", () => {
                        saveCart();
                        window.location.href = 'cuidadores.php';

                    });
                </script>
            </div>
        </div>
    </div>

    <main>
        <div class="models-area"></div>
    </main>


    <aside>
        <div class="cart--area">
            <div class="menu-closer">
                <span class="material-icons">close</span>
            </div>
            <form action="finalizarCompraCuidadores.php" method="POST">
                <h1>Seus Pedidos</h1>
                <div class="cart"></div>
                <div class="cart--details">
                    <div class="cart--totalitem ">
                        Data de Entrada:
                        <div class="input-group w50">
                            <input type="date" id="dataEntrada" name="dataEntrada"></input>
                        </div>
                        Período de Entrada:
                        <div class="input-group w50">
                            <select name="HorarioInicial" id="HorarioInicial">
                                <option value="manha">Manhã</option>
                                <option value="tarde">Tarde</option>
                                <option value="noite">Noite</option>
                            </select>
                        </div>
                        Data de Saída:
                        <div class="input-group w50">
                            <input type="date" id="dataSaida" name="dataSaida"></input>
                        </div>
                        Período de Saída:
                        <div class="input-group w50">
                            <select name="HorarioFinal" id="HorarioFinal">
                                <option value="manha">Manhã</option>
                                <option value="tarde">Tarde</option>
                                <option value="noite">Noite</option>
                            </select>
                        </div>
                        <br>
                        <div class="Calculando" id="Calculando" name="Calculando">Calcular</div>

                        <p id="resultadodata" style="color: rgb(254, 1, 130);"></p>

                        <script>
                            document.getElementById("Calculando").addEventListener("click", function() {
                                const cartString = JSON.parse(localStorage.getItem('cart'));
                                const cartid = [];
                                for (var i = 0; i < cartString.length; i++) {
                                    var id = cartString[i].id;
                                    cartid.push(id);

                                }
                                document.getElementById("cartid").value = cartid;
                                var dataEntrada = new Date(document.getElementById("dataEntrada").value);
                                var dataSaida = new Date(document.getElementById("dataSaida").value);

                                var diferenca = dataSaida.getTime() - dataEntrada.getTime();
                                var dias = diferenca / (1000 * 3600 * 24); // Converter milissegundos em dias

                                document.getElementById("resultadodata").innerHTML = "A diferença é de " + dias + " dias.";

                                var total = parseFloat(document.querySelector('.cart--totalitem.total.big span:last-child').textContent.replace('R$ ', ''));
                                var resultadoMultiplicacao = total * dias;

                                document.querySelector('.cart--totalitem.total.big span:last-child').textContent = 'R$ ' + resultadoMultiplicacao.toFixed(2);
                                document.getElementById("total_cuidador").value = resultadoMultiplicacao;
                            });
                        </script>

                    </div>
                    <br>
                    <div class="cart--totalitem subtotal">
                        <span>Subtotal</span>
                        <span>R$ --</span>
                    </div>
                    <div class="cart--totalitem desconto">
                        <label for="coupon-code">Código do Cupom:</label>
                        <div class="input-group w50">
                            <input type="text" id="cupom" placeholder="Código do cupom">
                        </div>
                        <button type="button" name="aplicar-cupom-btn" id="aplicar-cupom-btn" class="Aplicar">Aplicar</button>
                        <p id="resultado" names="resultado"> Aceitamos só um cupom para cada compra! </p>
                        <span>Desconto</span>
                        <span>R$ --</span>
                    </div>
                    <div class="cart--totalitem total big">
                        <span>Total</span>
                        <span style="color: rgb(13, 184, 254); " id="TotalCuidadores" name="TotalCuidadores">R$ --</span>

                    </div>
                    <input type="number" id="total_cuidador" name="total_cuidador" style="display: none
                    ;">
                            <input type="TEXT" name="cartid" id="cartid" style="display: none;" >

                    <button type="submit" id="Finalizar" name="Finalizar" class="cart--finalizar">Finalizar a Compra</button>
                </div>
            </form>
        </div>
    </aside>
    <div class="modelsWindowArea">
        <div class="modelsWindowBody">
            <div class="modelsInfo--cancelMobileButton">Voltar</div>

            <div class="modelsInfo">
                <h1>--</h1>
                <div class="modelsInfo--desc">--</div>

                <div class="modelsInfo--pricearea">
                    <div class="modelsInfo--sector">Preço</div>
                    <div class="modelsInfo--price">
                        <div class="modelsInfo--actualPrice">R$ --</div>
                        <div class="modelsInfo--qtarea">
                            <button class="modelsInfo--qtmenos"></button>
                            <div class="modelsInfo--qt"></div>
                            <button class="modelsInfo--qtmais"></button>
                        </div>
                    </div>
                </div>
                <div class="modelsInfo--addButton">Contratar</div>
                <div class="modelsInfo--cancelButton">Cancelar</div>
            </div>
        </div>
    </div>

    <script src="js/cuidadores.js"></script>

</body>

</html>
<?php
mysqli_free_result($result);

mysqli_close($conn);
?>