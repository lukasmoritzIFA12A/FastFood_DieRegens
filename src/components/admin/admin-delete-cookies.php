<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

echo '<script>
    localStorage.clear();
    sessionStorage.clear();
</script>';

setcookie("cookie_name", "", time() - 3600, "/");
session_unset();
session_destroy();

header("Location: ../startseite/startseite.php");
exit();