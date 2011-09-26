<? ob_start() ?>
<html>
    <head>
        <link type="text/css" href="css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
        <script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>
        <script type="text/javascript" src="js/jquery.ui.datepicker-pt-BR.js"></script>
        <script type="text/javascript">
            jQuery(function($) {
                $("#vencimento").datepicker({
                    dateFormat: 'yy-mm-dd',
                    regional: 'pt-BR'
                });
                $("#data_pagto").datepicker({
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
        if ((isset($_GET['id']) == FALSE) or (isset($_GET['imovel_id']) == FALSE))
            exit;

        $imovel_id = (int) $_GET['imovel_id'];
        $result = mysql_query("SELECT imovel_endereco FROM boletos where imovel_id = '$imovel_id'") or trigger_error(mysql_error());
        $row = mysql_fetch_row($result);
        $endereco = $row[0];
        echo "";
        echo '<strong>' . $endereco . "</strong> | <a href='list.php?imovel_id=$imovel_id'>Voltar</a><br />";
        $id = (int) $_GET['id'];
        if (isset($_POST['submitted'])) {
            foreach ($_POST AS $key => $value) {
                $_POST[$key] = mysql_real_escape_string(htmlentities($value));
            }
            $sql = "UPDATE `boletos` SET 
            `ccorrente` =  '{$_POST['ccorrente']}' ,
            `digito_cc` =  '{$_POST['digito_cc']}' ,
            `banco` =  '{$_POST['banco']}' ,
            `agencia` =  '{$_POST['agencia']}' ,
            `cedente_codigo` =  '{$_POST['cedente_codigo']}' ,
            `cedente_nome` =  '{$_POST['cedente_nome']}' ,
            `carteira` =  '{$_POST['carteira']}' ,
            `nosso_num` =  '{$_POST['nosso_num']}' ,
            `vencimento` =  '{$_POST['vencimento']}' ,
            `num_doc` =  '{$_POST['num_doc']}' ,
            `sacado` =  '{$_POST['sacado']}' ,
            `aluguel` =  '{$_POST['aluguel']}' ,
            `iptu` =  '{$_POST['iptu']}' ,
            `sanepar` =  '{$_POST['sanepar']}' ,
            `limpeza` =  '{$_POST['limpeza']}' ,
            `material` =  '{$_POST['material']}' ,
            `copel` =  '{$_POST['copel']}' ,
            `outros` =  '{$_POST['outros']}' ,
            `pago` =  '{$_POST['pago']}' ,
            `desconto` =  '{$_POST['desconto']}'";

            if ($_POST['data_pagto'] != NULL)
                $sql = $sql . ", `data_pagto` =  '{$_POST['data_pagto']}'";

            if ($_POST['total_pago'] != NULL)
                $sql = $sql . ", `total_pago` =  '{$_POST['total_pago']}'";

            $sql = $sql . " WHERE `id` = '$id' ";
            mysql_query($sql) or die(mysql_error());
            echo (mysql_affected_rows()) ? "Cadastro salvo<br />" : "Nada foi alterado <br />";
        }
        $row = mysql_fetch_array(mysql_query("SELECT * FROM `boletos` WHERE `id` = '$id' "));
        echo "<form action='' method='POST'>";
        echo "<br />";
        echo "<table>";
        echo "<tr><td>Ccorrente</td>";
        echo "<td><input type='text' name='ccorrente' value=" . stripslashes($row['ccorrente']) . "></td></tr>";
        echo "<tr><td>Digito CC</td>";
        echo "<td><input type='text' name='digito_cc' value=" . stripslashes($row['digito_cc']) . "></td></tr>";
        echo "<tr><td>Banco</td>";
        echo "<td><input type='text' name='banco' value=" . stripslashes($row['banco']) . "></td></tr>";
        echo "<tr><td>Agencia</td>";
        echo "<td><input type='text' name='agencia' value=" . stripslashes($row['agencia']) . "></td></tr>";
        echo "<tr><td>Carteira</td>";
        echo "<td><input type='text' name='carteira' value=" . stripslashes($row['carteira']) . "></td></tr>";
        echo "<tr><td>Nosso Num</td>";
        echo "<td><input type='text' name='nosso_num' value=" . stripslashes($row['nosso_num']) . "></td></tr>";
        echo "<tr><td>Cedente Codigo</td>";
        echo "<td><input type='text' name='cedente_codigo' value=" . stripslashes($row['cedente_codigo']) . "></td></tr>";
        echo "<tr><td>Cedente Nome</td>";
        echo "<td><input type='text' name='cedente_nome' size=60 value='" . stripslashes($row['cedente_nome']) . "'></td></tr>";
        echo "<tr><td>Sacado</td>";
        echo "<td><input type='text' name='sacado' size=60 value='" . stripslashes($row['sacado']) . "'></td></tr>";
        echo "<tr><td>Vencimento</td>";
        echo "<td><input type='text' id='vencimento' name='vencimento' value=" . stripslashes($row['vencimento']) . "></td></tr>";
        echo "<tr><td>Num Doc</td>";
        echo "<td><input type='text' name='num_doc' value=" . stripslashes($row['num_doc']) . "></td></tr>";
        echo "<tr><td>Aluguel</td>";
        echo "<td><input type='text' name='aluguel' value=" . stripslashes($row['aluguel']) . "></td></tr>";
        echo "<tr><td>Copel</td>";
        echo "<td><input type='text' name='copel' value=" . stripslashes($row['copel']) . "></td></tr>";
        echo "<tr><td>Sanepar</td>";
        echo "<td><input type='text' name='sanepar' value=" . stripslashes($row['sanepar']) . "></td></tr>";
        echo "<tr><td>Material</td>";
        echo "<td><input type='text' name='material' value=" . stripslashes($row['material']) . "></td></tr>";
        echo "<tr><td>Iptu</td>";
        echo "<td><input type='text' name='iptu' value=" . stripslashes($row['iptu']) . "></td></tr>";
        echo "<tr><td>Limpeza</td>";
        echo "<td><input type='text' name='limpeza' value=" . stripslashes($row['limpeza']) . "></td></tr>";
        echo "<tr><td>Outros</td>";
        echo "<td><input type='text' name='outros' value=" . stripslashes($row['outros']) . "></td></tr>";
        echo "<tr><td>Desconto</td><td><input type='text' name='desconto' value=" . stripslashes($row['desconto']) . "></td></tr>";

        echo "<tr>";
        echo "<td>Pago</td><td>";
        echo "<input type='radio' name='pago' value='1'";
        if (isset($row['pago']) && $row['pago'] == 1) {
            echo 'checked';
        }
        echo ">Sim";
        echo "<input type='radio' name='pago' value='0'";
        if (isset($row['pago']) && $row['pago'] == 0) {
            echo 'checked';
        }
        echo ">Nao";
        echo "</td></tr>";
        echo "<tr><td>Data do pagto</td><td><input type='text' id='data_pagto' name='data_pagto' value=" . stripslashes($row['data_pagto']) . "></td></tr>";
        echo "<tr><td>Total Pago</td><td><input type='text' name='total_pago' value=" . stripslashes($row['total_pago']) . "></td></tr>";
        echo "</table>";
        echo"<p><input type='submit' value='Salvar' /><input type='hidden' value='1' name='submitted' />";
        echo"</form>";
        mysql_close($link);
        ?>
    </body>
</html>
<? ob_flush() ?>
