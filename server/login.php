<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, TRUNCATE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, X-API_KUNCI");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(200);
  exit;
}

require_once "config.php";

function getInput() {
    return json_decode(file_get_contents("php://input"), true);
}

$developer_mode = true;  // ketik false jika ingin test autentikasi
$sandi_rahasia = bin2hex(random_bytes(16));
$headers = getallheaders();
$kunci_pengguna = $headers['X-API_KUNCI'] ?? "";

if (!$developer_mode && $kunci_pengguna !== $sandi_rahasia) {
      header("Content-Type: text/html; charset=utf-8");
        echo "<h1 style='color:red; text-align:center; margin-top:20%; font-family:sans-serif;'>
        Kenapa Buka Server Ku Dek 😠
        </h1>";
    exit();
}  

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case 'POST':
        $input = getInput();
        $aksi = $input['aksi'] ?? "";
        $name = $conn->real_escape_string($input['nama'] ?? '');
        $email = $conn->real_escape_string($input['email'] ?? '');
        $password = $conn->real_escape_string($input['password'] ?? '');

        if ($email && $password) {
        if (empty($email) && empty($password)) {
            echo json_encode([
                "status" => "Gagal",
                "pesan" => "Email Atau Password Tidak Boleh Kosong !"
            ]);
        } else {
        $query = $conn -> query( "SELECT * FROM users WHERE email = '$email' AND password = '$password' ");
        
        if (mysqli_num_rows($query) > 0) {
            echo json_encode([
                "status" => "Berhasil",
                "pesan" => "Berhasil Login !"
            ]);
        } else {
            echo json_encode([
                "status" => "Gagal",
                "pesan" => "Gagal Login !"
            ]);
        }
        exit;
    }
        }
}
?>