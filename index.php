<?php
$nome = "";
$email = "";
$telefone = "";
$mensagem = "";

// Pega a string de conexão do Render
$db_url = getenv("DATABASE_URL");

// Tenta conectar ao PostgreSQL
$conn = pg_connect($db_url);

if (!$conn) {
    die("Erro ao conectar no banco de dados.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"] ?? "";
    $email = $_POST["email"] ?? "";
    $telefone = $_POST["telefone"] ?? "";

    $query = "INSERT INTO usuarios (nome, email, telefone) VALUES ($1, $2, $3)";
    $result = pg_query_params($conn, $query, [$nome, $email, $telefone]);

    if ($result) {
        $mensagem = "Usuário cadastrado com sucesso no banco de dados.";
    } else {
        $mensagem = "Erro ao salvar no banco de dados.";
    }
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
    <input type="text" name="nome" required value="<?php echo htmlspecialchars($nome); ?>"><br><br>

    <label>E-mail:</label><br>
    <input type="email" name="email" required value="<?php echo htmlspecialchars($email); ?>"><br><br>

    <label>Telefone:</label><br>
    <input type="text" name="telefone" required value="<?php echo htmlspecialchars($telefone); ?>"><br><br>

    <button type="submit">Cadastrar</button>
  </form>

  <?php if (!empty($mensagem)): ?>
    <p><strong><?php echo htmlspecialchars($mensagem); ?></strong></p>
  <?php endif; ?>

  <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
    <h2>Dados recebidos pelo servidor</h2>
    <p><strong>Nome:</strong> <?php echo htmlspecialchars($nome); ?></p>
    <p><strong>E-mail:</strong> <?php echo htmlspecialchars($email); ?></p>
    <p><strong>Telefone:</strong> <?php echo htmlspecialchars($telefone); ?></p>
  <?php endif; ?>

</body>
</html>
