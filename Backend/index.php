<!DOCTYPE html>
<html>

<head>
    <title>SecureShare</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/app.css">
</head>

<body>

<?php include 'navbar.php'; ?>

<div class="container-fluid">
    <div class="row">

        <!-- 🔵 SIDEBAR -->
        <div class="col-md-3 p-4" style="height:100vh; background: rgba(255,255,255,0.5); backdrop-filter: blur(10px);">

            <h5 class="mb-4">⚙️ Settings</h5>
            <form id="uploadForm" method="POST" action="finalUpload.php" enctype="multipart/form-data">


                <input type="password" name="passcode" class="form-control mb-3" placeholder="Set Passcode" required>

                <select name="expiry" class="form-control mb-3" required>
                    <option value="">Select Expiry</option>
                    <option value="1">1 min</option>
                    <option value="5">5 min</option>
                    <option value="10">10 min</option>
                    <option value="30">30 min</option>
                </select>

                <button type="submit" class="btn btn-primary w-100">
                    ⬆ Upload File
                </button>

            </form>

        </div>

        <!-- 🔷 CENTER CONTENT -->
        <div class="col-md-9 d-flex flex-column justify-content-center align-items-center" style="height:100vh;">

            <!-- 🌟 TITLE -->
            <h1 style="
                font-size: 48px;
                font-weight: 800;
                background: linear-gradient(135deg,#6366f1,#3b82f6);
                -webkit-background-clip: text;
                color: transparent;
                margin-bottom: 30px;
            ">
                SecureShare
            </h1>

            <!-- 📦 UPLOAD BOX -->
             <div id="uploadBox" style="
    border: 2px dashed #93c5fd;
    padding: 50px;
    border-radius: 20px;
    background: rgba(255,255,255,0.5);
    backdrop-filter: blur(10px);
    text-align: center;
    width: 300px;
    cursor: pointer;
    transition: 0.3s;
"
onclick="document.getElementById('fileInput').click()"
>

    <p id="uploadText" style="font-weight:600; color:#1e3a8a;">
        📂 Click to Upload File
    </p>

    <!-- hidden input -->
    <input type="file" id="fileInput" name="file" form="uploadForm" style="display:none;" required>

</div>
        </div>

    </div>
</div>

<!-- hidden form (important) -->
<form id="uploadForm" method="POST" action="finalUpload.php" enctype="multipart/form-data"></form>
<script>
document.getElementById("fileInput").addEventListener("change", function() {

    let fileName = this.files[0]?.name;

    if (fileName) {
        document.getElementById("uploadText").innerHTML =
            "✅ " + fileName;
    }
});
</script>

</body>
</html>
