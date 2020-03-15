</div> <!-- div utama-->
<div class="modal fade" id="modalMd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="modalMdTitle"></h4>
                  </div>
                  <div class="modal-body">
                      <div class="modalError"></div>
                      <div id="modalMdContent"></div>
                  </div>
              </div>
          </div>
        </div>


<a href="#" class="float" data-toggle="modal" data-target="#search_modal">
<i class="fa fa-search my-float"></i>
</a>

<div class="modal" tabindex="-1" role="dialog" id="search_modal">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <form class="form-inline mt-2 mt-md-0" action="<?php echo route('search');?>" method="post">
      <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
      <input name="q" class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
      <button class="btn btn-success my-2 my-sm-0" type="submit">Search</button>
    </form>
      </div>
    </div>
  </div>
</div>
        
 <!-- Essential javascripts for application to work-->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha256-KM512VNnjElC30ehFwehXjx1YCHPiQkOPmqnrWtpccM=" crossorigin="anonymous"></script>
 <script type="text/javascript" src="<?php echo asset('js/moment.min.js');?>"></script>
 <script type="text/javascript" src="<?php echo asset('js/daterangepicker.js');?>"></script>
		    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    
	
	<script>

	$(function () {

    //single date
    $('#date, #date1, #date2, #date3').daterangepicker({
		singleDatePicker: true,
		locale: {
            format: 'YYYY-MM-DD'
        }
	});
	
});


$('#show-user').autocomplete({
            // delay: 500,
            minLength: 2,
            source: function(request, response) {
                $.getJSON("/pesanan/loadpesanan", {
                    name: request.term,
                }, function(data) {
                    response(data);
                });
            },
            focus: function(event, ui) {
                // prevent autocomplete from updating the textbox
                event.preventDefault();
            },
            select: function(event, ui) {
                // prevent autocomplete from updating the textbox
                event.preventDefault();
 
                $('input[name="show_user"]').val(ui.item.label);
                $('input[name="pesanan_id"]').val(ui.item.id);
            }
        });
   
   
        $(document).on('ajaxComplete ready', function () {
    $('.modalMd').off('click').on('click', function () {
        $('#modalMdContent').load($(this).attr('value'));
        $('#modalMdTitle').html($(this).attr('title'));
    });
});


$(document).ready(function(){
    $('#modal_lunas').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('whatever') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var jenis = button.data('jenis')
  var modal = $(this)
  modal.find('.modal-title').text('Update '+jenis+' no order '+recipient)
  modal.find('.modal-body #no_order').val(recipient)
  modal.find('.modal-body #modal_jenis').val(jenis)
  modal.find('#target').text(jenis)
})
});
	</script>
  </body>
</html>