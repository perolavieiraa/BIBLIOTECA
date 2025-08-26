<?php
include "conexao.php";
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) { echo "ID inválido"; exit; }

$leitor = $conexao->query("SELECT * FROM leitores WHERE id_leitor=$id")->fetch_assoc();
if (!$leitor) { echo "Leitor não encontrado"; exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $conexao->real_escape_string($_POST['nome']);
    $email = $conexao->real_escape_string($_POST['email']);
    $tel = $conexao->real_escape_string($_POST['telefone']);
    $sql = "UPDATE leitores SET nome='$nome', email='$email', telefone='$tel' WHERE id_leitor=$id";
    if ($conexao->query($sql)) header("Location: listar.php");
    else $erro = $conexao->error;
}
?>
<h2>Editar Leitor</h2>
<a href="listar.php">Voltar</a>
<?php if (!empty($erro)) echo "<p>$erro</p>"; ?>
<form method="post">
Nome: <input name="nome" value="<?= htmlspecialchars($leitor['nome']) ?>" required><br>
Email: <input name="email" type="email" value="<?= htmlspecialchars($leitor['email']) ?>"><br>
Telefone: <input name="telefone" value="<?= htmlspecialchars($leitor['telefone']) ?>"><br>
<button>Atualizar</button>
</form>
