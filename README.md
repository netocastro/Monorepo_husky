# Backend
Essa é uma API foi construida para um desafio da Husky. Ela simula uma aplicação que gerencia
entregas de delivery, onde se pode manipular os pedidos dos usuários.

## Projeto

Essa aplicação é feita com PHP puro e utiliza todas as normas de programação seguindo as PSRs( PHP Standards Recommendations ), arquitetura e padrões de projeto como MVC , Active Record e Layer Supertype;

### Requistos para rodar a API
+ Servidor Apache (wamp,xampp ou qualquer um de sua preferência)
+ MySQL
+ PHP version 7.4
+ Composer

## Instalação do Backend

+ Coloque a pasta desse projeto dentro da raiz diretório público seu servidor Apache, de preferência, como htdocs ou WWW, assim não será necessário modificar as rotas no frontend. Caso não seja possível, será explicado como editar o frontend mais adiante.

+ Abra o terminal dentro da pasta backend e execute o comando: "composer update" (sem as aspas),
pra ter certeza que não falta algum componente.

+ Na raiz do projeto, na pasta database execute o arquivo database.sql em seu SGBD  para criar as tabelas
e popular o banco de dados.

+ Dentro da pasta src/Core se encontra o arquivo Config.php, nele vc precisa editar a
constante BASE_PATH para o diretorio no qual vc colocou a pasta do projeto.
Também terá que editar a constante DATA_LAYER_CONFIG com as informações do seu banco de dados.

Exemplo BASE_PATH:

    Se o aquivo foi extraído para a raiz da sua pasta pública, matenha a constante assim:

	define("BASE_PATH", "http{$s}://{$_SERVER['HTTP_HOST']}");  

    Caso não, edite para o diretório onde vc colocou a pasta, assim:

    define("BASE_PATH", "http{$s}://{$_SERVER['HTTP_HOST']}/<minha_pasta>");  

Exemplo DATA_LAYER_CONFIG:
   
    define('DATA_LAYER_CONFIG', [
        'driver' => 'mysql',  
        'host' => 'localhost',          // nome do seu host
        'port' => '3306',
        'dbname' => 'backend_husky',    // nome da database
        'username' => 'root',           // usuário
        'passwd' => '',				    // senha
        'options' => [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_CASE => PDO::CASE_NATURAL,
        ],
    ]);

    

O BASE_PATH reconhece automaticamente se o servidor é HTTP ou HTTPS.
Se você estiver utilizando um certificado SSL, descomente as linhas 10, 11 e 12 no arquivo .htaccess
que se encontra na raiz do projeto, removendo o "#". Depois disso é so acessar o projeto através do
navegador, cliente de API REST como insomnia e postman ou através da documentação da dessa API, apartir da rota /documentation pra poder fazer as requisições com swagger.

    Ex: http://localhost/documentation

### Explicando o Backend

O backend possui o CRUD de todas as tabelas do banco e dados e poderão ser acessadas através do swagger.

## Métodos
Requisições para a API devem seguir os padrões:

### Users
| Método | URI | Descrição |
|---|---|---|
| `GET` | /user | Retorna todos os registros de usuários do banco de dados.|
| `GET` | /user/{id} | Retorna as informações de um usuário específico através do id no banco de dados. |
| `POST` | /user | Insere um usuário no banco de dados. |
| `PUT` | /user/{id} | Atualiza as informações de um usuário específico através do id no banco de dados.|
| `DELETE` | /user/{id} | Deleta um usuário específico através do id no banco de dados. |

### Motoboys
| Método | URI | Descrição |
|---|---|---|
| `GET` | /motoboy | Retorna todos os registros de motoboys do banco de dados.|
| `GET` | /motoboy/{id} | Retorna as informações de um motoboy específico através do id no banco de dados. |
| `POST` | /motoboy | Insere um motoboy no banco de dados. |
| `PUT` | /motoboy/{id} | Atualiza as informações de um motoboy específico através do id no banco de dados.|
| `DELETE` | /motoboy/{id} | Deleta um motoboy específico através do id no banco de dados. |

### Status
| Método | URI | Descrição |
|---|---|---|
| `GET` | /status | Retorna todos os registros de status do banco de dados.|
| `GET` | /status/{id} | Retorna as informações de um status específico através do id no banco de dados. |
| `POST` | /status | Insere um status no banco de dados. |
| `PUT` | /status/{id} | Atualiza as informações de um status específico através do id no banco de dados.|
| `DELETE` | /status/{id} | Deleta um status específico através do id no banco de dados. |


### Delivery
| Método | URI | Descrição |
|---|---|---|
| `GET` | /delivery | Retorna todos os registros de deliveries do banco de dados.|
| `GET` | /delivery/{id} | Retorna as informações de um delivery específico através do id no banco de dados. |
| `POST` | /delivery | Insere um delivery no banco de dados. |
| `PUT` | /delivery/{id} | Atualiza as informações de um delivery específico através do id no banco de dados.|
| `DELETE` | /delivery/{id} | Deleta um delivery específico através do id no banco de dados. |

### Web
Também foi criada uma rota Web, que serve para requisicões específicas do site, para não haver a necessidade
de alterar as rotas padrões. Nela se pode faze requisoções como alterar apenas o status em uma tabela, alterar apenas o motoboy sem precisar as rotas padroes do CRUD. Essas rotas poderiam estar, se necessário dentro da rotas de suas respectivas tabelas, mas como são exclusivas para a função do site específico, optei por colocar em rotas diferentes.

| Método | URI | Descrição |
|---|---|---|
| `POST` | /filterDeliveries | Retorna o filtro da pesquisa de pedidos entre motoboys estatus no banco de dados.|
| `POST` | /changeStatusDelivery | Atualiza apenas o status de um determinado pedido. |
| `POST` | /changeMotoboyDelivery | Atualiza apenas o motoboy de um determinado pedido. |

# Frontend

### Recursos disponíveis 

* Acesso a todos os pedidos
* troca de motoboys dos pedidos
* troca de status do pedido
* atualização de pedidos
* Criação de pedidos
* Filtro de Pedidos por motoboys
* Filtro de Pedidos por status
* Filtro de Pedidos entre Motoboys e status

### Como usar o front End

O frontend do site foi criado de forma bem simples e intuitiva atendendo os requisitos do desafio.Na página inicial há apenas um texto explicando sobre o que é o site. Se as sugestões feitas na sessão de backend foram seguidas, basta acessar : https://localhost/monorepo_husky/frontend/index.html

Na barra de navegação você pode escolher entre vizualizar ou cadastrar as Entregas. Ao clicar em vizualizar você terá acesso a todos os pedidos com informações de usuários, motoboys, status, endereços de coleta, e endereços de destino podendo filtra-lós por motoboy, por status ou pelos dois.

 Se quiser fazer uma pesquisa mais específica como por exemplo, qual os status das entregas de um motoboy.
 Ao lado das informações do pedido, existe um botão com o icone de um olho, nele vc se irá até a tela do pedido onde poderá alterar o motoboy que fará a entrega e o status do pedido. Se clicar em editar poderá editar todas as informações do pedido. 

Por estarem em projetos diferentes, as URLs das requisições AJAX no frontend estão estáticas e são baseadas na URL do seu servidor. É necessário modificá-las com o caminho igual a da sua variável BASE_PATH no backend.

Se seu servidor não possuir SSL eliminar o s em "https://".
Exemplo:

    Se decidir extrair todos os arquivos da pasta do backend dentro da raiz da sua pasta pública, as requisições devem ser feitas assim assim,:

	$.ajax({
        url: 'https://localhost/status',
        type: 'GET',
        dataType: "JSON",
        success: (data) => {
            changeStatus(data);
        },
        error: (error) => {
            console.log(error.responseText);
        }
    });

    Se seguiu as recomendações da sessão sobre backend, não precisará modificar o frontend, então as requisições estarão assim:

    $.ajax({
        url: 'https://localhost/monorepo_husky/backend/status',
        type: 'GET',
        dataType: "JSON",
        success: (data) => {
            changeStatus(data);
        },
        error: (error) => {
            console.log(error.responseText);
        }
    });
    

## Observações

+ O BANCO DE DADOS FOI CRIARDO DE FORMA SIMPLES E OBJETIVA PARA ESSE PROJETO VIZANDO EXECUTAR O DESAFIO DE FORMA SUCINTA.

+ NÃO FORAM FEITAS TODAS AS VALIDAÇÕES POSSÍVEIS NO FRONTEND.

+ A O TAMANHO DA PASTA DO PROJETO ESTÁ GRANDE POR CAUSA DA PASTA DO SWAGGER.

+ AS CHAVES ESTRANGEIRAS DA TA TABELA DELIVERY DEVEM SER ADCIONADAS DEPENDENDO DO REQUERIMENTO DO PROJETO.
SENDO ASSIM, FORAM COLOCADAS TODAS AS CHAVES ESTRANGEIRAS COM UPDATE E DELETE CASCADE, DESSA FORMA OS AVALIADORES PODEM EXERCER O CRUD SEM SE PREOCUPAR COM AS RESTRIÇÕES.


