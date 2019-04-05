<?php
session_start();
$db_host = "localhost";
$db_user = "jontnsui_personaluser";
$db_pass = "%rDgmHi?L[-I";
$db_name = "jontnsui_personal";
$conn = mysqli_connect($db_host,$db_user,$db_pass,$db_name);

define('BASEPATH',dirname(__FILE__).'/../'); //defining global constants 
define('BASEURL','http://jonthanks.com/2019/');

require_once(BASEPATH.'core/model/Model.php');
require_once(BASEPATH.'core/model/GalleryItemModel.php');
require_once(BASEPATH.'core/controller/GalleryItemController.php');
require_once(BASEPATH.'core/model/GallerySectionModel.php');
