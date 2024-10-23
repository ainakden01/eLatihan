<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id']))
    {
        $userId = $_POST['user_id'];

        // Delete institute by user ID securely using prepared statements
        $stmt = $pdo->prepare("DELETE FROM users WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);

        if ($stmt->execute())
        {
            echo "Institute deleted successfully";
        }
        else
        {
            echo "Error: Failed to delete institute.";
        }
    }
?>