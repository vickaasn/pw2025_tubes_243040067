<?php
if (isset($success_msg)) {
    foreach ($success_msg as $msg) {
        echo '<script>swal("Berhasil", "' . $msg . '", "success");</script>';
    }
}
if (isset($warning_msg)) {
    foreach ($warning_msg as $msg) {
        echo '<script>swal("Peringatan", "' . $msg . '", "warning");</script>';
    }
}
if (isset($info_msg)) {
    foreach ($info_msg as $msg) {
        echo '<script>swal("Info", "' . $msg . '", "info");</script>';
    }
}
if (isset($error_msg)) {
    foreach ($error_msg as $msg) {
        echo '<script>swal("Error", "' . $msg . '", "error");</script>';
    }
}
