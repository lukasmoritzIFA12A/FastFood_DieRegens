<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

echo '<script>
    localStorage.clear();
    sessionStorage.clear();
</script>';

session_destroy();

header("Location: ../startseite/startseite.php");
exit();