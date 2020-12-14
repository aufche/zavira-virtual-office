@include('layouts.header')
<style type="text/css">

.tracking-detail {
 padding:3rem 0
}
#tracking {
 margin-bottom:1rem
}
[class*=tracking-status-] p {
 margin:0;
 font-size:1.1rem;
 color:#fff;
 text-transform:uppercase;
 text-align:center
}
[class*=tracking-status-] {
 padding:1.6rem 0
}
.tracking-status-intransit {
 background-color:#f9cb40;
}

.tracking-list {
 border:1px solid #f9cb40;
}
.tracking-item {
 border-left:1px solid #f9cb40;
 position:relative;
 padding:2rem 1.5rem .5rem 2.5rem;
 font-size:.9rem;
 margin-left:3rem;
 min-height:5rem
}
.tracking-item:last-child {
 padding-bottom:4rem
}
.tracking-item .tracking-date {
 margin-bottom:.5rem
}
.tracking-item .tracking-date span {
 color:#888;
 font-size:85%;
 padding-left:.4rem
}
.tracking-item .tracking-content {
 padding:.5rem .8rem;
 background-color:#f4f4f4;
 border-radius:.5rem
}
.tracking-item .tracking-content span {
 display:block;
 color:#888;
 font-size:85%
}
.tracking-item .tracking-icon {
 line-height:2.6rem;
 position:absolute;
 left:-1.3rem;
 width:2.6rem;
 height:2.6rem;
 text-align:center;
 border-radius:50%;
 font-size:2em;
 background-color:#fff;
 color:#fff
}

.tracking-item .tracking-icon.status-intransit {
 color:#f9cb40;
 border:1px solid #e5e5e5;
 font-size:2em;
}
@media(min-width:992px) {
 .tracking-item {
  margin-left:10rem
 }
 .tracking-item .tracking-date {
  position:absolute;
  left:-10rem;
  width:7.5rem;
  text-align:right
 }
 .tracking-item .tracking-date span {
  display:block
 }
 .tracking-item .tracking-content {
  padding:0;
  background-color:transparent
 }
}
</style>
<main class="app-content">
      

    
    <div class="tile">
    <div class="container">
   
   <div class="row">

  
      
      <div class="col-md-12 col-lg-12">

     


         <div id="tracking-pre"></div>
         <div id="tracking">
            <div class="text-center tracking-status-intransit">
               <p class="tracking-status text-dark">Timeline History Orderan <?php echo $id;?></php></p>
            </div>
            <div class="tracking-list">

            
            <?php
               
              foreach ($history_pesanan as $item){
                ?>
                <div class="tracking-item">
                  <div class="tracking-icon status-intransit">
                     
                  <i class="fas fa-check"></i>
                  </div>
                  <div class="tracking-date"><?php echo date('d M Y h:i:s A', strtotime($item->created_at));?></div>
                  <div class="tracking-content"><?php echo $item->keterangan; ?></div>
               </div>
                <?php
              }
            ?>
            </div>
         </div>
      </div>
   </div>
</div>
    </div>

   
    </main>
@include('layouts.footer')