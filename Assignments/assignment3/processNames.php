<?php
session_start();

function addClearNames() {
    if (!isset($_SESSION['names'])) {
        $_SESSION['names'] = [];
    }

    if (isset($_POST['add'])) {
        $name = trim($_POST['name']);
        if (!empty($name)) {
            $parts = explode(" ", $name);
            if (count($parts) == 2) {
                $formattedName = $parts[1] . ", " . $parts[0];
                array_push($_SESSION['names'], $formattedName);
                sort($_SESSION['names']);
            }
        }
    } elseif (isset($_POST['clear'])) {
        $_SESSION['names'] = [];
    }

    return implode("\n", $_SESSION['names']);
}
