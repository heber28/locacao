<?

include_once($_SERVER['DOCUMENT_ROOT'] . '/locacao/resources/session.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/locacao/resources/config.php');

echo "<h2>Listagem de Im&oacute;veis</h2>";
echo "<a href=new.php>Novo im&oacute;vel</a> | ";
echo "<a href=/locacao/boletos/search.php>Quitar pagamentos</a><br /><br />";
echo "<table border=1 >";
echo "<tr>";
echo "<td><b>Endereco</b></td>";
echo "<td><b>Alugado</b></td>";
echo "</tr>";
$result = mysql_query("SELECT * FROM imoveis order by endereco") or trigger_error(mysql_error());
while ($row = mysql_fetch_array($result)) {
	foreach ($row AS $key => $value) {
		$row[$key] = stripslashes($value);
	}
	echo "<tr>";
	echo "<td>{$row['endereco']}</td>";
	if ($row['alugado'] == 1)
	echo "<td valign='top'>Sim</td>";
	else
	echo "<td valign='top'>Nao</td>";
	echo "<td valign='top'><a href=edit.php?id={$row['id']}>Editar</a></td>";
	echo "<td><a href=delete.php?id={$row['id']}>Excluir</a></td> ";
	echo "<td><a href=/locacao/boletos/list.php?imovel_id={$row['id']}>Boletos</a></td>";
	echo "</tr>";
}
echo "</table>";
mysql_close($link);
?>