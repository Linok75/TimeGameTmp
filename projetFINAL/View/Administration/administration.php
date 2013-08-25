<script src="scripts/administration.js"></script>
<div class="page-header"><h1>Administration</h1></div>
<div class="pagination pagination-large">
    <ul>
        <?php if($_SESSION['type']==1){ ?><li><span class="link" id="SU">Utilisateurs</span></li> <?php } ?>
        <li><span class="link" id="SF">Fiches</span></li>
        <li><span class="link" id="SA">Animes</span></li>
        <li><span class="link" id="SM">Mangas</span></li>
    </ul>
</div>
<div class="admin" id="AU"> <h2>Liste des utilisateurs</h2>

    <table class="table table-striped table-bordered">


        <thead>
            <tr>
                <th>Avatar</th>
                <th>Pseudo</th>
                <th>Nom</th>
                <th>Prenom</th>
                <th>Mail</th>
                <th>Type</th>
                <th>Editer</th>
                <th>Supprimer</th>

            </tr>
        </thead>


        <tbody>
            <?php
            for ($i = 0, $size = count($utilisateurs); $i < $size; $i++) {
                if ($utilisateurs[$i]['idtype'] != 1) {
                    ?>
                    <tr>
                        <td>			
                            <img class="featurette-image span1 img-polaroid" src="avatar/<?php echo $utilisateurs[$i]['profil'][0]['avatar']; ?>">
                        </td>
                        <td><?php echo html($utilisateurs[$i]['pseudo']); ?></td>
                        <td><?php echo html($utilisateurs[$i]['nom']); ?></td>
                        <td><?php echo html($utilisateurs[$i]['prenom']); ?></td>
                        <td><?php echo html($utilisateurs[$i]['mail']); ?></td>
                        <td><?php echo html($utilisateurs[$i]['type']); ?></td>

                        <td>

                            <FORM method=post action="index.php?module=Administration&action=gestionProfil&iduser=<?php echo $utilisateurs[$i]['iduser']; ?>">	
                                <button><i class="icon-pencil"></i></button>
                            </FORM>
                        </td>

                        <td>
                            <FORM method=post action="index.php?module=Administration&action=suppUser&iduser=<?php echo $utilisateurs[$i]['iduser']; ?>">
                                <button><i class="icon-remove"></i></button>
                            </FORM>
                        </td>

                    </tr>
                <?php }
            } ?>
        </tbody>
    </table></div>







<div class="admin" id="AF"> <h2>Liste des fiches</h2>
    <table class="table table-striped table-bordered">


        <thead>
            <tr>
                <th>Manga</th>
                <th>Anime</th>	
                <th>Editer</th>
                <th>Supprimer</th>
            </tr>
        </thead>


        <tbody>

            <?php
            for ($i = 0, $size = count($fiches); $i < $size; $i++) {
                ?>
                <tr>
                    <td><?php
                if (!empty($fiches[$i]['manga'])) {
                    echo html($fiches[$i]['manga'][0]['titre']);
                }
                ?></td>
                    <td><?php
                    if (!empty($fiches[$i]['anime'])) {
                        echo html($fiches[$i]['anime'][0]['titre']);
                    }
                    ?></td>
                    <td>

                        <FORM method=post action="index.php?module=Administration&action=gestionFiche&idmanga=<?php echo $fiches[$i]['idmanga']; ?>&idanime=<?php echo $fiches[$i]['idanime']; ?>">	
                            <button><i class="icon-pencil"></i></button>
                        </FORM>
                    </td>

                    <td>
                        <FORM method=post action="index.php?module=Administration&action=suppFiche&idmanga=<?php echo $fiches[$i]['idmanga']; ?>&idanime=<?php echo $fiches[$i]['idanime']; ?>">	
                            <button><i class="icon-remove"></i></button>
                        </FORM>
                    </td>

                </tr>	

    <?php
}
?> 
        </tbody>
    </table></div>					



<div class="admin" id="AA"> <h2>Liste des animes</h2>
    <table class="table table-striped table-bordered">


        <thead>
            <tr>
                <th>Image</th>
                <th>Titre</th>
                <th>Titre Alternatif</th>
                <th>Auteur</th>
                <th>Dernier Épisode</th>
                <th>Statut</th>
                <th>Editer</th>
                <th>Supprimer</th>

            </tr>
        </thead>


        <tbody>
<?php
for ($i = 0, $size = count($fiches); $i < $size; $i++) {
    if (!empty($fiches[$i]['anime'])) {
        $anime = $fiches[$i]['anime']
        ?>


                    <tr>
                        <td><?php echo '<img class="featurette-image span1 img-polaroid" src="illustrations/' . $anime[0]['image'] . '">'; ?></td>
                        <td><?php echo html($anime[0]['titre']); ?></td>
                        <td><?php echo html($anime[0]['titreAlt']); ?></td>
                        <td><?php echo html($anime[0]['auteur']); ?></td>
                        <td><?php echo html($anime[0]['lastEp']); ?></td>
                        <td><?php echo html($anime[0]['statut'][0]['statut']); ?></td>


                        <td>

                            <FORM method=post action="index.php?module=Administration&action=gestionAnime&idanime=<?php echo $anime[0]['idanime']; ?>">	
                                <button><i class="icon-pencil"></i></button>
                            </FORM>
                        </td>

                        <td>
                            <FORM method=post action="index.php?module=Administration&action=suppAnime&idanime=<?php echo $anime[0]['idanime']; ?>">
                                <button><i class="icon-remove"></i></button>
                            </FORM>
                        </td>

                    </tr>	


        <?php
    }
}
?> 
        </tbody>
    </table></div>	

<div class="admin" id="AM"> <h2>Liste des mangas</h2>
    <table class="table table-striped table-bordered">


        <thead>
            <tr>
                <th>Couverture</th>
                <th>Titre </th>
                <th>Titre Alternatif</th>
                <th>Auteur</th>
                <th>Dernier Chapitre</th>
                <th>Statut</th>
                <th>Editer</th>
                <th>Supprimer</th>

            </tr>
        </thead>


        <tbody>

<?php
for ($i = 0, $size = count($fiches); $i < $size; $i++) {
    if (!empty($fiches[$i]['manga'])) {
        $manga = $fiches[$i]['manga']
        ?>


                    <tr>
                        <td><?php echo '<img class="featurette-image span1 img-polaroid" src="couvertures/' . $manga[0]['couverture'] . '">'; ?></td>
                        <td><?php echo html($manga[0]['titre']); ?></td>
                        <td><?php echo html($manga[0]['titreAlt']); ?></td>
                        <td><?php echo html($manga[0]['auteur']); ?></td>
                        <td><?php echo html($manga[0]['dernierchap']); ?></td>
                        <td><?php echo html($manga[0]['statut'][0]['statut']); ?></td>


                        <td>

                            <FORM method=post action="index.php?module=Administration&action=gestionManga&idmanga=<?php echo $manga[0]['idmanga']; ?>">	
                                <button><i class="icon-pencil"></i></button>
                            </FORM>
                        </td>

                        <td>
                            <FORM method=post action="index.php?module=Administration&action=suppManga&idmanga=<?php echo $manga[0]['idmanga']; ?>">
                                <button><i class="icon-remove"></i></button>
                            </FORM>
                        </td>

                    </tr>	


        <?php
    }
}
?>
        </tbody>
    </table></div>
