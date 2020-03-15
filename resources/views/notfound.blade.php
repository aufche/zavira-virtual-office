@include('layouts.header');
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> All Orders</h1>
          <p>This page contains all orders</p>
        </div>
      </div>
    <div class="tile">
   <?php 
    if (!empty($status)){
        echo $status;
    }
   ?>
    </div>
    </main>
  
@include('layouts.footer');