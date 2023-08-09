let cartTotal = 0;
let cartIds = [];
let cartImages = [];
let cartNames = [];
let cart = [];
let modalQt = 0;
let key = 0;
let modelsJson = [];
let price1 = 0;
let cartDesconto = 0;
let cartToken = 0;
let valorprod = [];

jQuery.ajax({
  url: "phpjs.php",
  dataType: "json",
  success: function (data) {
    if (Array.isArray(data)) {
      modelsJson = data.map((produto) => ({
        id: produto.ID_PROD.split(',').map((id) => parseInt(id)),
        name: produto.NOME_PROD,
        img: "data:imagem/jpeg;base64," + produto.imagem_base64,
        price: parseFloat(produto.VALOR_PROD).toFixed(2),
        sizes: produto.qntd_prod.split(',').map((qntd_prod) => parseInt(qntd_prod)),
        description: produto.DESC_PROD,
        categoriaprod: produto.ID_CATEGORIA,
        status: produto.STATUS_PRODUTO


      }));

      jQuery.ajax({
        url: "buscar.php",
        dataType: "json",
        success: function (data) {
          if (Array.isArray(data)) {
            modelsJson1 = data.map((cupom) => ({

              iddesconto: cupom.ID_PROMOCAO,
              desconto: parseFloat(cupom.VALOR_PROMOCAO).toFixed(2),
              token: cupom.TOKEN_PROMOCAO,
              categoriatoken: cupom.ID_CATEGORIA



            }));

            console.log(modelsJson);
            // mapeando os dados recebidos e preenchendo a lista de produtos, modelos
            const c = (el) => document.querySelector(el); //para localizar o primeiro item
            const cs = (el) => document.querySelectorAll(el); //para localizar todos os itens

            modelsJson.map((item, index) => {
              let cartQuantities = item.sizes;
              if (item.sizes == 0) {
                // Define o preço como "Indisponível"
                item.price = "Indisponível";
                modelsItem.querySelector('.models-item--price').innerHTML = `R$ ${item.price}`;

              }


              if (item.sizes > 0) {
                //Vamos pegar a estrutura HTML que tem a class 'models-item', 
                //dentro da class 'models' e clonar - true indica para pegar subitens
                //let modelsItem = document.querySelector('.models .models-item').cloneNode(true);
                //Depois de ajustado com a constante
                let modelsItem = c('.models .models-item').cloneNode(true);
                // preenchendo as informações dos modelos
                //acrescentar um identificador para a pizza - FrontEnd
                modelsItem.setAttribute('data-key', index);
                modelsItem.querySelector('.models-item--img img').src = item.img;
                modelsItem.querySelector('.models-item--price').innerHTML = `R$ ${item.price}`;
                //iniciar pelo nome -- o mais simples
                modelsItem.querySelector('.models-item--name').innerHTML = item.name;
                modelsItem.querySelector('.models-item--desc').innerHTML = item.description;
                //Adicionar o evento de click ao tag <a> que temos envolvendo a imagem e o "+"
                //Vai abrir o Modal - Janela
                modelsItem.querySelector('a').addEventListener('click', (e) => {
                  e.preventDefault(); //Previne a ação padrão que iria atualizar a tela
                  //let key = e.target.closest('.models-item').getAttribute('data-key'); //pegando informação do identificador
                  //Transforma a variável key em global.
                  key = e.target.closest('.models-item').getAttribute('data-key'); //pegando informação do identificador
                  modalQt = 1;
                  modalQtbd = item.sizes;
                  //Alimentando os dados do Modal
                  c('.modelsBig img').src = modelsJson[key].img;
                  c('.modelsInfo h1').innerHTML = modelsJson[key].name;
                  c('.modelsInfo--desc').innerHTML = modelsJson[key].description;
                  c('.modelsInfo--actualPrice').innerHTML = `R$ ${modelsJson[key].price}`;
                  // ('.modelsInfo--size.selected').classList.remove('selected');
                  /*  cs('.modelsInfo--size').forEach((size, sizeIndex)=>{
                        if(sizeIndex == 2) {
                            size.classList.add('selected');
                            c('.modelsInfo--actualPrice').innerHTML = `R$ ${modelsJson[key].price[sizeIndex]}`;
                        }
                        //size.innerHTML = modelsJson[key].sizes[sizeIndex];
                      //  size.querySelector('span').innerHTML = modelsJson[key].sizes[sizeIndex];
                    });*/
                  c('.modelsInfo--actualPrice').innerHTML = `R$ ${modelsJson[key].price}`;
                  c('.modelsInfo--qt').innerHTML = modalQt;
                  //Mostrar a janela Modal
                  c('.modelsWindowArea').style.opacity = 0; //criando uma animação

                  c('.modelsWindowArea').style.display = 'flex';
                  setTimeout(() => {
                    c('.modelsWindowArea').style.opacity = 1; //mostrando a janela, sem Timeout, não vemos o efeito
                  }, 200);
                });

                //preenchendo as informações no site
                //Depois de ajustado com a constante
                document.querySelector('.models-area').append(modelsItem);

                c('.models-area').append(modelsItem);
              }
            });
            function addToCart() {
              let productExists = false;

              cart.forEach((item) => {
                if (item.id === modelsJson[key].id[0]) {
                  productExists = true;
                  item.quantity += modalQt;
                }
              });

              if (!productExists) {
                cart.push({
                  id: modelsJson[key].id[0],
                  name: modelsJson[key].name,
                  img: modelsJson[key].img,
                  price: modelsJson[key].price,
                  quantity: modalQt
                });
              }

              updateCart();
              closeModal();
            }
            function closeModal() {
              c('.modelsWindowArea').style.opacity = 0; //criando uma animação
              setTimeout(() => {
                c('.modelsWindowArea').style.display = 'none'; //fechando a janela, sem Timeout, não vemos o efeito
              }, 500);
              //mostrar o funcionamento via console do navegador, antes de atribuir aos botões
            }

            cs('.modelsInfo--cancelButton, .modelsInfo--cancelMobileButton').forEach((item) => {
              item.addEventListener('click', closeModal);
            });

            c('.modelsInfo--qtmenos').addEventListener('click', () => {
              if (modalQt > 1) {
                modalQt--;
                c('.modelsInfo--qt').innerHTML = modalQt;
              }
            });

            c('.modelsInfo--qtmais').addEventListener('click', () => {
              if (modalQt < modalQtbd) {
                modalQt++;
                c('.modelsInfo--qt').innerHTML = modalQt;
              }
            });

            /* cs('.modelsInfo--size').forEach((size, sizeIndex)=>{
                 size.addEventListener('click', (e)=> {
                     c('.modelsInfo--size.selected').classList.remove('selected');
                     //e.target.classList.add('selected'); //ocorre erro se clicar no <span></span>
                     size.classList.add('selected');
                     
                 });
             });*/


            c('.modelsInfo--actualPrice').innerHTML = `R$ ${modelsJson[key].price[modalQt]}`;
            function addToCart(key, modalQt, price1) {
              let identifier = modelsJson[key].id + '@';
              const locaId = cart.findIndex((item) => item.identifier == identifier);

              let modalqtmax = modelsJson[key].sizes;

              if (locaId > -1) {
                // item já existe no carrinho


                const maxQty = modalqtmax - cart[locaId].qt;

                if (modalQt > maxQty) {
                  console.log("A quantidade máxima permitida foi atingida");
                  cart[locaId].qt = modalqtmax;
                } else {
                  cart[locaId].qt += modalQt;
                }

              } else {
                // item não existe no carrinho, adiciona normalmente
                if (modalQt > modalqtmax) {
                  console.log("A quantidade máxima permitida foi atingida");
                } else {

                  const item = {
                    id: modelsJson[key].id,
                    identifier,
                    qt: modalQt,
                    price: price1,
                    // adicionando a quantidade do item
                  };
                  cart.push(item);
                }
              }

              updateCart();
              closeModal();
            }
            c('.modelsInfo--addButton').addEventListener('click', () => {



              addToCart();

              closeModal();

            });


            function addToCart() {
              let identifier = modelsJson[key].id + '@';
              const locaId = cart.findIndex((item) => item.identifier == identifier);

              let modalqtmax = modelsJson[key].sizes;

              if (locaId > -1) {
                // item já existe no carrinho
                const maxQty = modalqtmax - cart[locaId].qt;
                if (modalQt > maxQty) {
                  console.log("A quantidade máxima permitida foi atingida");
                  cart[locaId].qt = modalqtmax;
                } else {
                  cart[locaId].qt += modalQt;
                }
              } else {
                // item não existe no carrinho, adiciona normalmente
                if (modalQt > modalqtmax) {
                  console.log("A quantidade máxima permitida foi atingida");
                } else {
                  const item = {
                    id: modelsJson[key].id,
                    identifier,
                    qt: modalQt,
                    price: price1,
                  };
                  cart.push(item);

                  // adiciona o ID, imagem e nome do produto aos arrays



                }
              }

              cartImages.push(modelsJson[key].img);
              cartNames.push(modelsJson[key].name);

              updateCart();
            }






            console.log(modelsJson1);



            // document.getElementById("aplicar-cupom-btn").addEventListener("click", aplicarCupomAjax);



            // declarando a variável global para armazenar o valor do desconto


            function updateCart() {
              c('.menu-openner span').innerHTML = cart.length;
              if (cart.length > 0) {
                c('aside').classList.add('show');
                c('.cart').innerHTML = '';
                let desconto = 0;
                let subtotal = 0;
                let total = 0;

                cart.map((itemCart, index) => {

                  let modelItem = modelsJson.find((itemBD) => itemBD.id == itemCart.id);

                  subtotal += modelItem.price * itemCart.qt;

                  let cartItem = c('.models .cart--item').cloneNode(true);
                  cartItem.setAttribute('data-id', itemCart.id);

                  cartItem.querySelector('img').src = modelItem.img;
                  cartItem.querySelector('.cart--item-nome').innerHTML = `${modelItem.name}`;
                  cartItem.querySelector('.cart--item--qt').innerHTML = itemCart.qt;
                  cartItem.querySelector('.cart--item-qtmenos').addEventListener('click', () => {
                    if (itemCart.qt > 1) {
                      itemCart.qt--;
                    } else {
                      cart.splice(index, 1);
                    }


                    updateCart();
                  });

                  let modalQtbd = modelsJson[key].sizes;

                  if (itemCart.qt < modalQtbd) {
                    cartItem.querySelector('.cart--item-qtmais').addEventListener('click', () => {
                      if (itemCart.qt < modalQtbd) {
                        itemCart.qt++;
                        updateCart();
                      }
                      saveCart();


                    });
                  }
                  saveCart();
                  c('.cart').append(cartItem);


                });
                document.getElementById("aplicar-cupom-btn").addEventListener("click", () => {



                  let cupomInput = document.getElementById("cupom");
                  let cupomToken = cupomInput.value;

                  const bdcupom = modelsJson1.find((cupom) => cupom.token === cupomToken);
                  const categoriaprod = modelsJson[key].categoriaprod;
                  const categoriatoken = bdcupom ? bdcupom.categoriatoken : null;

                  saveCart()

                  if (bdcupom && categoriatoken === categoriaprod) {

                    cartToken = cupomToken;
                    console.log(cartToken);
                    let desconto = bdcupom.desconto;
                    total = subtotal - desconto;
                    desconto = subtotal - total;
                    cartTotal = total;
                    c('.subtotal span:last-child').innerHTML = `R$ ${subtotal.toFixed(2).replace(".", ",")}`;
                    c('.desconto span:last-child').innerHTML = `R$ ${desconto.toFixed(2).replace(".", ",")}`;
                    c('.total span:last-child').innerHTML = `R$ ${total.toFixed(2).replace(".", ",")}`
                    let resultado = document.getElementById("resultado");
                    resultado.style.color = "green";
                    resultado.innerHTML = "Cupom disponível";
                    cartDesconto = desconto;
                    console.log("Total: ", cartTotal);
                    saveCart()




                    // atribuindo o valor do desconto à variável global
                  } else if (bdcupom && categoriatoken !== categoriaprod) {
                    total = subtotal - desconto;
                    desconto = subtotal - total;
                    cartTotal = total;


                    c('.subtotal span:last-child').innerHTML = `R$ ${subtotal.toFixed(2).replace(".", ",")}`;
                    c('.desconto span:last-child').innerHTML = `R$ ${desconto.toFixed(2).replace(".", ",")}`;
                    c('.total span:last-child').innerHTML = `R$ ${total.toFixed(2).replace(".", ",")}`
                    let resultado = document.getElementById("resultado");
                    resultado.style.color = "red";
                    console.log("Total: ", cartTotal);


                    resultado.innerHTML = "Esse cupom não é válido para essa categoria";
                  } else {
                    total = subtotal - desconto;
                    desconto = subtotal - total;
                    cartTotal = total;

                    c('.subtotal span:last-child').innerHTML = `R$ ${subtotal.toFixed(2).replace(".", ",")}`;
                    c('.desconto span:last-child').innerHTML = `R$ ${desconto.toFixed(2).replace(".", ",")}`;
                    c('.total span:last-child').innerHTML = `R$ ${total.toFixed(2).replace(".", ",")}`
                    let resultado = document.getElementById("resultado");
                    resultado.innerHTML = "Digite um cupom válido";
                    resultado.style.color = "red";


                    subtotal -= desconto;
                    // calculando o total após aplicar o desconto
                    total = subtotal;

                    console.log("Total: ", cartTotal);

                  }
                })

                saveCart()

                document.getElementById("Finalizar").addEventListener("click", () => {



                  saveCart();
                  window.location.href = 'compra.php';




                });






                function saveCart() {

                  localStorage.setItem('cartImages', JSON.stringify(cartImages));
                  localStorage.setItem('cartNames', JSON.stringify(cartNames));
                  localStorage.setItem('cartTotal', JSON.stringify(cartTotal));
                  localStorage.setItem('cart', JSON.stringify(cart));
                  localStorage.setItem('cartDesconto', JSON.stringify(cartDesconto));
                  localStorage.setItem('cartToken', JSON.stringify(cartToken));




                }

                // adicionando o desconto ao subtotal
                subtotal -= desconto;

                // calculando o total após aplicar o desconto
                total = subtotal;
                cartTotal = total;
                saveCart()
                c('.subtotal span:last-child').innerHTML = `R$ ${subtotal.toFixed(2).replace(".", ",")}`;
                c('.desconto span:last-child').innerHTML = `R$ ${desconto.toFixed(2).replace(".", ",")}`;
                c('.total span:last-child').innerHTML = `R$ ${total.toFixed(2).replace(".", ",")}`;
                /*saveProductToCookie(modelsJson[key].id, modalQt, modelsJson[key].img, modelsJson[key].name)
                
                function saveProductToCookie(id, quantity, image, name, total) {
                  // cria uma string com as informações que você deseja salvar, incluindo o total
                  const productData = `${id}_${quantity}_${image}_${name}_${total}`;
                
                  // define a validade do cookie
                  const expires = ";expires=" + new Date(Date.now() + 86400e3).toUTCString(); // expira em 1 dia
                
                  // cria o cookie com o nome "cart" e adiciona a string com os dados do produto
                  document.cookie = `cart=${productData};${expires};path=/`*/




              } else {
                c('aside').classList.remove('show');
                c('aside').style.left = '100vw';
              }


            }

          }
        }
      })



    } else {
      alert("O servidor retornou uma resposta inválida.");
    }
  },
  error: function (jqXHR, textStatus, errorThrown) {
    alert("Não foi possível acessar o servidor.");
  }
});