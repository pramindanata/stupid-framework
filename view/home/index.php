<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Test</title>
  <link rel="stylesheet" href="<?php echo asset('/css/app.css') ?>">
</head>
<body>
  <h1>Hi <?php echo user('username') ?></h1>

  <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt corporis provident, velit pariatur harum ut rem saepe temporibus reprehenderit dicta! Dicta quibusdam sunt blanditiis officia soluta tempora, perferendis culpa ut!</p>

  <?php part('component.logout') ?>

  <script src="<?php echo asset('/js/app.js') ?>"></script>
</body>
</html>
