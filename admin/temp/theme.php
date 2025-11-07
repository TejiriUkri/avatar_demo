<?php

require_once("../resources/Config.php");
echo $_POST['theme'];
//if (isset($_POST['theme'])) {
//    $new_theme = $_POST['theme'];
//
//    if ($new_theme === 'black' || $new_theme === 'white') {
//        $_SESSION['theme'] = $new_theme;
//
//        if (isset($_SESSION['organization']) && isset($_SESSION['ID'])) {
//            $organization = $_SESSION['organization'];
//            $user_id = $_SESSION['ID'];
//
//            $stmt = mysqli_prepare($connection, "UPDATE user SET theme = ? WHERE organization = ? ");
//            if (!$stmt) {
//                die("Prepare failed: " . mysqli_error($connection));
//            }
//
//            mysqli_stmt_bind_param($stmt, "sss", $new_theme, $organization);
//            if (!mysqli_stmt_execute($stmt)) {
//                die("Execute failed: " . mysqli_stmt_error($stmt));
//            }
//
//            mysqli_stmt_close($stmt);
//        }
//    } else {
//        echo "Invalid theme value";
//    }
//}
//
//header('Location: index.php');
//exit;
?>