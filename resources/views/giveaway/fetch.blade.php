@include('layouts.header')
<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Peserta Giveaway</h1>
        </div>
      </div>
      
      <div class="tile">
      @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <form method="post" action="<?php echo route('ga.fetch.submit');?>">
        <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
            <div class="form-group">
              <label for="">Url Instagram</label>
              <input type="text" class="form-control" name="url" aria-describedby="helpId" placeholder="">
              <small id="helpId" class="form-text text-muted">Help text</small>
            </div>

            <button type="submit" name="" id="" class="btn btn-primary" btn-lg btn-block">Submit</button>
        </form>
      </div>
    </main>
@include('layouts.footer')