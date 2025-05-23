<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
?>

<header class="header">
   <section class="flex">

      <div class="icons">
         <?php
            $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $count_cart_items->execute([$user_id]);
            $total_cart_counts = $count_cart_items->rowCount();
         ?>
         <a href="search_page.php" class="search-btn">
            <i class="fas fa-search"></i>
            <span>Search</span>
         </a>
         
         <a href="cart.php" class="cart-btn">
            <i class="fas fa-shopping-cart"></i>
            <span class="badge"><?= $total_cart_counts; ?></span>
         </a>
         <button id="menu-btn" class="menu-btn">
            <i class="fas fa-bars"></i>
         </button>
         <button id="user-btn" class="user-btn">
            <i class="fas fa-user"></i>
         </button>
      </div>

      <a href="home.php" class="logo">
         <i class="fas fa-store"></i>
         <span>Stussy Ian</span>
      </a>

      <nav class="navbar">
         <a href="home.php">Home</a>
         <a href="about.php">About Us</a>
         <a href="orders.php">Orders</a>
         <a href="shop.php">Shop Now</a>
         <a href="contact.php">Contact Us</a>
      </nav>

      
      <div class="profile">
         <?php          
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <div class="profile-header">
            <i class="fas fa-user-circle"></i>
            <h3><?= $fetch_profile["name"]; ?></h3>
         </div>
         <div class="profile-actions">
            <a href="update_user.php" class="btn">
               <i class="fas fa-user-edit"></i>
               Update Profile
            </a>
            <div class="flex-btn">
               <a href="user_register.php" class="btn btn-secondary">
                  <i class="fas fa-user-plus"></i>
                  Register
               </a>
               <a href="user_login.php" class="btn btn-secondary">
                  <i class="fas fa-sign-in-alt"></i>
                  Login
               </a>
            </div>
            <a href="components/user_logout.php" class="btn btn-danger" onclick="return confirm('logout from the website?');">
               <i class="fas fa-sign-out-alt"></i>
               Logout
            </a>
         </div>
         <?php
            }else{
         ?>
         <div class="profile-header">
            <i class="fas fa-user-circle"></i>
            <h3>Welcome!</h3>
         </div>
         <p>Please login or register to continue</p>
         <div class="flex-btn">
            <a href="user_register.php" class="btn btn-secondary">
               <i class="fas fa-user-plus"></i>
               Register
            </a>
            <a href="user_login.php" class="btn btn-secondary">
               <i class="fas fa-sign-in-alt"></i>
               Login
            </a>
         </div>
         <?php
            }
         ?>      
      </div>
   </section>
</header>