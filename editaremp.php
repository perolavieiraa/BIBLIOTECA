<?php
include "conexao.php";
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) { echo "ID inválido"; exit; }

$emprestimo = $conexao->query("SELECT * FROM emprestimos WHERE id_emprestimo=$id")->fetch_assoc();
if (!$emprestimo) { echo "Empréstimo não encontrado"; exit; }

$livros = $conexao->query("SELECT id_livro, titulo FROM livros ORDER BY titulo");
$leitores = $conexao->query("SELECT id_leitor, nome FROM leitores ORDER BY nome");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_livro = (int)$_POST['id_livro'];
    $id_leitor = (int)$_POST['id_leitor'];
    $data_emprestimo = $_POST['data_emprestimo'];
    $data_devolucao = $_POST['data_devolucao'] ?: null;

    if ($id_livro != $emprestimo['id_livro']) {
        $verLivro = $conexao->query("SELECT * FROM emprestimos WHERE id_livro = $id_livro AND data_devolucao IS NULL");
        if ($verLivro->num_rows > 0) $erro = "Livro escolhido está emprestado.";
    }

    $sqlCount = "SELECT COUNT(*) AS qtd FROM emprestimos WHERE id_leitor = $id_leitor AND data_devolucao IS NULL";
    if ($id_leitor == $emprestimo['id_leitor']) {
        $qtd = $conexao->query($sqlCount)->fetch_assoc()['qtd'];
        $qtd = max(0, $qtd - 1);
    } else {
        $qtd = $conexao->query($sqlCount)->fetch_assoc()['qtd'];
    }
    if (empty($erro) && $qtd >= 3) $erro = "Leitor já possui 3 empréstimos ativos.";

    if (empty($erro) && $data_devolucao && $data_devolucao < $data_emprestimo) $erro = "Data de devolução inválida.";

    if (empty($erro)) {
        $sql = "UPDATE emprestimos SET id_livro=$id_livro, id_leitor=$id_leitor, data_emprestimo='$data_emprestimo',
                data_devolucao=" . ($data_devolucao ? "'$data_devolucao'" : "NULL") . " WHERE id_emprestimo=$id";
        if ($conexao->query($sql)) header("Location: listaremp.php");
        else $erro = $conexao->error;
    }
}
?>
<h2>Editar Empréstimo</h2>
<a href="listar.php">Voltar</a>
<?php if (!empty($erro)) echo "<p>$erro</p>"; ?>
<form method="post">
Livro:
<select name="id_livro">
<?php while ($l = $livros->fetch_assoc()) { ?>
    <option value="<?= $l['id_livro'] ?>" <?= $l['id_livro'] == $emprestimo['id_livro'] ? 'selected' : '' ?>>
        <?= htmlspecialchars($l['titulo']) ?>
    </option>
<?php } ?>
</select><br>
Leitor:
<select name="id_leitor">
<?php while ($le = $leitores->fetch_assoc()) { ?>
    <option value="<?= $le['id_leitor'] ?>" <?= $le['id_leitor'] == $emprestimo['id_leitor'] ? 'selected' : '' ?>>
        <?= htmlspecialchars($le['nome']) ?>
    </option>
<?php } ?>
</select><br>
Data Empréstimo: <input type="date" name="data_emprestimo" value="<?= $emprestimo['data_emprestimo'] ?>" required><br>
Data Devolução (opcional): <input type="date" name="data_devolucao" value="<?= $emprestimo['data_devolucao'] ?>"><br>
<button>Salvar</button>
</form>