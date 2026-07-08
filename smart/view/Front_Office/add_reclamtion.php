<?php
    require_once '../../Controller/reclamationC.php';
    $reclamation = new Reclamation($_GET['description']);
    $reclamationC = new ReclamationC();
    $reclamationC->addReclamation($reclamation);
    echo "<script>alert('Reclamation sent successfully!');window.location.href='contact.php';</script>";
?>