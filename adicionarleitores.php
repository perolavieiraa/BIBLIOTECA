<?php
include "conexao.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $conexao->real_escape_string($_POST['nome']);
    $email = $conexao->real_escape_string($_POST['email']);
    $tel = $conexao->real_escape_string($_POST['telefone']);

    $sql = "INSERT INTO leitores (nome, email, telefone) VALUES ('$nome', '$email', '$tel')";
    if ($conexao->query($sql)) header("Location: listarleitores.php");
    else $erro = $conexao->error;
}
?>
<h2>Adicionar Leitor</h2>
<a href="listarleitores.php">Voltar</a>
<?php if (!empty($erro)) echo "<p>$erro</p>"; ?>
<form method="post">
Nome: <input name="nome" required><br>
Email: <input name="email" type="email"><br>
Telefone: <input name="telefone"><br>
<button>Salvar</button>
</form>