<html>
<head>
  <meta charset="UTF-8">
</head>
<body>

<?php
if($_SESSION['name']="yesh"){
if (isset($_POST['enter'])) {
  //--------------
$x=$_POST['usuario'];
class MyDB1 extends SQLite3
 {
    function __construct()
    {
       $this->open('test.db');
    }
 }
 $db1 = new MyDB1();
 if(!$db1){
    //echo $db1->lastErrorMsg();
 } else {
    //echo "Opened database successfully\n";
 }
 $sql =<<<EOF
 DELETE from CHAT where ID='$x';
EOF;
 $ret = $db1->exec($sql);
 if(!$ret){
   //echo $db1->lastErrorMsg();
 } else {
    //echo $db1->changes(), " Record deleted successfully\n";
 }
/*
 $sql =<<<EOF
 SELECT * from CHAT;
EOF;
 $ret = $db1->query($sql);
 while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
    echo "ID = ". $row['ID'] . "\n";
    echo "USUARIO = ". $row['USUARIO'] ."\n";
    echo "NAME = ". $row['NAME'] ."\n";
    echo "EMAIL = ". $row['EMAIL'] ."\n";
 }
 echo "Operation done successfully\n";
 $db1->close();
 */
}
//------------
   class MyDB extends SQLite3
   {
      function __construct()
      {
         $this->open('test.db');
      }
   }
   $db = new MyDB();
   if(!$db){
      //echo $db->lastErrorMsg();
   } else {
      //echo "Opened database successfully\n";
   }

   $sql =<<<EOF
      SELECT * from CHAT;
EOF;
    echo "<table border=1>";
    echo "<tr><td>ID</td><td>USUARIO</td><td>NOME</td><td>EMAIL</td></tr>";
   $ret = $db->query($sql);

   while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
      echo "<tr>";
      echo "<td> ".$row['ID'] . "</td>";
echo "<td> ".$row['USUARIO'] ."</td>";
      echo "<td> ".$row['NAME'] ."</td>";
      echo "<td> ".$row['EMAIL'] ."</td>";
      echo '<td><input type="button" onClick="setv('.$row['ID'] .');" value="Delete"></td>';
      echo "</tr>";
   }
   echo "</table>";
   //echo "Operation done successfully\n";
   $db->close();
?>
<form action="users.php" method="post">
  <label for="name">Deseja deletar o usuario com ID :</label>
  <input type="text" name="usuario" id="name" />
  <input type="submit" name="enter" id="enter" value="Confirmar" />
</form>
<script>
function setv($id){
  nome = document.getElementById('usuario');
  nome.value=$id;
}
</script>
<?php
} ?>
</body>
</html>
