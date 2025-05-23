<?php
include 'components/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $transaction_id = $_POST['transaction_id'] ?? '';
    $user_id = $_POST['user'] ?? '';
    $transaction_status = $_POST['transaction_status'] ?? '';

    if (empty($transaction_id) || empty($user_id) || empty($transaction_status)) {
        echo 0;
        exit;
    }

    // Sanitize inputs
    $transaction_id = filter_var($transaction_id, FILTER_SANITIZE_STRING);
    $user_id = filter_var($user_id, FILTER_SANITIZE_NUMBER_INT);
    $transaction_status = filter_var($transaction_status, FILTER_SANITIZE_STRING);

    // Create payments table if not exists
    $create_table_sql = "CREATE TABLE IF NOT EXISTS `payments` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `user_id` INT(11) NOT NULL,
        `transaction_id` VARCHAR(255) NOT NULL,
        `transaction_status` VARCHAR(50) NOT NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

    $conn->exec($create_table_sql);

    // Insert payment record
    $insert_payment = $conn->prepare("INSERT INTO `payments` (user_id, transaction_id, transaction_status) VALUES (?, ?, ?)");
    $result = $insert_payment->execute([$user_id, $transaction_id, $transaction_status]);

if ($result) {
    // Debug: log user ID and deletion attempt
    error_log("paypal_processor.php: Deleting cart items for user_id: " . $user_id);

    // Delete cart items for the user after successful payment
    $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
    $delete_result = $delete_cart->execute([$user_id]);

    if ($delete_result) {
        error_log("paypal_processor.php: Cart items deleted successfully for user_id: " . $user_id);
    } else {
        error_log("paypal_processor.php: Failed to delete cart items for user_id: " . $user_id);
    }

    echo 1;
} else {
    echo 0;
}
} else {
    echo 0;
}
?>
