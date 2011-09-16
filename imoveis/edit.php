<?
include('config.php');
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    if (isset($_POST['submitted'])) {
        foreach ($_POST AS $key => $value) {
            $_POST[$key] = mysql_real_escape_string($value);
        }
        $sql = "UPDATE `imoveis` SET  `endereco` =  '{$_POST['endereco']}' ,  `alugado` =  '{$_POST['alugado']}'   WHERE `id` = '$id' ";
        mysql_query($sql) or die(mysql_error());
        echo (mysql_affected_rows()) ? "Cadastro salvo<br />" : "Nada alterado<br />";
        echo "<a href='list.php'>Voltar para Lista</a>";
    }
    $row = mysql_fetch_array(mysql_query("SELECT * FROM `imoveis` WHERE `id` = '$id' "));
?>
    <form action='' method='POST'>
        <p><b>Endereco:</b><br /><input type='text' name='endereco' size=80 value='<?= stripslashes($row['endereco']) ?>' />
        <p><b>Alugado:</b><br />
            <input type='radio' name='alugado' value='1'<?
    if (isset($row['alugado']) && $row['alugado'] == 1) {
        echo 'checked';
    }
?>>Sim
        <input type='radio' name='alugado' value='0'<?
    if (isset($row['alugado']) && $row['alugado'] == 0) {
        echo 'checked';
    } ?>>Nao
        <p><input type='submit' value='Salvar' /><input type='hidden' value='1' name='submitted' />
    </form>
<? } ?> 