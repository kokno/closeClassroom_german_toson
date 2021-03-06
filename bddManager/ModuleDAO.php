<?php

class ModuleDAO
{
    public function __construct()
    {
        $connect = new ConnectDAO();
        $_SESSION['bdd'] = $connect->connect();
    }
    
    public function getModules()
    {
        try {
            $resultat = mysqli_query($_SESSION['bdd'], 'SELECT * FROM modules');
            if (mysqli_num_rows($resultat) != '0') {
                $tab[0] = mysqli_fetch_assoc($resultat);
                if (mysqli_num_rows($resultat) > '0') {
                    for ($i = 1; $i < mysqli_num_rows($resultat); $i++) {
                        array_push($tab, mysqli_fetch_assoc($resultat));
                    }
                }
                return $tab;
            } else {
                return false;
            }
        }
        catch (Exception $e) {
            $_SESSION['error'] = 'Erreur requete BDD';
            $_SESSION['display_msg_error'] = true;
        }
    }
    
    public function getModulesByFormation($idFormation)
    {
        try {
            $resultat = mysqli_query($_SESSION['bdd'], "SELECT * from modules WHERE id IN (SELECT id_module from assomoduleformation where id_formation = '" . $idFormation . "');");
            if (mysqli_num_rows($resultat) != '0') {
                $tab[0] = mysqli_fetch_assoc($resultat);
                if (mysqli_num_rows($resultat) > '0') {
                    for ($i = 1; $i < mysqli_num_rows($resultat); $i++) {
                        array_push($tab, mysqli_fetch_assoc($resultat));
                    }
                }
                return $tab;
            } else {
                return false;
            }
        }
        catch (Exception $e) {
            $_SESSION['error'] = 'Erreur requete BDD';
            $_SESSION['display_msg_error'] = true;
        }
    }
    
    public function getNameModule($idModule)
    {
        try {
            $resultat = mysqli_query($_SESSION['bdd'], "SELECT name FROM modules WHERE `id`= '" . $idModule . "'");
            if (mysqli_num_rows($resultat) != '0') {
                $tab[0] = mysqli_fetch_assoc($resultat);
                return $tab[0];
            } else {
                return;
            }
        }
        catch (Exception $e) {
            $_SESSION['error'] = 'Erreur requete BDD';
            $_SESSION['display_msg_error'] = true;
        }
    }
    
    public function createModule($nameModule, $formations)
    {
        try {
            mysqli_query($_SESSION['bdd'], "INSERT INTO modules (name) VALUES ('" . addslashes(utf8_decode($nameModule)) . "')");
            $resultat = mysqli_query($_SESSION['bdd'], "SELECT id FROM modules WHERE `name` = '" . addslashes($nameModule) . "'");
            $log = mysqli_fetch_assoc($resultat);
            foreach($formations as $idFormation) {
                mysqli_query($_SESSION['bdd'], "INSERT INTO assomoduleformation (id_formation, id_module) VALUES ('" . $idFormation . "', '" . $log['id'] . "')");
            }
        }
        catch (Exception $e) {
            $_SESSION['error'] = 'Erreur requete BDD';
            $_SESSION['display_msg_error'] = true;
        }
    }
    
    public function updateModule($idModule, $nameModule, $formations)
    {
        try {
            mysqli_query($_SESSION['bdd'], "UPDATE `modules` SET `name` = '" . addslashes(utf8_decode($nameModule)) . "' WHERE `id` = '" . $idModule . "'");
            mysqli_query($_SESSION['bdd'], "DELETE FROM `assomoduleformation` WHERE `id_module` = '" . $idModule . "'");
            foreach($formations as $idFormation) {
                mysqli_query($_SESSION['bdd'], "INSERT INTO assomoduleformation (id_formation, id_module) VALUES ('" . $idFormation . "', '" . $idModule . "')");
            }
        }
        catch (Exception $e) {
            $_SESSION['error'] = 'Erreur requete BDD';
            $_SESSION['display_msg_error'] = true;
        }
    }
    
    public function deleteModule($idModule)
    {
        try {
            mysqli_query($_SESSION['bdd'], "DELETE FROM `practices` WHERE `id_module` = '" . $idModule . "'");
            mysqli_query($_SESSION['bdd'], "DELETE FROM `assomoduleformation` WHERE `id_module` = '" . $idModule . "'");
            mysqli_query($_SESSION['bdd'], "DELETE FROM `modules` WHERE `id` = '" . $idModule . "'");
        }
        catch (Exception $e) {
            $_SESSION['error'] = 'Erreur requete BDD';
            $_SESSION['display_msg_error'] = true;
        }
    }
    
    public function verifModule($idModule)
    {
        try {
            $resultat = mysqli_query($_SESSION['bdd'], "SELECT * FROM modules WHERE `id`= '" . $idModule . "'");
            if (mysqli_num_rows($resultat) != '0') {
                return true;
            } else {
                return false;
            }
        }
        catch (Exception $e) {
            $_SESSION['error'] = 'Erreur requete BDD';
            $_SESSION['display_msg_error'] = true;
        }
    }

    public function getDoublonByName($nameModule, $idModule)
    {
        try {
            $resultat = mysqli_query($_SESSION['bdd'], "SELECT * FROM modules WHERE `name`= '" . addslashes($nameModule) . "' and `id` != '" . $idModule . "' ");
            if (mysqli_num_rows($resultat) != '0') {
                return true;
            } else {
                return false;
            }
        }
        catch (Exception $e) {
            $_SESSION['error'] = 'Erreur requete BDD';
            $_SESSION['display_msg_error'] = true;
        }
    }
}
