<?php
include 'connect.php';

// Fetch all reports, along with flashcard and set names, and user information
$query = "SELECT r.id, r.flashcard_id, r.set_id, r.reason, f.question AS flashcard_question, s.name AS set_name, u.username, r.report_date 
          FROM reports r
          JOIN flashcards f ON r.flashcard_id = f.id
          JOIN flashcardsets s ON r.set_id = s.id
          JOIN accounts u ON r.user_id = u.id";  // Assuming there's a users table with user_id

$result = $mysqli->query($query);

if ($result) {
    // HTML to display the reports
    echo '<div class="wrapper">';
    echo '<h1>Reported Flashcards</h1>';
    echo '<table border="1">
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Flashcard ID</th>
                <th>Set ID</th>
                <th>Flashcard Question</th>
                <th>Set Name</th>
                <th>Reason</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>';

    // Display each report
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['username']}</td>
                <td>{$row['flashcard_id']}</td>
                <td>{$row['set_id']}</td>
                <td>" . htmlspecialchars(strip_tags(str_replace("Front cannot be empty.", "", $row['flashcard_question']))) . "</td>
                <td>" . htmlspecialchars($row['set_name']) . "</td>
                <td>" . htmlspecialchars($row['reason']) . "</td>
                <td>{$row['report_date']}</td>
                <td>
                    <button onclick=\"resolveReport({$row['id']})\">Resolve</button>
                    <button onclick=\"deleteFlashcard({$row['flashcard_id']})\">Delete Flashcard</button>
                </td>
              </tr>";
    }

    echo '</table></div>';
} else {
    echo "Error fetching reports: " . $mysqli->error;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Admin - Review Reports</title>
</head>
<body>
    <script>
        function resolveReport(reportId) {
            fetch('resolve_report.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ report_id: reportId })
            })
            .then(response => response.json())
            .then(result => {
                if (result.status === 'success') {
                    alert("Report marked as resolved.");
                    location.reload();
                } else {
                    alert("Error resolving report: " + result.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        function deleteFlashcard(flashcardId) {
            if (confirm("Are you sure you want to delete this flashcard?")) {
                fetch('delete_flashcard.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ flashcard_id: flashcardId })
                })
                .then(response => response.json())
                .then(result => {
                    if (result.status === 'success') {
                        alert("Flashcard deleted.");
                        location.reload();
                    } else {
                        alert("Error deleting flashcard: " + result.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
        }
    </script>
</body>
</html>
