<?php

require_once "./vendor/autoload.php";

use Luizlins\Projeto01\Dominio\Modulos\Medico;
use Luizlins\Projeto01\Dominio\Modulos\Paciente;
use Luizlins\Projeto01\Dominio\Modulos\Consulta;
use Luizlins\Projeto01\Infraestrutura\Configuracoes\Telefone;
use Luizlins\Projeto01\Infraestrutura\Persistencia\FabricaConexao;
use Luizlins\Projeto01\Infraestrutura\Repositorios\RepositorioPaciente;
use Luizlins\Projeto01\Infraestrutura\Repositorios\RepositorioMedico;

$medico = new Medico(
    null,
    "CRM/PI 24546",
    "Luiz Lins",
    "Oftomologista"
);

$telefone = new Telefone("86999920976");
$dataNascimento = new DateTimeImmutable("1985-10-27");

$paciente = new Paciente(
    "006 237 863 55",
    "Maria Antonia",
    [$telefone],
    $dataNascimento
);

$dataConsulta = new DateTimeImmutable("2026-03-01 13:00"); 
$consulta = new Consulta(
    $medico,
    $paciente,
    $dataConsulta,
    400.00
);

var_dump($consulta);

$pdo = FabricaConexao::criarConexao();

$repositorio = new RepositorioPaciente($pdo);
$sucesso = $repositorio->salvar($paciente);

if ($sucesso) {
    echo "\n✅ Paciente salvo no banco!";
} else {
    echo "\n❌ Erro ao salvar.";
}

$repositorioMedico = new RepositorioMedico();
$sucessoMedico = $repositorioMedico->inserir($medico);

if ($sucessoMedico) {
    echo "\n✅ Médico salvo no banco!";
} else {
    echo "\n❌ Erro ao salvar médico.";
}