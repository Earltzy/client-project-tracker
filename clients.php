<?php
include "config.php";

// ADD CLIENT
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

// DELETE CLIENT
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM clients WHERE id='$id'");
}

// GET CLIENT DATA FOR EDIT
$editData = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $editData = $conn->query("SELECT * FROM clients WHERE id='$id'")->fetch_assoc();
}

// UPDATE CLIENT
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

<h2><?php echo $editData ? "Edit Client" : "Add Client"; ?></h2>

<form method="POST" onsubmit="return validateForm()">
    <input type="hidden" name="id" value="<?php echo $editData['id'] ?? ''; ?>">

    <input type="text" name="name" placeholder="Client Name"
        value="<?php echo $editData['name'] ?? ''; ?>" required>

    <input type="email" name="email" placeholder="Email"
        value="<?php echo $editData['email'] ?? ''; ?>">

    <input type="text" name="phone" placeholder="Phone"
        value="<?php echo $editData['phone'] ?? ''; ?>">

    <button name="<?php echo $editData ? 'update' : 'add'; ?>">
        <?php echo $editData ? 'Update' : 'Add'; ?>
    </button>
</form>

<hr>

<h2>Client List</h2>

<?php
$result = $conn->query("SELECT * FROM clients");

while($row = $result->fetch_assoc()) {
    echo "<b>".$row['name']."</b> - ".$row['email'];

    echo " 
    <a href='?edit=".$row['id']."'>Edit</a> 
    <a href='?delete=".$row['id']."' onclick='return confirm(\"Delete this client?\")'>Delete</a>
    ";

    echo "<br><br>";
}
?>

<script>
function validateForm() {
    let name = document.querySelector('[name="name"]').value;

    if (name === "") {
        alert("Name is required!");
        return false;
    }
}
</script>