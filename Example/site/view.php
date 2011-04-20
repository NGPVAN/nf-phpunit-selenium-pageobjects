<?php

require_once __DIR__ . '/../PersonModel.php';

$name = isset($_POST['your_name']) ? $_POST['your_name'] : '';
$name = htmlspecialchars($name);
$gender = isset($_POST['gender']) ? $_POST['gender'] : '';

$p = new PersonModel();
$p->setRealName($name);
$p->setGender($gender);

?>
<h1 id="title">Viewing your data</h1>
<table>
    <tr>
        <th>Your Name</th>
        <td id="output_your_name"><?php echo $p->getRealName(); ?>
    </tr>
    <tr>
        <th>Your Gender</th>
        <td id="output_your_gender"><?php echo $p->getGenderString(); ?>
    </tr>
</table>