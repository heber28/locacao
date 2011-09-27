<? ob_start() ?>
<html>
    <head>
        <link href="style.css" rel="stylesheet" type="text/css">
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
        echo "<div id='wrapper'>";
        echo "<div id='header'>";
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
        echo "</div>"; #header

        echo "<div id='container'>";
        echo "<div id='side-a'>";

        $row = mysql_fetch_array(mysql_query("SELECT * FROM `boletos` WHERE `id` = '$id' "));
        echo "<form action='' method='POST'>";
        echo "Conta Corrente<br />";
        echo "<input type='text' name='ccorrente' value=" . stripslashes($row['ccorrente']) . "><br />";
        echo "Digito CC<br />";
        echo "<input type='text' name='digito_cc' value=" . stripslashes($row['digito_cc']) . "><br />";
        echo "Banco<br />";
        echo "<input type='text' name='banco' value=" . stripslashes($row['banco']) . "><br />";
        echo "Agencia<br />";
        echo "<input type='text' name='agencia' value=" . stripslashes($row['agencia']) . "><br />";
        echo "Carteira<br />";
        echo "<input type='text' name='carteira' value=" . stripslashes($row['carteira']) . "><br />";
        echo "Nosso Num<br />";
        echo "<input type='text' name='nosso_num' value=" . stripslashes($row['nosso_num']) . "><br />";
        echo "Cedente Codigo<br />";
        echo "<input type='text' name='cedente_codigo' value=" . stripslashes($row['cedente_codigo']) . "><br />";
        echo "Cedente Nome<br />";
        echo "<input type='text' name='cedente_nome' size=60 value='" . stripslashes($row['cedente_nome']) . "'><br />";
        echo "Sacado<br />";
        echo "<input type='text' name='sacado' size=60 value='" . stripslashes($row['sacado']) . "'><br />";

        echo "</div>";
        echo "<div id='side-b'>";

        echo "Vencimento<br />";
        echo "<input type='text' id='vencimento' name='vencimento' value=" . stripslashes($row['vencimento']) . "><br />";
        echo "Num Doc<br />";
        echo "<input type='text' name='num_doc' value=" . stripslashes($row['num_doc']) . "><br />";
        echo "Aluguel<br />";
        echo "<input type='text' name='aluguel' value=" . stripslashes($row['aluguel']) . "><br />";
        echo "Copel<br />";
        echo "<input type='text' name='copel' value=" . stripslashes($row['copel']) . "><br />";
        echo "Sanepar<br />";
        echo "<input type='text' name='sanepar' value=" . stripslashes($row['sanepar']) . "><br />";

        echo "</div>";
        echo "<div id='side-c'>";

        echo "Material<br />";
        echo "<input type='text' name='material' value=" . stripslashes($row['material']) . "><br />";
        echo "Iptu<br />";
        echo "<input type='text' name='iptu' value=" . stripslashes($row['iptu']) . "><br />";
        echo "Limpeza<br />";
        echo "<input type='text' name='limpeza' value=" . stripslashes($row['limpeza']) . "><br />";
        echo "Outros<br />";
        echo "<input type='text' name='outros' value=" . stripslashes($row['outros']) . "><br />";
        echo "Desconto<br />";
        echo "<input type='text' name='desconto' value=" . stripslashes($row['desconto']) . "><br />";

        echo "</div>";
        echo "<div id='side-d'>";
        echo "Pago<br />";
        echo "<input type='radio' name='pago' value='1'";
        if (isset($row['pago']) && $row['pago'] == 1) {
            echo 'checked';
        }
        echo ">Sim&nbsp;&nbsp;&nbsp;";
        echo "<input type='radio' name='pago' value='0'";
        if (isset($row['pago']) && $row['pago'] == 0) {
            echo 'checked';
        }
        echo ">Nao";
        echo "<br /><br />";
        echo "Data do pagto<br />";
        echo "<input type='text' id='data_pagto' name='data_pagto' value=" . stripslashes($row['data_pagto']) . "><br />";
        echo "Total Pago<br />";
        echo "<input type='text' name='total_pago' value=" . stripslashes($row['total_pago']) . "><br />";
        echo"<p><input type='submit' value='Salvar' /><input type='hidden' value='1' name='submitted' /><br />";
        echo"</form>";

        echo "</div>";
        echo "</div>"; #container
        echo "</div>"; #wrapper

        mysql_close($link);
        ?>
    </body>
</html>
<? ob_flush() ?>
