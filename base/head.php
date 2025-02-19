<?php function head($title, $css){ ?>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <base href="/">
        <title><?php echo $title ?></title>
        <link rel='shortcut icon' href='assets/NxtChefLOGO.png' type='image/x-icon'>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="styles/navbar.css">
        <link rel="stylesheet" href="styles/utilities.css">
        <link rel="stylesheet" href="styles/<?php echo $css ?>.css">
    </head>
<?php } ?>