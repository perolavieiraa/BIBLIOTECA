<?php
include "conexao.php";
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) { echo "ID inválido"; exit; }

$ver = $conexao->query("SELECT * FROM emprestimos WHERE id_livro = $id AND data_devolucao IS NULL");
if ($ver->num_rows > 0) {
    echo "Não é possível excluir: livro possui empréstimo ativo.";
    echo "<a href='listar.php'>Voltar</a>";
    exit;
}

$conexao->query("DELETE FROM livros WHERE id_livro=$id");
header("Location: listarlivros.php");
exit;