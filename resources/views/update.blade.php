<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">

    <style type="text/css">
      @media (min-width: 1000px) {
            .container{
                max-width: 500px;
            }
        }
    </style>
  </head>
  <body>

  <div class="container m-3">
  @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <form action="<?php echo route('updateform');?>" method="post">
            <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
            <div class="form-group">
              <label for="no">No Order</label>
              <input type="text" class="form-control form-control-lg" name="no" id="textboxID" aria-describedby="no order" placeholder="">
              <small id="no order" class="form-text text-muted">Masukkan No Order dan tekan tombol enter pada keyboard</small>
            </div>
            <button type="submit" class="btn btn-primary btn-lg mb-2 btn-block">Find</button>
        </form>
  </div>

  <script type="text/javascript">
        document.getElementById('textboxID').focus();
    </script>
    
  </body>
</html>