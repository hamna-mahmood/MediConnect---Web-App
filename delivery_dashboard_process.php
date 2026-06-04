<?php
session_start();
include "db.php";

if (isset($_GET['deliver'])) {

    $order_id = mysqli_real_escape_string($conn, $_GET['deliver']);

    $stmt = $conn->prepare(
        "UPDATE delivery_orders SET status='Delivered' WHERE order_id=?"
    );
    $stmt->bind_param("s", $order_id);
    $stmt->execute();

    header("Location: delivery.php");
    exit();
}
?>
