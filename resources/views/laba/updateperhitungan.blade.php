<!doctype html>
<html lang="en">
  <head>
    <title>Update Perhitungan Laba</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>

  <div class="container">
      <div class="row">
          <div class="col-md-12 mt-3">
          @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
              <form method="post" action="<?php echo route('perhitungan.update');?>">
              <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
               <div class="form-group">
                 <label for="id">No Order</label>
                 <input type="number" name="id" id="id" class="form-control form-control-lg" placeholder="" aria-describedby="No Order">
                 <small id="No Order" class="text-muted">Input No Order</small>
               </div>

               <div class="form-group">
                 <label for="harga_final">Harga Final</label>
                 <input type="number" name="harga_final" id="harga_final" class="form-control form-control-lg" placeholder="" aria-describedby="helpId">
                 <small id="helpId" class="text-muted">Harga final dari Pak bejo</small>
               </div>
                <button type="submit" class="btn btn-warning btn-block btn-lg">Update</button>
              </form>
          </div>
      </div>
  </div>
    
  </body>
</html>