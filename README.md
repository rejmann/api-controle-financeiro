# Desafio de Back-end da Alura

Crie uma API Rest funcional focada em controle financeiro.

## Autor

- [Site](https://www.rejman.dev.br)
- [Linkedin](https://www.linkedin.com/in/nascimentorejman)
- [Github](https://www.github.com/rejmann)

## Tecnologias

**Back-end:** Lumen e MySql

**Server:** Nginx

**Devops:** Docker

## Instalação

Clone o repositório:

```bash
  git clone https://github.com/rejmann/challenge-api-controle-financeiro-lumen.git
```

Acesse o diretório e suba os containers:

```bash
  cd challenge-api-controle-financeiro-lumen
  docker compose up --build --remove-orphans
```

Acesse o container da aplicação com:

```bash
  docker exec -it -u $(id -u):$(id -g) app bash
```

Criar as tabelas e populando o banco de dados:

```bash
  php artisan migrate --seed
```

## Referências da API

#### Url base:

```http
  localhost:8989/api/
```

#### Cadastrando Usuário:

```http
  POST /cadastrar
```
```json
{
    "name": "Usuário",
    "email": "email@exemplo.com",
    "password": "Senha"
}
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `name` | `string` | **required** |
| `email` | `email` | **required,unique** |
| `password` | `password` | **required,max:500** |

#### Gerando Access Token:

```http
  POST /login
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `email` | `email` | **required** |
| `password` | `password` | **required,max:500** |


#### Cadastrar Receitas ou Despesas:

```http
  POST /receitas | POST /despesas
```
```json
{
    "description": "Descrição da movimentação",
    "date": "11/01/2023",
    "value": 100,
    "type": "despesas"
}
```
| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `description` | `string` | **required,max:255** |
| `date` | `date` | **required,date** |
| `value` | `integer` | **required,integer** |
| `type` | `password` | **required,string** |
| `category` | `password` | **required,string** (não obrigatório para receita) |

#### Buscar Receitas ou Despesas:

```http
  GET /receitas | GET /despesas
```

#### Buscar por ID, Receita ou Despesa específica:

```http
  GET /receitas/{$id} | GET /despesas/{$id} 
```

#### Buscar Receitas ou Despesas por descrição:

```http
  GET /receitas?descricao="sua_descricao" | GET /despesas?descricao="sua_descricao" 
```

#### Buscar Receitas ou Despesas por período:

```http
  GET /receitas/{$ano}/{$mes} | GET /despesas/{$ano}/{$mes} 
```

#### Atualizar Receitas ou Despesas:

```http
  PUT /receitas/{$id} | GET /despesas/{$id} 
```
```json
{
    "description": "Descrição da movimentação ATUALIZADA",
    "date": "11/01/2023",
    "value": 100,
}
```
| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `description` | `string` | **required,max:255** |
| `date` | `date` | **required,date** |
| `value` | `integer` | **required,integer** |

#### Excluindo Receitas ou Despesas:

```http
  DELETE /receitas/{$id} | GET /despesas/{$id} 
```