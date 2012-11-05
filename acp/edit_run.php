<?php
require_once "../config/config.php";
global $currentUser;
if(!userIsAdmin() or !isset($_GET['id'])) {
  header("Location: index.php");
  die();
}
$run=new Run;
$run->fillIn($_GET['id']);
if(!$run->status)
  header("Location: ../index.php");
if(!$currentUser->ownsRun($_GET['id']))
  header("Location: ../index.php");
if(!empty($_POST)) {
  $errors=array();
  if(isset($_POST['name']) and $_POST['name']!==$run->name)
    $run->changeName($_POST['name']);
  if(!$run->status)
    $errors=array_merge($errors,$run->GetErrors());
  if($run->public==true and !isset($_POST['public']))
    $run->changePublic(false);
  elseif($run->public==false and isset($_POST['public']))
    $run->changePublic(true);
  if(!$run->status)
    $errors=array_merge($errors,$run->GetErrors());
  if($run->registered_req==true and !isset($_POST['registered']))
    $run->changeRegisteredReq(false);
  elseif($run->registered_req==false and isset($_POST['registered']))
    $run->changeRegisteredReq(true);
  if(!$run->status)
    $errors=array_merge($errors,$run->GetErrors());
}

?>
<?php
include("pre_content.php");
?>	

<p><strong><?php echo _("Editiere Studie: "); ?></strong> <?php echo $run->name; ?> <br /> 
<?php
if(!empty($_POST) and count($errors)>0) {
?>
<div id="errors">
<?php errorOutput($errors); ?>
</div>
<?php
    }
?>
<form id="edit_form" name="edit_form" method="post" action="edit_run.php?id=<?php echo $_GET['id']; ?>" >
  <p>
  <label><?php echo _("Name"); ?>
  </label>
  <input type="text" name="name" id="name" value="<?php echo $run->name; ?>"/>
  </p>
  <p>
  <label><?php echo _("Run nur f&uuml;r registrierte Benutzer verf&uuml;gbar"); ?>
  </label>
  <input type="checkbox" name="registered" id="registered" <?php if($run->registered_req==true) echo "checked";?>/>
  </p>
  <p>
  <label><?php echo _("Ver&ouml;ffentlichen"); ?>
  </label>
  <input type="checkbox" name="public" id="public" <?php if($run->public==true) echo "checked";?>/>
  </p>

  <button type="submit"><?php echo _("Absenden"); ?></button>
  </form>



<br>
  <p><a href="view_run.php?id=<?php echo $run->id; ?>"><?php echo _("Zur&uuml;ck zum Run"); ?></a></p>

<?php
include("post_content.php");
?>	