<?php
include 'lang.php';
include 'db.php'; // DB connection

$error = "";

// --- HANDLE ADD STOCK FORM ---
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['medName'])){
    $name  = trim($_POST['medName']);
    $qty   = $_POST['medQty'];
    $price = $_POST['medPrice'];

    // Validation
    if($name != "" && $qty > 0 && $price > 0 && $price <= 2000){
        if(intval($qty) != floatval($qty)){
            $error = "Quantity must be a whole number!";
        } else {
            // Check duplicate medicine
            $stmt_check = $conn->prepare("SELECT id FROM stock WHERE medicine_name = ?");
            $stmt_check->bind_param("s", $name);
            $stmt_check->execute();
            $stmt_check->store_result();
            if($stmt_check->num_rows > 0){
                $error = "This medicine already exists in stock!";
            } else {
                $stmt = $conn->prepare("INSERT INTO stock (medicine_name, quantity, price) VALUES (?, ?, ?)");
                $stmt->bind_param("sii", $name, $qty, $price);
                $stmt->execute();
                $stmt->close();
            }
            $stmt_check->close();
        }
    }
}

// --- HANDLE DELETE ---
if(isset($_GET['delete_id'])){
    $delete_id = intval($_GET['delete_id']);
    $conn->query("DELETE FROM stock WHERE id = $delete_id");
}

// --- FETCH STOCK ---
$stockResult = $conn->query("SELECT * FROM stock");
?>

<!DOCTYPE html>
<html>
<head>
<title><?php echo $text[$lang]['welcome'] ?? 'Welcome'; ?> | Pharmacy Dashboard</title>

<style>
body {
    font-family: Georgia, serif;
    background-color: #EAD9B0;
    margin: 0;
    padding: 20px;
}

.container {
    width: 90%;
    margin: auto;
    background-color: #E8D5A6;
    padding: 30px;
    border-radius: 15px;
    border: 2px solid #8B6A3E;
    box-shadow: 0 6px 20px rgba(0,0,0,0.25);
}

h2 {
    text-align: center;
    color: #4B2E17;
    text-transform: uppercase;
    letter-spacing: 2px;
}

h3 {
    color: #4B2E17;
    border-bottom: 2px solid #8B6A3E;
    padding-bottom: 6px;
    margin-top: 40px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
    background-color: #F3E8C8;
}

th, td {
    border: 1px solid #8B6A3E;
    padding: 12px;
    text-align: center;
}

th {
    background-color: #4B2E17;
    color: #F9F4E3;
}

.stock-form {
    display: flex;
    gap: 10px;
    justify-content: center;
    margin-bottom: 20px;
    padding-bottom: 20px;
    border-bottom: 1px dashed #8B6A3E;
}

input {
    padding: 10px;
    border: 1px solid #8B6A3E;
    border-radius: 6px;
    background-color: #F9F4E3;
}

.btn-add {
    background-color: #4B2E17;
    color: #F9F4E3;
    padding: 10px 20px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
}

.btn-add:hover {
    background-color: #5C3A1F;
}

.btn-delete {
    background-color: #4B2E17;
    color: white;
    border: none;
    padding: 6px 10px;
    border-radius: 5px;
    cursor: pointer;
}

.error {
    color: #8B1E1E;
    text-align: center;
    margin-bottom: 10px;
    font-weight: bold;
}

.back-btn {
    text-align: center;
    margin-top: 30px;
}

.back-btn button {
    background-color: #4B2E17;
    color: #F9F4E3;
    padding: 10px 25px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
}
.back-btn button:hover {
    background-color: #5C3A1F;
}
</style>
</head>

<body>

<div class="container">

<div style="text-align:right; margin-bottom:10px;">
    <label><?php echo $text[$lang]['language'] ?? 'Language'; ?>:</label>
    <select>
        <option>English</option>
        <option>Hindi</option>
        <option>Tamil</option>
    </select>
</div>

<h2><?php echo $text[$lang]['welcome'] ?? 'Welcome'; ?> - Dashboard</h2>

<?php if($error != "") { echo "<div class='error'>$error</div>"; } ?>

<h3>Manage Inventory</h3>

<form method="POST" class="stock-form" onsubmit="return validateForm()">
    <input type="text" name="medName" id="medName" placeholder="Medicine Name" required>
    <input type="number" name="medQty" id="medQty" placeholder="Quantity" required>
    <input type="number" name="medPrice" id="medPrice" placeholder="Price (Max 2000)" required>
    <button type="submit" class="btn-add"><?php echo $text[$lang]['add_stock'] ?? 'Add to Stock'; ?></button>
</form>

<table>
<thead>
<tr>
    <th>Medicine Name</th>
    <th>Quantity</th>
    <th>Price (Rs)</th>
    <th>Action</th>
</tr>
</thead>
<tbody>
<?php while($row = $stockResult->fetch_assoc()){ ?>
<tr>
    <td><?php echo $row['medicine_name']; ?></td>
    <td><?php echo $row['quantity']; ?></td>
    <td><?php echo $row['price']; ?></td>
    <td>
        <a href="?delete_id=<?php echo $row['id']; ?>" class="btn-delete"
           onclick="return confirm('Are you sure?')">Remove</a>
    </td>
</tr>
<?php } ?>
</tbody>
</table>

<div class="back-btn">
    <button onclick="window.location.href='login.php'">
        Back to Login
    </button>
</div>

</div>

<script>
function validateForm() {
    var qty = document.getElementById("medQty").value;
    if(!Number.isInteger(parseFloat(qty))){
        alert("Quantity must be a whole number!");
        return false;
    }
    var price = parseInt(document.getElementById("medPrice").value);
    if(price > 2000){
        alert("Price cannot exceed 2000 Rs");
        return false;
    }
    return true;
}
</script>

</body>
</html>
