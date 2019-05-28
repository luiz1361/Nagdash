<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once('../config.php');
require_once('../phplib/utils.php');

if (array_key_exists('nagdash_unwanted_hosts', $_COOKIE)) {
    $unwanted_hosts = unserialize($_COOKIE['nagdash_unwanted_hosts']);
} else {
    $unwanted_hosts = array();
}

if (!is_array($unwanted_hosts)) $unwanted_hosts = array();

?>
<html>
<head>
<title>Nagios Dashboard</title>
<script src="js/nagdash.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<link rel="stylesheet" href="css/blinkftw.css">
<link rel="stylesheet" href="css/main.css">

<style type="text/css">
  <?php foreach ($nagios_hosts as $host) {
        echo ".tag_{$host['tag']}   { background-color: {$host['tagcolour']} }\n";
  } ?>
</style>

</head>
<body>
  <div id="spinner"><h3><img src="images/ajax-loader.gif" align="absmiddle"> Refreshing...</h3></div>
  <div id="nagioscontainer"></div>
  <?php NagdashHelpers::render("settings_dialog.php", ["nagios_hosts" => $nagios_hosts,
                                                       "unwanted_hosts" => $unwanted_hosts]);?>


<script>
    $(document).keypress("s", function(e) {
        $("#settings_modal").modal();
    });
    $(document).ready(load_nagios_data(<?php echo ($show_refresh_spinner === true)?>));
</script>
</body>
</html>
