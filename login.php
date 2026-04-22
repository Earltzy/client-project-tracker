<?php
session_start();
include "config.php";

$error = "";

/* =====================
   LOGIN PROCESS
===================== */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = md5($_POST['password']); // (we keep your current setup)

    $result = $conn->query("SELECT * FROM users 
                            WHERE username='$username' 
                            AND password='$password'");

    if ($result->num_rows > 0) {
        $_SESSION['user'] = $username;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!-- TAILWIND -->
<script src="https://cdn.tailwindcss.com"></script>

<div class="min-h-screen flex items-center justify-center bg-gray-100">

    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">

        <!-- TITLE -->
        <h2 class="text-2xl font-bold text-center mb-6">
            Admin Login
        </h2>

        <!-- ERROR MESSAGE -->
        <?php if ($error != "") { ?>
            <div class="bg-red-100 text-red-600 p-2 mb-4 rounded text-sm text-center">
                <?= $error ?>
            </div>
        <?php } ?>

        <!-- FORM -->
        <form method="POST" class="space-y-4">

            <input
                type="text"
                name="username"
                placeholder="Username"
                class="w-full border p-3 rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
                required>

            <input
                type="password"
                name="password"
                placeholder="Password"
                class="w-full border p-3 rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
                required>

            <button
                type="submit"
                class="w-full bg-blue-500 hover:bg-blue-600 text-white py-3 rounded font-semibold">
                Login
            </button>

        </form>

    </div>

</div>