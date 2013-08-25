<?php if (isset($_GET['char'])) { ?><h2>Liste des fiches en <?php echo $_GET['char']; ?></h2><?php } else {
    echo '<h2>Résultat pour '.$_POST['search'].'</h2>';
} 

if(!empty($manga)){ ?>

<div class="row-fluid">
<?php if(empty($anime)){ ?>
	<div class="span12">
<?php }else{ ?>
    <div class="span6">
<?php } ?>
        <table class="liste">
            <caption>MANGA</caption>
            <thead>
                <tr>
                    <th>Titre Manga</th>
                    <th>Dernier Chapitre</th>
                    <th>Statut</th>
                    <th>Auteur</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $color = true;
                for ($i = 0, $size = count($manga); $i < $size; ++$i) {
                    echo '<tr ';
                    if ($color) {
                        echo 'class="ligne lignecolor"';
                        $color = false;
                    } else {
                        echo 'class="ligne"';
                        $color = true;
                    }
                    echo ' onclick="window.location.href=\'./index.php?module=Fiche&action=displayFiche&idmanga=' . $manga[$i]['idmanga'] . '\'">';
                    echo '<td>' . html($manga[$i]['titre']) . '</td><td>' . html($manga[$i]['dernierchap']) . '</td><td>' . html($manga[$i]['statut']) . '</td><td>' . html($manga[$i]['auteur']) . '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php 
		}
		if(!empty($anime)){ 
	?>
	<?php if(empty($manga)){ ?>
		<div class="span12">
	<?php }else{ ?>
		<div class="span6">
	<?php } ?>
        <table class="liste">
            <caption>ANIME</caption>
            <thead>
                <tr>
                    <th>Titre Anime</th>
                    <th>Dernier &Eacute;pisode</th>
                    <th>Statut</th>
                    <th>Auteur</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $color = true;
                for ($i = 0, $size = count($anime); $i < $size; ++$i) {
                    echo '<tr ';
                    if ($color) {
                        echo 'class="ligne lignecolor"';
                        $color = false;
                    } else {
                        echo 'class="ligne"';
                        $color = true;
                    }
                    echo ' onclick="window.location.href=\'./index.php?module=Fiche&action=displayFiche&idanime=' . $anime[$i]['idanime'] . '\'">';
                    echo '<td>' . html($anime[$i]['titre']) . '</td><td>' . html($anime[$i]['lastEp']) . '</td><td>' . html($anime[$i]['statut']) . '</td><td>' . html($anime[$i]['auteur']) . '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
        <?php }
        if(empty($manga) && empty($anime)){
			echo 'Aucune fiche trouvé !';
		}?>
    </div>
</div>	
