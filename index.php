<?php
// CONEXÃO (COLOQUE SUA STRING DO NEON)
$pdo = new PDO(
    "pgsql:host=ep-crimson-base-antmg7mn-pooler.c-6.us-east-1.aws.neon.tech;port=5432;dbname=neondb;sslmode=require",
    "neondb_owner",
    "npg_8VAiWXuP4hZn"
);

// VARIÁVEIS
$nome = "";
$email = "";
$telefone = "";

// EXCLUIR
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id=?");
    $stmt->execute([$_GET['delete']]);
}

// EDITAR (carregar dados)
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id=?");
    $stmt->execute([$_GET['edit']]);
    $user = $stmt->fetch();

    $nome = $user['nome'];
    $email = $user['email'];
    $telefone = $user['telefone'];
}

// INSERIR ou ATUALIZAR
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];

    if (!empty($_POST['id'])) {
        // UPDATE
        $stmt = $pdo->prepare("UPDATE usuarios SET nome=?, email=?, telefone=? WHERE id=?");
        $stmt->execute([$nome, $email, $telefone, $_POST['id']]);
    } else {
        // INSERT
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, telefone) VALUES (?, ?, ?)");
        $stmt->execute([$nome, $email, $telefone]);
    }
}

// LISTAR
$stmt = $pdo->query("SELECT * FROM usuarios ORDER BY id DESC");
$usuarios = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Sistema Web II</title>
</head>

<body>

<h1>Cadastro de Usuário</h1>

<form method="POST">
<input type="hidden" name="id" value="<?php echo $_GET['edit'] ?? ''; ?>">

<label>Nome:</label><br>
<input type="text" name="nome" value="<?php echo $nome; ?>" required><br><br>

<label>Email:</label><br>
<input type="email" name="email" value="<?php echo $email; ?>" required><br><br>

<label>Telefone:</label><br>
<input type="text" name="telefone" value="<?php echo $telefone; ?>" required><br><br>

<button type="submit">Salvar</button>
</form>

<hr>

<h2>Usuários cadastrados</h2>

<table border="1">
<tr>
<td>ID</td>
<td>Nome</td>
<td>Email</td>
<td>Telefone</td>
<td>Ações</td>
</tr>

<?php foreach ($usuarios as $u): ?>
<tr>
<td><?php echo $u['id']; ?></td>
<td><?php echo $u['nome']; ?></td>
<td><?php echo $u['email']; ?></td>
<td><?php echo $u['telefone']; ?></td>
<td>
<a href="?edit=<?php echo $u['id']; ?>">Editar</a> |
<a href="?delete=<?php echo $u['id']; ?>">Excluir</a>
</td>
</tr>
<?php endforeach; ?>

</table>

</body>
</html>
