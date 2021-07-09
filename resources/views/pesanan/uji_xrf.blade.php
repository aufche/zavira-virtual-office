@include('layouts.header');
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Update Hasil Uji XRF</h1>
        </div>
      </div>

     
    <div class="tile">
    @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
    <div class="container">
        <div class="row">
            <div class="col-md-12">


            <form action="<?php echo route('pesanan.ujixrf');?>" method="post" autocomplete="off" enctype="multipart/form-data">
                <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
                <input type = "hidden" name = "id" value = "<?php echo $id ?>">
        <div class="form-row">
            


           

            <div class="col-md-10">
               
                <label for="">Lampiran file hasil uji XRF</label>
                 <input type="file" name="hasiluji" class="form-control-file form-control-lg mb-3"  />

                 
                 <button type="submit" class="btn btn-primary btn-lg btn-block mt-3">Upload</button>
            </div>

        

            
        </div>
    
    </form>
           
            </div>
        </div>
    </div>
    </div>
    </main>
  
@include('layouts.footer');