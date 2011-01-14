<?php
if(! defined('CMS_CONFIGFILE_INCLUDED')){
 die('NO CONFIGFILE FOUND');
}
//utf 8 hack
header('Content-type: text/html; charset=UTF-8');
include('tpl/standard/lang/'.$cfg_cms['backend_lang'].'/lang_general.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>iSefrengo CMS | Login</title>
<link href="tpl/standard/css/login.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="favicon.ico" />
</head>
<body>
  <noscript>
  <div class="nojs">
    <p><?PHP echo $cms_lang['login_nojs']; ?></p>
  </div>
  </noscript>
<div id="wrapper">
  <div id="header">
    <h2>iSefrengo:: Login</h2>
  </div>
  <form name="login" action="<?php print $this->url() ?>" method="post" target="_top">
  <?php global $username, $doublelogin, $challengefail; if (isset($username) && !isset($doublelogin) && !isset($challengefail)): ?>
    <p class="warning"><?PHP echo $cms_lang['login_invalidlogin']; ?></p>
  <?php elseif (isset($doublelogin) && !isset($challengefail)): ?>
    <p class="warning"><?PHP echo $cms_lang['login_logininuse']; ?></p>
  <?php elseif (isset($challengefail)): ?>
    <p class="warning"><?PHP echo $cms_lang['login_challenge_fail']; ?></p>
  <?php endif ?>
  <?php global $error; if ($error=='noclient'): ?>
   <p class="warning"><?PHP echo $cms_lang['login_noclient']; ?></p>
  <?php endif ?>
  <div id="content">
    <p>
     <span class="hide"><?PHP echo $cms_lang['login_username'].": "; ?></span>
     <input name="username" type="text" value="<?php print (isset($this->auth['uname']) ? $this->auth['uname'] : '') ?>" id="username" tabindex="1" maxlength="32" />
     </p>
     <p>
     <span class="hide"><?PHP echo $cms_lang["login_password"].": "; ?></span>
     <input name="password" type="password" value="" id="password" tabindex="2" maxlength="32" />
     </p>
  <div id="navi">
  <p><?PHP echo $cms_lang['login_pleaselogin'] ?></p>
          <input type="submit" name="Submit" value="Login &raquo;" tabindex="3" />
      <input type="hidden" name="response"  value="" />
      <input type="hidden" name="area"  value="con" />
  </div>
  </div>
  </form>
  </div>
  <div class="footer">
    <p><?PHP echo $cms_lang['login_licence']; ?></p>
  </div>
<?PHP echo "\n $mysql_debug"; ?>
</body>
</html>
