<?php
session_start(); 
if (isset($_SESSION['logado']) && $_SESSION['logado'] == true) {
  $idcliente = $_SESSION['idCliente'];

if(isset($_REQUEST['boleto']) and ($_REQUEST['boleto'] == 'confirmado')){


  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "dbpets";
  
  $conn = new mysqli($servername, $username, $password, $dbname);

  $valortotal = $_POST['real'];
  $valorfrete = $_POST['valorfrete'];
  $cartid = explode(',', $_POST['cartid']);
  $quantidade = explode(',', $_POST['cartQt']);

  $Nomes = explode(',',  $_POST['cartNames']);
  $datadia = date('Y-m-d H:i:s');

  $cartDesconto = $_POST['cartDesconto'];
  $CartToken = $_POST['cartToken'];

  // criando a conexão com o banco de dados
  $numeroBoleto = '';

  for ($i = 0; $i < 44; $i++) {
      $numeroBoleto .= rand(0, 9);
  }

  $dataAtual = date('Y-m-d');

// verifica se houve algum erro na conexão
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// consulta o endereço do cliente na tabela tb_cliente
$query = "SELECT RUA_ENDERECO_CLIENTE,CEP_ENDERECO_CLIENTE,NUM_ENDERECO_CLIENTE,BAIRRO_ENDERECO_CLIENTE, CIDADE_ENDERECO_CLIENTE, UF_ENDERECO_CLIENTE,COMP_ENDERECO_CLIENTE  FROM tb_endereco_cliente WHERE ID_CLIENTE = $idcliente";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    // obtém o resultado da consulta
    $row = $result->fetch_assoc();

    // Salva todas as colunas retornadas em uma variável chamada $endereço
    $endereco_cliente = $row['RUA_ENDERECO_CLIENTE'] . ', ' . $row['NUM_ENDERECO_CLIENTE'] . ', ' . $row['BAIRRO_ENDERECO_CLIENTE'] . ', ' . $row['CIDADE_ENDERECO_CLIENTE'] . ', ' . $row['UF_ENDERECO_CLIENTE'] . ', ' . $row['COMP_ENDERECO_CLIENTE'];


    // insere o endereço na tabela tb_pedido_venda
    $query = "INSERT INTO tb_pedido_venda (ID_CLIENTE, DATA_VENDA, ENDERECO_VENDA, PGTO_VENDA, CONDICAO_VENDA, CUPOM_VENDA, DESCONTO_VENDA, STATUS_VENDA, VALOR_VENDA, VALOR_FRETE_VENDA, EMPRESA_ENTREGA_VENDA)
    VALUES ('$idcliente', '$datadia', '$endereco_cliente', 'boleto', 'à vista', '$CartToken', '$cartDesconto', 'pago', '$valortotal', '$valorfrete', 'Zooli transporte')";
    $result = $conn->query($query);

    if ($result === TRUE) {
        $ID_PEDIDO_VENDA = $conn->insert_id;

        if (is_array($cartid)) {
          // Loop para inserir os itens do carrinho
          for ($i = 0; $i < count($cartid); $i++) {
              $currentCartId = $cartid[$i];
              $currentQuantidade = $quantidade[$i];
      
              // Consulta para obter o preço individual do produto com base no ID
              $query = "SELECT VALOR_PROD FROM tb_prod WHERE ID_PROD = '$currentCartId'";
              $result = $conn->query($query);
      
              if ($result && $result->num_rows > 0) {
                  $row = $result->fetch_assoc();
                  $valorindividual = $row['VALOR_PROD'];
      
                  // Inserir o item do carrinho com o preço individual no banco de dados
                  $query = "INSERT INTO tb_item_venda (ID_PEDIDO_VENDA, ID_PROD, N_ITEM_PRODUTO, QTD_ITEM_PRODUTO, VALOR_ITEM_PRODUTO)
                  VALUES ('$ID_PEDIDO_VENDA', '$currentCartId', '$currentCartId', '$currentQuantidade', '$valorindividual')";
                  $result = $conn->query($query);}
      
              // Verificar se a inserção foi bem-sucedida
              if (!$result) {
                  $errorMessage = "Erro ao inserir dados na tabela tb_item_venda: " . $conn->error;
                  die($errorMessage);
              }
          }
      } else {
          $errorMessage = "O campo cartid não é um array.";
          die($errorMessage);
      }
      
      // Insere o boleto na tabela tb_boleto
      $query = "INSERT INTO tb_boleto (ID_PEDIDO_VENDA, DATA_BOLETO, VALOR_BOLETO, NUMERO_BOLETO, STATUS_BOLETO)
      VALUES ('$ID_PEDIDO_VENDA', '$dataAtual', '$valortotal', '$numeroBoleto', 'pago')";
      $result = $conn->query($query);
      
      // Verificar se a inserção foi bem-sucedida
      if ($result) {
        $query = "SELECT NOME_CLIENTE, CPF_CLIENTE FROM tb_cliente WHERE ID_CLIENTE = $idcliente";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
          // Iterar pelos resultados
          while ($row = $result->fetch_assoc()) {
              $nomeCliente = $row['NOME_CLIENTE'];
              $cpfCliente = $row['CPF_CLIENTE'];
         include 'pdf.php';
          }}
      } else {
          $errorMessage = "Erro ao inserir dados na tabela tb_boleto: " . $conn->error;
          die($errorMessage);
      }}
    
    
    }
$conn->close();


    }


elseif(isset($_REQUEST['cartao']) and ($_REQUEST['cartao'] == 'confirmado')){
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "dbpets";
  $conn = new mysqli($servername, $username, $password, $dbname);

  $valortotal = $_POST['real1'];
  $valorfrete = $_POST['valorfrete1'];
  $cartid = explode(',', $_POST['cartid1']);
  $quantidade = explode(',', $_POST['cartQt1']);
  $cartDesconto = $_POST['cartDesconto1'];
  $CartToken = $_POST['cartToken1'];
  $cardNumber =$_POST['cardNumber1'];
  $cardName =$_POST['cardName'];
  $cardExpireDate =$_POST['cardExpireDate'];
  $parcelar =$_POST['parcelar'];
  $cardSecurityCode =$_POST['cardSecurityCode'];
  $BANDEIRA_CARTAO=$_POST['BANDEIRA_CARTAO'];
  $datadia = date('Y-m-d H:i:s');

if ($conn->connect_error) {
  die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// consulta o endereço do cliente na tabela tb_cliente
$query = "SELECT RUA_ENDERECO_CLIENTE,CEP_ENDERECO_CLIENTE,NUM_ENDERECO_CLIENTE,BAIRRO_ENDERECO_CLIENTE, CIDADE_ENDERECO_CLIENTE, UF_ENDERECO_CLIENTE,COMP_ENDERECO_CLIENTE  FROM tb_endereco_cliente WHERE ID_CLIENTE = $idcliente";
$result = $conn->query($query);

if ($result->num_rows > 0) {
  // obtém o resultado da consulta
  $row = $result->fetch_assoc();

  // Salva todas as colunas retornadas em uma variável chamada $endereço
  $endereco_cliente = $row['RUA_ENDERECO_CLIENTE'] . ', ' . $row['NUM_ENDERECO_CLIENTE'] . ', ' . $row['BAIRRO_ENDERECO_CLIENTE'] . ', ' . $row['CIDADE_ENDERECO_CLIENTE'] . ', ' . $row['UF_ENDERECO_CLIENTE'] . ', ' . $row['COMP_ENDERECO_CLIENTE'];


  // insere o endereço na tabela tb_pedido_venda
  $query = "INSERT INTO tb_pedido_venda (ID_CLIENTE, DATA_VENDA, ENDERECO_VENDA, PGTO_VENDA, CONDICAO_VENDA, CUPOM_VENDA, DESCONTO_VENDA, STATUS_VENDA, VALOR_VENDA, VALOR_FRETE_VENDA, EMPRESA_ENTREGA_VENDA)
  VALUES ('$idcliente', '$datadia', '$endereco_cliente', 'cartão', '$parcelar', '$CartToken', '$cartDesconto', 'pago', '$valortotal', '$valorfrete', 'Zooli transporte')";
  $result = $conn->query($query);

  if ($result === TRUE) {
      $ID_PEDIDO_VENDA = $conn->insert_id;

      if (is_array($cartid)) {
        // Loop para inserir os itens do carrinho
        for ($i = 0; $i < count($cartid); $i++) {
            $currentCartId = $cartid[$i];
            $currentQuantidade = $quantidade[$i];
    
            // Consulta para obter o preço individual do produto com base no ID
            $query = "SELECT VALOR_PROD FROM tb_prod WHERE ID_PROD = '$currentCartId'";
            $result = $conn->query($query);
    
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $valorindividual = $row['VALOR_PROD'];
    
                // Inserir o item do carrinho com o preço individual no banco de dados
                $query = "INSERT INTO tb_item_venda (ID_PEDIDO_VENDA, ID_PROD, N_ITEM_PRODUTO, QTD_ITEM_PRODUTO, VALOR_ITEM_PRODUTO)
                VALUES ('$ID_PEDIDO_VENDA', '$currentCartId', '$currentCartId', '$currentQuantidade', '$valorindividual')";
                $result = $conn->query($query);}
    
            // Verificar se a inserção foi bem-sucedida
            if (!$result) {
                $errorMessage = "Erro ao inserir dados na tabela tb_item_venda: " . $conn->error;
                die($errorMessage);
            }
        }
    } else {
        $errorMessage = "O campo cartid não é um array.";
        die($errorMessage);
    }
    
    // Insere o boleto na tabela tb_boleto
    $query = "INSERT INTO tb_cartao_cliente (ID_CLIENTE, NUMERO_CARTAO, NOME_CARTAO, VALIDADE_CARTAO, CSV_CARTAO, BANDEIRA_CARTAO)
    VALUES ('$idcliente', '$cardNumber', '$cardName', '$cardExpireDate', '$cardSecurityCode', '$BANDEIRA_CARTAO')";
    $result = $conn->query($query);
    
    // Verificar se a inserção foi bem-sucedida
    if ($result) {
        // envia a resposta para o JavaScript
        $response = array("message" => "Dados entregues com sucesso!");
        echo json_encode($response);
    } else {
        $errorMessage = "Erro ao inserir dados na tabela tb_boleto: " . $conn->error;
        die($errorMessage);
    }}}
$conn->close();


}
else{
?>

<script>

const cartString = JSON.parse(localStorage.getItem('cart'));
const cartImages = JSON.parse(localStorage.getItem('cartImages'));
const cartNames = JSON.parse(localStorage.getItem('cartNames'));
const cartTotal = parseFloat(JSON.parse(localStorage.getItem('cartTotal')));
const cartDesconto = parseFloat(JSON.parse(localStorage.getItem('cartDesconto')));
const cartToken =  JSON.parse(localStorage.getItem('cartToken'))

console.log('ola',cartToken);

const cartQt = [];
for (var i = 0; i < cartString.length; i++) {
  var qt = cartString[i].qt;
  cartQt.push(qt);
}

const cartid = [];
for (var i = 0; i < cartString.length; i++) {
  var id = cartString[i].id;
  cartid.push(id);
}
const cartPrice =[];
for (var i = 0; i < cartString.length; i++) {
  var price = cartString[i].price;
  cartPrice.push(price);
}

console.log('Total  '+ cartTotal);
console.log("img"+cartImages);
console.log("names"+cartNames);
console.log("quantidade"+cartQt);
console.log("id"+cartid);

/*eliminando elementos iguais
cartNames = cartNames.filter(function(este, i) {
    return cartNames.indexOf(este) === i;
});*/

var cartValuesDiv = document.getElementById("cartValues");

for (var i = 0; i < cartImages.length; i++) {
  //cartValuesDiv.innerHTML += "<br> Nomes: " + cartNames + "<br> Quantidade: " + cartQt + "<br> IDs: " + cartid;
}

for (var i = 0; i < cartNames.length; i++) {
  console.log("Nome: " + cartNames[i]);
  console.log("Quantidade: " + cartQt[i]);
  console.log("Quantidade: " + cartPrice[i]);
 // console.log("total: " + cartTotal[i]);

  console.log("imagem:"+cartImages[i]);
}
</script>

<script>

let cep = '';
let logradouro = '';
let bairro = '';
let cidade = '';
let estado = '';
let uf = '';
let valorfrete=0;
let tempo = 0;
let real =0;

function cepcalcular() {
  jQuery.ajax({
    url: "calculafrete.php",
    dataType: "json",
    success: function(data) {
      if (Array.isArray(data)) {
        const modelsJson = data.map((frete) => ({
          uf: frete.UF,
          valorfrete: frete.VALOR_FRETE,
          Tempo: frete.TEMPO_ENTREGA_DIAS
        }));
        
        const cep = document.getElementById('cep').value;
        const url = "https://brasilapi.com.br/api/cep/v1/" + cep;
        const req = new XMLHttpRequest();
        req.open("GET", url);
        req.onload = function() {
          if (req.status === 200) {
            const endereco = JSON.parse(req.response);
            logradouro = endereco.street;
            bairro = endereco.neighborhood;
            cidade = endereco.city;
            estado = endereco.state;
            
            let estadoEncontrado = false;
            valorfrete, tempo;
            for (let i = 0; i < modelsJson.length; i++) {
              const item = modelsJson[i];
              if (item.uf.includes(estado)) {
                estadoEncontrado = true;
                valorfrete = item.valorfrete;
                tempo = item.Tempo;
                break;
              }
            }
            
            if (estadoEncontrado) {
                console.log(valorfrete +'tempo:'+ tempo);
                let resultado = document.getElementById('resultado');
                resultado.style.margin = "20px auto";
                resultado.style.padding = "10px";
                resultado.style.backgroundColor = "#f8f8f8";
                resultado.style.border = "1px solid #ccc";
                resultado.style.borderRadius = "5px";
                resultado.style.boxShadow = "0 0 5px rgba(0, 0, 0, 0.1)";
                resultado.style.fontFamily = "Arial, sans-serif";
                resultado.style.fontSize = "16px";
                resultado.style.display = "block";
                resultado.style.width = "400px";
                resultado.style.textAlign = "center";
                
                resultado.innerHTML = "<i class='fas fa-truck'></i> Valor do frete: " + valorfrete + ", Aproximadamente " + tempo + " dias para entrega. Endereço: " + logradouro + ", " + bairro + ", " + cidade + ", " + estado;
                resultado.style.color = "red";
                const valor = parseFloat(valorfrete);

                let escrito = document.getElementById('total');
                
                real = valor + cartTotal;
                escrito.innerHTML = 'Valor total: R$ ' +  `R$ ${real.toFixed(2).replace(".", ",")}`;


            } else {
              console.log('estado não encontrado');
            }
          } else if (req.status === 400) {
            alert("Cep inválido!");
          } else {
            alert("Erro ao buscar cep!");
          }
        };
        req.send();
      }
    }
  });
}

</script>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/estilo.css">
  <link rel="stylesheet" href="css/form.css">
  <link rel="stylesheet" href="css/compras.css">
  <link rel="icon" type="icon" href="img/fotinho.png"/>
  <script src="js/scripts.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <title>Pagamento</title>
<head>

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
      
      <header>
        <div class="header-content clearfix">
            
          <img src="img/ZOOLI.png" alt="LOGO" class="logo">
        
          <nav>
            <ul>
               <li><a href="index.php">Inicial</a></li>
                <li><a href="login.php">Cuidadores</a></li>
                <li><a href="login.php">Compras</a></li>
                <li><a href="contato.php">Contato</a></li>
                <li><a href="sair.php"><img src="img/icones/sair.png" width="30" height="30"></a></li>
            </ul>
          </nav>
        </div>
    </header>
    </div>
   
    <center> 
         <table>
            <thead>
              <tr>
                <img src="" alt="">
                <th></th>
                <th>Nome do Produto</th>
                <th>Quantidade</th>
              </tr>
            </thead>
            <tbody id="tabela-corpo">
            </tbody>
          </table>
    </center>

    <script>
        //  dados do carrinho de compras
        const carrinho = cartNames.map((nome, index) => ({
        img: cartImages[index],
        nome,
        quantidade: cartQt[index] ?? 0, // define 0 como valor padrão se a posição for "undefined"
        
        }));
        //removendo produtos iguais
        const produtos = [];
        
        carrinho.forEach(item => {
          const index = produtos.findIndex(prod => prod.nome === item.nome );
          if (index === -1) {
            produtos.push(item);
          } else {
            produtos[index].quantidade += item.quantidade;
          }
        });
            const tabelaCorpo = document.getElementById('tabela-corpo');
            produtos.forEach(produto => {
            const row = document.createElement('tr');
            row.innerHTML = `
            <td><img src="${produto.img}" alt="${produto.nome}"></td>
            <td>${produto.nome}</td>
            <td>${produto.quantidade}</td>
            
          `;
          tabelaCorpo.appendChild(row);
        });
        
        
          function boleto() {
          document.getElementById("cartid").value = cartid;
          document.getElementById("valorfrete").value = valorfrete;
          document.getElementById("real").value = JSON.stringify(real);
          document.getElementById("cartQt").value = cartQt;
          document.getElementById("cartNames").value = JSON.stringify(cartNames);
          document.getElementById("cartDesconto").value = JSON.stringify(cartDesconto);
          document.getElementById("cartToken").value = JSON.stringify(cartToken);
        }
        
        function valor() {
          var parcelas = document.getElementById("parcelar").value;
          var valorParcela = cartTotal / parseInt(parcelas);
          var valorTotal;
          if (parcelas === "a vista") { // verifica se a opção selecionada é "1x"
            valorTotal = real; // exibe o valor sem juros
            document.getElementById("total").innerHTML = 'Valor total da compra: R$'+ real.toFixed(2).replace(".", ","); // arredonda para duas casas decimais
            document.getElementById("valorTotal").innerHTML = " " ; // arredonda para duas casas decimais
        
          } else {
            valorTotal = real / parseInt(parcelas) * 1.05; // adiciona 5% de juros ao total
            const valorparcela = real * 1.05;
            console.log(valorparcela);
        
            document.getElementById("valorTotal").innerHTML = 'Valor da Parcela R$'+valorTotal.toFixed(2).replace(".", ",") ; // arredonda para duas casas decimais
            document.getElementById("total").innerHTML = 'Valor total da compra: R$'+ valorparcela.toFixed(2).replace(".", ","); // arredonda para duas casas decimais
        
          }
           // cria um objeto XHR
        }
        
        function cartao() {
          document.getElementById("cartid1").value = cartid;
          document.getElementById("valorfrete1").value = valorfrete;
          document.getElementById("real1").value = JSON.stringify(real);
          document.getElementById("cartQt1").value = cartQt;
          document.getElementById("cartNames1").value = JSON.stringify(cartNames);
          document.getElementById("cartDesconto1").value = JSON.stringify(cartDesconto);
          document.getElementById("cartToken1").value = JSON.stringify(cartToken);
        }
    </script>
    <div class="form-Compra">
    <div id="cartValues"></div>
    <br>
    <h3>Calcule o Valor do Frete:</h3>
    <div class="input-group w60">
        <input type="text" id="cep" name="cep">
    </div>
    <button onclick="cepcalcular()" class="buttonCep">Calcular</button>
    <div id="resultado"></div>
    <br>
	<h3>Selecione a Forma de Pagamento:</h3>
	<form id="paymentForm">
		<input type="radio" name="paymentType" value="card" > Cartão de Crédito <br>
		<input type="radio" name="paymentType" value="boleto" > Boleto Bancário <br>
	</form>

	<div id="cardDiv"  style="display: none;">
    <form action="compra.php?cartao=confirmado" method="POST">
        <br><br>
        <div class="input-group w50">
            <p>Número do Cartão:</p>
    		<input type="number" id="cardNumber1" name="cardNumber1"  maxlength="16" required >
		</div>
		<div class="input-group w50">
    		<p>Nome do Titular:</p>
    		<input type="text" id="cardName" name="cardName" >
		</div>
		<div class="input-group w50">
    		<p>Data de Validade:</p>
            <input type="month" id="cardExpireDate" name="cardExpireDate" required>
        </div>
        <div class="input-group w50">
	    	<p> Código de Segurança:</p>
			<input type="number" id="cardSecurityCode" name="cardSecurityCode" required maxlength="5">
	    </div>
	    <div class="input-group w50">
            <p>Bandeira do Cartão:</p>
            <input type="text" id="BANDEIRA_CARTAO" name="BANDEIRA_CARTAO">
        </div>
        <div class="input-group w50">
            <p>Parcelamento:</p> 
            <select id="parcelar" name="parcelar"required onchange="valor()">
              <option value="a vista">À vista</option>
              <option value="2x">2x no cartão</option>
              <option value="3x">3x no cartão</option>
              <option value="4x">4x no cartão</option>
              <option value="5x">5x no cartão</option>
              <option value="6x">6x no cartão</option>
              <option value="7x">7x no cartão</option>
              <option value="8x">8x no cartão</option>
              <option value="9x">9x no cartão</option>
              <option value="10x">10x no cartão</option>
              <option value="11x">11x no cartão</option>
              <option value="12x">12x no cartão</option>
            </select><br><br>
        </div>
        
        <input type="text" name="cartid1" id="cartid1" style="display: none;">
        <input type="text" name="valorfrete1" id="valorfrete1" style="display: none;">
        <input type="text" name="real1" id="real1" style="display: none;">
        <input type="text" name="cartQt1" id="cartQt1" style="display: none;">
        <input type="text" name="cartNames1" id="cartNames1" style="display: none;">
        <input type="text" name="cartDesconto1" id="cartDesconto1" style="display: none;">
        <input type="text" name="cartToken1" id="cartToken1" style="display: none;">
        <p id="valorTotal"></p>
			<button type="submit" id="cartao1" name="cartao1" onclick="cartao()" class="button">Confirmar Pagamento</button>
		</form>
	</div>

	<div id="boletoDiv" style="display: none;">
  <form action="compra.php?boleto=confirmado" method="POST" id="boletoForm">
    <input type="text" name="cartid" id="cartid" style="display: none;">
    <input type="text" name="valorfrete" id="valorfrete" style="display: none;">
    <input type="text" name="real" id="real" style="display: none;">
    <input type="text" name="cartQt" id="cartQt" style="display: none;">
    <input type="text" name="cartNames" id="cartNames" style="display: none;">
    <input type="text" name="cartDesconto" id="cartDesconto" style="display: none;">
    <input type="text" name="cartToken" id="cartToken" style="display: none;">

    <button id="submit" style="display: block;" onclick="boleto()" class="button">Gerar Boleto</button>
  </form>
</div>

  </form>
  </div>
    <script>
  // obtém referências aos elementos HTML relevantes
  var cardDiv = document.getElementById("cardDiv");
  var boletoDiv = document.getElementById("boletoDiv");
  var cardRadio = document.querySelector('input[value="card"]');
  var boletoRadio = document.querySelector('input[value="boleto"]');

  // adiciona um ouvinte de evento ao elemento HTML que contém os radio buttons
  document.getElementById("paymentForm").addEventListener("change", function(event) {
    // verifica qual radio button foi selecionado
    if (cardRadio.checked) {
      // mostra o div com o formulário de pagamento com cartão de crédito
      cardDiv.style.display = "block";
      boletoDiv.style.display = "none";
    } else if (boletoRadio.checked) {
      // mostra o div com o botão para gerar o boleto bancário
      cardDiv.style.display = "none";
      boletoDiv.style.display = "block";
    }
  });

</script>

<p id="total" name="total"></p>
<?php
}
}
?>

