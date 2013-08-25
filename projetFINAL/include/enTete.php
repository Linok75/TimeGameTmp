<script src="scripts/entete.js"></script>
<!-- MENU CONNEXION -->
<div class="modal hide" id="connexion">
    <div class="modal-header"> <a class="close" data-dismiss="modal">×</a>
        <h2>Connexion</h2>
    </div>
    <div class="modal-body">
        <div class="formulaire">
            <form class="form-horizontal" method="post" action="index.php?module=Utilisateur&action=connexion">
                <div class="control-group">
                    <label class="control-label">Pseudo</label>
                    <div class="controls">
                        <input type="text" id="pseudo" placeholder="Pseudo" name="pseudo"/>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Mot de Passe</label>
                    <div class="controls">
                        <input type="password" id="pass" placeholder="Mot de Passe" name="mdp"/>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn">Connexion</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal-footer"> <a class="btn btn-info" data-dismiss="modal">Fermer</a> </div>
</div>

<!-- MENU INSCRIPTION -->
<div class="modal hide" id="inscription">
    <div class="modal-header"> <a class="close" data-dismiss="modal">×</a>
        <h2>Inscription</h2>
    </div>
    <div class="modal-body">
        <div class="formulaire">
            <form class="form-horizontal" method="post" action="index.php?module=Utilisateur&action=inscription">
                <div class="control-group">
                    <label class="control-label">Pseudo</label>
                    <div class="controls">
                        <input type="text" id="pseudo" placeholder="Pseudo" name="pseudo"/>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Mot de Passe</label>
                    <div class="controls">
                        <input type="password" id="pass" placeholder="Mot de Passe" name="mdp"/>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Nom</label>
                    <div class="controls">
                        <input type="text" id="nom" placeholder="Nom" name="nom"/>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Prénom</label>
                    <div class="controls">
                        <input type="text" id="prenom" placeholder="Prénom" name="prenom"/>
                    </div>
                </div>	

                <div class="control-group">
                    <label class="control-label">Adresse e-mail</label>
                    <div class="controls">
                        <input type="email" id="mail" placeholder="Adresse e-mail" name="mail"/>
                    </div>
                </div>


                <div class="control-group">
                    <label class="control-label" >Date de naissance</label>
                    <div class="controls">
                        <?php
                        echo '<select class="span1" name="jour">';
                        for ($i = 1; $i <= 31; $i++) {
                            echo '<option value="' . $i . '">' . $i . '</option>';
                        }
                        echo '</select>';
                        ?>


                        <?php
                        echo '<select class="span1" name="mois">';
                        for ($i = 1; $i <= 12; $i++) {
                            echo '<option value="' . $i . '">' . $i . '</option>';
                        }
                        echo '</select>';
                        ?>

                        <?php
                        echo '<select class="span1" name="annee">';
                        for ($i = (date('Y') - 18); $i >= (date('Y') - 99); $i--) {
                            echo '<option value="' . $i . '">' . $i . '</option>';
                        }
                        echo '</select>';
                        ?>
                    </div>			
                </div>
                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn">Inscription</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal-footer"> <a class="btn btn-info" data-dismiss="modal">Fermer</a> </div>
</div>


<div class="row-fluid">
    <div class="row-fluid">
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <ul class="nav">
                    <li><a href="index.php">CRAZY MANGA</a></li>
                    <li><a href="index.php?module=Fiche&action=displayTop50">Top 50</a></li>
                    <?php
                    if (isset($_SESSION['id']) AND isset($_SESSION['pseudo'])) {
                        ?>
                        <li><a href="index.php?module=Profil&action=displayProfil">Profil</a></li>
                        <li><a href="index.php?module=Ami&action=listeAmi">Amis</a></li>
                        <li><a href="index.php?module=Message&action=listeMessage">Messages</a></li>
                        <?php if ($_SESSION['type'] <= 2) { ?>
                            <li><a href="index.php?module=Fiche&action=newFiche">Nouvelle Fiche</a></li>
                            <li><a href="index.php?module=Administration&action=displayAdmin">Administration</a></li>
                        <?php } ?>
                    </ul>

                    <div class="navbar-form pull-right">
                        <ul class="offset1 nav">
                            <li><a href="index.php?module=Utilisateur&action=deconnexion">Deconnexion</a></li>
                        </ul>
                    </div>
                <?php } else { ?>
                    </ul>

                    <div class="navbar-form pull-right">
                        <ul class="nav">
                            <li><a data-toggle="modal" href="#connexion" >Connexion</a></li>
                            <li><a data-toggle="modal" href="#inscription" >Inscription</a></li>
                        </ul>
                    </div>
                <?php } ?>
                <!-- BARRE DE RECHERCHE -->
                <div class="navbar-form pull-right">
                    <ul class="nav">
                        <li>
                            <form class="navbar-form form-search" method="POST" action="index.php?module=Fiche&action=recherche">
                                <div class="input-append">
                                    <input type="text" name="search" class="span5 search-query" placeholder="recherche..." value="">
                                    <button type="submit" class="btn">Search</button>
                                    <?php if (!empty($_SESSION)) { ?><label class="control-label">&nbsp;Fiche&nbsp;</label><input checked="checked" class="checkbox" name="type" type="radio" value="fiche" />
                                        <label class="control-label">&nbsp;Amis&nbsp;</label><input name="type" class="checkbox" type="radio" value="amis" /><?php } ?>
                                </div>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <header class="jumbotron subhead" id="overview">
            <div id="myCarousel" class="carousel slide">
                <!-- Carousel items -->
                <div class="carousel-inner">                
                    <div class="active item"><img src="images/1.jpg" /></div>
                    <div class="item"><img src="images/2.jpg" /></div>
                    <div class="item"><img src="images/3.jpg" /></div>
                    <div class="item"><img src="images/4.jpg" /></div>
                    <div class="item"><img src="images/5.jpg" /></div>
                </div>
                <!-- Carousel nav -->
                <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
                <a id="next" class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
            </div>
        </header>	
    </div>
