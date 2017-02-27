<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<style media="screen">
html,body,div,span,applet,object,iframe,h1,h2,h3,h4,h5,h6,p,blockquote,pre,a,abbr,acronym,address,big,cite,code,del,dfn,em,img,ins,kbd,q,s,samp,small,strike,strong,sub,sup,tt,var,b,u,i,center,dl,dt,dd,ol,ul,li,fieldset,form,label,legend,table,caption,tbody,tfoot,thead,tr,th,td,article,aside,canvas,details,embed,figure,figcaption,footer,header,hgroup,menu,nav,output,ruby,section,summary,time,mark,audio,video{border:0;font-size:100%;font:inherit;vertical-align:baseline;margin:0;padding:0;}article,aside,details,figcaption,figure,footer,header,hgroup,menu,nav,section{display:block;}body{line-height:1;}ol,ul{list-style:none;}blockquote,q{quotes:none;}blockquote:before,blockquote:after,q:before,q:after{content:none;}table{border-collapse:collapse;border-spacing:0;}.clearfix:after{content:".";display:block;clear:both;visibility:hidden;line-height:0;height:0;}.clearfix{display:inline-block;}html[xmlns] .clearfix{display:block;}* html .clearfix{height:1%;}

body {
	background: #392C44;
}

canvas {
	background: #fff;
	margin: 20px auto;
	border: 5px solid #E8E8E8;
	display: block;}

#changenamebutton{
  display: none;
}
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

</style>


@if($canvas->isNew)
<!-- Button trigger modal -->
<button id="changenamebutton" type="button" data-toggle="modal" data-target="#myModal"></button>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Name Your Canvas</h4>
      </div>

      <form class="" action="/nameCanvas" method="post">
        {{csrf_field()}}
        <div class="modal-body">
          <div class="form-group">
            <label for="canvasName">You need to name your canvas first.</label>
            <input type="text" class="form-control" id="canvasName" name="name" placeholder="ex. My Awesome Canvas">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="url" value="{{$canvas->url}}">Save changes</button>
        </div>
      </form>

    </div>
  </div>
</div>
@else
<article><!-- our canvas will be inserted here--></article>
@endif


<img id="img" style="display: none" src="{{$canvas->image}}">
<!-- <div id="autosave"
      data-ajax="true"
      data-action="/autosave"
      data-method="post"
      _success="autosave_success(data)"
      data-json='{
        "url": "@{{$canvas->url}}",
        "data": "@{{$canvas->data}}"
      }'
>
autosave
</div> -->

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script src="/js/no.jquery.js"></script>



<script type="text/javascript">
window.__SNIDDL_AJAX__ = {
  data: {!! json_encode([
      '_token' => csrf_token(),
  ]) !!}
};
  $('document').ready(function(){
    img = document.getElementById('img')
    img.url = '{{$canvas->url}}';
  })
  // $('html').mouseleave(function(){
  //   console.log('mousseleft');
  // })
  $('#changenamebutton').click()

  // autosave = setInteraval(function(){
  //
  // }, 5000)

  // getImgData = function(){
  //   return $('canvas')[0].toDataURL;
  // }
  //
  // autosave_success = function(data){
  //   data = JSON.parse(data);
  //   var stringJSON = $('#autosave')[0].__data__.json;
  //   var json = JSON.parse(stringJSON);
  //   json.data = data.imageData;
  //   var restringJSON = JSON.stringify(json);
  //   $('#autosave')[0].__data__.json = restringJSON;
  // }
</script>

<script src="/js/jquery.event.drag-2.0.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.3/socket.io.js" charset="utf-8"></script>
<script src="/js/scripts.js"></script>
