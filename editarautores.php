<?php
include "conexao.php";
$id = $_GET['id'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $nac = $_POST['nacionalidade'];
    $ano = $_POST['ano_nascimento'];
    $sql = "UPDATE autores SET nome='$nome', nacionalidade='$nac', ano_nascimento='$ano' WHERE id_autor=$id";
    if ($conexao->query($sql)) echo "Atualizado!";
}
$res = $conexao->query("SELECT * FROM autores WHERE id_autor=$id")->fetch_assoc();
?>
<form method="post">
Nome: <input name="nome" value="<?= $res['nome'] ?>"><br>
Nacionalidade: <input name="nacionalidade" value="<?= $res['nacionalidade'] ?>"><br>
Ano Nascimento: <input name="ano_nascimento" value="<?= $res['ano_nascimento'] ?>"><br>
<button>Atualizar</button>
</form>