# Sistema de Receitas

Um sistema de gerenciamento de receitas culinárias desenvolvido para avaliação da empresa Private Code.

---

## Índice

- [Sobre o Projeto](#sobre-o-projeto)
- [Funcionalidades](#funcionalidades)
- [Tecnologias](#tecnologias)
- [Arquitetura](#arquitetura)
- [Pré-requisitos](#pré-requisitos)
- [Instalação](#instalação)
- [Executando o Projeto](#executando-o-projeto)
- [Testes](#testes)
- [Usuário de Teste](#usuário-de-teste)
- [Banco de Dados](#banco-de-dados)
- [Notas de Desenvolvimento](#notas-de-desenvolvimento)
- [Dúvidas](#dúvidas)

---

## Sobre o Projeto

Sistema web para compartilhamento e avaliação de receitas culinárias, onde usuários podem:
- Criar e compartilhar suas próprias receitas
- Avaliar receitas de outros usuários
- Comentar em receitas
- Visualizar receitas com sistema de avaliação por estrelas

**Objetivo:** Demonstrar implementação de CRUD completo com Laravel seguindo princípios SOLID, Repository Pattern e Service Layer.

---

## Funcionalidades

### Autenticação
- [x] Registro de novos usuários
- [x] Login/Logout
- [x] Validação de formulários em português
- [x] Proteção CSRF em todas as requisições

### Receitas (CRUD Completo)
- [x] Listagem paginada de receitas
- [x] Visualização detalhada de receitas
- [x] Criação de novas receitas (autenticado)
- [x] Edição de receitas próprias
- [x] Exclusão de receitas próprias
- [x] Ingredientes dinâmicos (array)
- [x] Modo de preparo em texto longo

### Sistema de Avaliações
- [x] Avaliar receitas com 1-5 estrelas
- [x] Média de avaliações exibida
- [x] Usuário pode avaliar apenas uma vez por receita
- [x] Não pode avaliar própria receita

### Sistema de Comentários
- [x] Comentar em receitas
- [x] Exibir autor e data do comentário
- [x] Apenas usuários autenticados podem comentar

### Qualidade e Testes
- [x] 66 testes unitários automatizados (Pest PHP)
- [x] 100% cobertura em Services, Repositories e Policies

---

## Tecnologias

### Backend
- **Laravel 12** - Framework PHP
- **PHP 8.2+** - Linguagem de programação
- **MySQL/SQLite** - Banco de dados
- **Eloquent ORM** - Mapeamento objeto-relacional

### Testes
- **Pest PHP 3.8** - Framework de testes moderno
- **Mockery** - Biblioteca de mocks
- **66 testes unitários** - 100% cobertura em Services/Repositories/Policies

### Frontend
- **Blade Templates** - Motor de templates do Laravel
- **Bootstrap 5.3** - Framework CSS
- **Bootstrap Icons 1.10** - Biblioteca de ícones
- **CSS3** - Estilos customizados
- **MySQL** - Banco de dados
### Arquitetura
- **Repository Pattern** - Abstração de acesso a dados
- **Service Layer** - Lógica de negócio isolada
- **Policies** - Autorização granular
- **Form Requests** - Validação encapsulada
- **Seeders/Factories** - Dados de teste

---

## Arquitetura

```
┌─────────────────────────────────────────────────────┐
│                    CONTROLLER                        │
│              (RecipeController.php)                  │
│         Recebe requests, retorna responses           │
└──────────────────┬──────────────────────────────────┘
                   │
                   ▼
┌─────────────────────────────────────────────────────┐
│                    SERVICE                           │
│               (RecipeService.php)                    │
│           Lógica de negócio isolada                  │
└──────────────────┬──────────────────────────────────┘
                   │
                   ▼
┌─────────────────────────────────────────────────────┐
│                   REPOSITORY                         │
│             (RecipeRepository.php)                   │
│          Abstração de acesso ao banco                │
└──────────────────┬──────────────────────────────────┘
                   │
                   ▼
┌─────────────────────────────────────────────────────┐
│                     MODEL                            │
│                  (Recipe.php)                        │
│              Representação da entidade               │
└─────────────────────────────────────────────────────┘
```

---

## Pré-requisitos

Certifique-se de ter instalado:

- **PHP 8.2 ou superior**
  ```bash
  php -v
  ```

- **Composer** (gerenciador de dependências PHP)
  ```bash
  composer --version
  ```

- **MySQL**
  ```bash
  mysql --version
  ```

- **Git** (opcional, para clonar o repositório)
  ```bash
  git --version
  ```

---

## Instalação

### 1. Clone o Repositório
```bash
git clone https://github.com/Vinicius-1307/private_code_test.git
cd private_code_test
```

### 2. Instale as Dependências PHP
```bash
composer install
```

### 3. Configure o Arquivo de Ambiente
```bash
# Copie o arquivo de exemplo
cp .env.example .env

# Gere a chave da aplicação
php artisan key:generate
```

### 4. Configure o Banco de Dados

Crie o banco de dados MySQL:
```bash
mysql -u root -p
CREATE DATABASE sistema_receitas;
EXIT;
```

Edite o arquivo `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistema_receitas
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

### 5. Execute as Migrations e Seeders
```bash
# Recria todas as tabelas e popula com dados de teste
php artisan migrate:fresh --seed
```

Isso irá criar:
- 5 usuários (incluindo usuário de teste)
- 6 receitas variadas (bolo, lasanha, brigadeiro, etc.)
- Tabelas de comentários e avaliações

---

## Executando o Projeto

### Inicie o Servidor de Desenvolvimento

```bash
php artisan serve
```

Acesse: **http://localhost:8000**

### Porta Customizada (Opcional)

```bash
php artisan serve --port=8080
```

Acesse: **http://localhost:8080**

---

## Testes

O projeto possui **cobertura completa de testes unitários** implementados com **Pest PHP**.

### 📊 Cobertura de Testes

```
✅ 66 testes | 163 assertions
✅ Services: 100% cobertura (31 testes)
✅ Repositories: 100% cobertura (22 testes)  
✅ Policies: 100% cobertura (11 testes)
✅ Tempo de execução: ~0.54s
```

### Executando os Testes

**Todos os testes:**
```bash
composer test
```

### Componentes Testados

**Services:**
- `RecipeService` - 12 testes (CRUD, paginação, validações)
- `CommentService` - 7 testes (criação, listagem, exclusão)
- `RatingService` - 12 testes (avaliações, scores 1-5)

**Repositories:**
- `RecipeRepository` - 10 testes (queries, eager loading)
- `CommentRepository` - 5 testes (CRUD, ordenação)
- `RatingRepository` - 7 testes (updateOrCreate, unicidade)

**Policies:**
- `RecipePolicy` - 6 testes (autorização update/delete)
- `CommentPolicy` - 5 testes (múltiplos cenários)

---

## Usuário de Teste

Após executar as seeders (`migrate:fresh --seed`), use essas credenciais para login:

```
Email: privatecode@email.com
Senha: password
```

**Outros usuários também disponíveis:**
- Todos com senha `password`
- Nomes e emails gerados aleatoriamente pelo Faker

---

## Banco de Dados

### Schema de Receitas
```sql
recipes
├── id (PK)
├── user_id (FK → users)
├── title (string)
├── description (text, nullable)
├── ingredients (json)
├── steps (text)
├── created_at
└── updated_at
```

### Schema de Avaliações
```sql
ratings
├── id (PK)
├── recipe_id (FK → recipes)
├── user_id (FK → users)
├── score (integer 1-5)
├── created_at
└── updated_at

UNIQUE(recipe_id, user_id) # Um usuário avalia uma vez
```

### Schema de Comentários
```sql
comments
├── id (PK)
├── recipe_id (FK → recipes)
├── user_id (FK → users)
├── body (text)
├── created_at
└── updated_at
```

---

## Notas de Desenvolvimento

### Padrões Utilizados
- **Repository Pattern** - Abstração de dados
- **Service Layer** - Lógica de negócio
- **Dependency Injection** - Via constructor
- **Policy-Based Authorization** - Gates e Policies
- **Form Request Validation** - Validação encapsulada

### Princípios SOLID
- **S**ingle Responsibility - Cada classe tem uma responsabilidade
- **O**pen/Closed - Aberto para extensão, fechado para modificação
- **L**iskov Substitution - Interfaces garantem substituibilidade
- **I**nterface Segregation - Interfaces específicas
- **D**ependency Inversion - Dependências via abstração

### Qualidade de Código
- **66 testes unitários** com Pest PHP
- **100% cobertura** em Services, Repositories e Policies
- **Mocks e stubs** para isolamento de testes
- **TDD-ready** - Estrutura preparada para Test-Driven Development
- Documentação completa de testes em [TESTING.md](TESTING.md)

---

## Dúvidas
**Email:** viniciusjose9@outlook.com

**LinkedIn:** [Vinicius José](https://www.linkedin.com/in/vinicius-josé-dev/)
