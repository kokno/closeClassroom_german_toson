<?php
    session_start(); //On initialise la session
    include 'controllers/MainController.class.php';
    ?>

    <!DOCTYPE html>
    <html lang="fr">
    <head>
    	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    	<title>CloseClassroom - TOSON / GERMAN</title>
    	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    	<link href="//fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    	<link rel="shortcut icon" href="style/img/college.png" />
    	<link href="style/css/bootstrapM.css" type="text/css" rel="stylesheet" media="all"  />
    	<link href="style/font-awesome-4.5.0/css/font-awesome.css" rel="stylesheet" />
        <link href="style/css/bootstrap3-wysihtml5.min.css" type="text/css" rel="stylesheet" />
        <script src="style/js/jquery-1.7.2.min.js"></script>
        <script src="style/js/bootstrap.js"></script>
        <script src="style/js/bootstrap3-wysihtml5.all.min.js"></script>
    </head>
    <body>
    	<?php
    	$controller = new MainController();
    	?>

    	<script>
    		setTimeout(function() {
    			$('#alertSuccess').modal('hide');
    		}, 3000);

    		setTimeout(function() {
    			$('#alertError').modal('hide');
    		}, 3000);
    	</script>
    	
    </body>
    </html>

    
