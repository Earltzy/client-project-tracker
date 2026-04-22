<?php
include "config.php";

// ADD PROJECT
if (isset($_POST['add_project'])) {
    $client_id = $_POST['client_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    if (!empty($title)) {
        $conn->query("INSERT INTO projects (client_id, title, description) 
                      VALUES ('$client_id','$title','$description')");
    } else {
        echo "Title is required!";
    }
}

// DELETE PROJECT
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM projects WHERE id='$id'");
}

// GET PROJECT DATA (EDIT)
$editData = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $editData = $conn->query("SELECT * FROM projects WHERE id='$id'")->fetch_assoc();
}

// UPDATE PROJECT
if (isset($_POST['update_project'])) {
    $id = $_POST['id'];
    $client_id = $_POST['client_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    $conn->query("UPDATE projects SET 
        client_id='$client_id',
        title='$title',
        description='$description'
        WHERE id='$id'");
}

// STATUS UPDATE
if (isset($_GET['status']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];

    $conn->query("UPDATE projects SET status='$status' WHERE id='$id'");
}
?>

<h2><?php echo $editData ? "Edit Project" : "Add Project"; ?></h2>

<form method="POST" onsubmit="return validateForm()">

    <input type="hidden" name="id" value="<?php echo $editData['id'] ?? ''; ?>">

    <select name="client_id" required>
        <option value="">Select Client</option>

        <?php
        $clients = $conn->query("SELECT * FROM clients");
        while($c = $clients->fetch_assoc()) {
            $selected = ($editData && $editData['client_id'] == $c['id']) ? "selected" : "";
            echo "<option value='".$c['id']."' $selected>".$c['name']."</option>";
        }
        ?>
    </select>

    <input type="text" name="title" placeholder="Project Title"
        value="<?php echo $editData['title'] ?? ''; ?>" required>

    <textarea name="description"><?php echo $editData['description'] ?? ''; ?></textarea>

    <button name="<?php echo $editData ? 'update_project' : 'add_project'; ?>">
        <?php echo $editData ? 'Update' : 'Add'; ?>
    </button>
</form>

<hr>

<h2>Project List</h2>

<?php
$result = $conn->query("
    SELECT projects.*, clients.name AS client_name 
    FROM projects 
    JOIN clients ON projects.client_id = clients.id
");

while($row = $result->fetch_assoc()) {
    echo "<b>".$row['title']."</b> - ".$row['client_name'];
    echo " | Status: ".$row['status']." ";

    echo "
    <a href='?edit=".$row['id']."'>Edit</a> 
    <a href='?delete=".$row['id']."' onclick='return confirm(\"Delete project?\")'>Delete</a>
    ";

    echo "<br>";

    echo "
    <a href='?id=".$row['id']."&status=pending'>Pending</a> |
    <a href='?id=".$row['id']."&status=ongoing'>Ongoing</a> |
    <a href='?id=".$row['id']."&status=completed'>Completed</a>
    ";

    echo "<br><br>";
}
?>

<script>
function validateForm() {
    let title = document.querySelector('[name="title"]').value;

    if (title === "") {
        alert("Project title is required!");
        return false;
    }
}
</script>