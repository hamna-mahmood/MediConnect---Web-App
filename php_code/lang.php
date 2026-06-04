<?php
// --- Get language from cookie (fallback to English) ---
$lang = $_COOKIE['lang'] ?? 'en';

// --- Translation array ---
$text = [
    'en' => [
        'welcome' => 'Welcome to MediConnect',
        'logout' => 'Logout',
        'email' => 'Email',
        'password' => 'Password',
        'login_as' => 'Login as',
        'patient' => 'Patient',
        'pharmacy' => 'Pharmacy',
        'delivery' => 'Delivery Agent',
        'place_order' => 'Place Order',
        'dashboard' => 'Dashboard',
        'language' => 'Language',

        // --- New keys for order.php ---
        'order' => 'Place Order',
        'medicine' => 'Medicine',
        'quantity' => 'Quantity',
        'delivery_type' => 'Delivery Type',
        'delivery_address' => 'Home Address',
        'payment_method' => 'Payment Method',
        'pharmacy_name' => 'Pharmacy',
        'fill_all_fields' => 'Please fill in all required fields!',
        'home_address_required' => 'Home Address is required for Home delivery!',
        'invalid_address' => 'Please enter a valid Home Address!',
        'qty_invalid' => 'Quantity must be a positive whole number!',
        'med_not_found' => 'Selected medicine not found in stock!',
        'qty_error' => 'Required quantity not available. Only %d in stock!',
        'order_success' => 'Order placed successfully!',
    ],
    'hi' => [
        'welcome' => 'मेडिकनेक्ट में आपका स्वागत है',
        'logout' => 'लॉग आउट',
        'email' => 'ईमेल',
        'password' => 'पासवर्ड',
        'login_as' => 'लॉगिन रूप',
        'patient' => 'रोगी',
        'pharmacy' => 'फार्मेसी',
        'delivery' => 'डिलीवरी एजेंट',
        'place_order' => 'ऑर्डर दें',
        'dashboard' => 'डैशबोर्ड',
        'language' => 'भाषा',

        // --- New keys ---
        'order' => 'ऑर्डर दें',
        'medicine' => 'दवा',
        'quantity' => 'मात्रा',
        'delivery_type' => 'वितरण प्रकार',
        'delivery_address' => 'होम पता',
        'payment_method' => 'भुगतान विधि',
        'pharmacy_name' => 'फार्मेसी',
        'fill_all_fields' => 'कृपया सभी आवश्यक फ़ील्ड भरें!',
        'home_address_required' => 'होम डिलीवरी के लिए पता आवश्यक है!',
        'invalid_address' => 'कृपया सही होम पता दर्ज करें!',
        'qty_invalid' => 'मात्रा एक सकारात्मक पूर्णांक होनी चाहिए!',
        'med_not_found' => 'चयनित दवा स्टॉक में नहीं है!',
        'qty_error' => 'आवश्यक मात्रा उपलब्ध नहीं है। केवल %d स्टॉक में है!',
        'order_success' => 'ऑर्डर सफलतापूर्वक रखा गया!',
    ],
    'ta' => [
        'welcome' => 'மெடிகனெக்ட் வரவேற்கிறது',
        'logout' => 'வெளியேறு',
        'email' => 'மின்னஞ்சல்',
        'password' => 'கடவுச்சொல்',
        'login_as' => 'உள்நுழைவு வகை',
        'patient' => 'நோயாளி',
        'pharmacy' => 'மருந்தகம்',
        'delivery' => 'டெலிவரி ஏஜெண்ட்',
        'place_order' => 'ஆர்டர் செய்யவும்',
        'dashboard' => 'டாஷ்போர்டு',
        'language' => 'மொழி',

        // --- New keys ---
        'order' => 'ஆர்டர் செய்யவும்',
        'medicine' => 'மருந்து',
        'quantity' => 'அளவு',
        'delivery_type' => 'வழங்கும் வகை',
        'delivery_address' => 'முகவரி',
        'payment_method' => 'பணம் செலுத்தும் முறை',
        'pharmacy_name' => 'மருந்தகம்',
        'fill_all_fields' => 'எல்லா தேவையான புலங்களையும் நிரப்பவும்!',
        'home_address_required' => 'வீட்டு விநியோகத்திற்கான முகவரி அவசியம்!',
        'invalid_address' => 'சரியான வீட்டு முகவரியை உள்ளிடவும்!',
        'qty_invalid' => 'அளவு ஒரு நேர்மறை முழு எண் இருக்க வேண்டும்!',
        'med_not_found' => 'தேர்ந்தெடுக்கப்பட்ட மருந்து மையத்தில் இல்லை!',
        'qty_error' => 'தேவையான அளவு கிடைக்கவில்லை. ஸ்டாக்கில் மட்டும் %d உள்ளது!',
        'order_success' => 'ஆர்டர் வெற்றிகரமாக செய்யப்பட்டது!',
    ],
];

// --- Safety check: fallback to English if language key missing ---
if (!isset($text[$lang])) {
    $lang = 'en';
}
?>
