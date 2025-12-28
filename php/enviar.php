<?php
// Mostrar erros em dev (remova em produção)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Sempre responder JSON
header('Content-Type: application/json; charset=UTF-8');

// Aceitar somente POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode(['ok' => false, 'message' => 'Método não permitido.']);
  exit;
}

// Coletar campos
$campos = [
  'nome'       => $_POST['nome'] ?? '',
  'cpf'        => $_POST['cpf'] ?? '',
  'rg'         => $_POST['rg'] ?? '',
  'sexo'       => $_POST['sexo'] ?? '',
  'logradouro' => $_POST['logradouro'] ?? '',
  'numero'     => $_POST['numero'] ?? '',
  'bairro'     => $_POST['bairro'] ?? '',
  'cidade'     => $_POST['cidade'] ?? '',
  'estado'     => $_POST['estado'] ?? '',
  'cep'        => $_POST['cep'] ?? '',
  'telFixo'    => $_POST['telFixo'] ?? '',
  'telCelular' => $_POST['telCelular'] ?? '',
  'dataHora'   => date('Y-m-d H:i:s')
];

// Caminho do CSV (ajuste conforme sua estrutura)
$arquivo = __DIR__ . '/../cadastros.csv';
$novoArquivo = !file_exists($arquivo);

try {
  $fp = fopen($arquivo, 'a');
  if (!$fp) {
    throw new Exception('Não foi possível abrir o arquivo de cadastros.');
  }

  // Cabeçalho na primeira vez
  if ($novoArquivo) {
    fputcsv($fp, array_keys($campos), ';');
  }

  // Linha de dados
  fputcsv($fp, array_values($campos), ';');
  fclose($fp);

  echo json_encode(['ok' => true, 'message' => 'Cadastro salvo com sucesso!']);
  exit;

} catch (Exception $e) {
  echo json_encode(['ok' => false, 'message' => $e->getMessage()]);
  exit;
}