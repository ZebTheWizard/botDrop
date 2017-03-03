<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
<link rel="stylesheet" href="/css/simple-color-picker.css">
<link rel="stylesheet" href="/css/popup.css">
<style media="screen">
html,body,div,span,applet,object,iframe,h1,h2,h3,h4,h5,h6,p,blockquote,pre,a,abbr,acronym,address,big,cite,code,del,dfn,em,img,ins,kbd,q,s,samp,small,strike,strong,sub,sup,tt,var,b,u,i,center,dl,dt,dd,ol,ul,li,fieldset,form,label,legend,table,caption,tbody,tfoot,thead,tr,th,td,article,aside,canvas,details,embed,figure,figcaption,footer,header,hgroup,menu,nav,output,ruby,section,summary,time,mark,audio,video{border:0;font-size:100%;font:inherit;vertical-align:baseline;margin:0;padding:0;}article,aside,details,figcaption,figure,footer,header,hgroup,menu,nav,section{display:block;}body{line-height:1;}ol,ul{list-style:none;}blockquote,q{quotes:none;}blockquote:before,blockquote:after,q:before,q:after{content:none;}table{border-collapse:collapse;border-spacing:0;}.clearfix:after{content:".";display:block;clear:both;visibility:hidden;line-height:0;height:0;}.clearfix{display:inline-block;}html[xmlns] .clearfix{display:block;}* html .clearfix{height:1%;}

body {
	background: #392C44;
}

canvas {
    background: transparent;
    display: block;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
article {
    position: absolute;
    background-image: url(/image/trans.png);
    width: 100%;
    height: 400px;
    overflow: visible;
    text-align: center;
    background-size: 20%;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
.canvas-wrapper {
    margin-top: 30px;
    position: absolute;
    left: 50%;
    transform: translate(-50%);
    height: 500px;
    overflow-x: auto;
    border-radius: 4px;
    background: #1a1a1b;
}
/*#changenamebutton{
  display: none;
}*/
.modal{
      font-family: sans-serif !important;
}
h4#myModalLabel {
    font-size: 1.3em;
    font-weight: 600;
    color: #999;
    letter-spacing: 1px;
}
label {
    margin: 10px 0;
}

.tools {
    position: absolute;
    height: 100%;
    background: #1a1a1b;
    z-index: 1;
    left: 0px;
    border: 1px solid black;
    padding: 2px
}

.tool {
    margin: 10px;
    background: #3e3e3e;
    box-sizing: border-box;
    width: 36px;
    height: 36px;
    border-radius: 4px;
    border: 1px solid #ccc;
    color: white;
    position: relative;
    cursor: pointer;
} .tool:hover{
    background: #505050;
}
.tool .fa {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.popup {
    background: #1a1a1b;
    padding: 40px 40px 30px 30px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    border-radius: 4px;
    box-shadow: 0px 5px 12px 1px rgba(0, 0, 0, 0.39);
    display: none;
}
div#colorpickerwrapper {
    position: relative;
    width: 300px;
    height: 360px;
}
#hex-input{
  position: absolute;
  bottom: 0;
}
.Scp {
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    padding: 0 !important;
    background: transparent !important;
}

.Scp-hue {
    position: absolute;
    float: none;
    right: -10px;
}
.popup .close {
    color: white;
    position: absolute;
    opacity: 1;
    top: 0;
    right: 0;
    padding: 10px 20px;
    cursor: pointer;
}
.slideout {
    background: #1a1a1b;
    position: absolute;
    top: -10px;
    right: 0;
    display: none;
    z-index: -1;
    padding-left: 10px;
    text-align: left;
    /*transition: right 1.8s;
     -webkit-transition: right 1.8s;*/
     -webkit-transition: all 5s ease;
   -moz-transition: all 5s ease;
    -ie-transition: all 5s ease;
     -o-transition: all 5s ease;
        transition: all 5s ease;

}.slideout.show{
  right: -116px;
  display: block;
}
.slideout .tool {
    display: inline-block;
    float: left;
    margin: 10px 10px 10px 0;
}


</style>



@if($canvas->isNew)
  <div id="forms">
    Hello
  </div>

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
      title: 'Name your canvas',
      el: '#forms',
      draggable: true,
      pinnable: true,
      closeable: true
    })
  })
@endif


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
