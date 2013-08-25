<?php

// Constantes permettant de 
	define("PROD_ROOT", "/~aribola/"); 
	define("PROD_ROOT_LONG", "/home/etudiants/info/aribola/public_html/"); 
	define("DEV_ROOT", "/public/");


//define("PROD_ROOT", "/var/www/projetWeb/");
//define("PROD_ROOT_LONG", "/var/www/projetWeb/");

define("ROOT", PROD_ROOT);
define("ROOT_URL", ROOT . 'index.php');
define("ROOT_LONG", PROD_ROOT_LONG);
set_include_path(get_include_path() . PATH_SEPARATOR . ROOT_LONG);

//require 'include/infosBd.php';
require 'include/EinfosBd.php';
require 'include/fonctions.php';
spl_autoload_register('generic_autoload');

Controller_Template::$db = new MyPDO('mysql:host=database-etudiants;dbname='.$dbname, $login, $pass);
//Controller_Template::$db = new MyPDO('mysql:host=localhost;dbname=' . $dbname, $login, $pass);
Controller_Template::$profil = new Controller_Profil();

session_start();

if (isset($_GET['module'])) {
    if ($_GET['module'] == 'Fiche') {
        if (isset($_GET['action'])) {
            if ($_GET['action'] == 'newFiche') {
                if (isset($_SESSION['type'])) {
                    if ($_SESSION['type'] <= 2) {
                        $controller = Controller_Fiche::getInstance('Fiche');
                        $controller->newFiche();
                    } else {
                        Controller_Template::$profil->index();
                    }
                } else {
                    Controller_Template::$profil->index();
                }
            } else if ($_GET['action'] == 'addManga') {
                if (!empty($_POST)) {
                    $controller = Controller_Fiche::getInstance('Fiche');
                    $controller->addManga();
                } else {
                    $controller = Controller_Fiche::getInstance('Fiche');
                    $controller->newFiche();
                }
            } else if ($_GET['action'] == 'addAnime') {
                if (!empty($_POST)) {
                    $controller = Controller_Fiche::getInstance('Fiche');
                    $controller->addAnime();
                } else {
                    $controller = Controller_Fiche::getInstance('Fiche');
                    $controller->formAnime();
                }
            } else if ($_GET['action'] == 'displayFiche') {
                if (isset($_GET['idmanga']) || isset($_GET['idanime'])) {
                    if (!empty($_GET['idmanga']) || !empty($_GET['idanime'])) {
                        $controller = Controller_Fiche::getInstance('Fiche');
                        $controller->displayFiche();
                    } else {
                        Controller_Template::$profil->index();
                    }
                } else {
                    Controller_Template::$profil->index();
                }
            } else if ($_GET['action'] == 'finalFiche') {
                if (isset($_GET['idmanga']) && isset($_GET['idanime'])) {
                    if (!empty($_GET['idmanga']) && !empty($_GET['idanime'])) {
                        $controller = Controller_Fiche::getInstance('Fiche');
                        $controller->finalFiche();
                    } else {
                        Controller_Template::$profil->index();
                    }
                } else {
                    Controller_Template::$profil->index();
                }
            } else if ($_GET['action'] == 'setCompar') {
                if (isset($_SESSION['type'])) {
                    if ($_SESSION['type'] <= 2) {
                        if (!empty($_POST)) {
                            $controller = Controller_Fiche::getInstance('Fiche');
                            $controller->setCompar();
                        } else {
                            Controller_Template::$profil->index();
                        }
                    } else {
                        Controller_Template::$profil->index();
                    }
                } else {
                    Controller_Template::$profil->index();
                }
            } else if ($_GET['action'] == 'displayListe') {
                if (isset($_GET['char'])) {
                    if (!empty($_GET['char'])) {
                        $controller = Controller_Fiche::getInstance('Fiche');
                        $controller->displayListe();
                    } else {
                        Controller_Template::$profil->index();
                    }
                } else {
                    Controller_Template::$profil->index();
                }
            } else if ($_GET['action'] == 'setNote') {
                if (!empty($_SESSION)) {
                    if (isset($_GET['idanime']) || isset($_GET['idmanga']) && isset($_GET['note'])) {
                        if ((!empty($_GET['idanime']) || !empty($_GET['idmanga'])) && !empty($_GET['note'])) {
                            $controller = Controller_Fiche::getInstance('Fiche');
                            $controller->setNote();
                        } else {
                            Controller_Template::$profil->index();
                        }
                    } else {
                        Controller_Template::$profil->index();
                    }
                } else {
                    Controller_Template::$profil->index();
                }
            } else if ($_GET['action'] == 'delNote') {
                if (!empty($_SESSION)) {
                    if (isset($_GET['idanime']) || isset($_GET['idmanga'])) {
                        if (!empty($_GET['idanime']) || !empty($_GET['idmanga'])) {
                            $controller = Controller_Fiche::getInstance('Fiche');
                            $controller->delNote();
                        } else {
                            Controller_Template::$profil->index();
                        }
                    } else {
                        Controller_Template::$profil->index();
                    }
                } else {
                    Controller_Template::$profil->index();
                }
            } else if ($_GET['action'] == 'setAime') {
                if (!empty($_SESSION)) {
                    if (isset($_GET['idanime']) || isset($_GET['idmanga'])) {
                        if (!empty($_GET['idanime']) || !empty($_GET['idmanga'])) {
                            $controller = Controller_Fiche::getInstance('Fiche');
                            $controller->setAime();
                        } else {
                            Controller_Template::$profil->index();
                        }
                    } else {
                        Controller_Template::$profil->index();
                    }
                } else {
                    Controller_Template::$profil->index();
                }
            } else if ($_GET['action'] == 'delAime') {
                if (!empty($_SESSION)) {
                    if (isset($_GET['idanime']) || isset($_GET['idmanga'])) {
                        if (!empty($_GET['idanime']) || !empty($_GET['idmanga'])) {
                            $controller = Controller_Fiche::getInstance('Fiche');
                            $controller->delAime();
                        } else {
                            Controller_Template::$profil->index();
                        }
                    } else {
                        Controller_Template::$profil->index();
                    }
                } else {
                    Controller_Template::$profil->index();
                }
            } else if ($_GET['action'] == 'displayTop50') {
                $controller = Controller_Fiche::getInstance('Fiche');
                $controller->displayTop50();
            } else if ($_GET['action'] == 'addCom') {
                if (!empty($_SESSION)) {
                    if (isset($_POST['idAnime']) || isset($_POST['idManga'])) {
                        if (!empty($_POST['idAnime']) || !empty($_POST['idManga'])) {
                            $controller = Controller_Fiche::getInstance('Fiche');
                            $controller->addCom();
                        } else {
                            Controller_Template::$profil->index();
                        }
                    } else {
                        Controller_Template::$profil->index();
                    }
                } else {
                    Controller_Template::$profil->index();
                }
            } else if ($_GET['action'] == 'suppCom') {
                if (!empty($_SESSION)) {
                    if (isset($_GET['idcom'])) {
                        if (!empty($_GET['idcom'])) {
                            $controller = Controller_Fiche::getInstance('Fiche');
                            $controller->suppCom();
                        } else {
                            Controller_Template::$profil->index();
                        }
                    } else {
                        Controller_Template::$profil->index();
                    }
                } else {
                    Controller_Template::$profil->index();
                }
            } else if ($_GET['action'] == 'recherche') {
                if (!empty($_POST)) {
                    $controller = Controller_Fiche::getInstance('Fiche');
                    $controller->recherche();
                } else {

                    Controller_Template::$profil->index();
                }
            } else {

                Controller_Template::$profil->index();
            }
        } else {

            Controller_Template::$profil->index();
        }
    } else if ($_GET['module'] == 'Utilisateur') {
        if (isset($_GET['action'])) {
            if ($_GET['action'] == 'connexion') {
                if (empty($_SESSION)) {
                    if (isset($_POST['pseudo']) && isset($_POST['mdp'])) {
                        $controller = Controller_Utilisateur::getInstance('Utilisateur');
                        $controller->connexion();
                    } else {
                        Controller_Template::$profil->index();
                    }
                } else {
                    Controller_Template::$profil->index();
                }
            } else if ($_GET['action'] == 'inscription') {
                if (empty($_SESSION)) {
                    if (!empty($_POST)) {
                        $controller = Controller_Utilisateur::getInstance('Utilisateur');
                        $controller->inscription();
                    } else {

                        Controller_Template::$profil->index();
                    }
                } else {
                    Controller_Template::$profil->index();
                }
            } else if ($_GET['action'] == 'deconnexion') {
                if (!empty($_SESSION)) {
                    $controller = Controller_Utilisateur::getInstance('Utilisateur');
                    $controller->deconnexion();
                } else {
                    Controller_Template::$profil->index();
                }
            } else {
                Controller_Template::$profil->index();
            }
        } else {
            Controller_Template::$profil->index();
        }
    } else if ($_GET['module'] == 'Profil') {
        if (isset($_GET['action'])) {
            if ($_GET['action'] == 'setAvatar') {
                if (!empty($_SESSION)) {
                    if (!empty($_FILES)) {

                        Controller_Template::$profil->setAvatar();
                    } else {

                        Controller_Template::$profil->index();
                    }
                } else {

                    Controller_Template::$profil->index();
                }
            } else if ($_GET['action'] == 'setStatut') {
                if (!empty($_SESSION)) {
                    if (!empty($_POST)) {
                        Controller_Template::$profil->setStatut();
                    } else {
                        Controller_Template::$profil->index();
                    }
                } else {
                    Controller_Template::$profil->index();
                }
            } else if ($_GET['action'] == 'displayProfil') {
                if (!empty($_SESSION)) {
                    Controller_Template::$profil->displayProfil();
                } else {
                    Controller_Template::$profil->index();
                }
            } else if ($_GET['action'] == 'editerProfil') {
                if (!empty($_SESSION)) {
                    Controller_Template::$profil->editerProfil();
                } else {
                    Controller_Template::$profil->index();
                }
            } else {
                Controller_Template::$profil->index();
            }
        } else {
            Controller_Template::$profil->index();
        }
    } else if ($_GET['module'] == 'Administration') {
        if (isset($_GET['action'])) {
            if ($_GET['action'] == 'displayAdmin') {
                if (isset($_SESSION['type'])) {
                    if ($_SESSION['type'] <= 2) {
                        $controller = Controller_Administration::getInstance('Administration');
                        $controller->displayAdmin();
                    } else {
                        Controller_Template::$profil->index();
                    }
                } else {
                    Controller_Template::$profil->index();
                }
            } else if ($_GET['action'] == 'gestionProfil') {
                if (isset($_SESSION['type'])) {
                    if ($_SESSION['type'] == 1) {
                        $controller = Controller_Administration::getInstance('Administration');
                        if (isset($_GET['iduser'])) {
                            if (!empty($_GET['iduser'])) {
                                $controller->gestionProfil();
                            } else {

                                $controller->displayAdmin();
                            }
                        } else {
                            $controller->displayAdmin();
                        }
                    } else {
                        Controller_Template::$profil->index();
                    }
                } else {
                    Controller_Template::$profil->index();
                }
            } else if ($_GET['action'] == 'suppUser') {
                if (isset($_SESSION['type'])) {
                    if ($_SESSION['type'] == 1) {
                        $controller = Controller_Administration::getInstance('Administration');
                        if (isset($_GET['iduser'])) {
                            if (!empty($_GET['iduser'])) {
                                $controller->suppUser();
                            } else {
                                $controller->displayAdmin();
                            }
                        } else {
                            $controller->displayAdmin();
                        }
                    } else {
                        Controller_Template::$profil->index();
                    }
                } else {
                    Controller_Template::$profil->index();
                }
            } else if ($_GET['action'] == 'editerProfil') {
                if (isset($_SESSION['type'])) {
                    if ($_SESSION['type'] == 1) {
                        $controller = Controller_Administration::getInstance('Administration');
                        if (!empty($_POST)) {
                            $controller->editerProfil();
                        } else {
                            $controller->displayAdmin();
                        }
                    } else {
                        Controller_Template::$profil->index();
                    }
                } else {
                    Controller_Template::$profil->index();
                }
            } else if ($_GET['action'] == 'gestionFiche') {
                if (isset($_SESSION['type'])) {
                    if ($_SESSION['type'] <= 2) {
                        $controller = Controller_Administration::getInstance('Administration');
                        if (isset($_GET['idanime']) && isset($_GET['idmanga'])) {
                            if (!empty($_GET['idanime']) || !empty($_GET['idmanga'])) {
                                $controller->gestionFiche();
                            } else {
                                $controller->displayAdmin();
                            }
                        } else {
                            $controller->displayAdmin();
                        }
                    } else {
                        Controller_Template::$profil->index();
                    }
                } else {
                    Controller_Template::$profil->index();
                }
            } else if ($_GET['action'] == 'suppFiche') {
                if (isset($_SESSION['type'])) {
                    if ($_SESSION['type'] <= 2) {
                        $controller = Controller_Administration::getInstance('Administration');
                        if (isset($_GET['idanime']) && isset($_GET['idmanga'])) {
                            if (!empty($_GET['idanime']) || !empty($_GET['idmanga'])) {
                                $controller->suppFiche();
                            } else {
                                $controller->displayAdmin();
                            }
                        } else {
                            $controller->displayAdmin();
                        }
                    } else {
                        Controller_Template::$profil->index();
                    }
                } else {
                    Controller_Template::$profil->index();
                }
            } else if ($_GET['action'] == 'addManga') {
                if (isset($_SESSION['type'])) {
                    if ($_SESSION['type'] <= 2) {
                        $controller = Controller_Administration::getInstance('Administration');
                        if (isset($_POST['idanime'])) {
                            if (!empty($_POST['idanime'])) {
                                $controller->addManga();
                            } else {
                                $controller->displayAdmin();
                            }
                        } else {
                            $controller->displayAdmin();
                        }
                    } else {
                        Controller_Template::$profil->index();
                    }
                } else {
                    Controller_Template::$profil->index();
                }
            } else if ($_GET['action'] == 'suppManga') {
                if (isset($_SESSION['type'])) {
                    if ($_SESSION['type'] <= 2) {
                        $controller = Controller_Administration::getInstance('Administration');
                        if (isset($_GET['idmanga'])) {
                            if (!empty($_GET['idmanga'])) {
                                $controller->suppManga();
                            } else {
                                $controller->displayAdmin();
                            }
                        } else {
                            $controller->displayAdmin();
                        }
                    } else {
                        Controller_Template::$profil->index();
                    }
                } else {
                    Controller_Template::$profil->index();
                }
            }else if ($_GET['action'] == 'suppAnime') {
                if (isset($_SESSION['type'])) {
                    if ($_SESSION['type'] <= 2) {
                        $controller = Controller_Administration::getInstance('Administration');
                        if (isset($_GET['idanime'])) {
                            if (!empty($_GET['idanime'])) {
                                $controller->suppAnime();
                            } else {
                                $controller->displayAdmin();
                            }
                        } else {
                            $controller->displayAdmin();
                        }
                    } else {
                        Controller_Template::$profil->index();
                    }
                } else {
                    Controller_Template::$profil->index();
                }
            } else if ($_GET['action'] == 'addAnime') {
                if (isset($_SESSION['type'])) {
                    if ($_SESSION['type'] <= 2) {
                        $controller = Controller_Administration::getInstance('Administration');
                        if (isset($_POST['idmanga'])) {
                            if (!empty($_POST['idmanga'])) {
                                $controller->addAnime();
                            } else {
                                $controller->displayAdmin();
                            }
                        } else {
                            $controller->displayAdmin();
                        }
                    } else {
                        Controller_Template::$profil->index();
                    }
                } else {
                    Controller_Template::$profil->index();
                }
            } else if ($_GET['action'] == 'gestionAnime') {
                if (isset($_SESSION['type'])) {
                    if ($_SESSION['type'] <= 2) {
                        $controller = Controller_Administration::getInstance('Administration');
                        if (isset($_GET['idanime'])) {
                            if (!empty($_GET['idanime'])) {
                                $controller->gestionAnime();
                            } else {
                                $controller->displayAdmin();
                            }
                        } else {
                            $controller->displayAdmin();
                        }
                    } else {
                        Controller_Template::$profil->index();
                    }
                } else {
                    Controller_Template::$profil->index();
                }
            } else if ($_GET['action'] == 'setAnime') {
                if (isset($_SESSION['type'])) {
                    if ($_SESSION['type'] <= 2) {
                        $controller = Controller_Administration::getInstance('Administration');
                        if (isset($_POST['idanime'])) {
                            if (!empty($_POST['idanime'])) {
                                $controller->setAnime();
                            } else {
                                $controller->displayAdmin();
                            }
                        } else {
                            $controller->displayAdmin();
                        }
                    } else {
                        Controller_Template::$profil->index();
                    }
                } else {
                    Controller_Template::$profil->index();
                }
            } else if ($_GET['action'] == 'gestionManga') {
                if (isset($_SESSION['type'])) {
                    if ($_SESSION['type'] <= 2) {
                        $controller = Controller_Administration::getInstance('Administration');
                        if (isset($_GET['idmanga'])) {
                            if (!empty($_GET['idmanga'])) {
                                $controller->gestionManga();
                            } else {
                                $controller->displayAdmin();
                            }
                        } else {
                            $controller->displayAdmin();
                        }
                    } else {
                        Controller_Template::$profil->index();
                    }
                } else {
                    Controller_Template::$profil->index();
                }
            } else if ($_GET['action'] == 'setManga') {
                if (isset($_SESSION['type'])) {
                    if ($_SESSION['type'] <= 2) {
                        $controller = Controller_Administration::getInstance('Administration');
                        if (isset($_POST['idmanga'])) {
                            if (!empty($_POST['idmanga'])) {
                                $controller->setManga();
                            } else {
                                $controller->displayAdmin();
                            }
                        } else {
                            $controller->displayAdmin();
                        }
                    } else {
                        Controller_Template::$profil->index();
                    }
                } else {
                    Controller_Template::$profil->index();
                }
            } else {
                Controller_Template::$profil->index();
            }
        } else {
            Controller_Template::$profil->index();
        }
    } else if ($_GET['module'] == 'Ami') {
        if (!empty($_SESSION)) {
            if (isset($_GET['action'])) {
                if ($_GET['action'] == 'listeAmi') {
                    $controller = Controller_Ami::getInstance('Ami');
                    $controller->listeAmi();
                } else if ($_GET['action'] == 'pagePerso') {
                    if (isset($_GET['pseudo'])) {
                        if (!empty($_GET['pseudo'])) {
                            $controller = Controller_Ami::getInstance('Ami');
                            $controller->pagePerso();
                        } else {
                            Controller_Template::$profil->index();
                        }
                    } else {
                        Controller_Template::$profil->index();
                    }
                } else if ($_GET['action'] == 'demandeAmi') {
                    if (isset($_GET['ami'])) {
                        if (!empty($_GET['ami'])) {
                            $controller = Controller_Ami::getInstance('Ami');
                            $controller->demandeAmi();
                        } else {
                            Controller_Template::$profil->index();
                        }
                    } else {
                        Controller_Template::$profil->index();
                    }
                } else if ($_GET['action'] == 'ajoutAmi') {
                    if (isset($_GET['ami'])) {
                        if (!empty($_GET['ami'])) {
                            $controller = Controller_Ami::getInstance('Ami');
                            $controller->ajoutAmi();
                        } else {
                            Controller_Template::$profil->index();
                        }
                    } else {
                        Controller_Template::$profil->index();
                    }
                } else if ($_GET['action'] == 'suppAmi') {
                    if (isset($_GET['ami'])) {
                        if (!empty($_GET['ami'])) {
                            $controller = Controller_Ami::getInstance('Ami');
                            $controller->suppAmi();
                        } else {
                            Controller_Template::$profil->index();
                        }
                    } else {
                        Controller_Template::$profil->index();
                    }
                } else {
                    Controller_Template::$profil->index();
                }
            } else {
                Controller_Template::$profil->index();
            }
        } else {
            Controller_Template::$profil->index();
        }
    } else if ($_GET['module'] == 'Message') {
        if (!empty($_SESSION)) {
            if (isset($_GET['action'])) {
                if ($_GET['action'] == 'listeMessage') {
                    $controller = Controller_Message::getInstance('Message');
                    $controller->listeMessage();
                } else if ($_GET['action'] == 'filMp') {
                    if (isset($_GET['ami'])) {
                        if (!empty($_GET['ami'])) {
                            $controller = Controller_Message::getInstance('Message');
                            $controller->filMp();
                        } else {
                            Controller_Template::$profil->index();
                        }
                    } else {
                        Controller_Template::$profil->index();
                    }
                } else if ($_GET['action'] == 'formMp') {
                    if (isset($_GET['ami'])) {
                        if (!empty($_GET['ami'])) {
                            $controller = Controller_Message::getInstance('Message');
                            $controller->formMp();
                        } else {
                            Controller_Template::$profil->index();
                        }
                    } else {
                        Controller_Template::$profil->index();
                    }
                } else if ($_GET['action'] == 'envoiMp') {
                    if (isset($_POST)) {
                        $controller = Controller_Message::getInstance('Message');
                        $controller->envoiMp();
                    } else {
                        Controller_Template::$profil->index();
                    }
                } else if ($_GET['action'] == 'rafraichir') {
                    $controller = Controller_Message::getInstance('Message');
                    $controller->rafraichirMp();
                } else if ($_GET['action'] == 'suppUnMessage') {
                    if (isset($_GET['mp'])) {
                        if (!empty($_GET['mp'])) {
                            $controller = Controller_Message::getInstance('Message');
                            $controller->suppUnMessage();
                        } else {
                            Controller_Template::$profil->index();
                        }
                    } else {
                        Controller_Template::$profil->index();
                    }
                } else if ($_GET['action'] == 'suppAllMessages') {
                    if (isset($_GET['allMp'])) {
                        if (!empty($_GET['allMp'])) {
                            $controller = Controller_Message::getInstance('Message');
                            $controller->suppAllMessages();
                        } else {
                            Controller_Template::$profil->index();
                        }
                    } else {
                        Controller_Template::$profil->index();
                    }
                } else {
                    Controller_Template::$profil->index();
                }
            } else {
                Controller_Template::$profil->index();
            }
        } else {
            Controller_Template::$profil->index();
        }
    } else {
        Controller_Template::$profil->index();
    }
} else {
    Controller_Template::$profil->index();
}
?>
