<? ob_start() ?>
<html>
<head>
<link type="text/css"
	href="css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="js/jquery.ui.datepicker-pt-BR.js"></script>
<script type="text/javascript">
            jQuery(function($) {
                $("#datepicker").datepicker({
                    dateFormat: 'yy-mm-dd',
                    regional: 'pt-BR'
                });
            });
        </script>
</head>
<body>
<?
include_once($_SERVER['DOCUMENT_ROOT'] . '/locacao/resources/session.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/locacao/resources/config.php');
echo "<form action='' method='POST'>";
if (isset($_GET['imovel_id']) == FALSE)
exit;
$imovel_id = (int) $_GET['imovel_id'];
$result = mysql_query("SELECT endereco FROM imoveis where id = '$imovel_id'") or trigger_error(mysql_error());
$row = mysql_fetch_row($result);
$endereco = $row[0];

echo "";
echo '<strong>' . $endereco . "</strong> | <a href='list.php?imovel_id=$imovel_id'>Voltar</a>";
if (isset($_POST['submitted'])) {
	foreach ($_POST AS $key => $value) {
		$_POST[$key] = mysql_real_escape_string(htmlentities($value));
	}
	$sql = "INSERT INTO `boletos` ( `imovel_id` ,  `imovel_endereco` ,  `ccorrente` ,  `digito_cc` ,  `banco` ,  `agencia` ,  `cedente_codigo` ,  `cedente_nome` ,  `carteira` ,  `nosso_num` ,  `vencimento` ,  `num_doc` ,  `sacado` ,  `aluguel` ,  `iptu` ,  `sanepar` ,  `limpeza` ,  `material` ,  `copel` ,  `outros` ,  `desconto` ) VALUES(  '{$_GET['imovel_id']}' , '$endereco' ,  '{$_POST['ccorrente']}' ,  '{$_POST['digito_cc']}' ,  '{$_POST['banco']}' ,  '{$_POST['agencia']}' ,  '{$_POST['cedente_codigo']}' ,  '{$_POST['cedente_nome']}' ,  '{$_POST['carteira']}' ,  '{$_POST['nosso_num']}' ,  '{$_POST['vencimento']}' ,  '{$_POST['num_doc']}' ,  '{$_POST['sacado']}' ,  '{$_POST['aluguel']}' ,  '{$_POST['iptu']}' ,  '{$_POST['sanepar']}' ,  '{$_POST['limpeza']}' ,  '{$_POST['material']}' ,  '{$_POST['copel']}' ,  '{$_POST['outros']}' ,  '{$_POST['desconto']}'  ) ";
	mysql_query($sql) or die(mysql_error());
	$id = mysql_insert_id();
	echo "<br /><br />";
	echo "Cadastro salvo<br />";
	echo "<a href=boleto_real.php?id=$id>Imprimir boleto</a><br />";
} else {
	$sql = "select * from boletos where imovel_id = '$imovel_id' and id = (select max(id) from boletos where imovel_id = '$imovel_id')";
	$result = mysql_query($sql) or die(mysql_error());

	if (mysql_num_rows($result) == 0) {
		echo "<br /><br />";
		echo "<table>";
		echo "<tr><td>Ccorrente</td>";
		echo"<td><input type='text' name='ccorrente'></td></tr>";
		echo "<tr><td>Digito CC</td>";
		echo"<td><input type='text' name='digito_cc'></td></tr>";
		echo "<tr><td>Banco</td>";
		echo"<td><input type='text' name='banco'></td></tr>";
		echo "<tr><td>Agencia</td>";
		echo"<td><input type='text' name='agencia'></td></tr>";
		echo "<tr><td>Carteira</td>";
		echo"<td><input type='text' name='carteira'></td></tr>";
		echo "<tr><td>Nosso Num</td>";
		$nosso_num = date('ym', time()) . substr(sprintf("%03d", $imovel_id), 0, 3) . sprintf("%02d", rand(0, 99));
		echo"<td><input type='text' name='nosso_num' value=" . $nosso_num . "></td></tr>";
		echo "<tr><td>Cedente Codigo</td>";
		echo"<td><input type='text' name='cedente_codigo'></td></tr>";
		echo "<tr><td>Cedente Nome</td>";
		echo"<td><input type='text' name='cedente_nome' size=60></td></tr>";
		echo "<tr><td>Sacado</td>";
		echo"<td><input type='text' name='sacado' size=60></td></tr>";
		echo "<tr><td>Vencimento</td>";
		$data = strtotime('+1 month');
		echo"<td><input type='text' name='vencimento' id='datepicker' value=" . strftime('%Y-%m-%d', $data) . "></td></tr>";
		echo "<tr><td>Num Doc</td>";
		echo"<td><input type='text' name='num_doc' value='01/12'></td></tr>";
		echo "<tr><td>Aluguel</td>";
		echo"<td><input type='text' name='aluguel' value=0></td></tr>";
		echo "<tr><td>Copel</td>";
		echo"<td><input type='text' name='copel' value=0></td></tr>";
		echo "<tr><td>Sanepar</td>";
		echo"<td><input type='text' name='sanepar' value=0></td></tr>";
		echo "<tr><td>Material</td>";
		echo"<td><input type='text' name='material' value=0></td></tr>";
		echo "<tr><td>Iptu</td>";
		echo"<td><input type='text' name='iptu' value=0></td></tr>";
		echo "<tr><td>Limpeza</td>";
		echo"<td><input type='text' name='limpeza' value=0></td></tr>";
		echo "<tr><td>Outros</td>";
		echo"<td><input type='text' name='outros' value=0></td></tr>";
		echo "<tr><td>Desconto</td><td><input type='text' name='desconto' value=0></td></tr>";
		echo "</table>";
		echo "<input type='submit' value='Salvar' /><input type='hidden' value='1' name='submitted' /><br />";
	} else {
		while ($row = mysql_fetch_array($result)) {
			foreach ($row AS $key => $value) {
				$row[$key] = stripslashes($value);
			}
			echo "<br /><br />";
			echo "<table>";
			echo "<tr><td>Ccorrente</td>";
			echo"<td><input type='text' name='ccorrente' value=" . stripslashes($row['ccorrente']) . "></td></tr>";
			echo "<tr><td>Digito CC</td>";
			echo"<td><input type='text' name='digito_cc' value=" . stripslashes($row['digito_cc']) . "></td></tr>";
			echo "<tr><td>Banco</td>";
			echo"<td><input type='text' name='banco' value=" . stripslashes($row['banco']) . "></td></tr>";
			echo "<tr><td>Agencia</td>";
			echo"<td><input type='text' name='agencia' value=" . stripslashes($row['agencia']) . "></td></tr>";
			echo "<tr><td>Carteira</td>";
			echo"<td><input type='text' name='carteira' value=" . stripslashes($row['carteira']) . "></td></tr>";
			echo "<tr><td>Nosso Num</td>";
			$nosso_num = date('ym', time()) . substr(sprintf("%03d", $imovel_id), 0, 3) . sprintf("%02d", rand(0, 99));
			echo"<td><input type='text' name='nosso_num' value=" . $nosso_num . "></td></tr>";
			echo "<tr><td>Cedente Codigo</td>";
			echo"<td><input type='text' name='cedente_codigo' value=" . stripslashes($row['cedente_codigo']) . "></td></tr>";
			echo "<tr><td>Cedente Nome</td>";
			echo"<td><input type='text' name='cedente_nome' size=60 value='" . stripslashes($row['cedente_nome']) . "'></td></tr>";
			echo "<tr><td>Sacado</td>";
			echo"<td><input type='text' name='sacado' size=60 value='" . $row['sacado'] . "'></td></tr>";
			echo "<tr><td>Vencimento</td>";
			$data = strtotime(stripslashes($row['vencimento']) . ' +1 month');
			echo"<td><input type='text' id='datepicker' name='vencimento' value=" . strftime('%Y-%m-%d', $data) . "></td></tr>";
			echo "<tr><td>Num Doc</td>";
			$num_doc = substr(stripslashes($row['num_doc']), 0, 2);
			$parcelas = substr(stripslashes($row['num_doc']), 3, 2);
			$num_doc = (int) $num_doc + 1;
			if ($num_doc > $parcelas)
			$num_doc = '01';
			else
			$num_doc = sprintf("%02d", $num_doc);
			$num_doc = $num_doc . substr(stripslashes($row['num_doc']), 2, 3);
			echo"<td><input type='text' name='num_doc' value=" . $num_doc . "></td></tr>";
			echo "<tr><td>Aluguel</td>";
			echo"<td><input type='text' name='aluguel' value=" . stripslashes($row['aluguel']) . "></td></tr>";
			echo "<tr><td>Copel</td>";
			echo"<td><input type='text' name='copel' value=0></td></tr>";
			echo "<tr><td>Sanepar</td>";
			echo"<td><input type='text' name='sanepar' value=0></td></tr>";
			echo "<tr><td>Material</td>";
			echo"<td><input type='text' name='material' value=0></td></tr>";
			echo "<tr><td>Iptu</td>";
			echo"<td><input type='text' name='iptu' value=" . stripslashes($row['iptu']) . "></td></tr>";
			echo "<tr><td>Limpeza</td>";
			echo"<td><input type='text' name='limpeza' value=" . stripslashes($row['limpeza']) . "></td></tr>";
			echo "<tr><td>Outros</td>";
			echo"<td><input type='text' name='outros' value=0></td></tr>";
			echo "<tr><td>Desconto</td><td><input type='text' name='desconto' value=" . stripslashes($row['desconto']) . "></td></tr>";
			echo "</table>";
			echo "<input type='submit' value='Salvar' /><input type='hidden' value='1' name='submitted' /><br />";
		}
	}
}
echo "</form>";
mysql_close($link);
?>
</body>
</html>
<? ob_flush() ?>