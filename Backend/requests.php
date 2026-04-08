<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "initialFile.php";

// 👉 APPROVE REQUEST + ADD 10 MIN EXPIRY
if (isset($_GET['approve'])) {

    $id = $_GET['approve'];

    // Get file_id from request
    $res = $conn->query("SELECT file_id FROM requests WHERE id=$id");

    if ($res && $res->num_rows > 0) {

        $row = $res->fetch_assoc();
        $file_id = $row['file_id'];

        // 🔥 Add 10 minutes expiry
        $new_expiry = date("Y-m-d H:i:s", strtotime("+10 minutes"));

        // Update request status
        $conn->query("UPDATE requests SET status='Approved' WHERE id=$id");

        // Update file expiry time
        $conn->query("UPDATE files SET expiry_time='$new_expiry' WHERE id=$file_id");

        echo "<script>alert('Approved! Access given for 10 minutes'); window.location='requests.php';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Requests</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/app.css">
</head>

<body style="background: linear-gradient(135deg, #dbeafe, #e0f2fe); min-height:100vh;">

<?php include 'navbar.php'; ?>

<div class="container mt-5">

    <h3 class="mb-4 text-center" style="font-weight:600; color:#1e3a8a;">
        📩 Access Requests
    </h3>

    <div class="card p-4 shadow-lg" 
         style="border-radius:15px; background: rgba(255,255,255,0.85); backdrop-filter: blur(10px);">

        <table class="table table-hover">

            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>File ID</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

            <?php
            $result = $conn->query("SELECT * FROM requests ORDER BY id DESC");

            if ($result && $result->num_rows > 0) {

                while ($row = $result->fetch_assoc()) {
            ?>

                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['file_id']; ?></td>

                    <td>
                        <?php if ($row['status'] == 'Approved') { ?>
                            <span class="badge bg-success">Approved</span>
                        <?php } else { ?>
                            <span class="badge bg-warning text-dark">Pending</span>
                        <?php } ?>
                    </td>

                    <td>
                        <?php if ($row['status'] != 'Approved') { ?>
                            <a href="requests.php?approve=<?php echo $row['id']; ?>" 
                               class="btn btn-sm"
                               style="background: linear-gradient(135deg,#34d399,#10b981); color:white; border:none;">
                               Approve
                            </a>
                        <?php } else { ?>
                            <span class="text-muted">No Action</span>
                        <?php } ?>
                    </td>
                </tr>

            <?php
                }
            } else {
                echo "<tr><td colspan='4' class='text-center'>No requests found</td></tr>";
            }
            ?>

            </tbody>

        </table>

    </div>

</div>

</body>
</html>
