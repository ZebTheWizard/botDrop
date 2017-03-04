<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
<link rel="stylesheet" href="/css/canvas.css">



@if($canvas->isNew)
  <div id="result">
    Settings Saved!
  </div>

  <form id="changeCanvasName" action="/nameCanvas" method="post">
    {{csrf_field()}}
      <div class="form-group">
        <input type="text" class="form-control" id="canvasName" name="name" placeholder="Canvas Name" required="true">
        <input type="hidden" name="url" value="{{$canvas->url}}">
      </div>
  </form>

@else
<div class="canvas-wrapper col-md-10 col-sm-10">
  <article><!-- our canvas will be inserted here--></article>
</div>



<div class="tools">
  <div class="tool" data-action="/dashboard">
    <i class="fa fa-home" aria-hidden="true"></i>
  </div>
  <div class="tool" id="brush">
    <i class="fa fa-paint-brush" aria-hidden="true"></i>
    <div class="slideout">
      <div class="tool" id="brush-minus"><i class="fa fa-minus" aria-hidden="true"></i></div>
      <div class="tool" id="brush-plus"><i class="fa fa-plus" aria-hidden="true"></i></div>
    </div>
  </div>
  <div class="tool" id="current-color">
  </div>
</div>
@endif


<img id="img" style="display: none" src="{{$canvas->image}}">
<div class="popup" id="colorpicker" >
  <i class="fa fa-times close"></i>
  <div id="colorpickerwrapper" class="popup-section">
    <iframe style="display:none"></iframe>


    <div class="input-group"  id="hex-input">
      <span class="input-group-addon">#</span>
      <input type="text" class="form-control" placeholder="FF0000" aria-describedby="basic-addon1">
    </div>
  </div>
</div>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script> -->

<script src="/js/no.jquery.js"></script>
<script src="/js/popup.js"></script>



<script type="text/javascript">
window.__SNIDDL_AJAX__ = {
  data: {!! json_encode([
      '_token' => csrf_token(),
  ]) !!}
};
  $('document').ready(function(){
    img = document.getElementById('img')
    img.url = '{{$canvas->url}}';
    $('#changenamebutton').click()

@if($canvas->isNew)
    new Popup ({
      title: 'Canvas Creation',
      el:  '#changeCanvasName',
      buttons: ['Create', 'Cancel'],
      onDefault: function(){
        document.getElementById('changeCanvasName').submit();
      },
      onCancel: function(){
        window.location = "/dashboard"
      }
    })
@endif
  })

</script>

<script src="/js/jquery.event.drag-2.0.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.3/socket.io.js" charset="utf-8"></script> -->
<script src="http://sniddl.app:8000/socket.io/socket.io.js"></script>

@if($canvas->isNew == 0)
<script src="/js/scripts.js"></script>





<script type="text/javascript">
$('document').ready(function(){
  var colorPicker = new ColorPicker({
    color: '#FF0000',
    background: '#454545',
    el: document.body,
    width: 300,
    height: 300,
    window: document.getElementsByTagName('iframe')[0].contentWindow
  });
  var colorpickerwrapper = document.getElementById('colorpickerwrapper');
  colorPicker.appendTo(colorpickerwrapper)
  colorPicker.onChange(function(){
    var hex = colorPicker.getHexString()
    $('#hex-input input').val(hex.slice(1));
    $('#current-color').css('background-color',hex)
    window.App.ctx.strokeStyle = hex
  })

  $('#current-color').click(function(){
    $("#colorpicker").toggle();
    $("#colorpicker .close").click(function(){
      $("#colorpicker").hide();
    })
  })



  // $('.slideout').parent().click(function(){
  //   $(this).find('.slideout').toggle().css('right','-116px')
  // }).children().not('i').click(function(){
  //   return false;
  // })

  // $('#brush-minus').click(function(){
  //   if (App.ctx.lineWidth >= 6){
  //     App.ctx.lineWidth -= 5
  //   }
  // })
  //
  // $('#brush-plus').click(function(){
  //   if (App.ctx.lineWidth <= 100){
  //     App.ctx.lineWidth += 5
  //   }
  // })

  // $('canvas').live('dragstart', function(e){
  //   $('#brush .slideout').hide()
  //   $("#colorpicker").hide();
  // })
})


</script>
@endif
