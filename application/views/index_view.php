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
    <?php
    // 載入helper/test_helper.php
    $this->load->helper('test');
    // 小圖
    $link = array(
        'type'  => "image/x-icon",
        'rel'   => "shortcut icon",
        'href'  => base_url()."images/joba.jpg",
        'ver'   => date('YmdHis')
    );
    echo load_html_file($link);
    // CSS
    $css_link = array();
    $css_link[] = 'css/welcome.css';
    $css_link[] = 'css/bootstrap-3.2.0-dist/css/bootstrap.min.css';
    $css_link[] = 'css/bootstrap-3.2.0-dist/css/bootstrap-theme.min.css';
    $css_link = (!empty($css)&&is_array($css)&&count($css)) ? array_merge($css_link, $css) : $css_link ;

    foreach( $css_link as $val )
    {
        if( preg_match('/^http/i', $val) )
        {
            $link = array(
                'type'  => "text/css",
                'rel'   => "stylesheet",
                'href'  => $val,
                'ver'   => ''
            );
            echo load_html_file($link);
            exit('LINE: '.__LINE__.'/'.$val);
        }
        else if( file_exists($val) )
        {
            $link = array(
                'type'  => "text/css",
                'rel'   => "stylesheet",
                'href'  => base_url().$val,
                'ver'   => ''
            );
            echo load_html_file($link);
        }
        else
        {
            print_r($val);
        }
    }

    if( !empty($css_ie) && is_array($css_ie) && count($css_ie) )
    {
        echo '<!--[if lte IE 8]>';
        foreach($css_ie as $val)
        {
            $link = array(
                'type'  => "text/css",
                'rel'   => "stylesheet",
                'href'  => $val,
                'ver'   => ''
            );
            echo load_html_file($link);
        }
        echo '<![endif]-->';
    }

    $js_link = array();
    // $js_link[] = 'js/jquery-1.11.js';
    $js_link[] = 'js/jquery-1.12.3.min.js';
    $js_link[] = 'css/bootstrap-3.2.0-dist/js/bootstrap.min.js';
    $js_link[] = 'js/welcome.js';
    $js_link = (!empty($js)&&is_array($js)&&count($js)) ? array_merge($js_link,$js) : $js_link ;

    foreach( $js_link as $val )
    {
        if( preg_match('/^http/i', $val) )
        {
            $link = array(
                'type'  => "text/javascript",
                'rel'   => "stylesheet",
                'href'  => $val,
                'ver'   => '',
            );
            echo load_html_file($link);
            exit($val);
        }
        else if( file_exists($val) )
        {
            $link = array(
                'type'  => "text/javascript",
                'rel'   => "stylesheet",
                'href'  => base_url().$val,
                'ver'   => '',
            );
            echo load_html_file($link);
        }
        else
        {
            print_r($val);
        }
    }

    echo '<!--[if (gte IE 8)&(lt IE 10)]>';
    if( !empty($js_ie) && is_array($js_ie) && count($js_ie) )
    {
        foreach($js_ie as $val)
        {
            $link = array(
                'type'  => "text/javascript",
                'rel'   => "stylesheet",
                'href'  => $val,
                'ver'   => ''
            );
            echo load_html_file($link);
        }
    }
    $link = array(
        'type'  => "text/javascript",
        'rel'   => "stylesheet",
        'href'  => 'http://html5shiv.googlecode.com/svn/trunk/html5.js',
        'ver'   => ''
    );
    echo load_html_file($link);
    echo '<![endif]-->';
    ?>
</head>
<body>
    <noscript>Your browser does not support JavaScript!</noscript>
    <div class="float_right mg1211"><?PHP if( isset($_SESSION['uid']) ): ?><a href="<?=base_url()?>login/logout">登出 <?=$_SESSION['username']?></a><?PHP endif; ?></div>
    <div id="container">
        <?PHP if( $current_page!='welcome' && $current_page!='index'): ?>
            <ol class="breadcrumb">
                <li><a href="<?=base_url()?>" title="首頁"><span>首頁</span></a></li>
                <?PHP if( $current_fun!='index' && $current_fun!=$current_page ): ?>
                <li><a href="<?=base_url()?>{current_page}" title="{current_title}"><span>{current_title}</span></a></li>
                <?PHP endif; ?>
                <li class="active">{title}</li>
            </ol>
        <?PHP endif; ?>

        <h1>{title}</h1>
        {content_div}

        <?php $this->benchmark->mark('end'); $elapsed_time = $this->benchmark->elapsed_time('start', 'end'); ?>
        <p class="footer">Page rendered in <strong><?php echo $elapsed_time; ?></strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
    </div>

    <img id="goTop" src="<?=base_url()?>css/images/icons-svg/arrow-u-black.svg">
</body>
</html>