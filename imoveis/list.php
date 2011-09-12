<?

include('config.php');
echo "<table border=1 >";
echo "<tr>";
echo "<td><b>Endereco</b></td>";
echo "<td><b>Alugado</b></td>";
echo "</tr>";
$result = mysql_query("SELECT * FROM `imoveis`") or trigger_error(mysql_error());
while ($row = mysql_fetch_array($result)) {
    foreach ($row AS $key => $value) {
        $row[$key] = stripslashes($value);
    }
    echo "<tr>";
    echo "<td valign='top'><a href=/locacao/boletos/list.php?imovel_id={$row['id']}>{$row['endereco']}</a></td>";
    if ($row['alugado'] == 1)
        echo "<td valign='top'>Sim</td>";
    else
        echo "<td valign='top'>Nao</td>";
    echo "<td valign='top'><a href=edit.php?id={$row['id']}>Edit</a></td><td><a href=delete.php?id={$row['id']}>Delete</a></td> ";
    echo "</tr>";
}
echo "</table>";
echo "<br />";
echo "<a href=new.php>Novo cadastro</a>";
?>