<?php
function del($id){
  alert($id);
  class MyDB1 extends SQLite3
   {
      function __construct()
      {
         $this->open('test.db');
      }
   }
   $db1 = new MyDB1();
   if(!$db1){
      echo $db1->lastErrorMsg();
   } else {
      echo "Opened database successfully\n";
   }
   $sql =<<<EOF
      DELETE from CHAT where ID="$id";
EOF;
   $ret = $db1->exec($sql);
   if(!$ret){
     echo $db1->lastErrorMsg();
   } else {
      echo $db1->changes(), " Record deleted successfully\n";
   }

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
    ?>
