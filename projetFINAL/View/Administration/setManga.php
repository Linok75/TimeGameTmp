<script src="scripts/nouvelleFiche.js"></script>
<h2>Mise à jour Manga</h2>
<form class="span7 offset2 form-horizontal" name="manga" method="POST" enctype="multipart/form-data" action="index.php?module=Administration&action=setManga">
    <div id="anime">
        <input type="hidden" name="idmanga" value="<?php echo $idmanga; ?>">
        <div class="control-group">
            <label class="control-label" for="titre">Titre*</label><div class="controls"><input class="test nonNull"   id="titre" name="titre" type="text" value="<?php
if (isset($valide['titre'])) {
    echo $valide['titre'];
} else {
    echo html($manga[0]['titre']);
}
?>"></div>
            <span class="help-block err"><?php if (isset($erreur['titre'])) echo $erreur['titre']; ?></span>
        </div>
        <div class="control-group">
            <label class="control-label" for="titreAlt">Titre alternatif</label><div class="controls"><input id="titreAlt" name="titreAlt" type="text" value="<?php
                                                                                                if (isset($valide['alt'])) {
                                                                                                    echo $valide['alt'];
                                                                                                } else {
                                                                                                    echo html($manga[0]['titreAlt']);
                                                                                                }
?>"></div>
        </div>
        <div class="control-group">
            <label class="control-label" for="genre">Genre*</label>
            <div class="controls"><select class="nonNull"   id="genre" name="genre[]" multiple="multiple">
                    <?php
                    $i = 0;

                    for ($j = 0, $size = count($allGenre); $j < $size; ++$j) {
                        echo '<option value="' . $allGenre[$j]['idgenre'] . '"';
                        if (isset($valide['genre'])) {
                            if ($valide['genre'][$i] == $allGenre[$j]['idgenre']) {
                                echo ' selected="selected"';
                                $i++;
                            }
                        } else if (html($mangaGenre[$i]['genre']) == html($allGenre[$j]['genre'])) {
                            echo ' selected="selected"';
                            $i++;
                        }
                        echo '>' . html($allGenre[$j]['genre']) . '</option>';
                    }
                    ?>
                </select></div>
            <span class="help-block"><?php if (isset($erreur['genre'])) echo $erreur['genre']; ?></span>
        </div>
        <div class="control-group">
            <label class="control-label" for="auteur">Auteur*</label><div class="controls"><input class="nonNull"   id="auteur" name="auteur" type="text" value="<?php
                    if (isset($valide['auteur'])) {
                        echo $valide['auteur'];
                    } else {
                        echo html($manga[0]['auteur']);
                    }
                    ?>"></div>
            <span class="help-block"><?php if (isset($erreur['auteur'])) echo $erreur['auteur']; ?></span>
        </div>
        <div class="control-group">
            <label class="control-label" for="diffusion">Année de parution*</label><div class="controls"><input class="test nonNull"   id="diffusion" name="diffusion" type="text" value="<?php
                                                                                                            if (isset($valide['diffusion'])) {
                                                                                                                echo $valide['diffusion'];
                                                                                                            } else {
                                                                                                                echo $manga[0]['anneeparution'];
                                                                                                            }
                    ?>"></div>
            <span class="help-block err"><?php if (isset($erreur['diffusion'])) echo $erreur['diffusion']; ?></span>
        </div>
        <div class="control-group">
            <label class="control-label" for="studio">Éditeur d'origine*</label><div class="controls"><input class="nonNull"   id="studio" name="studio" type="text" value="<?php
                                                                                                                 if (isset($valide['studio'])) {
                                                                                                                     echo $valide['studio'];
                                                                                                                 } else {
                                                                                                                     echo html($manga[0]['editeurori']);
                                                                                                                 }
                    ?>"></div>
            <span class="help-block"><?php if (isset($erreur['studio'])) echo $erreur['studio']; ?></span>
        </div>
        <div class="control-group">
            <label class="control-label" for="lastEp">Dernier chapitre*</label><div class="controls"><input class="test nonNull"   id="lastEp" name="lastEp" type="text" value="<?php
                                                                                                            if (isset($valide['lastEp'])) {
                                                                                                                echo $valide['lastEp'];
                                                                                                            } else {
                                                                                                                echo $manga[0]['dernierchap'];
                                                                                                            }
                    ?>"></div>
            <span class="help-block err"><?php if (isset($erreur['lastEp'])) echo $erreur['lastEp']; ?></span>
        </div>
        <div class="control-group">
            <label class="control-label" for="statut">Statut*</label>
            <div class="controls"><select id="statut" name="statut">
                    <?php
                    for ($i = 0, $size = count($allStatut); $i < $size; ++$i) {
                        echo '<option value="' . $allStatut[$i]['idstatut'] . '"';
                        if (isset($valide['statut'])) {
                            if ($valide['statut'] == $allStatut[$i]['idstatut']) {
                                echo ' selected="selected"';
                            }
                        } else if ($manga[0]['statut'] == $allStatut[$i]['idstatut']) {
                            echo ' selected="selected"';
                        }
                        echo '>' . html($allStatut[$i]['statut']) . '</option>';
                    }
                    ?>
                </select></div>
        </div>
        <div class="control-group">
            <label class="control-label" for="illustration">Couverture*</label><div class="controls"><input class="nonNull"   id="illustration" name="illustration" type="file" value="<?php
                    if (isset($valide['illustration'])) {
                        echo $valide['illustration'];
                    } else {
                        echo $manga[0]['couverture'];
                    }
                    ?>"></div>
            <span class="help-block"><?php if (isset($erreur['illustration'])) echo $erreur['illustration'] . '<br/>'; ?>(Extension Valide : jpg,jpeg,png,gif | Taille maximal : 1Mo)</span>
        </div>
        <div class="control-group">
            <label class="control-label" for="synopsis">Résumé*</label><div class="controls"><textarea class="nonNull"   id="synopsis" name="synopsis"><?php
                                                                                                              if (isset($valide['synopsis'])) {
                                                                                                                  echo $valide['synopsis'];
                                                                                                              } else {
                                                                                                                  echo html($manga[0]['synopsis']);
                                                                                                              }
                    ?></textarea></div>
            <span class="help-block"><?php if (isset($erreur['synopsis'])) echo $erreur['synopsis']; ?></span>
        </div>
    </div>
    <input class="btn btn-success btn-block" id="next" type="submit" value="Update" name="Update" >
</form>

