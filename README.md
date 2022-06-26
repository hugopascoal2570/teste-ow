### Passo a passo da instalação

# atenção o projeto Utiliza o Docker com containers do nginx, redis, mysql, laravel 9, e queue

Remova o versionamento
```sh
rm -rf .git/
```
Crie o Arquivo .env
```sh
cd example-project/
cp .env.example .env
```
Atualize as variáveis de ambiente do arquivo .env
```dosini
APP_NAME=Teste_ow
APP_URL=http://localhost:8990

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=nome_que_desejar_db
DB_USERNAME=root
DB_PASSWORD=root

CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis

REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379

```
Suba os containers do projeto
```sh
docker-compose up -d
```
Acessar o container
```sh
docker-compose exec ow bash
```

Instalar as dependências do projeto
```sh
composer install
```
Gerar a key do projeto Laravel
```sh
php artisan key:generate
```
Acesse o projeto
[http://localhost:8990](http://localhost:8990)

# Atenção
O projeto conta com os Seeders dos usuários

# Rotas 
| Rota |Método| Usuário precisa estar autenticado  | Requer Parametros no Body  |       Descrição     | 
| ------------------- | ------------------- | ---------------------  | -------------------------- |  -------------------|
|/register| POST  | X | Name, email, password,birthday | Rota para criação de usuário|
| /auth| POST| X  | Email, password, device_name| Rota para autenticação de usuário|
| /api/users| GET | ✔ | X  | Rota para busca de todos os usuários|
| /api/user/id| POST| ✔ | id do usuário  | Rota para busca um usuário específico através de seu ID|
| /api/delete/id| DELETE| ✔ | id do usuário  | Rota para deletar um usuário específico através de seu ID|
| /api/deposit/value| POST| ✔ | valor para depositar  | Rota para dar créditos um usuário específico através de seu ID|
| /api/debit/value| POST| ✔ | valor para debitar saldo da conta  | Rota para retirar créditos um usuário específico através de seu ID |
|sistema não conta com opção de refund|
| /api/historic| GET| ✔ | X  | Rota para mostrar histórico do usuário |
| /api/delete/historic/id| DELETE| ✔ | id do histórico  | Rota para deletar histórico do usuário|
| /api/search/historic/all/| POST| ✔ | id do usuário  | Rota para exibir histórico do usuário em csv (apenas todas as requisições)|

