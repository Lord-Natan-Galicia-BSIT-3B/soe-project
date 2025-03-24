<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    <link rel="stylesheet" href="assets/css/Pages.css"> 
</head>
<body>
    <div class="pages-management-container"> 
        <h1>Reports</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Date Reported</th>
                    <th>Room</th>
                    <th>Report</th>
                    <th>Resolved Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Sample data, replace with database query
                $reports = [
                    ["date" => "11/05/2024", "room" => "SANDBOX", "report" => "Air conditioning failure in Room EDTECH LAB", "resolved" => "12/13/2024 at 11:00 am"],
                    ["date" => "11/05/2024", "room" => "SANDBOX", "report" => "Water leakage in Room SANDBOX", "resolved" => "12/13/2024 at 11:00 am"]
                ];
                
                foreach ($reports as $report) {
                    echo "<tr>
                        <td>{$report['date']}</td>
                        <td>{$report['room']}</td>
                        <td>{$report['report']}</td>
                        <td>{$report['resolved']}</td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
