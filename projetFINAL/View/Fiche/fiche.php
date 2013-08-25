<!-- CODE DES ETOILES REPRIS SUR : http://www.creativejuiz.fr/blog/tutoriels/systeme-notation-quelques-lignes-css -->
<?php if (!empty($_SESSION)) { ?>
    <div class="note">
        <?php
        if (count($note) == 0) {
            ?>
            <div class="rating pull-left"><!--
                --><a href="index.php?module=Fiche&action=setNote&idanime=<?php echo $idanime; ?>&idmanga=<?php echo $idmanga; ?>&note=5" title="5">★</a><!-- 
                --><a href="index.php?module=Fiche&action=setNote&idanime=<?php echo $idanime; ?>&idmanga=<?php echo $idmanga; ?>&note=4" title="4">★</a><!-- 
                --><a href="index.php?module=Fiche&action=setNote&idanime=<?php echo $idanime; ?>&idmanga=<?php echo $idmanga; ?>&note=3" title="3">★</a><!-- 
                --><a href="index.php?module=Fiche&action=setNote&idanime=<?php echo $idanime; ?>&idmanga=<?php echo $idmanga; ?>&note=2" title="2">★</a><!-- 
                --><a href="index.php?module=Fiche&action=setNote&idanime=<?php echo $idanime; ?>&idmanga=<?php echo $idmanga; ?>&note=1" title="1">★</a>  
            </div>
            <?php
        } else {
            echo '<div class="voteok pull-left">';
            if ($note[0]['note'] == 1) {
                echo '★';
            } else if ($note[0]['note'] == 2) {
                echo '★★';
            } else if ($note[0]['note'] == 3) {
                echo '★★★';
            } else if ($note[0]['note'] == 4) {
                echo '★★★★';
            } else if ($note[0]['note'] == 5) {
                echo '★★★★★';
            }
            echo '<a href="index.php?module=Fiche&action=delNote&idanime=' . $idanime . '&idmanga=' . $idmanga . '" class="enlevervote">enlever vote</a>';
            echo '</div>';
        }
        ?>

        <div class="pull-right">
            <?php
            if (count($aime) == 0) {
                ?>
                <a href="index.php?module=Fiche&action=setAime&idanime=<?php echo $idanime; ?>&idmanga=<?php echo $idmanga; ?>" role="button" class="btn btn-primary"><i class="icon-heart"></i> J'aime</a>
                <?php
            } else {
                ?>
                <a href="index.php?module=Fiche&action=delAime&idanime=<?php echo $idanime; ?>&idmanga=<?php echo $idmanga; ?>" role="button" class="btn btn-primary"><i class="icon-heart"></i> Ne plus aimer</a>
                <?php
            }

            if ($_SESSION['type'] <= 2) {
                ?>	
                <a href="index.php?module=Administration&action=gestionFiche&idmanga=<?php echo $idmanga; ?>&idanime=<?php echo $idanime; ?>" role="button" class="btn"><i class="icon-pencil"></i> Editer la fiche</a>
                <a href="index.php?module=Administration&action=suppFiche&idmanga=<?php echo $idmanga; ?>&idanime=<?php echo $idanime; ?>" role="button" class="btn"><i class="icon-remove"></i> Supprimer la fiche</a>
                <?php
            }
            ?>
        </div>

    </div>

    <hr class="featurette-divider">

    <?php
}
if ($idmanga != 0 && $idanime != 0) {
    ?>
    <div class="row-fluid">
        <div class="span6">
            <?php require 'manga.php'; ?>
        </div>
        <div class="span6">
            <?php require 'anime.php'; ?>
        </div>
    </div>
    <div class="contenu">
        <div class="row-fluid">
            <div class="span6">
                <div class="well">
                    <h4>Comparaison des histoires</h4>
                    <div class="offset1">
                        <?php
                        if (!empty($fiche[0]['storycompar'])) {
                            echo html($fiche[0]['storycompar']);
                        } else {
                            echo 'La comparaison reste à faire...';
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="span6">
                <div class="well">
                    <h4>Comparaison des dessins</h4>
                    <div class="offset1">
                        <?php
                        if (!empty($fiche[0]['artcompar'])) {
                            echo html($fiche[0]['artcompar']);
                        } else {
                            echo 'La comparaison reste à faire...';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
} else {
    if ($idanime != 0) {
        require 'anime.php';
    } else if ($idmanga != 0) {
        require 'manga.php';
    }
}
require 'commentaire.php';
?>
