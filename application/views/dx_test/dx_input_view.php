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
    <div id="container">
        <div id="body">
            <div class="dx-fieldset">
                <div class="dx-field">
                    <div class="dx-field-label">User Name</div>
                    <div class="dx-field-value"><div id="login"></div></div>
                </div>
                <div class="dx-field">
                    <div class="dx-field-label">Password</div>
                    <div class="dx-field-value"><div id="password"></div></div>
                </div>
                 <div class="dx-field">
                    <div class="dx-field-label">Email</div>
                    <div class="dx-field-value"><div id="email"></div></div>
                </div>
                <div class="dx-field">
                    <div class="dx-field-label">Number</div>
                    <div class="dx-field-value"><div id="numberBox"></div></div>
                </div>
                <div class="dx-field">
                    <div class="dx-field-label">???</div>
                    <div class="dx-field-value"><div id="selectBox"></div></div>
                </div>
                <div class="dx-field">
                    <div class="dx-field-label">Color</div>
                    <div class="dx-field-value"><div id="colorBox"></div></div>
                </div>
                <div class="dx-field">
                    <div class="dx-field-label">calendar</div>
                    <div class="dx-field-value"><div id="calendar"></div></div>
                </div>
                <div class="dx-field">
                    <div class="dx-field-label">fileUploader</div>
                    <div class="dx-field-value"><div id="fileUploader"></div></div>
                </div>
                <div class="dx-field">
                    <div class="dx-field-label">Information</div>
                    <div class="dx-field-value"><div id="textArea"></div></div>
                </div>
                <div class="dx-field">
                    <div class="dx-field-label">radio-group-simple</div>
                    <div class="dx-field-value"><div id="radio-group-simple"></div></div>
                </div>
                <div class="dx-field">
                    <div class="dx-field-label">radio-group-disabled</div>
                    <div class="dx-field-value"><div id="radio-group-disabled"></div></div>
                </div>
                <div class="dx-field">
                    <div class="dx-field-label">radio-group-change-layout</div>
                    <div class="dx-field-value"><div id="radio-group-change-layout"></div></div>
                </div>
                <div class="dx-field">
                    <div class="dx-field-label">radio-group-with-template</div>
                    <div class="dx-field-value"><div id="radio-group-with-template"></div></div>
                </div>
            </div>
            <div  id="tasks-list">
                Tasks by selected priority:
                <ul id="list"></ul>
            </div>
            <div id="summary"></div>
            <div class="dx-fieldset">
                <div class="dx-field">
                    <div class="dx-field-label"></div>
                    <div class="dx-field-value"><div id="button"></div></div>
                </div>
            </div>
            <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
        </div>
    </div>
</body>
</html>