<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"><!--HTML5-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="{title}">
    <meta name="description" content="{title}">
    <meta property="og:image" content="<?=base_url()?>images/joba.jpg">
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta http-equiv="x-frame-options" content="SAMEORIGIN" value="SAMEORIGIN">
    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->

    <title>{title}</title>
    {css}<link rel="stylesheet" type="text/css" href="{href}">{/css}
    {js}<script type="text/javascript" src="{src}"></script>{/js}
</head>
<body>
    <div class="breadcrumb">
        <a href="<?=base_url()?>" title="首頁"><span>首頁</span></a>
        <?PHP if( $current_fun!='index' && $current_fun!=$current_page ): ?>&nbsp;>&nbsp;<a href="<?=base_url()?>{current_page}" title="{current_title}"><span>{current_title}</span></a><?PHP endif; ?>
        &nbsp;>&nbsp;{title}
    </div>
    <div id="gridContainer" style="width:100%;"></div>
</body>
</html>