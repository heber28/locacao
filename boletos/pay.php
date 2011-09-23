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
        if (isset($_GET['id']) == FALSE)
            exit;

        $id = (int) $_GET['id'];
        $result = mysql_query("SELECT imovel_endereco FROM boletos where id = '$id'") or trigger_error(mysql_error());
        $row = mysql_fetch_row($result);
        $endereco = $row[0];
        echo "<form method='post'>";
        echo "";
        echo '<strong>' . $endereco . "</strong> | <a href='search.php?'>Voltar</a><br />";

        if (isset($_POST['submitted'])) {
            foreach ($_POST AS $key => $value) {
                $_POST[$key] = mysql_real_escape_string(htmlentities($value));
            }
            $sql = "UPDATE `boletos` SET `pago` =  '{$_POST['pago']}' ,  `data_pagto` =  '{$_POST['data_pagto']}' , `total_pago` =  '{$_POST['total_pago']}'   WHERE `id` = '$id' ";
            mysql_query($sql) or die(mysql_error());
            echo (mysql_affected_rows()) ? "Cadastro salvo<br />" : "Nada foi alterado <br />";
        }
        $row = mysql_fetch_array(mysql_query("SELECT * ,(aluguel + iptu + sanepar + limpeza + material + copel + outros) as total FROM `boletos` WHERE `id` = '$id' "));
        echo "<br />";
        echo "<table>";
        echo "<tr><td>Nosso Num</td><td>" . stripslashes($row['nosso_num']) . "</td></tr>";
        echo "<tr><td>Sacado</td><td>" . stripslashes($row['sacado']) . "</td></tr>";
        echo "<tr><td>Vencimento</td><td>" . stripslashes($row['vencimento']) . "</td></tr>";
        echo "<tr><td>Total</td><td>" . stripslashes($row['total']) . "</td></tr>";
        echo "<tr><td>Desconto</td><td>" . stripslashes($row['desconto']) . "</td></tr>";

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
        echo "</form>";
        mysql_close($link);
        ?>
    </body>
</html>
<? ob_flush() ?>