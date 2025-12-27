<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nome = $_POST["nome"];
  $cpf = $_POST["cpf"];
  $rg = $_POST["rg"];
  $sexo = $_POST["sexo"];
  $logradouro = $_POST["logradouro"];
  $numero = $_POST["numero"];
  $bairro = $_POST["bairro"];
  $cidade = $_POST["cidade"];
  $estado = $_POST["estado"];
  $cep = $_POST["cep"];
  $telFixo = $_POST["telFixo"];
  $telCelular = $_POST["telCelular"];

  $para = "seuemail@exemplo.com";
  $assunto = "Novo cadastro recebido";
  $mensagem = "Nome: $nome\nCPF: $cpf\nRG: $rg\nSexo: $sexo\nEndereço: $logradouro, $numero, $bairro, $cidade - $estado\nCEP: $cep\nTelefone Fixo: $telFixo\nTelefone Celular: $telCelular";

  $headers = "From: apduartte@gmail.com";

  if (mail($para, $assunto, $mensagem, $headers)) {
    echo "Cadastro enviado com sucesso!";
  } else {
    echo "Erro ao enviar o cadastro.";
  }
}
?>