<?php
function loginForm() {
echo '<div id="loginform"><h1>Treinamento LG</h1><form action="." method="post"><p>Entre com um nome de usuário, nome completo e seu e-mail para assistir ao treinamento</p><center><table border=0><tr><td><label for="name">Usuário: </label></td><td><input type="text" name="usuario" id="name" autofocus /></td></tr><tr><td><label for="name">CPF(apenas números): </label></td><td><input type="text" name="cpf" id="cpf" /></td></tr><tr><td><label for="name">Nome Completo: </label></td><td><input type="text" name="name" id="name" autofocus /></td></tr><tr><td><label for="name">E-mail: </label></td><td><input type="text" name="email" id="email" autofocus /></td></tr></table><br></center><input type="submit" name="enter" id="enter" value="Entre" /></form></div>';
}
function getSetup($key = null) {
    $arr = parse_ini_file('setup.ini');
    return isset($key) ? $arr[$key] : $arr;
}
function deleteOldHistory() {
    $expireHistory = getSetup('expire_history');
    $expireDate = date('Y-m-d', strtotime("-$expireHistory day"));
    foreach (glob('./history/*') as $f) {
        if (basename($f) < $expireDate) {
            unlink($f);
        }
    }
}
function isMail($email){
    $er = "/^(([0-9a-zA-Z]+[-._+&])*[0-9a-zA-Z]+@([-0-9a-zA-Z]+[.])+[a-zA-Z]{2,6}){0,1}$/";
    if (preg_match($er, $email)){
	return true;
    } else {
	return false;
    }
}
function insertchat($usuario,$name,$email){
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
      INSERT INTO CHAT (USUARIO,NAME,EMAIL)
      VALUES ('$usuario','$name', '$email');
EOF;

   $ret = $db1->exec($sql);
   $db1->close();
}
//-------------------------
function sqluser($usuario){
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
      SELECT * from CHAT where USUARIO like "$usuario";
EOF;
   $ret = $db->query($sql);

   if($row = $ret->fetchArray() ){
     $db->close();
     return false;
   }else{
     $db->close();
     return true;
   }
   //echo "Operation done successfully\n";

   $db->close();

}
function sqlname2($usuario){
  class MyDB5 extends SQLite3
   {
      function __construct()
      {
         $this->open('test.db');
      }
   }
   $db5 = new MyDB5();
   if(!$db5){
      //echo $db5->lastErrorMsg();
   } else {
      //echo "Opened database successfully\n";
   }

   $sql =<<<EOF
      SELECT * from CHAT where USUARIO like "$usuario";
EOF;
   $ret = $db5->query($sql);

   if($row = $ret->fetchArray() ){
     $db5->close();
     return false;
   }else{
     $db5->close();
     return true;
   }
   //echo "Operation done successfully\n";

   $db5->close();

}
function sqlemail($email){
   $db4 = new MyDB();
   if(!$db4){
      //echo $db->lastErrorMsg();
   } else {
      //echo "Opened database successfully\n";
   }

   $sql =<<<EOF
      SELECT EMAIL from CHAT where EMAIL like "$email";
EOF;
   $ret = $db4->query($sql);

   if($row = $ret->fetchArray() ){
     $db4->close();
     return false;
   }else{
     $db4->close();
     return true;
   }
   //echo "Operation done successfully\n";

   $db4->close();

}
function verificachat($name,$email){
  class MyDB3 extends SQLite3
   {
      function __construct()
      {
         $this->open('test.db');
      }
   }
   $db3 = new MyDB3();
   if(!$db3){
      //echo $db3->lastErrorMsg();
   } else {
      //echo "Opened database successfully\n";
   }

   $sql =<<<EOF
      SELECT * from CHAT where NAME like "$name" or EMAIL like "$email";
EOF;
   $db3->close();

}
function validacpf($var){
	$cpf = array(
"52163016234",
"79440460504",
"00843036036",
"31118099869",
"07310725450",
/*"4623219593",
"4824686539",
"01360412565",
"2087465525",
 "729004155",
"5580255365",
"3456750102",
"4740001179",
"01302127179",
"05903198171",
"08933288635",
"09720117619",
"14259204629",
"05711259644",
"10522526489",
"9776973477",
"98258737287",
"01648539289",
"95882367204",
"54600286200",
"77912276220",
"2284913202",
"13735886752",
"86992864149",
"13629100740",
"10845212702",
"13328806733",
"16830248779",
"04409475967",
"16084987788",
"37004893820",
"99634961053",
"95585613049",
"7938822655",
"04412579921",
"05633336933",
"8866211940",
"8410991977",
"4690875952",
"8894806995",
"1691108006",
"85223070046",
"60008070075",
"1708535004",*/
"1234567891",
"1234567892",
"1234567893",
"1234567894",
"1234567895",
"1234567896",
"1234567897",
"1234567898",
"1234567899",
"1234567890"
);
for ($i = 0; $i < sizeof($cpf); $i++) {
    if($var==$cpf[$i]){
		return true;
	}
}
return false;
}
if(!isset($_SESSION)) {
     session_start();
}else{
session_destroy();
}
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ./"); //Redirect the user
}
if (isset($_POST['enter'])) {
    if (strlen($_POST['name'])>3 && isMail($_POST['email']) && strlen($_POST['email'])>3 && sqluser($_POST['usuario']) && strlen($_POST['usuario'])>3 && validacpf($_POST['cpf'])) {
        $_SESSION['usuario'] = stripslashes(htmlspecialchars($_POST['usuario']));
		$_SESSION['name'] = stripslashes(htmlspecialchars($_POST['name']));
        $_SESSION['email'] = stripslashes(htmlspecialchars($_POST['email']));
        $usuario=$_SESSION['usuario'];
		$name=$_SESSION['name'];
        $email=$_SESSION['email'];
        insertchat($usuario,$name,$email);
        //$email=$_POST['email'];
    }elseif(!validacpf($_POST['cpf'])){
		echo '<center><span class="error">Você não esta autorizado a participar do treinamento.</span></center>';
	} else {
	if(!sqlname2($_POST['usuario'])){
        echo '<center><span class="error">O nome de usuário já foi utilizado, entre com um novo.</span></center>';
}else{
echo '<center><span class="error">Por favor entre com um nome e e-mail válidos.</span></center>';
//echo '<center><span class="error">Aguarde o início do treinamento.</span></center>';
}

    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Chat - Customer Module</title>
        <meta charset="UTF-8" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link type="text/css" rel="stylesheet" href="style.css" />
    </head>
    <body>
    <?php
    if (!isset($_SESSION['usuario'])) {
        loginForm();
        deleteOldHistory();
    } else {
        ?>
        <center>
          <div class="caixa">
            <h1 id="titulo">
              TREINAMENTO LG
            </h1>
          </div>
      </center>
        <div class="content">
          <div class="col-xs-12 col-lg-6 col-sm-6 col-md-8">
<!-- <iframe src="https://player.twitch.tv/?channel=twitchyesh" frameborder="0" allowfullscreen="true" scrolling="no" height="378" width="620"></iframe> -->
              <!-- <iframe class="embededVideo" src="https://player.twitch.tv/?channel=twitchyesh" frameborder="0" allowfullscreen="true" scrolling="no" width="100%" height="700px" ></iframe> -->
          </div>
          <div class="col-xs-12 col-lg-6 col-sm-6 col-md-8">
            <div id="wrapper">
                <div id="menu">
                    <p class="welcome">Bem vindo, <b>
<?php
echo $_SESSION['usuario'];

?>
</b></p>
                    <p class="logout"><a id="exit" href="#">Sair do Chat</a></p>
                    <!-- <p class="logout" style="margin-right: 1em;"><a target="_blank" href="history.php">History</a></p> -->
                    <div style="clear:both"></div>
                </div>
                <div id="chatbox">

                </div>
                <form id="formenviar" name="message" action=".">
                    <input name="usermsg" type="text" id="usermsg" size="63" autocomplete="off" autofocus />
                    <input name="submitmsg" type="submit"  id="submitmsg" value="Enviar" />
                    <input name="chub" type="submit"  id="teste1" value="teste" />
                </form>

            </div>
          </div>
        </div>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script type="text/javascript">


        function gogo(){
                    //alert('return sent');
                    //event.preventDefault();
                    $.ajax({
                        type: "POST",
                        url: "postmsg.php",
                        data: {action: 'teste'},
                        dataType:'json', //or HTML, JSON, etc.
                        async: true,

                        success: function(response){
                            alert(response);
                            var teste='teste';
                            postget(teste);
                            //echo what the server sent back...
                        }
                    });
        }
        function setset(x){
          return x;
        }
        function postget(xxx){

          var x=xxx;
          $.ajax({

              type: "GET",
              url: "postmsg.php",
              data: {action: x},
              dataType:'json', //or HTML, JSON, etc.
              success: function(response){
                //alert("um");
                $("#chatbox").append("<input type='button' value='"+response+"'>");
                //$("#chatbox").append("<input type='button' value='"+response+"'>");
                  //echo what the server sent back...
              }
          });
        }
        setInterval(postget(''),1000);
        setInterval(function(){
          $("#teste1").click(function(event) {
            event.preventDefault();
            gogo();
            //alert("ewji");
          });
        }, 300);
      function envia(x,y,z,i){
				if(i==2){
					/*x=x;
					y=y;
					z=z;
					i=i;*/
					--i;

          /*$.get("postmsg.html", function(data){
            $("#chatbox").append(data);
            alert( "Load was performed." );
          });
          */
          /*$.ajax({
          url: 'postmsg.php',
          type:'POST',
          data :{ id:id},
          dataType:'json', //most important
          async: true,
          success:function(data){
            console.log("foi?"); //first value..etc
          }

        });*/
					//poste(x,y,z,i);


				}
			}

                var ok=false;
                var id = 'undefined';
                var oldId = null;
				function poste(x,y,z,i){
					alert('oi'+i);
          //var hash = z;
          $.ajax({
          url: 'postmsg.php',
          type:'POST',
          data : {z: z},
          dataType:'json', /*most important**/
          success:function(data){
            console.log("foi?"); //first value..etc
          }
          });
          $("#chatbox").append(html+"<input type='button' value='aprovar'>");
          /*
          isRunLoadLog = true;
					var oldscrollHeight = $("#chatbox")[0].scrollHeight;
					$.ajax({
					type: 'POST',
					url: 'index.php',
					data: {x:x,y:y,z:z},
					dataType: 'json',
					async: true,
                        success: function(data) {
							htm="<div class='msgln'>("+data.x+") <b>"+data.y+"</b>: "+data.z+"<br></div>";
							$("#chatbox").append(htm);
							var newscrollHeight = $("#chatbox")[0].scrollHeight;
                                if (newscrollHeight > oldscrollHeight) {
                                    $("#chatbox").scrollTop($("#chatbox")[0].scrollHeight);
                                }
							isRunLoadLog = false;
						},


					});*/
				}
				var isRunLoadLog = false;

				$("#submitmsg").click(function() {
                    var clientmsg = $("#usermsg").val();
                    $("#usermsg").val('');
                    $("#usermsg").focus();
                    $.ajax({
                        type: 'POST',
                        url: 'post.php',
                        data: {text: clientmsg},
                        async: true,
                        success: function(data) {
                            if (!isRunLoadLog) {
                              var x = '<?php echo $_SESSION["usuario"]; ?>';
                                loadLog('','','','');
                            }
                        },
                        error: function(request, status, error) {
                            $("#usermsg").val(clientmsg);
                        },
                    });
                    return false;
                });

                function loadLog(x,d,y,m) {
					isRunLoadLog = true;
                    var oldscrollHeight = $("#chatbox")[0].scrollHeight;
                    var sessionname = '<?php echo $_SESSION["usuario"]; ?>';
                    //alert(sessionname);
                    var xis=x;
                    var d=d;
                    var y=y;
                    var m=m;
                    $.ajax({

                        type: 'POST',
                        url: 'server.php',
                        data: {id: id,oi:sessionname,xis:x},
                        dataType: 'json',
                        //cache: false,
                        async: true,
                        success: function(data) {
                            id = data.id;
                            if (oldId !== id) {
                                oldId = id;
                                var html = '';
                                var date;
                                for (var k in data.data.reverse()) {
                                        date = new Date(parseInt(data.data[k][0])*1000);
                                        date = date.toLocaleTimeString();
                                        date = date.replace(/([\d]+\D+[\d]{2})\D+[\d]{2}(.*)/, '$1$2');
                                        html = html
                                                +"<div class='msgln'>("+date+") <b>"
                                                +data.data[k][1]+"</b>: "+data.data[k][2]+"<br></div>";

                                }
                  if(data.user==="yesh_admin"){
									//$("#chatbox").append(html+data.user+"<input type='button' value='aprovar' id='"+data.data[k][2]+"' onclick='envia(\""+date+"\",\""+data.data[k][1]+"\",\""+data.data[k][2]+"\",\""+2+"\");'><br>");
                  //$("#chatbox").append(html+data.user+"<input type='button' value='aprovar' id='"+data.data[k][2]+"' onclick='envia(\"yesh_admin\");'><br>");
                  $("#chatbox").append(html+"<input type='button' value='aprovar' id='"+data.data[k][2]+"' onclick='envia(\"yesh_admin\",\""+date+"\",\""+data.data[k][1]+"\",\""+data.data[k][2]+"\");'><br>");
                  //$("#chatbox").append(html+"<input type='button' value='aprovar' id='"+data.data[k][2]+"' onclick='loadLog('','','','');'><br>");
                }
                //if(x==="yesh_admin"){
                    alert(data.xis+" & "+y+"."+m);
                    //htm="<div class='msgln'>("+d+") <b>"+data.xis+"</b>: "+m+"<br></div>";
                    $("#chatbox").append("<div class='msgln'>("+d+") <b>"+data.xis+"</b>: "+m+"<br></div>");
                //}

								var newscrollHeight = $("#chatbox")[0].scrollHeight;
                                if (newscrollHeight > oldscrollHeight) {
                                    $("#chatbox").scrollTop($("#chatbox")[0].scrollHeight);
                                }
                            }
                            isRunLoadLog = false;
                        },
                    });
                }
                function envia(x,d,y,m){
                  //alert('oi '+x+d+y+m);
                  var x=x;
                  var d=d;
                  var y=y;
                  var m=m;
                  var clientmsg = m;
                  $.ajax({
                      type: 'POST',
                      url: 'post.php',
                      data: {text: clientmsg,x:x},
                      async: true,
                      dataType: 'json',
                      success: function(data) {
                          if (!isRunLoadLog) {
                              loadLog(data.x,d,y,m);
                              x='mais';
                              //alert('hi '+x+d+y+m);
                          }
                      },
                      error: function(request, status, error) {
                          $("#usermsg").val(clientmsg);
                      },
                  });
                  return false;
                }
                function loglog(data) {
					isRunLoadLog = true;
                    var oldscrollHeight = $("#chatbox")[0].scrollHeight;
                    $.ajax({

                        type: 'POST',
                        url: 'server.php',
                        data: {id: id},
                        dataType: 'json',
                        //cache: false,
                        async: true,

                        success: function(data) {

                            id = data.id;
                            if (oldId !== id) {
                                oldId = id;
                                var html = '';
                                var date;
                                for (var k in data.data.reverse()) {
                                        date = new Date(parseInt(data.data[k][0])*1000);
                                        date = date.toLocaleTimeString();
                                        date = date.replace(/([\d]+\D+[\d]{2})\D+[\d]{2}(.*)/, '$1$2');
                                        html = html
                                                +"<div class='msgln'>("+date+") <b>"
                                                +data.data[k][1]+"</b>: "+data.data[k][2]+"<br></div>";

                                }
                	$("#chatbox").append(html+"<input type='button' value='aprovar' id='"+data.data[k][2]+"' onclick='envia(\""+date+"\",\""+data.data[k][1]+"\",\""+data.data[k][2]+"\",\""+2+"\");'><br>");


								var newscrollHeight = $("#chatbox")[0].scrollHeight;
                                if (newscrollHeight > oldscrollHeight) {
                                    $("#chatbox").scrollTop($("#chatbox")[0].scrollHeight);
                                }
                            }
                            isRunLoadLog = false;
                        },
                    });
                }
				loadLog('','','','');
				//setInterval(envia,300);
                setInterval(function(){loadLog('','','','')},
<?php
echo getSetup('interval')
?>
);
                $("#exit").click(function() {
                    var exit = confirm("Tem certeza que deseja encerrar a sessão?");
                    if (exit == true) {
                        window.location = 'index.php?logout=true';
                    }
                });



        </script>
        <?php
    }
?>

</body>
</html>
