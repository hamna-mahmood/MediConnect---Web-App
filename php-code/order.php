<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';
include 'lang.php';

$lang = $_GET['lang'] ?? 'en'; // Language selected via dropdown

$message = ""; // Will hold alert message
$message_type = ""; // success or error

// --- Handle POST submission ---
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $med_name = mysqli_real_escape_string($conn, $_POST['medicine_name']);
    $qty_ordered = $_POST['quantity'];
    $delivery = mysqli_real_escape_string($conn, $_POST['delivery_type']);
    $address = trim(mysqli_real_escape_string($conn, $_POST['delivery_address'] ?? ''));
    $payment = mysqli_real_escape_string($conn, $_POST['payment_method']);
    $pharmacy = "Safa"; // Fixed

    // --- Basic validation ---
    if(!$med_name || !$qty_ordered || !$delivery || !$payment || ($delivery === 'delivery' && !$address)){
        $message = $text[$lang]['fill_all_fields'] ?? "Please fill in all required fields!";
        $message_type = "error";
    } else {
        // --- Fetch stock ---
        $stmt = $conn->prepare("SELECT quantity FROM stock WHERE medicine_name = ?");
        $stmt->bind_param("s", $med_name);
        $stmt->execute();
        $result = $stmt->get_result();
        $stock_data = $result->fetch_assoc();
        $stmt->close();

        if(!$stock_data){
            $message = $text[$lang]['med_not_found'] ?? "Selected medicine not found in stock!";
            $message_type = "error";
        } elseif(!ctype_digit($qty_ordered) || (int)$qty_ordered <= 0) {
            $message = $text[$lang]['qty_invalid'] ?? "Quantity must be a positive whole number!";
            $message_type = "error";
        } elseif((int)$qty_ordered > $stock_data['quantity']){
            $message = sprintf($text[$lang]['qty_error'] ?? "Required quantity not available. Only %d in stock!", $stock_data['quantity']);
            $message_type = "error";
        } elseif($delivery === 'delivery') {
            // --- Address validation ---
            if(!preg_match("/^[a-zA-Z0-9\s,.-]+$/", $address)){
                $message = $text[$lang]['invalid_address'] ?? "Home address contains invalid characters!";
                $message_type = "error";
            } else {
                // Must contain street word
                $dictionary = ['Road','Street','Lane','Avenue','Boulevard','Drive','Circle','Court','Place','Square','Terrace','Park','Plaza'];
                $words = preg_split('/\s+/', $address);
                $valid_word_found = false;
                foreach($words as $w){
                    foreach($dictionary as $d){
                        if(strcasecmp($w, $d) === 0){
                            $valid_word_found = true;
                            break 2;
                        }
                    }
                }
                if(!$valid_word_found){
                    $message = $text[$lang]['invalid_address'] ?? "Please enter a valid Home Address with street name!";
                    $message_type = "error";
                } else {
                    // Proper spelling check
                    foreach($words as $word){
                        $cleanWord = preg_replace('/[^a-zA-Z]/', '', $word);
                        if($cleanWord !== "" && strlen($cleanWord) < 3){
                            $message = $text[$lang]['invalid_address'] ?? "Home Address contains invalid or misspelled words!";
                            $message_type = "error";
                            break;
                        }
                        if(preg_match('/(.)\\1{2,}/', strtolower($cleanWord))){
                            $message = $text[$lang]['invalid_address'] ?? "Home Address contains incorrect spellings!";
                            $message_type = "error";
                            break;
                        }
                    }
                    if(strlen($address) < 5 || strlen($address) > 50){
                        $message = $text[$lang]['invalid_address'] ?? "Home Address must be 5–50 characters!";
                        $message_type = "error";
                    }
                }
            }
        }

        // --- If no errors, place order ---
        if($message_type === "") {
            $qty_ordered = (int)$qty_ordered;

            $patient_email = "patient@example.com"; 
            $pharmacy_email = "safa@pharmacy.com";

            // Update stock
            $new_qty = $stock_data['quantity'] - $qty_ordered;
            $stmt = $conn->prepare("UPDATE stock SET quantity=? WHERE medicine_name=?");
            $stmt->bind_param("is", $new_qty, $med_name);
            $stmt->execute();
            $stmt->close();

            // Insert order
            $stmt = $conn->prepare("INSERT INTO orders (patient_email, pharmacy_email, medicine_name, quantity, delivery_type, delivery_address, payment_method, pharmacy_name) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssissss", $patient_email, $pharmacy_email, $med_name, $qty_ordered, $delivery, $address, $payment, $pharmacy);
            if($stmt->execute()){
                $message = $text[$lang]['order_success'] ?? "Order placed successfully!";
                $message_type = "success";
            } else {
                $message = "Error placing order: ".$stmt->error;
                $message_type = "error";
            }
            $stmt->close();
        }
    }
}

// --- Fetch medicines for dropdown ---
$stockResult = $conn->query("SELECT medicine_name FROM stock WHERE quantity > 0");
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $text[$lang]['order'] ?? "Place Order"; ?></title>
    
    <style>
    body { 
        font-family: Georgia, serif; 
        background-color: #EAD9B0;
        padding: 20px; 
    }

    .container { 
        width: 500px; 
        margin: auto; 
        background-color: #E8D5A6; 
        padding: 30px; 
        border-radius: 15px; 
        border: 2px solid #8B6A3E; 
        box-shadow: 0 6px 15px rgba(0,0,0,0.2); 
        position: relative;
    }

    h2 { 
        text-align: center; 
        color: #4B2E17; /* Dark brown heading */ 
        text-transform: uppercase; 
        letter-spacing: 2px; 
    }

    label { 
        display: block; 
        margin-top: 10px; 
        color: #4B2E17; /* Dark brown labels */ 
    }

    select, input { 
        width: 100%; 
        padding: 10px; 
        margin-top: 5px; 
        border-radius: 5px; 
        border: 1px solid #8B6A3E; 
        background-color: #F9F4E3; /* Very light beige */ 
    }

    .btn { 
        margin-top: 20px; 
        padding: 10px 20px; 
        background-color: #4B2E17; /* Dark brown */ 
        color: #F9F4E3; /* Light text */ 
        border: none; 
        border-radius: 5px; 
        cursor: pointer; 
        font-weight: bold; 
        transition: 0.3s;
    }

    .btn:hover {
        background-color: #5C3A1F; /* Slightly lighter brown on hover */ 
    }

    .bottom-buttons { 
        display: flex; 
        justify-content: space-between; 
        margin-top: 20px; 
    }

    .bottom-buttons button { 
        width: 48%; 
        background-color: #4B2E17; 
        color: #F9F4E3; 
        border: none; 
        border-radius: 5px; 
        cursor: pointer; 
        font-weight: bold; 
    }

    .bottom-buttons button:hover {
        background-color: #5C3A1F;
    }

    .alert { 
        padding: 15px; 
        border-radius: 5px; 
        margin-bottom: 15px; 
    }

    .alert.success { 
        background: #4CAF50; 
        color: white; 
    }

    .alert.error { 
        background: #f44336; 
        color: white; 
    }
</style>


    <script>
        function toggleAddress(){
            let delivery = document.getElementById('delivery_type').value;
            let addr = document.getElementById('delivery_address');
            if(delivery === 'pickup'){ 
                addr.value = '';
                addr.disabled = true;
            } else {
                addr.disabled = false;
            }
        }
    </script>
</head>
<body onload="toggleAddress()">
<div class="container">
    <h2><?php echo $text[$lang]['order'] ?? "Place Order"; ?></h2>

    <?php if($message): ?>
        <div class="alert <?php echo $message_type; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <label>Medicine:</label>
         <select name="medicine_name" required>
            <option value="">--Select Medicine--</option>
           <?php while($row = $stockResult->fetch_assoc()): ?>
             <option value="<?php echo htmlspecialchars($row['medicine_name']); ?>">
            <?php echo htmlspecialchars($row['medicine_name']); ?>
            </option>
            <?php endwhile; ?>
         </select>
        
        <label>Quantity:</label>
        <input type="number" name="quantity" id="quantity" required>

        <label>Delivery Type:</label>
        <select name="delivery_type" id="delivery_type" onchange="toggleAddress()" required>
            <option value="pickup">Pickup</option>
            <option value="delivery">Home Delivery</option>
        </select>

        <label>Home Address:</label>
        <input type="text" name="delivery_address" id="delivery_address">

        <label>Payment Method:</label>
        <select name="payment_method" required>
            <option value="">--Select--</option>
            <option value="card">Card</option>
            <option value="cash">Cash</option>
        </select>

        <label>Pharmacy:</label>
        <input type="text" value="Safa" disabled>

        <button type="submit" class="btn">Place Order</button>
    </form>

    <div class="bottom-buttons">
        <button class="btn" onclick="window.location.href='login.php'">Back to Login</button>
    </div>
</div>
</body>
</html>
