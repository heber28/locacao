<?

include('/../session.php');
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    include('/../config.php');
    $row = mysql_fetch_array(mysql_query("SELECT * FROM `imoveis` WHERE `id` = '$id' "));
    $disabled = '';
    if (isset($_POST['delbutton'])) {
        mysql_query("DELETE FROM `imoveis` WHERE `id` = '$id' ");
        echo (mysql_affected_rows()) ? "Cadastro excluido<br /> " : "Nada excluido<br /> ";
        echo "<a href='list.php'>Voltar</a> <br /><br />";
        $disabled = 'disabled';
    } elseif (isset($_POST['cancelbutton'])) {
        echo "Cancelado a exclusao <br />";
        echo "<a href='list.php'>Voltar</a> <br /><br />";
        $disabled = 'disabled';
    } else {
        echo "<form action='' method='POST'>";
        echo 'Tem certeza que deseja excluir o imovel: ' . $row['endereco'] . '?<br />';
        echo "<input name='delbutton' value='Excluir' type='submit'" . $disabled . ">";
        echo "<input name='cancelbutton' value='Cancelar' type='submit'" . $disabled . ">";
        echo "</form>";
    }
    mysql_close($link);
}
?>