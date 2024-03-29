<?php

if(isset($_GET['test'])) $user = 'codeadamca';
else
{

    $url = $_SERVER['REQUEST_URI'];
    $url = trim($url, '/');
    $url = explode('/', $url);
    $user = $url[1];

}

if($user == 'blank')
{
    $html = '<h1>enter a <span>github username</span></h1>';
}
else
{

    $url = 'https://github.com/users/'.$user.'/contributions';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    $result = curl_exec($ch);
    curl_close($ch);

    if($result == 'Not Found')
    {
        $html = '<h1>github user <span>'.$user.'</span> not found</h1>';
    }
    else
    {

        $start = strpos(
            $result,
            // '<div class="border py-2 graph-before-activity-overview">'
            '<tbody'
        );

        $end = strpos(
            $result, 
            '</tbody>',
            $start
        );

        $html = '<div class="border py-2 graph-before-activity-overview">
            <div><table>'.substr(
            $result, 
            $start,
            $end - $start
        ).'</table></div><div>
            '.($_SERVER['HTTP_REFERER'] != 'https://pages.codeadam.ca/github-contributions/' ? 
                '<a href="https://pages.codeadam.ca/github-contributions/" id="contributions-link" target="_top">
                    <img src="https://codeadam.ca/images/code-block-white.png" width="30">
                </a>' : '' ).'
            </div>
        </div>';

        /*
        $html = str_replace(
            '<svg width="823" height="128" class="js-calendar-graph-svg">',
            '<svg width="100%" viewBox="0 0 823 115" class="js-calendar-graph-svg">',
            $html
        );
        */

        while(preg_match_all('#(<span.*?>)(.*?)(</span>)#', $html)) {  
            $html = preg_replace('#(<span.*?>)(.*?)(</span>)#', '', $html);
        }

        $html = str_replace('translate(15, 20)', '', $html);

    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-8NNGHFBY58"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-8NNGHFBY58');
    </script>

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="https://fonts.googleapis.com/css?family=Lora" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=PT+Sans+Narrow" rel="stylesheet">

  <title>GitHub Contributions | Adam Thomas</title>

    <style>

    h1 {
        text-align: center;
        padding: 40px;
        font-weight: normal;
        font-size: 14px;
    }
    h1 span {
        color: #3AD353;
    }

    html, body {
        background-color: transparent !important;
        overflow: hidden;
        margin: 0 4px;
        padding: 0;
    }

    * {
        box-sizing: border-box;
    }

    body {
        font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Helvetica,Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji";
        font-size: 14px;
        line-height: 1.5;
        color: #fff;
    }


    /*

    body > div > div {
        cursor: pointer;
    }

    #contributions-link {
        display: block;
        text-align: center;
        margin-top: 3px;
    }

    svg {
        display: block;
    }

    .ContributionCalendar-label {
        font-size: 9px;
        fill: #fff; 
    }
    text {
        display: none;
        white-space: nowrap;
    }
    .text-center {
        text-align: center !important;
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
    */

    .graph-before-activity-overview {
        border-radius: 6px;
        max-width: 896px;
        margin: auto;
        background-color: #000;
    }
    .py-2 {
        padding-top: 12px !important;
        padding-bottom: 8px !important;
    }
    .border {
        border: 1px solid #30363d !important;
    }
    
    .ContributionCalendar-day, 
    .ContributionCalendar-day[data-level="0"] {
        fill: #161b22;
        shape-rendering: geometricPrecision;
        outline: 1px solid rgba(27, 31, 35, 0.06);
        outline-offset: -1px;
    }
    .ContributionCalendar-day[data-level="1"] {
        background-color: #0e4429;
    }
    .ContributionCalendar-day[data-level="2"] {
        background-color: #006d32;
    }
    .ContributionCalendar-day[data-level="3"] {
        background-color: #26a641;
    }
    .ContributionCalendar-day[data-level="4"] {
        background-color: #39d353;
    }

    table {
        margin: 0 auto 10px;
    }

    tr td:first-child {
        display: none;
    }

    a {
        display: block;
        text-align: center !important;
    }

    </style>

</head>
<body>

    <?php echo $html; ?>

    <script>

    window.addEventListener('load', (event) => {

        document.getElementsByClassName('js-calendar-graph')[0].addEventListener('click', (event) => {
            top.location.href = "https://github.com/<?php echo $user; ?>";
        });


        // console.log('<?php echo $user; ?>');
        // console.log('<?php echo $_SERVER['HTTP_REFERER']; ?>');

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // console.log(this.responseText);
            }
        };
        
        xhr.open("POST", "https://console.codeadam.ca/api/contributions/store", true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send("github=<?php echo urlencode( $user ); ?>&referer=<?php echo urlencode($_SERVER['HTTP_REFERER']); ?>");

    });

    </script>

</body>
</html>