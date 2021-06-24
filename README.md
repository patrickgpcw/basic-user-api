# API de Usuário

## Requisito para conseguir rodar o projeto

        Laravel 8

## Desejável para realizar o teste fora do Laravel

        Insomnia

## Clonando repositório

Executar o comando:

`git clone git@github.com:patrickgpcw/basic-user-api.git`

## Configurando o arquivo `.env`

Copie `.env.example` e crie o seu proprio `.env`.

Ao criar `.env` é preciso configurar o banco de dados do projeto, e chave JWT

Exemplo:

```shell
    DB_DATABASE=basic_user_db
    DB_USERNAME=root
    DB_PASSWORD=

    # ...

    JWT_PRIVATE_KEY=chave_super_secreta
```

## Migrando as informações para o banco de dados

Rode o comando

`php artisan migrate --seed`

Obs: O comando irá subir informações fictícias

## Rodando servidor

Utilize comando para rodar na porta 8000 (`http://localhost:8000`):

`php artisan serve`

## Endpoints da aplicação

| Nome        | Método | URL              | Autenticação Necessária |
| ----------- | ------ | ---------------- | ----------------------- |
| Login       | POST   | /api/login       | Não                     |
| Create User | POST   | /api/usuario     | Não                     |
| Read Users  | GET    | /api/usuario     | Sim                     |
| Show User   | GET    | /api/usuario/$id | Sim                     |
| Update User | PUT    | /api/usuario/$id | Sim                     |
| Delete User | DELETE | /api/usuario/$id | Sim                     |

> OBS. Todas as rotas com retorno no status 200, retorna um JSON, mas o `abort` no Laravel pode retornar um redirect, sendo assim, é interessante colocarno Header de todas as requisições `Accept: application/json` forçando retorno apenas em JSON

## Rotas

Todas as rotas que necessitam de autorização, necessário passar no header:

```
Authorization: Bearer /*jwt token de login*/
```

### Rota: Create User (POST /api/usuario)

Criação de um usuário

Body (JSON):

```json
{
    "first_name": "Patrick",
    "last_name": "Pessanha",
    "email": "patrick@patrick.com",
    "telephone": "+5521987330102",
    "password": "password",
    "password_confirmation": "password"
}
```

### Read User (GET /api/usuario)

Retorna uma lista de todos os usuários, **necessário autenticação**

Filtros (Parâmetros via GET):

| Nome do Filtro | Descrição                                             |
| -------------- | ----------------------------------------------------- |
| nome           | Retorna usuários onde o nome contain o parâmetro      |
| exibir         | Quantidade de itens que devem ser exibidos por página |
| pagina         | Pagina Atual                                          |

Ex: `http://localhost:8000/api/usuario?nome=Pa&exibir=7&pagina=2`

### Show User (GET /api/usuario/$id)

Retorna um usuário específico, **necessário autenticação**

### Update User (PUT /api/usuario/$id)

Atualizar um usuário específico, **necessário autenticação**

Body (JSON):

Sem a troca de senha

```json
{
    "first_name": "John",
    "last_name": "Doe",
    "email": "john@doe.com",
    "telephone": "+5521911112222"
}
```

Com a troca de senha

```json
{
    "first_name": "John",
    "last_name": "Doe",
    "email": "john@doe.com",
    "telephone": "+5521911112222",
    "password": "123trocar",
    "password_confirmation": "123trocar"
}
```

### Delete User (DELETE /api/usuario/$id)

Deletar um usuário específico, **necessário autenticação**

## Configurações

### API

No arquivo `config/api.php` tem as seguintes configurações:

| Nome da Configuração | Descrição                                          |
| -------------------- | -------------------------------------------------- |
| quantity             | Quantidade de items padrão quando realizado `read` |
| page                 | Página padrão quando realizado `read`              |

### Salt

No arquivo `config/salt.php` tem as seguintes configurações:

| Nome da Configuração | Descrição                                                         |
| -------------------- | ----------------------------------------------------------------- |
| preffix              | Char antes do Salt                                                |
| suffix               | Char depois do Salt                                               |
| length               | Tamanho do Salt                                                   |
| update_on_login      | Se deve atualizar o Salt no BD quando realizado login com sucesso |

## Testes

### PHP Unit

Para realizar os testes, é recomendado que seja feito um arquivo `.env.testing` para o ambiente de teste e rodar o comando:

`php artisan migrate --seed --env=testing`

Para realizar os testes execute o comando:

`php artisan test`

### Insomnia

Importar o arquivo `Insomnia_2021-06-24.json` no Insomnia e realizar todos os requests.
