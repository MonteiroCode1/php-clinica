<?php

namespace Luizlins\Projeto01\Infraestrutura\Repositorios;

use Luizlins\Projeto01\Dominio\Modulos\Paciente;
use PDO;

class RepositorioPaciente
{
    public function __construct(private PDO $pdo) {}

    public function salvar(Paciente $paciente): bool
    {
        $sql = "INSERT INTO pacientes (cpf, nome, data_nascimento) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        
        return $stmt->execute([
            $paciente->recuperarCpf(),
            $paciente->recuperarNome(),
            $paciente->recuperarDataNascimento()->format('Y-m-d')
        ]);
    }

    public function buscarTodos(): array
    {
        $sql = "SELECT * FROM pacientes;";
        $stmt = $this->pdo->query($sql);
        $dadosPacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $listaPacientes = [];

        foreach ($dadosPacientes as $dados) {
            $listaPacientes[] = new Paciente(
                $dados['cpf'],
                $dados['nome'],
                [], 
                new \DateTimeImmutable($dados['data_nascimento'])
            );
        }

        return $listaPacientes;
    }
}