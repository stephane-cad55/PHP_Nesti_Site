<script src="<?= BASE_URL ?>public/js/jquery-3.6.0.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<?php if ($loc == 'users') : ?>
    <script src="<?= BASE_URL ?>public/js/addUsers.js"></script>
<?php endif; ?>

<?php if ($loc == 'recipes') : ?>
    <script src="<?= BASE_URL ?>public/js/recipes.js"></script>
<?php endif; ?>

</body>

</html>