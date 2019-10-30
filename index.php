<?php
// set default page to one
$page = isset($_GET['page']) ? $_GET['page'] : 1;
// set number of records per page
$records_per_page = 5;
// calculate query limit
$from_record_num = ($records_per_page * $page) - $records_per_page;

include_once 'config/database.php';
include_once 'objects/product.php';
include_once 'objects/category.php';

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);
$category = new Category($db);

// query products
$stmt = $product->readAll($from_record_num, $records_per_page);
$num = $stmt->rowCount();
// page header
$page_title = "Current stock";
include_once "layout_header.php";

echo "<div class='right-button-margin'>
  <a href='create_product.php' class='btn btn-success pull-right'>Add Stock</a>
</div>";

// display products
if ($num>0) {
  echo "<table class='table table-hover table-responsive table-bordered'>";
    echo "<tr>";
      echo "<th>Item</th>";
      echo "<th>Price</th>";
      echo "<th>Description</th>";
      echo "<th>Category</th>";
      echo "<th>Actions</th>";
    echo "</tr>";

  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);

    echo "<tr>";
      echo "<td>{$name}</td>";
      echo "<td>{$price}</td>";
      echo "<td>{$description}</td>";
      echo "<td>";
      $category->id = $category_id;
      $category->readName();
      echo $category->name;
      echo "</td>";
      // read, edit and delete buttons
      echo "<td>";
        echo "<a href='read_one.php?id={$id}' class='btn btn-primary left-margin'>
          <span class='glyphicon glyphicon-list'></span> View
        </a>

        <a href='update_product.php?id={$id}' class='btn btn-info left-margin'>
          <span class='glyphicon glyphicon-edit'></span> Edit
        </a>

        <a delete-id='{$id}' class='btn btn-danger delete-object'>
          <span class='glyphicon glyphicon-remove'></span> Delete
        </a>";
      echo "</td>";
    echo "</tr>";

  }
  echo "</table>";

  // the page where this paging is used
  $page_url = "index.php?";
  // count all products in the database to calculate total pages
  $total_rows = $product->countAll();
  // paging buttons here
  include_once 'paging.php';

} else {
  echo "<div class='alert alert-info'>No products found.</div>";
}

include_once "layout_footer.php";
