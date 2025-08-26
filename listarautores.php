<?php
include "conexao.php";

$sql = "SELECT * FROM autores";
$resultado = $conexao->query($sql);
?>

<h2>Lista de Autores</h2>
<a href="adicionarautores.php">Adicionar Autor</a>
<table border="1">
    <tr>
        <th>Id</th>
        <th>Nome</th>
        <th>Nacionalidade</th>
        <th>Ano de nascimento</th>
        <th>Ações</th>
    </tr>
    <?php while ($linha = $resultado->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $linha['id_autor']; ?></td>
            <td><?php echo $linha['nome']; ?></td>
            <td><?php echo $linha['nacionalidade']; ?></td>
            <td><?php echo $linha['ano_nascimento']; ?></td>
            <td>
                <a href="editar.php?id=<?php echo $linha['id_autor']; ?>">Editar</a> |
                <a href="excluir.php?id=<?php echo $linha['id_autor']; ?>">Excluir</a>
            </td>
        </tr>
    <?php } ?>
</table>