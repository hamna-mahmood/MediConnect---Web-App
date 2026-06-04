<?php
include 'db.php';
// Language file including so that alerts can be translate 
include 'lang.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $med_name = mysqli_real_escape_string($conn, $_POST['medicine_name']);
    $qty_ordered = (int)$_POST['quantity'];
    $delivery = $_POST['delivery_type'];
    $address = mysqli_real_escape_string($conn, $_POST['delivery_address']);
    $payment = $_POST['payment_method'];
    $pharmacy = $_POST['pharmacy_name'];
    
    // Default values
    $patient_email = "patient@example.com"; 
    $pharmacy_email = "safa@pharmacy.com";

    // 1. Stock check
    $stock_query = mysqli_query($conn, "SELECT quantity FROM stock WHERE medicine_name = '$med_name'");
    $stock_data = mysqli_fetch_assoc($stock_query);

    if ($stock_data && $stock_data['quantity'] >= $qty_ordered) {
        // 2. Stock Update
        $new_qty = $stock_data['quantity'] - $qty_ordered;
        mysqli_query($conn, "UPDATE stock SET quantity = $new_qty WHERE medicine_name = '$med_name'");

        // 3. Insert into Orders Table
        $sql = "INSERT INTO orders (patient_email, pharmacy_email, medicine_name, quantity, delivery_type, delivery_address, payment_method, pharmacy_name) 
                VALUES ('$patient_email', '$pharmacy_email', '$med_name', $qty_ordered, '$delivery', '$address', '$payment', '$pharmacy')";

        if (mysqli_query($conn, $sql)) {
            // Success Alert (Translated)
            $msg = $text[$lang]['order_success'];
            echo "<script>alert('$msg'); window.location.href='order.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        // Stock Error Alert (Translated)
        $available = $stock_data['quantity'] ?? 0;
        $msg = $text[$lang]['stock_error'] . " " . $available;
        echo "<script>alert('$msg'); window.location.href='order.php';</script>";
    }
}
?>
