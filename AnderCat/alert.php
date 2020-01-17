<?php
function alert($msg, $url) {
    echo "<script>";
    echo   "alert('" . htmlentities($msg, ENT_QUOTES) . "');";
    echo   "window.location = '" . $url . "'";
    echo "</script>";
  }
?>