<?php
include "conexao.php";
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) { echo "ID inválido"; exit; }

$ver = $conexao->query("SELECT * FROM emprestimos WHERE id_leitor = $id AND data_devolucao IS NULL");
if ($ver->num_rows > 0) {
    echo "Não é possível excluir: leitor possui empréstimo(s) ativo(s).";
    echo "<a href='listar.php'>Voltar</a>";
    exit;
}

$conexao->query("DELETE FROM leitores WHERE id_leitor=$id");
header("Location: listar.php");
exit;