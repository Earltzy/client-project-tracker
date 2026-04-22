<?php
include "config.php";
include "includes/header.php";

/* =====================
   ADD CLIENT
===================== */
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    if (!empty($name)) {
        $conn->query("INSERT INTO clients (name,email,phone) 
                      VALUES ('$name','$email','$phone')");
    } else {
        echo "Name is required!";
    }
}

/* =====================
   DELETE CLIENT
===================== */
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM clients WHERE id='$id'");
}

/* =====================
   EDIT CLIENT
===================== */
$editData = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $editData = $conn->query("SELECT * FROM clients WHERE id='$id'")->fetch_assoc();
}

/* =====================
   UPDATE CLIENT
===================== */
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $conn->query("UPDATE clients SET 
        name='$name',
        email='$email',
        phone='$phone'
        WHERE id='$id'");
}
?>

<!-- MAIN CONTENT ONLY (NO SIDEBAR HERE) -->
<div class="flex-1">

    <h2 class="text-2xl font-bold mb-4">
        <?= $editData ? "Edit Client" : "Add Client" ?>
    </h2>

    <!-- FORM -->
    <div class="bg-white p-4 rounded shadow mb-6">

        <form method="POST" onsubmit="return validateForm()" class="space-y-2">

            <input type="hidden" name="id" value="<?= $editData['id'] ?? '' ?>">

            <input class="border p-2 w-full"
                type="text"
                name="name"
                placeholder="Client Name"
                value="<?= $editData['name'] ?? '' ?>">

            <input class="border p-2 w-full"
                type="email"
                name="email"
                placeholder="Email"
                value="<?= $editData['email'] ?? '' ?>">

            <input class="border p-2 w-full"
                type="text"
                name="phone"
                placeholder="Phone"
                value="<?= $editData['phone'] ?? '' ?>">

            <button class="bg-blue-500 text-white px-4 py-2 rounded"
                name="<?= $editData ? 'update' : 'add' ?>">
                <?= $editData ? 'Update' : 'Add' ?>
            </button>

        </form>

    </div>

    <!-- LIST -->
    <div class="bg-white p-4 rounded shadow">

        <h2 class="text-xl font-bold mb-4">Client List</h2>

        <?php
        $result = $conn->query("SELECT * FROM clients");

        while($row = $result->fetch_assoc()) {
        ?>
            <div class="flex justify-between border-b py-3">

                <div>
                    <p class="font-semibold"><?= $row['name'] ?></p>
                    <p class="text-sm text-gray-500">
                        <?= $row['email'] ?> | <?= $row['phone'] ?>
                    </p>
                </div>

                <div class="space-x-2">
                    <a class="text-blue-500"
                       href="?edit=<?= $row['id'] ?>">Edit</a>

                    <a class="text-red-500"
                       href="?delete=<?= $row['id'] ?>"
                       onclick="return confirm('Delete this client?')">
                       Delete
                    </a>
                </div>

            </div>
        <?php } ?>

    </div>

</div>

<script>
function validateForm() {
    let name = document.querySelector('[name="name"]').value;

    if (name === "") {
        alert("Name is required!");
        return false;
    }
}
</script>

<?php include "includes/footer.php"; ?>