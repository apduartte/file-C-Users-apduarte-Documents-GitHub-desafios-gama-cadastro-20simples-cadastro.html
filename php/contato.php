<?php
header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="cadastros_filtrados.csv"');

$arquivo = 'cadastros.csv';
$linhas = [];

if (file_exists($arquivo)) {
  if (($fp = fopen($arquivo, 'r')) !== false) {
    while (($row = fgetcsv($fp, 0, ';')) !== false) {
      $linhas[] = $row;
    }
    fclose($fp);
  }
}

// captura termo de busca
$busca = trim($_GET['q'] ?? '');

// função para verificar se linha contém o termo
function matchRow($row, $busca) {
  if ($busca === '') return true;
  foreach ($row as $campo) {
    if (stripos($campo, $busca) !== false) return true;
  }
  return false;
}

// exporta cabeçalho
if (count($linhas) > 0) {
  $fp = fopen('php://output', 'w');
  fputcsv($fp, $linhas[0], ';');

  // exporta apenas linhas que batem com a busca
  for ($i = 1; $i < count($linhas); $i++) {
    $row = $linhas[$i];
    if (!matchRow($row, $busca)) continue;
    fputcsv($fp, $row, ';');
  }
  fclose($fp);
}