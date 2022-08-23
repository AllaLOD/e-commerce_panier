<h1 class="text-center my-5">Envoyer un message</h1>

<div class="col-md-8 mx-auto">

<?php
    if(isset($_SESSION['message']))
    echo $_SESSION['message'];
?>

<?php unset($_SESSION['message']) ?>

<?php echo $formContact; ?>

</div>