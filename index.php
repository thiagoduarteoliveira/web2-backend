<?php
$nome = "";
$email = "";
$telefone = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"] ?? "";
    $email = $_POST["email"] ?? "";
    $telefone = $_POST["telefone"] ?? "";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistema Web II</title>
</head>
<body>

  <h1>Cadastro de Usuário</h1>
  <p>Preencha os dados abaixo.</p>

  <form method="POST" action="">
    <label>Nome:</label><br>
    <input type="text" name="nome" required><br><br>

    <label>E-mail:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Telefone:</label><br>
    <input type="text" name="telefone" required><br><br>

    <button type="submit">Cadastrar</button>
  </form>

  <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
    <h2>Dados recebidos pelo servidor</h2>
    <p><strong>Nome:</strong> <?php echo htmlspecialchars($nome); ?></p>
    <p><strong>E-mail:</strong> <?php echo htmlspecialchars($email); ?></p>
    <p><strong>Telefone:</strong> <?php echo htmlspecialchars($telefone); ?></p>
  <?php endif; ?>

</body>
</html>
