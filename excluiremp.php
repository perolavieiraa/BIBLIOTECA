<?php
include "conexao.php";
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) { echo "ID inválido"; exit; }

$conexao->query("DELETE FROM emprestimos WHERE id_emprestimo=$id");
header("Location: listaremp.php");
exit;