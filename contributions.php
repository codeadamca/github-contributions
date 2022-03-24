<?php

$url = $_SERVER['REQUEST_URI'];
$url = trim($url, '/');
$url = explode('/', $url);
$user = $url[1];

$url = 'https://github.com/users/'.$user.'/contributions';

$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $url);
$result = curl_exec($ch);
curl_close($ch);

$start = strpos(
    $result,
    '<div class="border py-2 graph-before-activity-overview">'
);

$end = strpos(
    $result, 
    '</svg>',
    $start
);

$html = substr(
    $result, 
    $start,
    $end - $start
).'</div></div>';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GitHub Contributions</title>

    <style>

    body {
        font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Helvetica,Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji";
        font-size: 14px;
        line-height: 1.5;
        color: #fff;
        background-color: #000;
    }
    * {
        box-sizing: border-box;
    }

    .graph-before-activity-overview {
        border-top-left-radius: 6px;
        border-top-right-radius: 6px;
        max-width: 896px;
        margin: auto;
    }
    .py-2 {
        padding-top: 8px !important;
        padding-bottom: 8px !important;
    }
    .border {
        border: 1px solid #30363d !important;
    }

    .ContributionCalendar-label {
        font-size: 9px;
        fill: #fff;
    }
    text {
        display: block;
        white-space: nowrap;
    }
    .text-center {
        text-align: center !important;
    }
    
    .ContributionCalendar-day, 
    .ContributionCalendar-day[data-level="0"] {
        fill: #161b22;
        shape-rendering: geometricPrecision;
        outline: 1px solid rgba(27, 31, 35, 0.06);
        outline-offset: -1px;
    }
    .ContributionCalendar-day[data-level="1"] {
        fill: #0e4429;
    }
    .ContributionCalendar-day[data-level="2"] {
        fill: #006d32;
    }
    .ContributionCalendar-day[data-level="3"] {
        fill: #26a641;
    }
    .ContributionCalendar-day[data-level="4"] {
        fill: #39d353;
    }

    .Link--muted {
        color: #8b949e;
    }
    a {
        color: #8b949e;
        text-decoration: none;
        background-color: transparent;
    }

    .float-left {
        float: left !important;
    }
    .float-right {
        float: right !important;
    }

    .d-flex {
        display: flex !important;
    }
    .text-center {
        text-align: center !important;
    }
    .pt-1 {
        padding-top: 4px !important;
    }

    .mx-md-2 {
        margin-right: 8px !important;
        margin-left: 8px !important;
    }
    .mx-3 {
        margin-right: 16px !important;
        margin-left: 16px !important;
    }
    .height-full {
        height: 100% !important;
    }
    .overflow-hidden {
        overflow: hidden !important;
    }

    .flex-xl-items-center {
        align-items: center !important;
    }
    .flex-items-end {
        align-items: flex-end !important;
    }
    .flex-column {
        flex-direction: column !important;
    }

    </style>

</head>
<body>

    <?php echo $html; ?>
    
</body>
</html>