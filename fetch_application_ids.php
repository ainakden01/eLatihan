<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['college_uni'])) {
    die("Access Denied");
}

$logged_in_user_id = $_SESSION['user_id'];

if (isset($_GET['query'])) {
    $searchTerm = $_GET['query'];

    try {
        $stmt = $pdo->prepare("
            SELECT DISTINCT application_id 
            FROM rayuan
            WHERE user_id = ? AND application_id LIKE ?
            LIMIT 10
        ");
        $stmt->execute([$logged_in_user_id, '%' . $searchTerm . '%']);
        $application_ids = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($application_ids) {
            foreach ($application_ids as $row) {
                echo '<a href="#" class="dropdown-item">' . htmlspecialchars($row['application_id']) . '</a>';
            }
        } else {
            echo '<p>No results found</p>';
        }
    } catch (PDOException $e) {
        echo 'Database query failed: ' . $e->getMessage();
    }
}


?>
