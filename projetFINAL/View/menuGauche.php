<div class="container-fluid centre">
    <div class="span2">
        <?php
        if (!empty($_SESSION)) {
            ?>

            <div class="well sidebar-nav">
                <?php
                echo '<h4>Salut ' . $_SESSION['pseudo'] . ' !</h4>';
                ?>
                <p><a data-toggle="modal" href="#avatar"><img src="avatar/<?php echo $avatarStatut[0]['avatar']; ?>"></a></p>


                <p>--------- INFOS ---------</p>
                <?php
                $nbAmi = count($demandeAmi);
                if ($nbAmi == 0) {
                    echo '<h5>' . $nbAmi . ' nouvelle demande d\'ami</h5>';
                } else {
                    echo '<a data-toggle="modal" href="#ami" ><h5>' . $nbAmi . ' nouvelle demande d\'ami</h5></a>';
                }

                $nbMess = count($messNonLu);
                if ($nbMess == 0) {
                    echo '<h5>' . $nbMess . ' nouveau message</h5>';
                } else {
                    echo '<a data-toggle="modal" href="#mp" ><h5>' . $nbMess . ' nouveau message</h5></a>';
                }
                ?>
                <?php
                if (empty($avatarStatut[0]['statut'])) {
                    echo '<blockquote><p>Pas de statut ...</p></blockquote>';
                    echo '<a data-toggle="modal" href="#statut" >Ecrire un statut</a>';
                } else {
                    echo '<blockquote><p>' . html($avatarStatut[0]['statut']) . '</p></blockquote>';
                    echo '<a data-toggle="modal" href="#statut" >Mettre à jour son statut</a>';
                }
                ?>	
            </div><!--/.well -->

            <?php
        } else {
            ?>
            <div class="well sidebar-nav">
                <h4>Bienvenue !</h4>
                <p>Rejoignez notre super communauté !</p>
                <p>Vous allez enfin pouvoir voir les différences entre un manga et un anime du même nom, mais 
                    "Crazy Manga" c'est aussi une communauté social plein de bonne humeur !</p> 
                <p><a data-toggle="modal" href="#connexion">Déja inscrit ?</a></p>
                <p><a data-toggle="modal" href="#inscription">Pas inscrit ?</a></p>    	
            </div><!--/.well -->
            <?php
        }
        ?>

        <div class="well sidebar-nav">
            <ul class="nav nav-list">
                <li class="nav-header">Anime/Mangas</li>
                <?php
                for ($i = 65; $i <= 90; $i++) {
                    echo '<li ';
                    if (!empty($_GET)) {
                        if ($_GET['char'] == chr($i)) {
                            echo 'class="active" ';
                        }
                    }
                    echo '><a href="./index.php?module=Fiche&action=displayListe&char=' . chr($i) . '">Fiche en ' . chr($i) . '</a></li>';
                }
                ?>             	
            </ul>
        </div><!--/.well -->
    </div><!--/span-->


    <div class="modal hide" id="statut">
        <div class="modal-header"> <a class="close" data-dismiss="modal">×</a>
            <h2>Changer profil</h2>
        </div>
        <div class="modal-body">
            <div class="formulaire">

                <form class="form-horizontal" method="post" action="index.php?module=Profil&action=setStatut">
                    <div class="control-group">
                        <label class="control-label">Statut</label>
                        <div class="controls">
                            <textarea id="statut" placeholder="Statut" name="statut"></textarea>
                        </div>
                    </div>

                    <div class="control-group">
                        <div class="controls">
                            <button type="submit" class="btn">Mettre à jour</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
        <div class="modal-footer"> <a class="btn btn-info" data-dismiss="modal">Fermer</a> </div>
    </div>

    <!-- POPUP (MODAL) CHANGEMENT AVATAR-->
    <div class="modal hide" id="avatar">
        <div class="modal-header"> <a class="close" data-dismiss="modal">×</a>
            <h2>Changer d'avatar</h2>
        </div>
        <div class="modal-body">
            <div class="formulaire">

                <form class="form-horizontal" method="post" action="index.php?module=Profil&action=setAvatar" enctype="multipart/form-data">
                    <div class="control-group">
                        <label class="control-label">Avatar</label>
                        <div class="controls">
                            <input class="nonNull" id="avatar" name="avatar" type="file">
                        </div>
                        <p class="offset1">(Extension Valide : jpg,jpeg,png,gif | Taille maximal : 1Mo)</p>
                    </div>

                    <div class="control-group">
                        <div class="controls">
                            <button type="submit" class="btn">Mettre à jour</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
        <div class="modal-footer"> <a class="btn btn-info" data-dismiss="modal">Fermer</a> </div>
    </div>
    <!-- POPUP (MODAL) DEMANDE D'AMI-->
    <div class="modal hide" id="ami">
        <div class="modal-header"> <a class="close" data-dismiss="modal">×</a>
            <h2>Demande(s) d'Ami(s)</h2>
        </div>
        <div class="modal-body">
            <?php
            for ($i = 0; $i < $nbAmi; $i++) {
                ?>
                <div class="featurette container-fluid">
                    <a href="index.php?module=Ami&action=pagePerso&pseudo=<?php echo html($demandeAmi[$i]['pseudo']); ?>"><img class="featurette-image pull-left span2 img-polaroid" src="avatar/<?php echo $demandeAmi[$i]['avatar']; ?>" height="100" width="100"></a>
                    <h3 class="featurette-heading offset2"><span class="muted"><?php echo html($demandeAmi[$i]['pseudo']); ?></span> vous demande en ami</h3>
                </div>
                <a href="index.php?module=Ami&action=ajoutAmi&ami=<?php echo html($demandeAmi[$i]['pseudo']); ?>" role="button" class="btn offset2">Accepter <?php echo html($demandeAmi[$i]['pseudo']); ?> </a>
                <a href="index.php?module=Ami&action=suppAmi&ami=<?php echo html($demandeAmi[$i]['pseudo']); ?>" role="button" class="btn">Refuser <?php echo html($demandeAmi[$i]['pseudo']); ?> </a>
                <hr class="featurette-divider">
                <?php
            }
            ?>
        </div>
        <div class="modal-footer"> <a class="btn btn-info" data-dismiss="modal">Fermer</a> </div>
    </div>			

    <!-- POPUP (MODAL) NOUVEAU MP-->
    <div class="modal hide" id="mp">
        <div class="modal-header"> <a class="close" data-dismiss="modal">×</a>
            <h2>Nouveau message privé</h2>
        </div>
        <div class="modal-body">
            <?php
            for ($i = 0; $i < $nbMess; $i++) {
                ?>
                <div class="featurette container-fluid">
                    <a href="index.php?module=Ami&action=pagePerso&pseudo=<?php echo $messNonLu[$i]['pseudo']; ?>"><img class="featurette-image pull-left span2 img-polaroid" src="avatar/<?php echo $messNonLu[$i]['avatar']; ?>" height="100" width="100"></a>
                    <h3 class="featurette-heading offset2">Message privé de <span class="muted"><?php echo html($messNonLu[$i]['pseudo']); ?></span></h3>
                    <p class="lead offset2" id="paragraphe"><?php echo html($messNonLu[$i]['message']); ?></p>
                </div>
                <hr class="featurette-divider">
                <?php
            }
            ?>
        </div>
        <div class="modal-footer"> <a class="btn btn-info" href="index.php?module=Message&action=rafraichir">Mettre à jour</a> </div>
    </div>
    <div class="contenu row-fluid span10">
