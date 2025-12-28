<?php
header('Content-Type: application/json; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(['ok' => false, 'message' => 'Método não permitido']);
  exit;
}

function clean($key) {
  return trim(filter_input(INPUT_POST, $key, FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '');
}

$dados = [
  'data_hora'  => date('Y-m-d H:i:s'),
  'nome'       => clean('nome'),
  'cpf'        => clean('cpf'),
  'rg'         => clean('rg'),
  'sexo'       => clean('sexo'),
  'logradouro' => clean('logradouro'),
  'numero'     => clean('numero'),
  'bairro'     => clean('bairro'),
  'cidade'     => clean('cidade'),
  'estado'     => clean('estado'),
  'cep'        => clean('cep'),
  'telFixo'    => clean('telFixo'),
  'telCelular' => clean('telCelular')
];

$arquivo = 'cadastros.csv';
if (!file_exists($arquivo)) {
  $cabecalho = array_keys($dados);
  $fp = fopen($arquivo, 'w');
  fputcsv($fp, $cabecalho, ';');
  fclose($fp);
}

$fp = fopen($arquivo, 'a');
fputcsv($fp, array_values($dados), ';');
fclose($fp);

echo json_encode(['ok' => true, 'message' => 'Cadastro salvo com sucesso!']);