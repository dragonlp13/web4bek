<?php
header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    print("hi");
    if (!empty($_GET['save'])) {
        print('Спасибо, результаты сохранены.');
    }
    include('form.php');
    exit();
}

$errors = FALSE;
if (empty($_POST['fio'])) {
    print('Заполните имя.<br/>');
    $errors = TRUE;
}

if (empty($_POST['email'])) {
    print('Заполните email.<br/>');
    $errors = TRUE;
} else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    print('Email введен некорректно.<br/>');
    $errors = TRUE;
}

if ($errors) {
    exit();
}

$user = 'u40079';
$pass = '76898768';
$abil= implode(",",$_POST['abilities']);


try {
    $db = new PDO('mysql:host=localhost;dbname=u40071', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
    $stmt = $db->prepare("INSERT INTO form SET fio = ?, email = ?, year = ?, sex = ?, limbs = ?, bio = ?, accept = ?");
    $stmt -> execute([$_POST['fio'], $_POST['email'], $_POST['year'], $_POST['sex'], $_POST['limbs'], $_POST['text'], $_POST['accept']]);
    $id_user = $db->lastInsertId();

    $stmt1 = $db->prepare("INSERT INTO abilities SET id = ?, abil = ?");
    $stmt1 -> execute([$id_user, $abil]);
}

catch(PDOException $e) {
    print('Error : ' . $e->getMessage());
    exit();
}
?>
