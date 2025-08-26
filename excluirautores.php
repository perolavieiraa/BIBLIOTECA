<?php
include "conexao.php";
$id = $_GET['id'];
$conexao->query("DELETE FROM autores WHERE id_autor=$id");
echo "Autor excluído!";
?>
<a href="listar.php">Voltar</a>