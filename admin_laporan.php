<?php
    try
    {
        $pdo = new PDO('mysql:host=localhost;dbname=non_existent_db', 'root', 'wrong_password');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->query('SELECT * FROM non_existent_table');
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (PDOException $e)
    {
        echo '<div style="color: red; border: 1px solid red; padding: 10px; border-radius: 5px;">';
        echo '<strong>Error:</strong> An exception occurred while attempting to connect to the database or execute a query.<br>';
        echo '<strong>Error Message:</strong> ' . htmlspecialchars($e->getMessage()) . '<br>';
        echo '<strong>Error Code:</strong> ' . htmlspecialchars($e->getCode()) . '<br>';
        echo '<strong>File:</strong> ' . htmlspecialchars($e->getFile()) . '<br>';
        echo '<strong>Line:</strong> ' . htmlspecialchars($e->getLine()) . '<br>';
        echo '<strong>Trace:</strong><br><pre>' . htmlspecialchars($e->getTraceAsString()) . '</pre>';
        echo '</div>';
    }
?>