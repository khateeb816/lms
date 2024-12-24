<?php include './includes/header.php'; ?>
<?php include './includes/sidebar.php'; ?>
<?php include '../../db.php'; ?>

<?php
$user_id = $_SESSION['id'];

$sql = $conn->query("SELECT * FROM `courses`");
$courses = [];
while ($row = $sql->fetch_assoc()) {
    $teachers = explode(',', $row['teacher_id']);
    if (in_array($user_id, $teachers)) {
        $courses[] = $row;
    }
}
?>

<div class="container-fluid">
    <h2>Courses</h2>
    <table id="courseTable" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>S No.</th>
                <th>Title</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sNo = 1;
            foreach ($courses as $course) {
                echo "
                    <tr>
                        <td>{$sNo}</td>
                        <td>" . htmlspecialchars($course['title'], ENT_QUOTES, 'UTF-8') . "</td>
                        <td>" . htmlspecialchars($course['description'], ENT_QUOTES, 'UTF-8') . "</td>
                    </tr>";
                $sNo++;
            }
            ?>
        </tbody>
    </table>
</div>

<script>
    new DataTable('#courseTable');
</script>

<?php include './includes/footer.php'; ?>