<?php
if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
    $allowed = array('jpg', 'jpeg', 'png', 'gif'); // Разрешенные типы файлов
    $filename = $_FILES['image']['name'];
    $filetmp = $_FILES['image']['tmp_name'];
    $filesize = $_FILES['image']['size'];

    // Получение расширения файла
    $ext = pathinfo($filename, PATHINFO_EXTENSION);

    // Проверка, является ли расширение файла разрешенным
    if(!in_array($ext, $allowed)) {
        echo json_encode(array('status' => 'error', 'message' => 'Please select a valid file format.'));
        exit;
    }

    // Проверка размера файла (например, не более 5 МБ)
    $maxsize = 5 * 1024 * 1024;
    if($filesize > $maxsize) {
        echo json_encode(array('status' => 'error', 'message' => 'File size is larger than the allowed limit.'));
        exit;
    }

    // Перемещение файла в папку uploads
    $dest = 'uploads/' . uniqid() . '.' . $ext;
    if(move_uploaded_file($filetmp, $dest)) {
        echo json_encode(array('status' => 'success', 'url' => $dest));
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'There was an error uploading your file.'));
    }
} else {
    echo json_encode(array('status' => 'error', 'message' => 'No file uploaded or there was an error uploading the file.'));
}
?>
