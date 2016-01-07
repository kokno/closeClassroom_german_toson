<?php

	// views
include('views/NavBarView.class.php');
include('views/LoginView.class.php');
include('views/ProfileView.class.php');
include('views/FormPracticeView.class.php');
include('views/PracticeView.class.php');
include('views/UserView.class.php');
include('views/FormUserView.class.php');

	// models
include('models/Utilisateur.class.php');
include('models/Practice.class.php');

	//controllers
include('controllers/PracticeController.class.php');
include('controllers/UserController.class.php');

	//managers
include('bddManager/UserDAO.php');
include('bddManager/PracticeDAO.php');

class MainController {

	function __construct() {

			//charge la session si cookie présent
		if(!$this->isLogged() && isset($_COOKIE["moncookie"])) {
			$username_cookie = substr($_COOKIE["moncookie"], 0, strrpos($_COOKIE["moncookie"], " "));
			$password_cookie = substr($_COOKIE["moncookie"], strrpos($_COOKIE["moncookie"], " ")+1);
			$login = new Utilisateur($username_cookie, $password_cookie);
		}

			//insertion de la navbar
		$this->navBar();

			//choix de la page
		if ($this->isLogged())
		{
			if (isset($_GET['page']))
			{
				switch ($_GET['page'])
				{
					case 'login':
					$this->login();
					break;

					case 'logout':
					$this->logout();
					break;

					case 'practice':
					$this->practice();
					break;

					case 'createPractice':
					$this->createPractice();
					break;

					case 'updatePractice':
					$this->updatePractice();
					break;

					case 'deletePractice':
					$this->deletePractice();
					break;

					case 'user':
					$this->user();
					break;

					case 'createUser':
					$this->createUser();
					break;

					case 'updateUser':
					$this->updateUser();
					break;

					case 'deleteUser':
					$this->deleteUser();
					break;

						default: //404
						break;
					}
				}
				else
				{
					$this->profile();
				}			
			}
			else
			{
				$this->login();
			}
			
			//popup d'erreur
			if(isset($_SESSION['error']) AND $_SESSION['error'] != null AND isset($_SESSION['display_msg_error']) AND $_SESSION['display_msg_error'])
			{
				include('include/ErrorModal.php');
				$_SESSION['display_msg_error'] = false;
			}
			//popup de succès
			if(isset($_SESSION['success']) AND $_SESSION['success'] != null AND isset($_SESSION['display_msg_success']) AND $_SESSION['display_msg_success'])
			{
				include('include/SuccessModal.php');
				$_SESSION['display_msg_success'] = false;
			}
		}
		
		//insertion de la navbar
		function navBar() {
			$navBarView = new navBarView();
			
			if ($this->isLogged())
			{
				echo $navBarView->getViewLogged();
			}
			else
			{
				echo $navBarView->getViewLogout();
			}
		}
		
		//teste si l'utilisateur est connecté
		function isLogged() {
			if (isset($_SESSION['isLogged']) AND $_SESSION['isLogged'] == true)
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		//charge la page de login
		function login() {
			$managerUser = new UserDAO();
			if (isset($_GET['username']) && isset($_GET['password']))
			{
				$managerUser->getUserByLoginAndPassword($_GET['username'],$_GET['password']);
			}
			else
			{
				$_SESSION['isLogged'] = false;				
			}
			

			//$login = new Utilisateur($_GET['username'],$_GET['password']);

			if (!$this->isLogged())
			{
				$_SESSION['isLogged'] = false;
				$loginView = new loginView();
				echo $loginView->getView();
			}
			else
			{
				$profileView = new ProfileView();
				echo $profileView->getView();
			}
		}

		//charge la page de déconnection
		function logout() {
			if (isset($_COOKIE['moncookie']))
			{
				unset($_COOKIE['moncookie']);
				setcookie('moncookie', '', time() - 3600, '/');
			}
			session_unset();
			session_destroy();
			header('Location: /webserv/');
		}

		//charge la page practice
		function practice() {
			$practiceView = new PracticeView();
			echo $practiceView->getView();
		}

		//charge la page createPractice
		function createPractice() {
			if (isset($_POST['namePractice']) && isset($_FILES['fichierUp']['name']) AND $_FILES['fichierUp']['name'] != null)
			{
				$uploader = PracticeController::Instance();
				$uploader->uploadFile($_POST['namePractice'], $_POST['descriptionPractice']);
			}
			$formPracticeView = new FormPracticeView();
			echo $formPracticeView->getViewInsert();
		}

		//charge la page mise à jour cours
		function updatePractice() {
			$verifPractice = new PracticeDAO();
			$isPracticeExist = $verifPractice->verifPractice($_GET['idPractice']);
			if (!$isPracticeExist)
			{
				$_SESSION['error'] = 'Le cours n\'existe pas';
				$_SESSION['display_msg_error'] = true;
				$this->practice();
			}
			else 
			{
				if (isset($_POST['namePractice']))
				{
					$newFile = false;
					if (isset($_FILES['fichierUp']['name']) AND $_FILES['fichierUp']['name'] != null)
					{
						$getFile = new PracticeDAO();
						$infos = $getFile->getFile($_GET['idPractice']);
						unlink($_SERVER['DOCUMENT_ROOT'].$infos['path']);

						$newFile = true;
						$uploader = PracticeController::Instance();
						$uploader->updateFile($_POST['namePractice'], $_POST['descriptionPractice'], $_GET['idPractice'], $newFile);
					}
					else 
					{
						$uploader = PracticeController::Instance();
						$uploader->updateFile($_POST['namePractice'], $_POST['descriptionPractice'], $_GET['idPractice'], $newFile);
					}
				}
				$managerPractice = new PracticeDAO();
				$infos = $managerPractice->getNameAndDescriptionPractice($_GET['idPractice']);
				$file = $managerPractice->getFile($_GET['idPractice']);
				$formPracticeView = new FormPracticeView();
				echo $formPracticeView->getViewUpdate($_GET['idPractice'], $infos['name'], $infos['description'], $file['file'], $file['path']);
			}
		}

		//charge la page delete practice
		function deletePractice() {
			$uploader = PracticeController::Instance();
			$uploader->deleteFile($_GET['idPractice']);
			$this->practice();
		}

		//charge la page user
		function user() {
			$userView = new UserView();
			echo $userView->getView();
		}

		//charge la page createUser
		function createUser() {
			if (isset($_POST['loginUser']) && isset($_POST['passwordUser']) && isset($_POST['emailUser']) && isset($_POST['typeUser']))
			{
				$userController = new UserController();
				$createUser = $userController->createUser($_POST['loginUser'], $_POST['passwordUser'], $_POST['emailUser'], $_POST['typeUser']);
			}
			$userView = new FormUserView();
			echo $userView->getViewInsert();
		}

		//charge la page mise à jour user
		function updateUser() {
			$verifUser = new UserDAO();
			$isUserExist = $verifUser->verifUser($_GET['idUser']);
			if (!$isUserExist)
			{
				$_SESSION['error'] = 'L\'utilisateur n\'existe pas';
				$_SESSION['display_msg_error'] = true;
				$this->user();
			}
			else 
			{
				if (isset($_POST['loginUser']) && isset($_POST['passwordUser']) && isset($_POST['emailUser']) && isset($_POST['typeUser']))
				{
					$userController = new UserController();
					$updateUser = $userController->updateUser($_POST['loginUser'], $_POST['passwordUser'], $_POST['emailUser'], $_POST['typeUser'], $_GET['idUser']);	
				}
				$managerUser = new UserDAO();
				$infos = $managerUser->getInfoUser($_GET['idUser']);
				$userView = new FormUserView();
				echo $userView->getViewUpdate($_GET['idUser'], $infos['login'], $infos['password'], $infos['email'], $infos['type']);
			}
		}

		//charge la page delete user
		function deleteUser() {
			$userController = new UserController();
			$deleteUser = $userController->deleteUser($_GET['idUser']);
			$this->user();
		}

		//charge la page profile
		function profile() {
			$profileView = new ProfileView();
			echo $profileView->getView();
		}
	}
	?>
