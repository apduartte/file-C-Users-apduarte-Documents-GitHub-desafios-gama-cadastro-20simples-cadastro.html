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
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Relatório de Cadastros</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 24px; }
    h1 { margin-bottom: 12px; }
    form { margin-bottom: 16px; }
    table { border-collapse: collapse; width: 100%; }
    th, td { border: 1px solid #ddd; padding: 8px; }
    th { background: #f5f5f5; text-align: left; }
    tr:nth-child(even) { background: #fafafa; }
  </style>
</head>
<body>
  <h1>Relatório de Cadastros</h1>

  <!-- Campo de busca -->
  <form method="get">
    <label for="q"><strong>Buscar por nome ou CPF:</strong></label>
    <input type="text" id="q" name="q" value="<?php echo htmlspecialchars($busca); ?>" placeholder="Digite nome ou CPF">
    <button type="submit">Filtrar</button>
    <a href="relatorio.php">Limpar</a>
  </form>

  <?php if (count($linhas) === 0): ?>
    <p>Nenhum cadastro encontrado.</p>
  <?php else: ?>
    <table>
      <thead>
        <tr>
          <?php foreach ($linhas[0] as $h) echo "<th>".htmlspecialchars($h)."</th>"; ?>
        </tr>
      </thead>
      <tbody>
        <?php
          for ($i = 1; $i < count($linhas); $i++) {
            $row = $linhas[$i];
            if (!matchRow($row, $busca)) continue; // aplica filtro
            echo '<tr>';
            foreach ($row as $campo) {
              echo '<td>'.htmlspecialchars($campo).'</td>';
            }
            echo '</tr>';
          }
        ?>
      </tbody>
    </table>
  <?php endif; ?>

  <p><a href="index.html">Voltar ao formulário</a></p>
</body>
</html>