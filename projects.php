<?php
include "config.php";
include "includes/header.php";

/* =====================
   ADD PROJECT
===================== */
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

/* =====================
   DELETE PROJECT
===================== */
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM projects WHERE id='$id'");
}

/* =====================
   EDIT PROJECT
===================== */
$editData = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $editData = $conn->query("SELECT * FROM projects WHERE id='$id'")->fetch_assoc();
}

/* =====================
   UPDATE PROJECT
===================== */
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

/* =====================
   STATUS UPDATE
===================== */
if (isset($_GET['status']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];

    $conn->query("UPDATE projects SET status='$status' WHERE id='$id'");
}
?>

<!-- MAIN CONTENT ONLY (NO SIDEBAR HERE) -->
<div class="flex-1">

    <!-- TITLE -->
    <h2 class="text-2xl font-bold mb-4">
        <?= $editData ? "Edit Project" : "Add Project" ?>
    </h2>

    <!-- FORM -->
    <div class="bg-white p-4 rounded shadow mb-6">

        <form method="POST" class="space-y-2">

            <input type="hidden" name="id" value="<?= $editData['id'] ?? '' ?>">

            <!-- CLIENT SELECT -->
            <select name="client_id" class="border p-2 w-full" required>
                <option value="">Select Client</option>

                <?php
                $clients = $conn->query("SELECT * FROM clients");
                while($c = $clients->fetch_assoc()) {
                    $selected = ($editData && $editData['client_id'] == $c['id']) ? "selected" : "";
                    echo "<option value='".$c['id']."' $selected>".$c['name']."</option>";
                }
                ?>
            </select>

            <input class="border p-2 w-full"
                type="text"
                name="title"
                placeholder="Project Title"
                value="<?= $editData['title'] ?? '' ?>">

            <textarea class="border p-2 w-full"
                name="description"
                placeholder="Description"><?= $editData['description'] ?? '' ?></textarea>

            <button class="bg-blue-500 text-white px-4 py-2 rounded"
                name="<?= $editData ? 'update_project' : 'add_project' ?>">
                <?= $editData ? 'Update' : 'Add' ?>
            </button>

        </form>

    </div>

    <!-- PROJECT LIST -->
    <div class="bg-white p-4 rounded shadow">

        <h2 class="text-xl font-bold mb-4">Project List</h2>

        <?php
        $result = $conn->query("
            SELECT projects.*, clients.name AS client_name 
            FROM projects 
            JOIN clients ON projects.client_id = clients.id
        ");

        while($row = $result->fetch_assoc()) {
        ?>

            <div class="border-b py-4 flex justify-between">

                <!-- LEFT -->
                <div>
                    <p class="font-semibold"><?= $row['title'] ?></p>
                    <p class="text-sm text-gray-500">
                        Client: <?= $row['client_name'] ?>
                    </p>
                    <p class="text-sm text-gray-600">
                        <?= $row['description'] ?>
                    </p>
                </div>

                <!-- RIGHT -->
                <div class="text-right">

                    <!-- STATUS BADGE -->
                    <span class="text-xs px-2 py-1 rounded
                        <?= 
                            $row['status'] == 'completed' ? 'bg-green-200' : 
                            ($row['status'] == 'ongoing' ? 'bg-blue-200' : 'bg-yellow-200')
                        ?>">
                        <?= $row['status'] ?>
                    </span>

                    <!-- ACTIONS -->
                    <div class="space-x-2 mt-2">
                        <a class="text-blue-500"
                           href="?edit=<?= $row['id'] ?>">Edit</a>

                        <a class="text-red-500"
                           href="?delete=<?= $row['id'] ?>"
                           onclick="return confirm('Delete project?')">
                           Delete
                        </a>
                    </div>

                    <!-- STATUS CHANGE -->
                    <div class="text-xs mt-2 space-x-1">
                        <a href="?id=<?= $row['id'] ?>&status=pending">Pending</a> |
                        <a href="?id=<?= $row['id'] ?>&status=ongoing">Ongoing</a> |
                        <a href="?id=<?= $row['id'] ?>&status=completed">Done</a>
                    </div>

                </div>

            </div>

        <?php } ?>

    </div>

</div>

<?php include "includes/footer.php"; ?>