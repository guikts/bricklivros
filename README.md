# BrickLivros - Sistema de Gestão de Bibliotecas

O BrickLivros é um sistema web desenvolvido para modernizar e simplificar a gestão de bibliotecas. Ele automatiza o catálogo de livros, o controle de empréstimos, devoluções e o cálculo de multas por atraso, oferecendo painéis personalizados tanto para os bibliotecários quanto para os leitores.

---

## Funcionalidades Principais

* Controle de Acesso (RBAC): Níveis de usuário distintos (Bibliotecário e Cliente/Leitor).
* Catálogo Inteligente: Visualização do acervo com controle dinâmico de estoque disponível.
* Gestão de Empréstimos e Devoluções: Sistema ágil para registrar saídas e entradas de livros.
* Cálculo Automático de Multas: O sistema calcula multas em tempo real com base na data de devolução estipulada.
* Dashboard Interativo: Painel focado na experiência do usuário (UX), mostrando contagem regressiva de dias para devolução.
* Geração de Relatórios: Exportação de relatórios de empréstimos em formato PDF.

---

## Tecnologias Utilizadas

* Backend: PHP 8+ e Laravel
* Frontend: HTML5, CSS3 puro e Laravel Blade
* Banco de Dados: MySQL
* Servidor Local Recomendado: Laragon ou XAMPP

---

## Como rodar o projeto localmente

Siga o passo a passo abaixo para clonar e rodar o BrickLivros na sua máquina.

### 1. Pré-requisitos
Certifique-se de ter instalado em sua máquina:
* PHP (Versão 8.0 ou superior)
* Composer (Gerenciador de dependências do PHP)
* MySQL (Pode usar o embutido no Laragon/XAMPP)
* Git

### 2. Clonando o Repositório
Abra o seu terminal e rode o comando:
```bash
git clone [https://github.com/guikts/bricklivros.git](https://github.com/guikts/bricklivros.git)
```
### 3. Instalando as Dependências
```bash
cd bricklivros
composer install
```

### 4. Configurando o ambiente (.env)
Copie o arquivo de exemplo
```bash
cp .env.example .env
```

Gere a chave de segurança do sistema
```bash
php artisan key:generate
```

### 5. Crie o Banco de Dados pelo MySQL ou pelo terminal:
```sql
CREATE DATABASE bricklivros;
```
### 6. Configurando a Conexão (.env)
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bricklivros
DB_USERNAME=root
DB_PASSWORD=
```
### 7. Execute as Migrations

```bash
php artisan migrate
```
### 8. Rodando a Aplicação

```bash
php atisan serve
```





