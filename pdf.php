<?php

// Carregar o Composer
require './vendor/autoload.php';

// Referenciar o namespace Dompdf
use Dompdf\Dompdf;

// Instanciar e usar a classe dompdf
$dompdf = new Dompdf(['enable_remote' =>true]);


    // Defina o conteúdo do PDF
    $html = '
       <html>
<head>
<style>


body {
    font-family: Arial, sans-serif;
}

.boleto {
    width: 600px; 
    margin: 0 auto;
    border: 1px solid #000;
    padding: 20px;
}




.info {
    margin-bottom: 20px;
}

.info p {
    margin: 5px 0;
}

.valor {
    text-align: right;
    font-size: 24px;
    font-weight: bold;
}
</style>

</head>
<body>
    <div class="boleto">
        <div class="info">
      
        <img src="http://localhost/zooli_ofc/img/boletologo.png" alt="LOGO" style="display: inline-block;">
        <p style="display: inline-block;">Banco do Brasil S.A.</p>
        <p style="display: inline-block;">'.$numeroBoleto.'</p>
                <p>Banco do Brasil S.A.</p>
            <p>Nome do pagador:'.$nomeCliente.'</p>
            <p>Cpf: '.$cpfCliente.'</p>
        </div>
        <div class="info">
            <p>Data de Vencimento: '.$dataAtual.'</p>
            <p>Valor do Boleto:  R$'.$valortotal.',00</p>
            <p>Linha Digitável: '.$numeroBoleto.',00</p>
        </div>
   
        <div class="valor">
            <p>Total a Pagar:  R$'.$valortotal.',00</p>

        </div>
        <div class="info">
        <p>--------------------------------------------------------------------------------------------------------------------</p>

            <p>Corte na linha pontilhada</p>
        </div>
        <div class="info">
            <p>Local de pagamento: Qualquer banco até o vencimento</p>
            <p>Após o vencimento, somente no Banco do Brasil</p>
            <p>Recebedor: Zooli company</p>
            <p>CNPJ: 123.456.789/0001-00</p>
            <p>Agência: 1234</p>
            <p>Conta: 12345-6</p>
        </div>
        <div class="info">
            <p>Data de Vencimento:'.$dataAtual.'</p>
            <p>Valor do Boleto:  R$'.$valortotal.',00</p>
            <p>Linha Digitável: '.$numeroBoleto.'</p>
        </div>
        <div class="info">
        <p>Local de pagamento: Qualquer banco até o vencimento</p>
        <p>Após o vencimento, somente no Banco do Brasil</p>
        <p>Recebedor: Zooli company</p>
        <p>CNPJ: 123.456.789/0001-00</p>
        <p>Agência: 1234</p>
        <p>Conta: 12345-6</p>
        </div>
        <div class="valor">
            <p>Total a Pagar:  R$'.$valortotal.',00</p>
        </div>
        <div class="info">
            <p>Corte na linha pontilhada</p>
            <p>--------------------------------------------------------------------------------------------------------------------</p>
            <img src="http://localhost/zooli_ofc/img/CODIGO.JPG" alt="LOGO" >
            
        </div>
        <div class="info">
            <p>Local de pagamento: Qualquer banco até o vencimento</p>
            <p>Após o vencimento, somente no Banco do Brasil</p>
        </div>
    </div>
</body>
</html>

    ';

    // Carregue o HTML no Dompdf
    $dompdf->loadHtml($html);
// Configurar o tamanho e a orientacao do papel
// landscape - Imprimir no formato paisagem
//$dompdf->setPaper('A4', 'landscape');
$dompdf->setPaper('A4', 'portrait');

// Renderizar o HTML como PDF
$dompdf->render();

// Gerar o PDF
$dompdf->stream('boleto_zooli.pdf');