function mostraValor() {
  // Obtém o valor selecionado do grupo de botões de rádio "star"
  var valor = parseInt(getRadioValor("star"), 10);
  var avaliacao = "";

  // Realiza um switch case para atribuir uma avaliação com base no valor selecionado
  switch (valor) {
    case 1:
      avaliacao = "Não gostei, tem que melhorar muito!!";
      break;

    case 2:
      avaliacao = "Tem que melhorar.";
      break;

    case 3:
      avaliacao = "Legal! Porém sinto que faltou algo!";
      break;

    case 4:
      avaliacao = "Uuh!!! Gostei muito. Faltou pouco para a excelência!";
      break;

    case 5:
      avaliacao = "Excelente!! Mantenha este padrão sempre.";
      break;

    default:
      avaliacao = "Por favor avalie, para sempre estar melhorando!";
  }

  // Exibe a avaliação na página, atribuindo-a ao elemento com o ID "valorAvaliado"
  document.getElementById("valorAvaliado").innerHTML = avaliacao;
}

function getRadioValor(name) {
  // Obtém o valor selecionado de um grupo de botões de rádio com o nome especificado
  var rads = document.getElementsByName(name);

  // Percorre os botões de rádio e retorna o valor do botão selecionado
  for (var i = 0; i < rads.length; i++) {
    if (rads[i].checked) {
      return rads[i].value;
    }
  }

  return null; // Retorna null se nenhum botão estiver selecionado
}
