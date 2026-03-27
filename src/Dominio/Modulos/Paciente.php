<?php

namespace Luizlins\Projeto01\Dominio\Modulos;

use DateTimeImmutable;

class Paciente {

    function __construct(
        private string $cpf,
        private string $nome,
        private array $telefone,
        private DateTimeImmutable $dataNascimento
    ) {}
    
public function recuperarCpf(): string 
    {
        return $this->cpf;
    }

    public function recuperarNome(): string 
    {
        return $this->nome;
    }

    public function recuperarTelefone(): array 
    {
        return $this->telefone;
    }

    public function recuperarDataNascimento(): DateTimeImmutable 
    {
        return $this->dataNascimento;
    }
}