<?php
header('Content-Type: text/html; charset=UTF-8');
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
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Relatório de Cadastros</title>
</head>
<body>
  <h1>Relatório de Cadastros</h1>
  <?php if (count($linhas) === 0): ?>
    <p>Nenhum cadastro encontrado.</p>
  <?php else: ?>
    <table border="1">
      <thead>
        <tr>
          <?php foreach ($linhas[0] as $h) echo "<th>".htmlspecialchars($h)."</th>"; ?>
        </tr>
      </thead>
      <tbody>
        <?php for ($i=1; $i<count($linhas); $i++): ?>
          <tr>
            <?php foreach ($linhas[$i] as $campo) echo "<td>".htmlspecialchars($campo)."</td>"; ?>
          </tr>
        <?php endfor; ?>
      </tbody>
    </table>
  <?php endif; ?>
</body>
</html>