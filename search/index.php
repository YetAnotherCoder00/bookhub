<?php

$sortByColumns = ["id", "kurztitle", "autor"];

?>

<html>
<head>

</head>

<body>

<div class="advancedsearch">
    <form action="index.php" method="get" class="advancedsearch_form">
        <select name="" class="" onchange="this.form.submit()">
            <option value="" disabled selected>Sort by <i class="fa-solid fa-chevron-down"></i></option>
            <?php
            foreach ($sortByColumns as $sortByColumn) {
                echo "<option value=" . $sortByColumn . ">" . $sortByColumn . "</option>";
            }
            ?>
        </select>
    </form>
    <button class="activateFilters">Filters</button>
</div>
</body>
</html>
