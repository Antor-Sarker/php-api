<?php

    require_once("./config/database.php");
    require_once("./api/TaskApi/Task.php");
    require_once("./api/TaskApi/Router.php");

    header("Content-Type: application/json");

    //database initialize
    $db = new Database();
    $conn = $db->getConnection();
    $task = new Task($conn);
    $router = new Router($task);

    $router->handelRequest();
    $conn->close();

?>