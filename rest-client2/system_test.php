<?php
/**
 * system-test.php
 * White Box Testing untuk REST Client PHP (NewsAPI.org)
 * Terdiri dari 3 test case dengan validator try-catch
 */

// === Konfigurasi dasar ===
$api_key_valid   = "ISI_DENGAN_API_KEY_VALID";  // Ganti dengan API key valid kamu
$api_key_invalid = "KEY_SALAH_TEST";            // API key tidak valid
$base_url        = "https://newsapi.org/v2/";

// === Fungsi utama: http_request_get ===
function http_request_get($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);

    if (curl_errno($ch)) {
        throw new Exception("cURL Error: " . curl_error($ch));
    }

    curl_close($ch);
    return $output;
}

/**
 * Fungsi pengujian umum
 */
function run_test($test_name, $url, $expected_status = "ok") {
    echo "\n-----------------------------------------\n";
    echo "🔹 Running Test: $test_name\n";
    echo "URL: $url\n";

    try {
        $response = http_request_get($url);
        $data = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Invalid JSON response");
        }

        if (isset($data['status']) && $data['status'] === $expected_status) {
            echo "✅ TEST RESULT: PASS — Status = {$data['status']}\n";
        } else {
            throw new Exception("Unexpected response status: " . ($data['status'] ?? 'null'));
        }

    } catch (Exception $e) {
        echo "❌ TEST RESULT: FAIL — " . $e->getMessage() . "\n";
    }
}

// ===================================================
// === TEST CASE 1: API Key Valid (Berita Top US) ===
// ===================================================
run_test(
    "TC-001: Request dengan API Key Valid (Top Headlines US)",
    $base_url . "top-headlines?country=us&apiKey=" . $api_key_valid,
    "ok"
);

// ===================================================
// === TEST CASE 2: API Key Tidak Valid = Error ===
// ===================================================
run_test(
    "TC-002: Request dengan API Key Tidak Valid",
    $base_url . "top-headlines?country=us&apiKey=" . $api_key_invalid,
    "error"
);

// ===================================================
// === TEST CASE 3: Parameter Salah (Invalid Query) ===
// ===================================================
run_test(
    "TC-003: Parameter Salah (country=xyz)",
    $base_url . "top-headlines?country=xyz&apiKey=" . $api_key_valid,
    "error"
);

echo "\n-----------------------------------------\n";
echo "🧪 Testing Completed.\n";
?>
