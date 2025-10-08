<?php
// File: test_age.php 
require_once "Validator.php";

// Test Case 1: umur valid
try {
    $result = validateAge(25); 
    echo "PASS: Umur 25 diterima\n";
} catch (Exception $e) {
    echo "FAIL: Umur 25 tidak diterima. Error: " . $e->getMessage() . "\n";
}
  
// Test Case 3: umur negatif
try {
    $result = validateAge(-5);
    echo "FAIL; Umur -5 seharusnya ditolak\n";
} catch (Exception $e) {
    echo "PASS: Umur -5 ditolak. Error: " . $e->getMessage() . "\n";
}

// File: test_age.php
require_once "Validator.php";

// Test Case 1: nama valid
try {
    $result = validateName("Nabila"); 
    echo "PASS: Nama 'Nabila' diterima\n";
} catch (Exception $e) {
    echo "FAIL: Nama 'Nabila' diterima. Error: " . $e->getMessage() . "\n";
}
  
// Test Case 3: nama invalid
try {
    $result = validateName("Nabila123");
    echo "FAIL: Nama Nabila123 harusnya ditolak\n";
} catch (Exception $e) {
    echo "PASS: Nama Nabila123 ditolak. Error: " . $e->getMessage() . "\n";
}