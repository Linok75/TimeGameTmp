<div class="page-header"><h1>Profil de <?php echo html($utilisateur[0]['pseudo']); ?></h1></div>
<div class="row-fluid">
    <form class="form-horizontal span7" method="post" action="index.php?module=Administration&action=editerProfil">
        <input type="hidden" name="iduser" value="<?php echo $_GET['iduser']; ?>">
        <div class="control-group">
            <label class="control-label">Civilité</label>
            <div class="controls">
                <label class="radio inline"><input type="radio" name="civilite" id="civilite" value="1" <?php
if ($profil[0]['civilite'] == 1) {
    echo 'checked';
}
?>/>Mr</label>
                <label class="radio inline"><input type="radio" name="civilite" id="civilite" value="2" <?php
                                                   if ($profil[0]['civilite'] == 2) {
                                                       echo 'checked';
                                                   }
?>/>Mme</label>
                <label class="radio inline"><input type="radio" name="civilite" id="civilite" value="3" <?php
                                                   if ($profil[0]['civilite'] == 3) {
                                                       echo 'checked';
                                                   }
?>/>Mlle</label>  
            </div>     	     	    
        </div>

        <div class="control-group">
            <label class="control-label">Nom</label>
            <div class="controls">
                <input type="text" id="nom" placeholder="Nom" name="nom" value="<?php echo html($utilisateur[0]['nom']); ?>"/>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Prenom</label>
            <div class="controls">
                <input type="text" id="prenom" placeholder="Prenom" name="prenom" value="<?php echo html($utilisateur[0]['prenom']); ?>"/>
            </div>
        </div>                 

        <div class="control-group">
            <label class="control-label">E-mail</label>
            <div class="controls">
                <input type="email" id="mail" placeholder="E-mail" name="mail" value="<?php echo html($utilisateur[0]['mail']); ?>"/>
            </div>
        </div>

        <div class="control-group">
            <label  class="control-label" for="noAvat">Cochez la case pour réinitialiser l'avatar. </label><div class="controls"><input id="noManga" type="checkbox" name="noAvat" value="noAvat" ></div>
        </div>


        <div class="control-group">
            <label class="control-label">Statut</label>
            <div class="controls">
                <textarea id="statut" placeholder="Statut" name="statut"><?php echo html($profil[0]['statut']); ?></textarea>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" >Date de naissance</label>
            <div class="controls">
                <?php
                echo '<select class="span3" name="jour">';
                for ($i = 1; $i <= 31; $i++) {
                    if ($i == $explodeDate[2]) {
                        echo '<option selected value="' . $i . '">' . $i . '</option>';
                    } else {
                        echo '<option value="' . $i . '">' . $i . '</option>';
                    }
                }
                echo '</select>';
                ?>

                <?php
                echo '<select class="span3" name="mois">';
                for ($i = 1; $i <= 12; $i++) {
                    if ($i == $explodeDate[1]) {
                        echo '<option selected value="' . $i . '">' . $i . '</option>';
                    } else {
                        echo '<option value="' . $i . '">' . $i . '</option>';
                    }
                }
                echo '</select>';
                ?>

                <?php
                echo '<select class="span3" name="annee">';
                for ($i = (date('Y') - 18); $i >= (date('Y') - 99); $i--) {
                    if ($i == $explodeDate[0]) {
                        echo '<option selected value="' . $i . '">' . $i . '</option>';
                    } else {
                        echo '<option value="' . $i . '">' . $i . '</option>';
                    }
                }
                echo '</select>';
                ?>
            </div>			
        </div>

        <div class="control-group">
            <label class="control-label">Description</label>
            <div class="controls">
                <textarea rows="3" id="description" name="description" placeholder="Description"><?php echo html($profil[0]['description']); ?></textarea>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Anime favoris</label>
            <div class="controls">
                <select id="animeFav" name="animeFav" >
                    <?php
                    for ($i = 0, $size = count($allAnime); $i < $size; $i++) {
                        if (html($allAnime[$i]['titre']) == html($anime[0]['titre'])) {
                            echo '<option selected values="' . $allAnime[$i]['idanime'] . '">' . html($allAnime[$i]['titre']) . '</option>';
                        } else {
                            echo '<option values="' . $allAnime[$i]['idanime'] . '">' . html($allAnime[$i]['titre']) . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Manga favoris</label>
            <div class="controls">
                <select id="manga" name="manga" >
                    <?php
                    for ($i = 0, $size = count($allManga); $i < $size; $i++) {
                        if (html($allManga[$i]['titre']) == html($manga[0]['titre'])) {
                            echo '<option selected values="' . $allManga[$i]['idmanga'] . '">' . html($allManga[$i]['titre']) . '</option>';
                        } else {
                            echo '<option values="' . $allManga[$i]['idmanga'] . '">' . html($allManga[$i]['titre']) . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Genre favoris</label>
            <div class="controls">
                <select id="genre" name="genre" >
                    <?php
                    for ($i = 0, $size = count($allGenre); $i < $size; $i++) {
                        if (html($allGenre[$i]['genre']) == html($genre[0]['genre'])) {
                            echo '<option selected values="' . $allGenre[$i]['idgenre'] . '">' . html($allGenre[$i]['genre']) . '</option>';
                        } else {
                            echo '<option values="' . $allGenre[$i]['idgenre'] . '">' . html($allGenre[$i]['genre']) . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Type d'utilisateur</label>
            <div class="controls">
                <select id="idtype" name="idtype" >
                    <?php
                    for ($i = 0, $size = count($allType); $i < $size; $i++) {
                        if ($allType[$i]['idtype'] == $utilisateur[0]['idtype']) {
                            echo '<option selected value="' . $allType[$i]['idtype'] . '">' . html($allType[$i]['type']) . '</option>';
                        } else {
                            echo '<option value="' . $allType[$i]['idtype'] . '">' . html($allType[$i]['type']) . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <button type="submit" class="btn">Mettre à jour</button>
            </div>
        </div>
    </form>
    <div class="span4 contenuVAM">
        <img class="featurette-image span12 img-polaroid" src="avatar/<?php echo html($profil[0]['avatar']); ?>">
    </div>
</div>