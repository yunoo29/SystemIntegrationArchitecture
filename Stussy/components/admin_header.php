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
   <div class="flex">
      <div class="menu-btn-container">
         <div id="menu-btn" class="fas fa-bars"></div>
      </div>

      <a href="../admin/dashboard.php" class="logo">Admin<span>Panel</span></a>

      <nav class="navbar">
         <a href="../admin/dashboard.php"><i class="fas fa-home"></i><span>Home</span></a>
         <a href="../admin/products.php"><i class="fas fa-box"></i><span>Products</span></a>
         <a href="../admin/placed_orders.php"><i class="fas fa-clipboard-list"></i><span>Orders</span></a>
         <a href="../admin/admin_accounts.php"><i class="fas fa-users-cog"></i><span>Admins</span></a>
         <a href="../admin/users_accounts.php"><i class="fas fa-users"></i><span>Users</span></a>
         <a href="../admin/messages.php"><i class="fas fa-envelope"></i><span>Messages</span></a>
      </nav>

      <div class="icons">
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `admins` WHERE id = ?");
            $select_profile->execute([$admin_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p><i class="fas fa-user-circle"></i> <?= $fetch_profile['name']; ?></p>
         <div class="flex-btn">
            <a href="../admin/update_profile.php" class="option-btn">Update Profile</a>
            <a href="../components/admin_logout.php" class="delete-btn" onclick="return confirm('logout from the website?');">Logout</a>
         </div>
      </div>

   </div>
</header>