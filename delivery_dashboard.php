<?php
session_start();
include 'db.php';
include 'lang.php';
?>


<html>
<head>
<title>MediConnect | Delivery Dashboard</title>

<style>
body {
    font-family: Georgia, serif;
    background-color: #EAD7AE;
    margin: 0;
    padding: 0;
}
.container {
    width: 80%;
    margin: 60px auto;
    background: #E6D1A3;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 0 15px rgba(75, 46, 26, 0.3);
    border: 1px solid #8B6A3E;
}
h2 {
    text-align: center;
    color: #4B2E1A;
}
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 25px;
}
th, td {
    border: 1px solid #8B6A3E;
    text-align: center;
    padding: 10px;
}
th {
    background-color: #4B2E1A;
    color: white;
}
tr:nth-child(even) {
    background-color: #F3E7C8;
}
.btn {
    text-decoration: none;
    color: white;
    background-color: #4B2E1A;
    padding: 7px 15px;
    border-radius: 5px;
}
.disabled {
    background-color: grey;
    pointer-events: none;
}
.back {
    text-align: center;
    margin-top: 25px;
}
</style>
</head>

<body>

<div class="container">
<h2>Delivery Dashboard</h2>

<table>
<tr>
    <th>Order ID</th>
    <th>Customer</th>
    <th>Address</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php
$query = "SELECT * FROM delivery_orders";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {

        echo "<tr>";
        echo "<td>{$row['order_id']}</td>";
        echo "<td>{$row['customer_name']}</td>";
        echo "<td>{$row['address']}</td>";
        echo "<td>{$row['status']}</td>";

        if ($row['status'] === 'Pending') {
            echo "<td><a class='btn' href='delivery_dashboard.php?deliver={$row['order_id']}'>Mark Delivered</a></td>";
        } else {
            echo "<td><a class='btn disabled'>Completed</a></td>";
        }

        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>No delivery orders found</td></tr>";
}
?>
</table>

<div class="back">
    <a href="login.html">← Back to Login</a>
</div>
</div>

<?php
if (isset($_GET['deliver'])) {
    $id = (int) $_GET['deliver'];
    mysqli_query($conn, "UPDATE delivery_orders SET status='Delivered' WHERE order_id=$id");
    echo "<script>window.location='delivery_dashboard.php';</script>";
}
?>

</body>
</html>
