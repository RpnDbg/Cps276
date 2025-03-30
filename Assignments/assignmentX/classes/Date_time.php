<?php
require_once 'PdoMethods.php';

class Date_time extends PdoMethods {

    public function checkSubmit() {
        if (isset($_POST['addNote'])) {
            $dateTime = $_POST['dateTime'] ?? '';
            $note = trim($_POST['note']) ?? '';

            if (empty($dateTime) || empty($note)) {
                return "<p class='text-danger'>You must enter a date, time, and note.</p>";
            }

            $timestamp = date("Y-m-d H:i:s", strtotime($dateTime));
            $sql = "INSERT INTO note (date_time, note) VALUES (:date_time, :note)";
            $bindings = [
                [':date_time', $timestamp],
                [':note', $note]
            ];

            $result = $this->otherBinded($sql, $bindings);
            return ($result === "error") ? "<p class='text-danger'>Error adding note.</p>" : "<p class='text-success'>Note added successfully.</p>";
        }

        if (isset($_POST['getNotes'])) {
            $begDate = $_POST['begDate'] ?? '';
            $endDate = $_POST['endDate'] ?? '';

            if (empty($begDate) || empty($endDate)) {
                return "<p class='text-danger'>Please select both beginning and ending dates.</p>";
            }

            $begDate .= " 00:00:00";
            $endDate .= " 23:59:59";

            $sql = "SELECT date_time, note FROM note WHERE date_time BETWEEN :begDate AND :endDate ORDER BY date_time DESC";
            $bindings = [
                [':begDate', $begDate],
                [':endDate', $endDate]
            ];

            $records = $this->selectBinded($sql, $bindings);

            if (empty($records)) return "<p class='text-warning'>No notes found in this date range.</p>";

            $output = "<table class='table'><thead><tr><th>Date and Time</th><th>Note</th></tr></thead><tbody>";
            foreach ($records as $row) {
                $date = date("n/j/Y h:i a", strtotime($row['date_time']));
                $output .= "<tr><td>{$date}</td><td>{$row['note']}</td></tr>";
            }
            $output .= "</tbody></table>";
            return $output;
        }
    }
}
