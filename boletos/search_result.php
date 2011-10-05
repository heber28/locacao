<?php

$nosso_num = mysql_real_escape_string(htmlentities($_POST['nosso_num']));

if (strlen($nosso_num) > 4) {
	include_once($_SERVER['DOCUMENT_ROOT'] . '/locacao/resources/db.php');
	$sql = "SELECT id, nosso_num, sacado, vencimento, (aluguel + iptu + sanepar + limpeza + material + copel + outros) as total, desconto, pago, data_pagto, total_pago from boletos where nosso_num like '$nosso_num%' ";
	$result = mysql_query($sql) or die(mysql_error());

	if (mysql_num_rows($result) == 0)
	exit;
	echo "<table border=1 >";
	echo "<tr>";
	echo "<td><b>Nosso Num</b></td>
        <td><b>Sacado</b></td>
        <td><b>Vencimento</b></td>
        <td><b>Total</b></td>
        <td><b>Desconto</b></td>
        <td><b>Pago</b></td>
        <td><b>Data Pagto</b></td>
        <td><b>Total Pago</b></td>
        <td></td>";
	echo "</tr>";

	while ($row = mysql_fetch_array($result)) {
		foreach ($row AS $key => $value) {
			$row[$key] = stripslashes($value);
		}
		echo "<tr>";
		echo "<td valign='top'>" . $row['nosso_num'] . "</td>";
		echo "<td valign='top'>" . $row['sacado'] . "</td>";
		echo "<td valign='top'>" . $row['vencimento'] . "</td>";
		echo "<td valign='top' align='right'>" . $row['total'] . "</td>";
		echo "<td valign='top' align='right'>" . $row['desconto'] . "</td>";
		echo "<td valign='top'>";
		if ($row['pago'] == 1)
		echo 'sim';
		else
		echo 'nao';
		echo "</td>";
		echo "<td valign='top'>" . $row['data_pagto'] . "</td>";
		echo "<td valign='top'>" . $row['total_pago'] . "</td>";
		echo "<td valign='top'><a href=pay.php?id=" . $row['id'] . ">Editar</a></td> ";
		echo "</tr>";
	}
	echo "</table>";
	mysql_close($link);
}
?>
