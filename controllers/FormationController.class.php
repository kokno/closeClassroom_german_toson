<?php


class FormationController
{
    public function __construct()
    {
    }
    
    public function createFormation($nameFormation, $descriptionFormation)
    {
        $getDoublon = new FormationDAO();
        $doublon = $getDoublon->getDoublonByName($nameFormation, '');

        if ($doublon) {
            $_SESSION['error'] = 'Une formation avec le même nom existe déjà !';
            $_SESSION['display_msg_error'] = true;
        }
        else {
            if (!(isset($_SESSION['error']) and $_SESSION['error'] != null and isset($_SESSION['display_msg_error']) and $_SESSION['display_msg_error'])) {
                $createFormation = new FormationDAO();
                $createFormation->createFormation($nameFormation, $descriptionFormation);
                $_SESSION['success'] = 'La formation <b>' . $nameFormation . '</b> a été créée.';
                $_SESSION['display_msg_success'] = true;
            } else {
                $_SESSION['error'] = 'La formation n\'a pas été crée';
                $_SESSION['display_msg_error'] = true;
            }
        }
    }

    public function updateFormation($nameFormation, $descriptionFormation, $idFormation)
    {
     $getDoublon = new FormationDAO();
     $doublon = $getDoublon->getDoublonByName($nameFormation, $idFormation);

     if ($doublon) {
        $_SESSION['error'] = 'Une formation avec le même nom existe déjà !';
        $_SESSION['display_msg_error'] = true;
    }
    else {
        if (!(isset($_SESSION['error']) and $_SESSION['error'] != null and isset($_SESSION['display_msg_error']) and $_SESSION['display_msg_error'])) {
            $updateFormation = new FormationDAO();
            $updateFormation->updateFormation($idFormation, $nameFormation, $descriptionFormation);
            $_SESSION['success'] = 'La formation <b>' . $nameFormation . '</b> a été mise à jour';
            $_SESSION['display_msg_success'] = true;
        } else {
            $_SESSION['error'] = 'La formation n\'a pas été mise à jour';
            $_SESSION['display_msg_error'] = true;
        }
    }
}

public function deleteFormation($idFormation)
{
    $managerFormation = new FormationDAO();
    $managerFormation->deleteFormation($idFormation);
}
}
