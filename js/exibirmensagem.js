function exibirMensagem(element) {
    // Obtém o ID da mensagem da div clicada
    var id = element.getAttribute("data-id");
  
    // Envia uma solicitação AJAX para recuperar a mensagem com o ID correspondente
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        // Exibe o formulário de envio de mensagem com os dados da mensagem preenchidos
        exibirFormulario(JSON.parse(this.responseText));
      }
    };
    xhttp.open("GET", "recuperar_mensagem.php?id=" + id, true);
    xhttp.open("GET", "recuperar_avaliacao.php?id=" + id, true);
    xhttp.send();
  }
 
    