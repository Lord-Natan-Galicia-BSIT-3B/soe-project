<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/Pages.css"> <!-- Make sure this matches your actual design -->
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1 {
            color: #1a237e;
            font-size: 24px;
        }

        .tabs {
            margin-top: 20px;
            margin-bottom: 20px;
            padding-left: 10px;
        }


        .tabs a {
            padding: 13px;
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }

        .tabs a.active {
            color: #1a237e;
            font-weight: bold;
            border-bottom: 2px solid #1a237e;
        }

        .tab-link {
            padding: 10px 15px;
            text-decoration: none;
            color: #333;
            font-weight: 500;
            border-bottom: 2px solid transparent;
        }

        .tab-link.active {
            font-weight: bold;
            color: #1a237e;
            border-bottom: 2px solid #1a237e;
        }


        .search-filter {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 65px;
        }

        .search-filter input {
            padding: 8px;
            width: 250px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .filter-controls {
            display: flex;
            gap: 10px;
            /* space between filter and print button */
        }

        .filter-button {
            padding: 8px 16px;
            background-color: #e0e0e0;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table thead th {
            text-align: left;
            padding: 12px;
            background-color: #f0f0f0;
        }

        .table tbody td {
            padding: 12px;
            border-top: 1px solid #ddd;
        }

        .print-button {
            float: right;
            margin-right: 10px;
        }

        .checkbox-cell {
            width: 40px;
        }
    </style>
</head>

<body>
    <div class="pages-management-container">
        <h1>Reports</h1>
        <div class="search-filter">
            <div class="left-controls">
                <input type="text" placeholder="Search">
                <button class="filter-button">Filters</button>
            </div>
            <button class="filter-button print-button">🖨️</button>
        </div>

        <div class="tabs">
    <ul class="nav nav-tabs tabs">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#report-logs">Report Logs</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#room-usage">Report Usage</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#reservation-report">Reservation Report</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#maintenance-report">Maintenance Report</a>
        </li>
    </ul>
</div>

<div class="tab-content mt-3">

    <!-- ✅ ACTIVE TAB CONTENT -->
    <div class="tab-pane fade show active" id="report-logs">
        <table class="table">
            <thead>
                <tr>
                    <th class="checkbox-cell"></th>
                    <th>Date Reported</th>
                    <th>Room</th>
                    <th>Report</th>
                    <th>Resolved Date</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $reports = [
                    ["date" => "11/05/2024", "room" => "SANDBOX", "report" => "Air conditioning failure in Room EDTECH LAB", "resolved" => "12/13/2024 at 11:00 am"],
                    ["date" => "11/05/2024", "room" => "SANDBOX", "report" => "Water leakage in Room SANDBOX", "resolved" => "12/13/2024 at 11:00 am"],
                    ["date" => "11/05/2024", "room" => "SANDBOX", "report" => "Water leakage in Room SANDBOX", "resolved" => "12/13/2024 at 11:00 am"],
                    ["date" => "11/05/2024", "room" => "SANDBOX", "report" => "Water leakage in Room SANDBOX", "resolved" => "12/13/2024 at 11:00 am"]
                ];

                foreach ($reports as $report) {
                    echo "<tr>
                        <td><input type='checkbox'></td>
                        <td>{$report['date']}</td>
                        <td>{$report['room']}</td>
                        <td>{$report['report']}</td>
                        <td>{$report['resolved']}</td>
                        <td>{$report['date']}</td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="tab-pane fade" id="room-usage">
    <table class="table">
            <thead>
                <tr>
                    <th class="checkbox-cell"></th>
                    <th>Room Name</th>
                    <th>Time and Date</th>
                    <th>Reserved By</th>
                    <th>Purpose Of Use</th>
                    <th>Frequency Of Use</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $reports = [
                    ["date" => "11/05/2024", "room" => "SANDBOX", "report" => "Air conditioning failure in Room EDTECH LAB", "resolved" => "12/13/2024 at 11:00 am"],
                    ["date" => "11/05/2024", "room" => "SANDBOX", "report" => "Water leakage in Room SANDBOX", "resolved" => "12/13/2024 at 11:00 am"],
                    ["date" => "11/05/2024", "room" => "SANDBOX", "report" => "Water leakage in Room SANDBOX", "resolved" => "12/13/2024 at 11:00 am"],
                    ["date" => "11/05/2024", "room" => "SANDBOX", "report" => "Water leakage in Room SANDBOX", "resolved" => "12/13/2024 at 11:00 am"]
                ];

                foreach ($reports as $report) {
                    echo "<tr>
                        <td><input type='checkbox'></td>
                        <td>{$report['date']}</td>
                        <td>{$report['room']}</td>
                        <td>{$report['report']}</td>
                        <td>{$report['resolved']}</td>
                        <td>{$report['date']}</td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="tab-pane fade" id="reservation-report">
        <p>Reservation report content here.</p>
    </div>

    <div class="tab-pane fade" id="maintenance-report">
        <table class="table">
            <thead>
                <tr>
                    <th class="checkbox-cell"></th>
                    <th>Date Reported</th>
                    <th>Room</th>
                    <th>Report</th>
                    <th>Resolved Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($reports as $report) {
                    echo "<tr>
                        <td><input type='checkbox'></td>
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
</div>


    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>