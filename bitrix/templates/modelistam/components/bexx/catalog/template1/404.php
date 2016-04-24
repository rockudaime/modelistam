<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?
//PST-9
$this->setFrameMode(true);
//PST-9
?>
<?
CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

$APPLICATION->IncludeFile('includes/404.php');

?>
