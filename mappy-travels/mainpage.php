!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Main Page</title>
    <?php
    /**
     * Created by IntelliJ IDEA.
     * User: mkb15131
     * Date: 26/03/2018
     * Time: 11:32
     */
    $noOfRoutes = 0;

    if($noOfRoutes == 0){
        ?>
        <header>
            Add New Route
        </header>
        <form method="get" action="addroute">
            <button type="submit" id = "addRoute"> + </button>
        </form>
        <?php
    } else {
    ?>
    <header>
        Routes
    </header>
    <button id = "route1"> Route 1 </button>
    <form method="get" action="addroute">
        <button type="submit" id = "addNewRoute"> + </button>
    </form>
<?php
}