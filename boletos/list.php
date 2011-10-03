<?

include_once($_SERVER['DOCUMENT_ROOT'] . '/locacao/resources/session.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/locacao/resources/config.php');
if (isset($_GET['imovel_id'])) {
	$imovel_id = (int) $_GET['imovel_id'];
	$result = mysql_query("SELECT endereco FROM imoveis where id = '$imovel_id'") or trigger_error(mysql_error());
	$endereco = mysql_result($result, 0);
        echo "<a href=/locacao/imoveis/list.php>Voltar</a>";
        echo '<h2>Lista de Boletos</h2>';
	echo '<strong>' . $endereco . '</strong><br /><br />';
	echo "<a href=new.php?imovel_id=$imovel_id>Novo boleto</a> | ";
	echo "<a href=bank.php?imovel_id=$imovel_id>Dados bancarios</a><br /><br />";
	$imovel_id = (int) $_GET['imovel_id'];
	$result = mysql_query("SELECT * FROM `boletos` where imovel_id = '$imovel_id' order by vencimento desc limit 14") or trigger_error(mysql_error());

	if (mysql_num_rows($result) > 0) {
		echo "<table border=1 >";
		echo "<tr>";
		echo "<td><b>Vencimento</b></td>";
		echo "<td><b>Num Doc</b></td>";
		echo "<td><b>Aluguel</b></td>";
		echo "<td><b>Copel</b></td>";
		echo "<td><b>Sanepar</b></td>";
		echo "<td><b>Material</b></td>";
		echo "<td><b>Iptu</b></td>";
		echo "<td><b>Limpeza</b></td>";
		echo "<td><b>Outros</b></td>";
		echo "<td><b>Total</b></td>";
		echo "<td><b>Desconto</b></td>";
		echo "<td><b>Nosso Num</b></td>";
		echo "<td><b>Pago</b></td>";
		echo "<td><b>Data Pagto</b></td>";
		echo "<td><b>Total Pago</b></td>";
		echo "</tr>";

		while ($row = mysql_fetch_array($result)) {
			foreach ($row AS $key => $value) {
				$row[$key] = stripslashes($value);
			}
			echo "<tr>";
			echo "<td valign='top'>" . $row['vencimento'] . "</td>";
			echo "<td valign='top'>" . $row['num_doc'] . "</td>";
			echo "<td valign='top'>" . $row['aluguel'] . "</td>";
			echo "<td valign='top'>" . $row['copel'] . "</td>";
			echo "<td valign='top'>" . $row['sanepar'] . "</td>";
			echo "<td valign='top'>" . $row['material'] . "</td>";
			echo "<td valign='top'>" . $row['iptu'] . "</td>";
			echo "<td valign='top'>" . $row['limpeza'] . "</td>";
			echo "<td valign='top'>" . $row['outros'] . "</td>";
			echo "<td valign='top'>" . number_format($row['aluguel'] + $row['copel'] + $row['sanepar'] + $row['material'] + $row['iptu'] + $row['limpeza'] + $row['outros'], 2, '.', '') . "</td>";
			echo "<td valign='top'>" . $row['desconto'] . "</td>";
			echo "<td valign='top'>" . $row['nosso_num'] . "</td>";
			if ($row['pago'] == 1)
			echo "<td valign='top'>Sim</td>";
			else
			echo "<td valign='top'>Nao</td>";
			if ($row['data_pagto'] == NULL)
			echo "<td valign='top'>&nbsp</td>";
			else
			echo "<td valign='top'>" . $row['data_pagto'] . "</td>";

			if ($row['total_pago'] == NULL)
			echo "<td valign='top'>&nbsp</td>";
			else
			echo "<td valign='top'>" . $row['total_pago'] . "</td>";
			echo "<td valign='top'><a href=edit.php?id={$row['id']}&imovel_id=$imovel_id>Editar</a></td>";
			echo "<td valign='top'><a href=delete.php?id={$row['id']}&imovel_id=$imovel_id>Excluir</a></td> ";
			echo "<td valign='top'><a href=boleto_real.php?id={$row['id']}>Imprimir</a></td>";
			echo "</tr>";
		}
		echo "</table>";
	}
	mysql_close($link);
}
?>