<?php

session_start();

?>

<!DOCTYPE html>
<html >
  	<head>

	    <meta charset="UTF-8">
	    <title> SMS </title>

	    <link rel="stylesheet" href="css/normalize.css">
	    <link rel="stylesheet" href="css/style.css?d=<?php echo date('sm'); ?>" />

  	</head>

	<script>


	  	/*
		 *
		 *  Redirect and close the session
		 *
		 */
		function logOut() {

		  $.post("close_session.php", function (data) {

			document.location.href = "index.php?select=0";

		  });

		}

	</script>

<?php

	require_once('./php/RecupConf.php');
	require_once('./php/Database.php');

	// Get all info from conf file
	$conf = new RecupConf();

	// Database class (connection and requests)
	$database = new Database($conf->getDbName(), $conf->getDbLogin(), $conf->getDbPasswd());

	// Database class (connection and requests)
	$database = new Database($conf->getDbName(), $conf->getDbLogin(), $conf->getDbPasswd());

	// Database class (connection and requests)
	$database = new Database($conf->getDbName(), $conf->getDbLogin(), $conf->getDbPasswd());

	// Create sessions variables if there is post variables
	if(isset($_POST['pseudo']) && isset($_POST['passwd'])){

	  // If the pseudo is in database
	  if($database->select("registered", "pseudo", "pseudo", $_POST['pseudo']) != ""){

	    // If the passwd correspond to the user's passwd
	    if($database->select("registered", "passwd", "pseudo", $_POST['pseudo'])[0] === hash('sha256', $_POST['passwd'])){

	      $_SESSION['pseudo'] = $_POST['pseudo'];
	      $_SESSION['passwd'] = $_POST['passwd'];

	    }
	    else{

	      unset($_SESSION['pseudo']);
	      unset($_SESSION['passwd']);

	    }
	  }
	  else{

	    unset($_SESSION['pseudo']);
	    unset($_SESSION['passwd']);

	  }
	}

	// If there is a session, draw the html
	if(isset($_SESSION['pseudo']) && isset($_SESSION['passwd'])){

?>

<?php


	$search = "";
	if(isset($_POST['search'])){

		$search = $_POST['search'];

	}

	if(isset($_GET['select'])){

		$selected = $_GET['select'];

	}
	else{

		$selected = 0;

	}

	/*
	 *
	 *	Organize sended and received messages
	 *
	 */
	function organize($tab1, $tab2){

		$tmpTab = array();
		$finalTab = array();

		$i = 0;
		while(isset($tab1[$i])){
			$tmpTab[$i] = array($tab1[$i][0], $tab1[$i][1], "received");
			$i++;
		}

		$j = 0;
		while(isset($tab2[$j])){
			$tmpTab[$i + $j] = array($tab2[$j][0], $tab2[$j][1], "sended");
			$j++;
		}

		$i = 0;
		while(count($tmpTab) > 0){

			$finalTab[$i] = $tmpTab[getMinValueIndex($tmpTab)];
			array_splice($tmpTab, getMinValueIndex($tmpTab), 1);
			$i++;

		}

		return $finalTab;

	}


	/*
	 *
	 *	get min value index
	 *
	 */
	function getMinValueIndex($tab){

		$min = $tab[0][1];
		$index = 0;

		$i = 0;
		while(isset($tab[$i][1])){

			if($min > $tab[$i][1]){

				$min = $tab[$i][1];
				$index = $i;

			}

			$i++;

		}

		return $index;

	}

?>

  <body>

    	<div class="ui">
		<div class="left-menu">
			<div id="submitbutton">
				<button class="button drag" type="submit" onclick="logOut()">Se Deconnecter</button>
			</div>
				<form method="post" action="" class="search">
					<input placeholder="search..." type="search" name="search" id="">
					<input class="drag" type="submit" value="&#xf002;">
				</form>
				<menu class="list-friends">

					<?php

					$i = 0;
					while(isset($database->select("user", "name")[$i])){

						if($search == ""){

							if($database->select("user", "name")[$i] != ""){

								echo 	'<li class="drag" id="'.$i.'">
											<img width="50" height="50" src="./img/logo.jpg">
											<div class="info">
												<div class="user">'.utf8_encode($database->select("user", "name")[$i]).'</div>
										';
								if($i == $selected){

									echo 	'
												<div class="status on" id="'.$database->select("user", "id")[$i].'"> '.$database->select("user", "number")[$i].'</div>
											';

								}
								else{

									echo 	'
												<div class="status" id="'.$database->select("user", "id")[$i].'"> '.$database->select("user", "number")[$i].'</div>
											';

								}

								echo 	'
											</div>
										</li>
										';

							}
							else{

								echo 	'<li class="drag" id="'.$i.'">
											<img width="50" height="50" src="./img/logo.jpg">
											<div class="info">
												<div class="user">'.$database->select("user", "number")[$i].'</div>
										';
								if($i == $selected){

									echo 	'
												<div class="status on" id="'.$database->select("user", "id")[$i].'"></div>
											';

								}


								echo 	'
												<div class="status" id="'.$database->select("user", "id")[$i].'"></div>
											</div>
										</li>
										';

							}

						}
						else{

							if( strpos( strtolower(utf8_encode( $database->select("user", "name")[$i] )), strtolower($search)) !== false){

								if($database->select("user", "name")[$i] != ""){

									echo 	'<li class="drag" id="'.$i.'">
												<img width="50" height="50" src="./img/logo.jpg">
												<div class="info">
													<div class="user">'.utf8_encode($database->select("user", "name")[$i]).'</div>
											';
									if($i == $selected){

										echo 	'
													<div class="status on"> '.$database->select("user", "number")[$i].'</div>
												';

									}
									else{

										echo 	'
													<div class="status"> '.$database->select("user", "number")[$i].'</div>
												';

									}

									echo 	'
												</div>
											</li>
											';

								}
								else{

									echo 	'<li class="drag" id="'.$i.'">
												<img width="50" height="50" src="./img/logo.jpg">
												<div class="info">
													<div class="user">'.$database->select("user", "number")[$i].'</div>
											';
									if($i == $selected){

										echo 	'
													<div class="status on"></div>
												';

									}

									echo 	'
												</div>
											</li>
											';

								}

							}

						}

						$i++;

					}

					?>

				</menu>
		</div>
		<div class="chat">
			<div class="top">
				<div class="avatar">
					<img width="50" height="50" src="./img/logo.jpg">
				</div>
				<div class="info">
					<div class="name"><?php if($database->select("user", "name")[$selected] != ""){ echo utf8_encode($database->select("user", "name")[$selected]); }else{ echo $database->select("user", "number")[$selected]; } ?></div>
					<div class="count" id="count"><?php echo ($database->count("receivedMessage", "*", "userId", $database->select("user", "id")[$selected]) + $database->count("sendedMessage", "*", "userId", $database->select("user", "id")[$selected]) ); ?> messages</div>
				</div>
			</div>
			<ul class="messages">

				<?php

				$received = array();
				$sended = array();

				$i = 0;
				while(isset( $database->select("receivedMessage", "message", "userId", $database->select("user", "id")[$selected])[$i] )){

					$received[$i] = array($database->select("receivedMessage", "message", "userId", $database->select("user", "id")[$selected])[$i], $database->select("receivedMessage", "time", "userId", $database->select("user", "id")[$selected])[$i] );
					$i++;

				}
				$j = 0;
				while(isset( $database->select("sendedMessage", "message", "userId", $database->select("user", "id")[$selected])[$j] )){

					$sended[$j] = array($database->select("sendedMessage", "message", "userId", $database->select("user", "id")[$selected])[$j], $database->select("sendedMessage", "time", "userId", $database->select("user", "id")[$selected])[$j] );
					$j++;

				}

				// [0] : message
				// [1] : date
				// [2] : sended/received
				$messages = organize($received, $sended);

				$i = 0;
				while(isset($messages[$i][0])){

					if($messages[$i][2] == "sended"){

						echo 	'<li class="i">
									<div class="head">
										<span class="time">'.$messages[$i][1].'</span>
										<span class="name">Moi</span>
									</div>
									<div class="message">'.utf8_encode($messages[$i][0]).'</div>
								</li>';

					}
					else{

						if($database->select("user", "name")[$selected] != ""){

							echo 	'<li class="friend-with-a-SVAGina">
										<div class="head">
											<span class="time">'.$messages[$i][1].'</span>
											<span class="name">'.$database->select("user", "name")[$selected].'</span>
										</div>
										<div class="message">'.utf8_encode($messages[$i][0]).'</div>
									</li>';

						}
						else{

							echo 	'<li class="friend-with-a-SVAGina">
										<div class="head">
											<span class="time">'.$messages[$i][1].'</span>
											<span class="name">'.$database->select("user", "number")[$selected].'</span>
										</div>
										<div class="message">'.utf8_encode($messages[$i][0]).'</div>
									</li>';

						}

					}

					$i++;

				}

				?>

			</ul>
			<div class="write-form">
				<textarea placeholder="Type your message" name="e" id="texxt"  rows="2"></textarea>
				<span class="send drag">Send</span>
			</div>
		</div>
	</div>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
	<script src='http://cdnjs.cloudflare.com/ajax/libs/nicescroll/3.5.4/jquery.nicescroll.js'></script>

    <script>


	/*
	 *
	 *  Wait for socket connection
	 *
	 */
	function waitForSocketConnection(socket, callback){

	  setTimeout(
	    function () {

	      if (socket.readyState === 1) {

	        if(callback != null){

	          callback();

	        }
	        return;

	      }
	      else {

	        waitForSocketConnection(socket, callback);

	      }

	    }, 5); // wait 5 milisecond for the connection...

	}


	jQuery(function($){

	    if (!("WebSocket" in window)) {

	      	alert("Your browser does not support web sockets");

	    }
	    else{

	      	setup();

	    }


	    function setup(){

		    // Make the connection with the server on the VM
		    var host = "ws://" + location.host + ":10000";
		    var socket = new WebSocket(host);

		    var claerResizeScroll, conf, insertI, lol;

			conf = {

			    cursorcolor: "#696c75",
			    cursorwidth: "5px",
			    cursorborder: "none"

			};

			lol = {

			    cursorcolor: "#cdd2d6",
			    cursorwidth: "5px",
			    cursorborder: "none"

			};

		    // Wait for connection before sending support and game name
		    waitForSocketConnection(socket, function(){

		      	// On message execution
		      	socket.onmessage = function (event) {

		        	var d = new Date,
				    	dformat = [d.getFullYear(),
				                ("0" + (d.getMonth() + 1)).slice(-2),
				               ("0" + d.getDate()).slice(-2)].join('-')+' '+
				              [d.getHours(),
				               d.getMinutes(),
				               d.getSeconds()].join(':');
				    var message = JSON.parse(event.data);

				    if(message.type == "sended"){

		        		$(".messages").append("<li class=\"i\"><div class=\"head\"><span class=\"time\">" + dformat + "</span><span class=\"name\"> Moi</span></div><div class=\"message\">" + decodeURI(message.contenu) + "</div></li>");

				    }
				    else if(message.type == "homeSended"){

				    	$(".messages").append("<li class=\"i\"><div class=\"head\"><span class=\"time\">" + dformat + "</span><span class=\"name\"> Moi</span></div><div class=\"message\">" + decodeURI(message.contenu) + "</div></li>");

				    }
				    else{

				    	if( parseInt('<?php echo $database->select("user", "id")[$selected] ?>') == message.id){

					    	if('<?php echo $database->select("user", "name")[$selected] ?>' != ""){

					    		$(".messages").append("<li class=\"friend-with-a-SVAGina\"><div class=\"head\"><span class=\"time\">" + dformat + "</span> <span class=\"name\"><?php echo $database->select('user', 'name')[$selected] ?></span></div><div class=\"message\">" + decodeURI(message.contenu) + "</div></li>");

					    	}
					    	else{

					    		$(".messages").append("<li class=\"friend-with-a-SVAGina\"><div class=\"head\"><span class=\"time\">" + dformat + "</span> <span class=\"name\"><?php echo $database->select('user', 'number')[$selected] ?></span></div><div class=\"message\">" + decodeURI(message.contenu) + "</div></li>");

					    	}

					    }
					    else{

					    	document.getElementById(message.id).className = "status off";

					    }

				    }

				    claerResizeScroll();
				    document.getElementById("count").innerHTML = (parseInt(document.getElementById("count").innerHTML) + 1) + " messages";

		      	}

				claerResizeScroll = function() {

				    $("#texxt").val("");
				    $(".messages").getNiceScroll(0).resize();
				    return $(".messages").getNiceScroll(0).doScrollTop(999999, 999);

				};

				insertI = function() {

				    var innerText, otvet;
				    innerText = $.trim($("#texxt").val());

				    if (innerText !== "") {

						var msg = {
						    type: "sended",
						    contenu: innerText,
						    id: '<?php echo $database->select("user", "id")[$selected] ?>',
						    registeredId: '<?php echo $database->select("registered", "id", "pseudo", $_SESSION["pseudo"])[0] ?>'
						};

						socket.send(JSON.stringify(msg));
				   	}

				};

				$(document).ready(function() {

				  	$('.drag').click(function() {

				  		window.location.href = "index.php?select=" + this.getAttribute('id');

				    });

				    $(".list-friends").niceScroll(conf);
				    $(".messages").niceScroll(lol);

				    $("#texxt").keypress(function(e) {

				      if (e.keyCode === 13) {

				        insertI();
				        return false;

				      }

				    });

				    claerResizeScroll();

				    return $(".send").click(function() {

				      return insertI();

				    });

				});

		    });

	    }

  	});

    </script>

  </body>

</html>

<?php

	}
	else{

?>

	<form action="index.php?select=0" method="post">

	<fieldset>
	<legend>Connexion</legend>

	<div>
	  <label for="auth"></label>
	  <input type="text" id="pseudo" name="pseudo" placeholder="Pseudo"/>
	  <input type="password" id="passwd" name="passwd" placeholder="Mot de passe"/>
	</div>

	<div id="submitbutton">
	  <button class="buttonConnexion drag" type="submit">Se connecter</button>
	</div>

	</fieldset>

	</form>

<?php
	}

?>
