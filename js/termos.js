$(document).ready(function(){ // Espera o documento estar pronto para executar o código dentro da função

    $(".checkbox").click(function(){ // Quando um elemento com a classe "checkbox" for clicado
    
         Swal.fire({ // Exibe um pop-up usando a biblioteca SweetAlert
            title: 'Política de Privacidade',
            text: 'A sua privacidade é importante para nós. É política da Zooli respeitar a sua privacidade em relação a qualquer informação sua que possamos coletar no site Zooli, e outros sites que possuímos eoperamos. Solicitamos informações pessoais apenas quando realmente precisamosdelas para lhe fornecer um serviço. Fazendo isso por meios justos e legais, como seu conhecimento e consentimento. Também informamos por que estamos coletandoe como será usado. Apenas retemos asinformações coletadas pelo tempo necessário para fornecer o serviço solicitado.Quando armazenamos dados, protegemos dentro de meios comercialmente aceitáveispara evitar perdas e roubos, bem como acesso, divulgação, cópia, uso oumodificação não autorizados. Não compartilhamos informações de identificaçãopessoal publicamente ou com terceiros, exceto quando exigido por lei. O nossosite pode ter links para sites externos que não são operados por nós. Estejaciente de que não temos controle sobre o conteúdo e práticas desses sites e nãopodemos aceitar responsabilidade por suas respectivas políticas de privacidade. Você é livre para recusar a nossa solicitaçãode informações pessoais, entendendo que talvez não possamos fornecer alguns dosserviços desejados. O uso continuado de nosso site será considerado como aceitaçãode nossas práticas em torno de privacidade e informações pessoais. Se vocêtiver alguma dúvida sobre como lidamos com dados do usuário e informaçõespessoais, entre em contato conosco.',
            confirmButtonColor: "rgb(13, 184, 254)",
          
          })
    })
})



