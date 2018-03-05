<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= wp_title(); ?></title>
</head>
<body>
    <header>
        <h1 class="dinet_page_title">Di'Net
            <span class="dinet_citation"><?= ( new Dinet\Monitoring\Citation() )->getCitation() ?></span>
        </h1>
    </header>
