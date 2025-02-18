<?php
$title = "Hello world!";
$days = 288;
$message = "Все возвращаются на работу!";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $title; ?></title>
</head>

<body>
  <p><?php echo $title; ?></p>
  <p><?php echo $days . " " . $message; ?></p>
  <p><?php print "$title"; ?></p>
</body>

</html>