// Função para buscar informações de um CEP
function buscaCep() {
  let cep = document.getElementById('cepCliente').value; // Obtém o valor do campo de CEP
  if (cep !== "") { // Verifica se o campo de CEP não está vazio
    let url = "https://brasilapi.com.br/api/cep/v1/" + cep; // Monta a URL da API com o CEP informado
    let req = new XMLHttpRequest(); // Cria uma instância do objeto XMLHttpRequest
    req.open("GET", url); // Configura uma requisição GET para a URL da API
    req.onload = function() { // Função a ser executada quando a requisição for concluída
      if (req.status === 200) { // Verifica se a requisição foi bem-sucedida (status 200)
        let endereco = JSON.parse(req.response); // Converte a resposta da API para um objeto JavaScript
        document.getElementById("enderecoCliente").value = endereco.street; 
        document.getElementById("bairroCliente").value = endereco.neighborhood; 
        document.getElementById("cidadeCliente").value = endereco.city; 
        document.getElementById("ufCliente").value = endereco.state; 
      }
      else if (req.status === 400) { // Verifica se o status da requisição é 400 (Bad Request)
        alert("Cep inválido!"); 
      }
      else { // Caso contrário (status diferente de 200 e 400)
        alert("Erro ao fazer a requisição"); 
      }
    };
    req.send(); // Envia a requisição
  }
}

window.onload = function() {
  let textcep = document.getElementById('cepCliente'); // Obtém o elemento do campo de CEP
  textcep.addEventListener('blur', buscaCep); // Adiciona um listener para o evento 'blur' (perda de foco) no campo de CEP, que chamará a função buscaCep
};
