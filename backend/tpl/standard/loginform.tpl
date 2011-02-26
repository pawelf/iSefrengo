<?php
if(! defined('CMS_CONFIGFILE_INCLUDED')){die('NO CONFIGFILE FOUND');}
//utf 8 hack  Is there a need for this hack?
header('Content-type: text/html; charset=UTF-8');
include('tpl/standard/lang/'.$cfg_cms['backend_lang'].'/lang_general.php');
?>
<!DOCTYPE html>
<html lang="<?php echo $cfg_cms['backend_lang']; ?>">
<head>
<meta charset="utf-8">
<title>iSefrengo CMS | Login</title>
<link href="tpl/standard/css/login.css" rel="stylesheet" type="text/css">
<link rel="shortcut icon" href="favicon.ico">
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
    <p class="profile">
     <span><?PHP echo $cms_lang['login_username'].": "; ?></span>
     <input name="username" type="text" value="<?php print (isset($this->auth['uname']) ? $this->auth['uname'] : '') ?>" id="username" tabindex="1" maxlength="32" placeholder="<?PHP echo $cms_lang['login_username'] ?>" required>
     </p>
     <p class="unlock">
     <span><?PHP echo $cms_lang["login_password"].": "; ?></span>
     <input name="password" type="password" value="" id="password" tabindex="2" maxlength="32" placeholder="<?PHP echo $cms_lang["login_password"] ?>" required>
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
