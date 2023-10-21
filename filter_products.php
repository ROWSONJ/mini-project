<?php
        require 'func.php';
        require 'conn.php';
        
        if (isset($_POST['carbrand'])) {
            $carbrandName = $_POST['carbrand'];

            $result = tablequery("SELECT p.*, c.category_name, b.carbrand_name FROM products p
                LEFT JOIN categories c ON p.category_id = c.category_id
                LEFT JOIN carbrands b ON p.carbrand_id = b.carbrand_id
                WHERE b.carbrand_name = '$carbrandName'");
        } else {
            $result = tablequery('SELECT p.*, c.category_name, b.carbrand_name FROM products p
                LEFT JOIN categories c ON p.category_id = c.category_id
                LEFT JOIN carbrands b ON p.carbrand_id = b.carbrand_id');
        }

        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) { 
            $isNewProduct = false; // Initialize a flag for checking if the product is new

      // Check if the product is new (released within the last week)
      if (!empty($row['Release_Date'])) {
      $releaseDate = strtotime($row['Release_Date']);
      $oneWeekAgo = strtotime('-1 week');
      if ($releaseDate > $oneWeekAgo) {
      $isNewProduct = true;
          }
      }  
      echo '<li class="product-item">
      <div class="product-card" tabindex="0">
          <figure class="card-banner">
              <img src="./assets/images/' . $row['p_image'] . '" width="312" height="350" loading="lazy"
                  alt="' . $row['product_name'] . '" class="image-contain">';

  // Display the "New" badge if it's a new product
  if ($isNewProduct) {
      echo '<div class="card-badge">New</div>';
  }

  echo '
              <ul class="card-action-list">
                  <li class="card-action-item">
                      <button class="card-action-btn" aria-labelledby="card-label-1">
                          <ion-icon name="cart-outline"></ion-icon>
                      </button>
                      <div class="card-action-tooltip" id="card-label-1">Add to Cart</div>
                  </li>
                  <li class="card-action-item">
                      <button class="card-action-btn" aria-labelledby="card-label-2">
                          <ion-icon name="heart-outline"></ion-icon>
                      </button>
                      <div class="card-action-tooltip" id="card-label-2">Add to Wishlist</div>
                  </li>
                  <li class="card-action-item">
                      <button class="card-action-btn" aria-labelledby="card-label-3">
                          <ion-icon name="eye-outline"></ion-icon>
                      </button>
                      <div class="card-action-tooltip" id="card-label-3">Quick View</div>
                  </li>
                  <li class="card-action-item">
                      <button class="card-action-btn" aria-labelledby="card-label-4">
                          <ion-icon name="repeat-outline"></ion-icon>
                      </button>
                      <div class="card-action-tooltip" id="card-label-4">Compare</div>
                  </li>
              </ul>
          </figure>
          <div class="card-content">
              <div class="card-cat">
                  <a href="#" class="card-cat-link">' . $row['category_name'] . '</a> / 
                  <a href="#" class="card-cat-link">' . $row['carbrand_name'] . '</a>
              </div>
              <h3 class="h3 card-title">
                  <a href="#">' . $row['product_name'] . '</a>
              </h3>
              <data class="card-price" value="180.85">฿' . $row['price'] . '</data>
          </div>
      </div>
  </li>';
}
} else {
echo "0 results";
}
?>