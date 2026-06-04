<?php
session_start();
include 'db.php';
include 'lang.php';
?>


<html>
<head>
<title>MediConnect | Medicine Search</title>

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
    margin-bottom: 25px;
}
.search-box {
    display: flex;
    justify-content: center;
    margin-bottom: 30px;
}
input[type="text"] {
    width: 70%;
    padding: 10px;
    border: 1px solid #8B6A3E;
    border-radius: 5px 0 0 5px;
    font-size: 16px;
}
button {
    padding: 10px 20px;
    border: none;
    background-color: #4B2E1A;
    color: white;
    font-size: 16px;
    border-radius: 0 5px 5px 0;
    cursor: pointer;
}
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
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
    padding: 10px 18px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 15px;
}
.back {
    text-align: center;
    margin-top: 30px;
}
</style>
</head>

<body>

<div class="container">
<h2>Search for Medicines</h2>

<form method="GET" class="search-box">
    <input type="text" name="medicine" placeholder="Enter medicine name..."
           value="<?php echo isset($_GET['medicine']) ? htmlspecialchars($_GET['medicine']) : ''; ?>" required>
    <button type="submit">Search</button>
</form>

<table>
<tr>
    <th>Medicine Name</th>
    <th>Availability</th>
    <th>Price</th>
</tr>

<?php
if (isset($_GET['medicine'])) {

    $medicine = mysqli_real_escape_string($conn, $_GET['medicine']);

    $query = "
        SELECT medicine_name, quantity, price
        FROM stock
        WHERE medicine_name LIKE '%$medicine%'
    ";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {

        while ($row = mysqli_fetch_assoc($result)) {

            $availability = ($row['quantity'] > 0) ? "Available" : "Out of Stock";

            echo "<tr>";
            echo "<td>{$row['medicine_name']}</td>";
            echo "<td>$availability</td>";
            echo "<td>" . ($row['price'] ? "Rs. {$row['price']}" : "—") . "</td>";
            echo "</tr>";
        }

    } else {
        echo "<tr><td colspan='4'>No medicines found</td></tr>";
    }
}
?>

</table>

<div class="back">
    <button class="btn" onclick="window.location.href='login.php'">
        Back to Login
    </button>

    <button class="btn" style="margin-left:15px;"
            onclick="window.location.href='order.php'">
        Place Order
    </button>
</div>

</div>

</body>
</html>
