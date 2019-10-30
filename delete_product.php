<?php

if ($_POST) {
  include_once 'config/database.php';
  include_once 'objects/product.php';

  $database = new Database();
  $db = $database->getConnection();
  // prep product object
  $product = new Product($db);
  // set product id to be deleted
  $product->id = $_POST['object_id'];
  // delete the product
  if ($product->delete()) {
    echo "Object was deleted.";
  } else {
    echo "Unable to delete object.";
  }
}
?>
