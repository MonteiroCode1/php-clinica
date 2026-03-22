# Projeto-01: Sistema de Gestão Médica em PHP

## Descrição do Projeto

Este é um projeto didático desenvolvido em PHP para demonstrar conceitos fundamentais de programação orientada a objetos (POO), arquitetura de software e persistência de dados. O sistema simula um **Sistema de Gestão Médica** simples, focando no gerenciamento de médicos, pacientes e consultas.

O projeto utiliza:
- **PHP 8+** com tipagem forte e propriedades readonly.
- **Composer** para autoloading PSR-4.
- **SQLite** como banco de dados para simplicidade.
- Padrões de arquitetura como **Domain-Driven Design (DDD)**, **Repository Pattern** e **Dependency Injection**.

Este projeto serve como referência para estudantes aprenderem sobre:
- Estruturação de projetos PHP.
- Separação de responsabilidades (Domínio vs Infraestrutura).
- Interfaces e implementação de repositórios.
- Conexão e operações básicas com banco de dados.
- Validação de dados e formatação.

## Estrutura do Projeto

```
PROJETO-01/
├── composer.json              # Configuração do Composer e autoload PSR-4
├── README.md                  # Este arquivo
├── banco.sqlite               # Banco de dados SQLite (criado manualmente)
├── index.php                  # Script principal de exemplo
├── medico.php                 # Script para criar a tabela 'medicos'
├── conexao.php                # Exemplo de conexão PDO
├── inserir-medico.php         # Exemplo de inserção via repositório
├── recuperar-medicos.php      # Exemplo de listagem via repositório
├── atualizar-medico.php       # Exemplo de atualização via repositório
├── remover-medico.php         # Exemplo de remoção via repositório
├── src/
│   ├── Dominio/               # Camada de Domínio (Regras de Negócio)
│   │   ├── Modulos/           # Entidades do Domínio
│   │   │   ├── Consulta.php   # Classe Consulta
│   │   │   ├── Medico.php     # Classe Medico
│   │   │   └── Paciente.php   # Classe Paciente
│   │   └── Repositorio/       # Interfaces de Repositório
│   │       └── RepositorioMedicoInterface.php
│   └── Infraestrutura/        # Camada de Infraestrutura (Implementações Técnicas)
│       ├── Configuracoes/     # Configurações e Utilitários
│       │   └── Telefone.php   # Classe para validação de telefones
│       ├── Persistencia/      # Camada de Persistência
│       │   └── FabricaConexao.php  # Factory para conexão PDO
│       └── Repositorios/      # Implementações de Repositórios
│           └── RepositorioMedico.php
└── vendor/                    # Dependências geradas pelo Composer
```

## Arquitetura e Conceitos

### Domain-Driven Design (DDD)
- **Domínio**: Representa o conhecimento do negócio (médicos, pacientes, consultas).
- **Entidades**: Classes como `Medico`, `Paciente`, `Consulta` que encapsulam dados e comportamentos.
- **Value Objects**: `Telefone` como um objeto de valor com validação.

### Repository Pattern
- Abstrai o acesso aos dados.
- Interface `RepositorioMedicoInterface` define contratos.
- Implementação `RepositorioMedico` lida com PDO e SQLite.

### Separação de Camadas
- **Domínio**: Independente de tecnologia (não conhece PDO ou SQLite).
- **Infraestrutura**: Implementa detalhes técnicos (conexão, queries).

## Requisitos do Sistema

- **PHP 8.0 ou superior** (para propriedades readonly e tipagem).
- **Composer** instalado.
- **SQLite3** disponível no sistema.

## Instalação e Configuração

### 1. Clonagem e Dependências
```bash
# Navegue até a pasta do projeto
cd PROJETO-01

# Instale as dependências via Composer
composer install
composer dump-autoload
```

### 2. Configuração do Banco de Dados
O projeto utiliza SQLite para simplicidade. Execute os comandos abaixo no terminal:

```bash
# Crie o arquivo do banco
touch banco.sqlite

# Abra o SQLite e crie a tabela
sqlite3 banco.sqlite

# Dentro do SQLite, execute:
CREATE TABLE medicos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    crm TEXT NOT NULL,
    nome TEXT NOT NULL,
    especialidade TEXT NOT NULL
);

# Insira dados de exemplo
INSERT INTO medicos (crm, nome, especialidade) VALUES ('CRM/PI 24546', 'Luiz Lins', 'Oftalmologista');
INSERT INTO medicos (crm, nome, especialidade) VALUES ('CRM/PI 12345', 'Maria Silva', 'Cardiologista');

# Saia do SQLite
.exit
```

Alternativamente, execute o script `medico.php` para criar a tabela:
```bash
php medico.php
```

## Executando o Projeto

### Exemplos de Uso

#### 1. Script Principal (`index.php`)
Demonstra a criação de objetos de domínio e uma consulta.
```bash
php index.php
```
Este script cria instâncias de `Medico`, `Paciente`, `Telefone` e `Consulta`, e faz um `var_dump` da consulta.

#### 2. Operações CRUD com Médicos
- **Listar médicos**:
  ```bash
  php recuperar-medicos.php
  ```
- **Inserir médico**:
  ```bash
  php inserir-medico.php
  ```
- **Atualizar médico** (exemplo com ID 2):
  ```bash
  php atualizar-medico.php
  ```
- **Remover médico** (exemplo com ID 1):
  ```bash
  php remover-medico.php
  ```

#### 3. Conexão Simples (`conexao.php`)
```bash
php conexao.php
```
Apenas conecta ao banco e imprime "Conectei".

## Classes Principais e Exemplos de Código

### Classe `Medico`
```php
<?php
namespace Luizlins\Projeto01\Dominio\Modulos;

class Medico {
    public function __construct(
        private ?int $id,
        private string $crm,
        private string $nome,
        private string $especialidade
    ) {}

    // Getters e setters
    public function recuperarId(): ?int { return $this->id; }
    public function definirId(int $id) { $this->id = $id; }
    public function recuperarCRM(): string { return $this->crm; }
    public function recuperarNome(): string { return strtoupper($this->nome); }
    public function recuperarEspecialidade(): string { return $this->especialidade; }
}
```

**Estudo**: Observe o uso de propriedades privadas e métodos de acesso. O nome é sempre retornado em maiúsculo.

### Classe `Paciente`
```php
<?php
namespace Luizlins\Projeto01\Dominio\Modulos;

use DateTimeImmutable;

class Paciente {
    public function __construct(
        private string $cpf,
        private string $nome,
        private array $telefone,  // Array de objetos Telefone
        private DateTimeImmutable $dataNascimento
    ) {}
    // Nota: Esta classe não possui getters implementados no código atual.
}
```

**Estudo**: Usa `DateTimeImmutable` para datas imutáveis. Telefones são um array de objetos `Telefone`.

### Classe `Consulta`
```php
<?php
namespace Luizlins\Projeto01\Dominio\Modulos;

class Consulta {
    public function __construct(
        private Medico $medico,
        private Paciente $paciente,
        private DateTimeImmutable $data,
        private float $valor
    ) {}
    // Nota: Sem getters implementados.
}
```

**Estudo**: Composição de objetos (Medico e Paciente).

### Classe `Telefone` (Value Object)
```php
<?php
namespace Luizlins\Projeto01\Infraestrutura\Configuracoes;

class Telefone {
    public function __construct(private string $numero) {
        $digitos = preg_replace('/\D/', '', $numero);
        if (strlen($digitos) !== 11) {
            throw new Exception("Formato de telefone inválido");
        }
        $this->numero = preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1)$2-$3', $digitos);
    }
}
```

**Estudo**: Validação de formato brasileiro (11 dígitos) e formatação automática.

### Repositório `RepositorioMedico`
Implementa operações CRUD usando PDO preparado para evitar SQL Injection.

**Método `inserir`**:
```php
public function inserir(Medico $medico): bool {
    $stmt = $this->conexao->prepare("INSERT INTO medicos (crm, nome, especialidade) VALUES (:crm, :nome, :especialidade)");
    $sucesso = $stmt->execute([
        ':crm' => $medico->recuperarCRM(),
        ':nome' => $medico->recuperarNome(),
        ':especialidade' => $medico->recuperarEspecialidade(),
    ]);
    $medico->definirId($this->conexao->lastInsertId());
    return $sucesso;
}
```

**Estudo**: Uso de prepared statements e hidratação de objetos.

## Esquema do Banco de Dados

### Tabela `medicos`
```sql
CREATE TABLE medicos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    crm TEXT NOT NULL,
    nome TEXT NOT NULL,
    especialidade TEXT NOT NULL
);
```

**Sugestões para Expansão**:
- Adicionar tabelas para `pacientes` e `consultas`.
- Implementar relacionamentos (foreign keys).

## Pontos de Estudo e Melhorias Sugeridas

### Conceitos Aprendidos
1. **Namespaces e Autoloading PSR-4**: Como organizar código em pastas.
2. **Injeção de Dependência**: `FabricaConexao` cria conexões.
3. **Imutabilidade**: Uso de `DateTimeImmutable`.
4. **Validação**: Classe `Telefone` valida entrada.
5. **Padrões de Projeto**: Repository abstrai persistência.

### Melhorias Possíveis
- **Completar as Classes**: Adicionar getters a `Paciente` e `Consulta`.
- **Implementar `recuperar`**: Método não implementado em `RepositorioMedico`.
- **Tratamento de Erros**: Adicionar try-catch nas operações de banco.
- **Testes Unitários**: Usar PHPUnit para testar classes.
- **Expandir o Domínio**: Adicionar mais entidades e regras de negócio.
- **API REST**: Transformar em uma API com rotas para CRUD.
- **Migrations**: Usar ferramentas como Doctrine para gerenciar schema.

### Exercícios para Estudantes
1. Implemente getters para `Paciente` e `Consulta`.
2. Crie um repositório para `Paciente` seguindo o padrão.
3. Adicione validação de CPF na classe `Paciente`.
4. Implemente o método `recuperar` no repositório.
5. Crie um script para popular o banco com dados fictícios.

## Contribuição

Este projeto é didático. Sugestões de melhorias são bem-vindas via pull requests ou issues.

## Autor

Luiz Lins (luizmagao@gmail.com)
