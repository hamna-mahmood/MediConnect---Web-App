<?php
session_start();
include "db.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (!empty($_GET['medicine'])) {

        $medicine = trim($_GET['medicine']);
        $medicine = mysqli_real_escape_string($conn, $medicine);

        $query = "
            SELECT pharmacy_name, availability, price
            FROM medicine_search
            WHERE medicine_name LIKE '%$medicine%'
        ";

        $result = mysqli_query($conn, $query);

        $_SESSION['search_results'] = [];

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $_SESSION['search_results'][] = $row;
            }
        }
    }

    header("Location: search.php");
    exit();
}
?>
