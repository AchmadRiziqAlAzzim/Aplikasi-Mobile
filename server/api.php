<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, TRUNCATE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(200);
  exit;
}

require_once "config.php";

function getInput() {
    return json_decode(file_get_contents("php://input"), true);
}
     
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case 'GET':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $result = $conn->query("SELECT * FROM users WHERE id = $id");
            $data = $result->fetch_assoc();
            echo json_encode($data);
        } else {
            $result = $conn->query("SELECT * FROM users ORDER BY id ASC");
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            echo json_encode($data);
        }
        break;

    case 'POST':
        $input = getInput();
        $aksi = $input['aksi'] ?? "";
        $name = $conn->real_escape_string($input['nama'] ?? '');
        $email = $conn->real_escape_string($input['email'] ?? '');
        $password = $conn->real_escape_string($input['password'] ?? '');

        if ($name && $email) {
            $conn->query("INSERT INTO users (nama, email, password) VALUES ('$name', '$email', '$password')");
            echo json_encode(["message" => "Data berhasil ditambahkan"]);
        } else {
            echo json_encode(["error" => "Nama dan email wajib diisi"]);
        }
        break;

    case 'PUT':
        if (!isset($_GET['id'])) {
            echo json_encode(["error" => "ID wajib disertakan"]);
            break;
        }

        $id = intval($_GET['id']);
        $input = getInput();
        $name = $conn->real_escape_string($input['nama'] ?? '');
        $email = $conn->real_escape_string($input['email'] ?? '');
        $password = $conn->real_escape_string($input['password'] ?? '');

        $conn->query("UPDATE users SET nama='$name', email='$email', password='$password' WHERE id=$id");
        echo json_encode(["message" => "Data berhasil diupdate"]);
        break;

    case 'DELETE':
        if (!isset($_GET['id'])) {
            echo json_encode(["error" => "ID wajib disertakan"]);
            break;
        }

        $id = intval($_GET['id']);
        $conn->query("DELETE FROM users WHERE id=$id");
        echo json_encode(["message" => "Data berhasil dihapus"]);
        break;

          default:
        echo json_encode(["error" => "Metode tidak didukung"]);
        break;

     case 'TRUNCATE':
        if ($conn -> query("TRUNCATE TABLE users")) {
            echo json_encode(["Berhasil" => "Semua Data Berhasil Di Hapus"]);
            break;
        }
    }
?>