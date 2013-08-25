<div class="contenu">
    <?php
    echo'<div class="well">';
    echo "<h3>Commentaire</h3>";
    if (!empty($_SESSION)) {
        ?>	
        <form class="offset3" action="index.php?module=Fiche&action=addCom" method="post">
            <input type="hidden" name="idAnime" value="<?php echo $idanime; ?>">
            <input type="hidden" name="idManga" value="<?php echo $idmanga; ?>">
            <p><label for="message">Votre message:</label>
                <textarea class="span8" name="message" id="message"></textarea></p>
            <p><button class="btn btn-large btn-primary" type="submit">Envoyer</button></p>
        </form>
    <?php } ?>
    </div>

    <?php

if (isset($coms)) {
    for ($i = 0, $size = count($coms); $i < $size; $i++) {

        if (empty($coms[$i]['pseudo'])) {
            $coms[$i]['pseudo'] = '"compte supprimé"';
            $coms[$i]['avatar'] = 'defaut.png';
        }

        echo '<hr class="featurette-divider">
      				<div class="featurette container-fluid">
        				<a href="index.php?module=Ami&action=pagePerso&pseudo=' . html($coms[$i]['pseudo']) . '"><img class="featurette-image pull-left span1 img-polaroid" src="avatar/' . $coms[$i]['avatar'] . '" height="100" width="100"></a>';
        if (!empty($_SESSION)) {
            if ($coms[$i]['pseudo'] == $_SESSION['pseudo'] || $_SESSION['type'] <= 2) {
                echo '<a href="index.php?module=Fiche&action=suppCom&idcom=' . $coms[$i]['idcom'] . '"><i class="icon-remove pull-right"></i></a>';
            }
        }

        echo '<h3 class="featurette-heading offset1">' . html($coms[$i]['pseudo']) . ' - ' . '<span class="muted">' . date("d/m/Y H:i:s", strtotime($coms[$i]['datepost'])) . '</span></h3>
        				<p class="lead offset1" id="paragraphe">' . html($coms[$i]['texte']) . '</p>
        			</div>';
    }
}
?>

</div>
