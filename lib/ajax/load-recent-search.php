<?php
session_start();

if (isset($_SESSION['recent_searches'])) {
    foreach ($_SESSION['recent_searches'] as $search) {
        echo '<span class="badge bg-dongker fw-semibold"><small>'.htmlspecialchars($search).'</small></span>';
    }
}
?>