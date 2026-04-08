<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "initialFile.php";

// HANDLE REQUEST FIRST (BEFORE ANY HTML)
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $result = $conn->query("SELECT * FROM files ORDER BY id DESC LIMIT 1");

    if ($result && $result->num_rows > 0) {

        $row = $result->fetch_assoc();

        // 👉 REQUEST ACCESS
        if (isset($_POST['request'])) {

            $file_id = $row['id'];
            $conn->query("INSERT INTO requests (file_id, status) VALUES ($file_id, 'Pending')");

            // IMPORTANT: stop before HTML output
            echo "<script>alert('Request sent to owner'); window.location='download.php';</script>";
            exit();
        }

        // 👉 DOWNLOAD FILE
        if (isset($_POST['download'])) {

            $pass = $_POST['passcode'];

            if (trim($pass) == trim($row['passcode'])) {
                $check = $conn->query("SELECT * FROM requests
                WHERE file_id = {$row['id']} AND status ='Approved'");

                if (strtotime($row['expiry_time']) > time() || $check->num_rows > 0) {

                    $file = $row['filepath'];

                    if (!file_exists($file)) {
                        echo "<script>alert('File not found'); window.location='download.php';</script>";
                        exit();
                    }

                    // 🔥 VERY IMPORTANT: CLEAR OUTPUT BUFFER
                    while (ob_get_level()) {
                        ob_end_clean();
                    }

                    // 🔽 FORCE DOWNLOAD
                    header("Content-Description: File Transfer");
                    header("Content-Type: application/octet-stream");
                    header("Content-Disposition: attachment; filename=\"" . basename($file) . "\"");
                    header("Content-Transfer-Encoding: binary");
                    header("Content-Length: " . filesize($file));
                    header("Cache-Control: no-cache");
                    header("Pragma: public");
                    header("Expires: 0");

                    readfile($file);
                    exit();

                } else {
                    echo "<script>alert('File expired! Please request access'); window.location='download.php';</script>";
                    exit();
                }

            } else {
                echo "<script>alert('Wrong passcode'); window.location='download.php';</script>";
                exit();
            }
        }

    } else {
        echo "<script>alert('No file found'); window.location='download.php';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Download File</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/app.css">
</head>

<body>

<?php include 'navbar.php'; ?>

<div class="container d-flex justify-content-center align-items-center" style="height:90vh;">

    <div class="card p-4 shadow-lg" style="width: 400px; border-radius:15px;">

        <h4 class="text-center mb-3">🔐 Download File</h4>

        <form method="POST">

            <input type="password" name="passcode" class="form-control mb-3" placeholder="Enter Passcode" required>

            <button type="submit" name="download" class="btn btn-primary w-100">
                Download
            </button>

            <button type="submit" name="request" class="btn btn-warning w-100 mt-2">
                Request Access
            </button>

        </form>

   <div class="alert alert-info mt-3 text-center">
    📱On mobile, check your Downloads folder after downloading.

        </div>     

    </div>

</div>

</body>
</html>
