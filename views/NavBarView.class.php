<?php


class navBarView
{
	public function __construct()
	{
	}

	public function getViewLogged($firstNameUser, $typeUser)
	{
		if ($typeUser == 'Admin') {
			$view = '<nav class="navbar navbar-inverse">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="index.php">CloseClassroom</a>
				</div>

				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
					<ul class="nav navbar-nav">
						<li id="tabUser"><a href="index.php?page=user">Administration Utilisateurs</a></li>
						<li id="tabFormation"><a href="index.php?page=formation">Formations</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="index.php" style="font-size: 13px;"> Bonjour, <strong>'.utf8_encode($firstNameUser).'</strong> </a>
							<li><a href="index.php?page=logout">Se déconnecter</a></li>
						</ul>
					</div>
				</div>
			</nav>';
		}
		else {
			$view = '<nav class="navbar navbar-inverse">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="index.php">CloseClassroom</a>
				</div>

				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
					<ul class="nav navbar-nav">
						<li id="tabFormation"><a href="index.php?page=formation">Formations</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="index.php" style="font-size: 13px;"> Bonjour, <strong>'.utf8_encode($firstNameUser).'</strong> </a>
							<li><a href="index.php?page=logout">Se déconnecter</a></li>
						</ul>
					</div>
				</div>
			</nav>';
		}

		return $view;
	}

	public function getViewLogout()
	{
		return '
		<nav class="navbar navbar-inverse">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="index.php">CloseClassroom</a>
				</div>

				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
					<ul class="nav navbar-nav">
					</ul>
				</div>
			</div>
		</nav>						
		';
	}
}
