<script src="scripts/classement.js"></script>
<div class="page-header"><h1>Classement - TOP 50</h1></div>
<table class="liste" id="orderByNote">
    <thead>
        <tr>
            <th>Place</th>
            <th>Titre Manga</th>
            <th>Titre Anime</th>
            <th>Note ▼</th>
            <th><span class="order">Nombre de j'aime</span></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $color = true;
        for ($i = 0, $size = count($classementByNote); $i < $size; ++$i) {
            echo '<tr ';
            if ($color) {
                echo 'class="ligne lignecolor"';
                $color = false;
            } else {
                echo 'class="ligne"';
                $color = true;
            }
            echo ' onclick="window.location.href=\'./index.php?module=Fiche&action=displayFiche&idmanga=' . $classementByNote[$i]['idmanga'] . '&idanime='.$classementByNote[$i]['idanime'].'\'">';
            echo '<td>'.($i+1).'</td><td>' . html($classementByNote[$i]['manga'][0]['titre']) . '</td><td>' . html($classementByNote[$i]['anime'][0]['titre']) . '</td><td>' . $classementByNote[$i]['note'] . '</td><td>' . $classementByNote[$i]['nbAime'] . '</td>';
            echo '</tr>';
        }
        ?>
    </tbody>
</table>
<table class="liste" id="orderByAime">
    <thead>
        <tr>
            <th>Place</th>
            <th>Titre Manga</th>
            <th>Titre Anime</th>
            <th><span class="order">Note</span></th>
            <th>Nombre de j'aime ▼</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $color = true;
        for ($i = 0, $size = count($classementByAime); $i < $size; ++$i) {
            echo '<tr ';
            if ($color) {
                echo 'class="ligne lignecolor"';
                $color = false;
            } else {
                echo 'class="ligne"';
                $color = true;
            }
            echo ' onclick="window.location.href=\'./index.php?module=Fiche&action=displayFiche&idmanga=' . $classementByAime[$i]['idmanga'] . '&idanime='.$classementByAime[$i]['idanime'].'\'">';
            echo '<td>'.($i+1).'</td><td>' . html($classementByAime[$i]['manga'][0]['titre']) . '</td><td>' . html($classementByAime[$i]['anime'][0]['titre']) . '</td><td>' . $classementByAime[$i]['note'] . '</td><td>' . $classementByAime[$i]['nbAime'] . '</td>';
            echo '</tr>';
        }
        ?>
    </tbody>
</table>
