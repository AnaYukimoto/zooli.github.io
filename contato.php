<?php
session_start();  // Inicia a sessão PHP

// Verifica se o formulário foi enviado
if (isset($_REQUEST['valor']) && ($_REQUEST['valor'] == 'enviado')) {
    // Atribui os valores dos campos do formulário a variáveis
    $Botao = $_POST["Botao"];
    $Nome = $_POST["sender"];
    $Email = $_POST["email"];
    $mesage = $_POST["message"];
    $status = "novo";

    // Verifica qual botão foi pressionado no formulário
    if ($Botao == "Inserir") {

        // Estabelece a conexão com o banco de dados MySQL
        $conexao = mysqli_connect('localhost', 'root', '', 'dbpets');
        // Verifica se houve um erro na conexão
        if ($conexao->connect_errno) {
            echo "Erro na conexão" . $conexao->connect_error;
            exit();
        }
        // Define o conjunto de caracteres da conexão como UTF-8
        $conexao->set_charset("utf8");

        // Cria uma declaração SQL preparada para inserir os dados na tabela "tb_faleconosco"
        $Comando = $conexao->prepare("INSERT INTO tb_faleconosco (NOME_CONTATO, EMAIL_CONTATO, ASSUNTO_CONTATO, status_contato) VALUES (?, ?, ?, ?)");
        // Vincula os valores das variáveis à declaração preparada
        $Comando->bind_param("ssss", $Nome, $Email, $mesage, $status);

        // Executa a declaração preparada
        if ($Comando->execute()) {
            // Verifica se a inserção foi bem-sucedida
            if ($Comando->affected_rows > 0) {
                // Exibe uma mensagem de sucesso e redireciona para a página "contato.php"
                echo "<script>alert('Mensagem enviada, verifique seu email para ver se foi respondido!'); window.location.href='contato.php'</script>";
                
                // Redefine os campos do formulário para nulo
                $Nome = null;
                $Email = null;
                $mesage = null;
            
            } else {
                echo "Erro ao tentar efetivar o contato.";
            }
        } else {
            echo "Erro: Não foi possível executar a declaração sql.";
        }
        
        // Fecha a declaração preparada e a conexão com o banco de dados
        $Comando->close();
        $conexao->close();
    }
} else {
    // Se o formulário não foi enviado, exibe o formulário de contato
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/contato.css">
    <link rel="stylesheet" href="css/estilo.css">
    <link rel="icon" type="icon" href="img/fotinho.png"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="js/scripts.js"></script>
    <title>Contato</title>
</head>
<body>
<!--  PARTE DA NAVBAR   -->
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
      <div class="logo">
        <img src="img/ZOOLI.png" alt="LOGO" >	
      </div>
      <nav>
        <ul>
           <li><a href="index.php">Inicial</a></li>
            <li><a href="login.php">Cuidadores</a></li>
            <li><a href="login.php">Compras</a></li>
            <li><a href="contato.php">Contato</a></li>
            <li><a href="login.php" class="cadastro">Entrar</a></li>
        </ul>
      </nav>
    </div>
  
  </header>
<!--  FINAL PARTE DA NAVBAR   -->
  <br><br>
<!--PARTE CONTATO-->
    <div class="fish" id="fish"></div>
    <div class="fish" id="fish2"></div>
    <section id="contact">
      <div class="contact-box">
        <div class="contact-links">
          <br>
          <h2 class="cont">CONTATO</h2>
          <div class="links">
            <div class="link">
            <img src="img/icones/facebook.png" alt="facebook" class="contactimg">
            </div>
            <div class="link">
            <img src="img/icones/instagram.png" alt="instagram" class="contactimg">
            </div>
            <div class="link">
            <img src="img/icones/twitter.png" alt="twitter" class="contactimg">
            </div>
            <div class="link">
            <img src="img/icones/wats.png" alt="wats" class="contactimg">
            </div>
          </div>
        </div>
        
        <div class="contact-form-wrapper">
        <form name="form1" action="contato.php?valor=enviado" method="POST">
            <!-- Campo do nome -->
            <div class="form-item"> 
              <input type="text"  name="sender" maxlength="60" required>
              <label>Seu Nome Completo</label>
            </div>
            <!-- Campo do e-mail -->
            <div class="form-item">
              <input type="email"  name="email" maxlength="80" required>
              <label>Seu E-mail</label>
            </div>
            <!-- Campo da mensagem -->
            <div class="form-item">
              <textarea class="" name="message" maxlength="500" required></textarea>
              <label>Sua Mensagem</label>
            </div>
            <!-- Botão de envio do formulário -->
            <button id="Botao" type="submit" name="Botao" value ="Inserir"class="submit-btn">Enviar</button>  
          </form>
        </div>
      </div>
</body>
</html>
<?php }
?>