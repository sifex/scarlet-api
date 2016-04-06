<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="cache-control" content="no-cache">
	<meta name="viewport" content="user-scalable=no" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta charset="UTF-8">
	<title>Australian Armed Forces</title>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js" charset="utf-8"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.1.1/foundation.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css" type="text/css" media="screen" charset="utf-8">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.transitions.min.css" type="text/css" media="screen" charset="utf-8">
	<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300' rel='stylesheet' type='text/css'>
	<style type="text/css" media="screen">

		#draggable {
			height:100px;
			position: fixed;
			width: 100%;
			z-index: 9997;
		}
		#minimise, #close {
			height: 26px;
			width: 34px;
			position: fixed;
		}
		#close {
			z-index: 9999;
			background: url('http://i.imgur.com/NBY6haG.png');
			left: 866px;
		}
		#close:hover {
			background: url('http://i.imgur.com/VvXKhGC.png');
		}
		#minimise {
			z-index: 9998;
			background: url('http://i.imgur.com/smlvZuR.png');
			left: 832px;
		}
		#minimise:hover {
			background: url('http://i.imgur.com/LQOLaD9.png');
		}

		html, body {
			overflow: hidden;
			width: 900px;
			height: 450px;
		}
		body {
			background-image: url('/key/images/bg.png');
			-webkit-background-size: cover;
			-moz-background-size: cover;
			-o-background-size: cover;
			background-size: cover;
			background-repeat: no-repeat;
			width: 900px;
			height: 450px;
		}
		.logo {
			background-image: url('/images/logo.png');
			height:100px;
			width: 100px;
			background-size: 100px 100px ;
			float:right;
		}
		form {
			margin-top: 180px;
		}
		input[type='text'] {
			margin-top: 25px;
			border-radius: 3px;
		}
	</style>
</head>
<body>
	<div id="draggable"></div>
	<div id="close"></div>
	<div id="minimise"></div>

	<form id="keyForm" action="#">
	  <div class="row">
	    <div class="medium-3 columns">
				<div class="logo"></div>
	    </div>
	    <div class="medium-7 columns end">
	      <label>
	        <input name="key" type="text" placeholder="Please enter your Scarlet Key">
	      </label>
	    </div>
	  </div>
	</form>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.0/jquery.min.js" charset="utf-8"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.1.2/foundation.js" charset="utf-8"></script>
	<script>

		$(document).foundation();

		function get(url) {
			$.get(url, function( data ) {
				return data;
			});
		}

		$("#keyForm").submit(function(e) {
			e.preventDefault();
				window.external.saveKeyAndRestart( data );
		});

		$("#draggable").mousedown(function() {
			window.external.drag();
		});

		$("#close").click(function() {
			window.external.closeBtn_Click();
		});

		$("#minimise").click(function() {
			window.external.minimizeBtn_Click();
		});




	</script>

</body>
</html>
