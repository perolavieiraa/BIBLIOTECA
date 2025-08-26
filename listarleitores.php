<?php
include "conexao.php";

$por_pagina = 5;
$pagina = max(1, (int)($_GET['page'] ?? 1));
$offset = ($pagina - 1) * $por_pagina;

$sqlCount = "SELECT COUNT(*) AS total FROM leitores";
$total = $conexao->query($sqlCount)->fetch_assoc()['total'];
$total_paginas = ceil($total / $por_pagina);

$sql = "SELECT * FROM leitores ORDER BY nome LIMIT $por_pagina OFFSET $offset";
$res = $conexao->query($sql);
?>
<h2>Leitores</h2>
<a href="index.php">Voltar</a> | <a href="adicionarleitores.php">Adicionar leitor</a>
<table border="1" style="margin-top:10px;">
<tr><th>ID</th><th>Nome</th><th>Email</th><th>Telefone</th><th>Ações</th></tr>
<?php while ($l = $res->fetch_assoc()) { ?>
<tr>
    <td><?= $l['id_leitor'] ?></td>
    <td><?= htmlspecialchars($l['nome']) ?></td>
    <td><?= htmlspecialchars($l['email']) ?></td>
    <td><?= htmlspecialchars($l['telefone']) ?></td>
    <td>
        <a href="editarleitores.php?id=<?= $l['id_leitor'] ?>">Editar</a> |
        <a href="excluirleitores.php?id=<?= $l['id_leitor'] ?>" onclick="return confirm('Excluir?')">Excluir</a> |
        <a href="emprestimos_por_leitor.php?id_leitor=<?= $l['id_leitor'] ?>">Ver empréstimos</a>
    </td>
</tr>
<?php } ?>
</table>
<div style="margin-top:10px;">
<?php for ($p = 1; $p <= $total_paginas; $p++) {
    echo "<a href=\"?page=$p\">$p</a> ";
} ?>
</div>
