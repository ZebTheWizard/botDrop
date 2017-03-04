<style media="screen">
.no-select{
  -webkit-touch-callout: none;
    -webkit-user-select: none;
     -khtml-user-select: none;
       -moz-user-select: none;
        -ms-user-select: none;
            user-select: none;
}

.module.disabled{
  -moz-filter:grayscale(100%) ;
  -webkit-filter:grayscale(100%) ;
  -o-filter:grayscale(100%) ;
  -ms-filter:grayscale(100%) ;
  filter:grayscale(100%) ;
}
.module.enabled{
  border-color: #555 !important;
  border-radius: 6px;
  box-shadow: 0px 2px 3px 0px rgba(0, 0, 0, 0.19);

}
.module {
    display: inline-block;
    width: 150px;
    height: 150px;
    position: relative;
    border-color: #bbb;
    background: white;
    margin: 10px;
    border-radius: 4px;
}.module.current{
  border-color: #555;
}
.module.add {
    box-shadow: none;
    border: 2px dashed #ccc;
    background: transparent;
    cursor: pointer;
}.module.add .fa {
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    font-size: 35px;
    color: #ccc;
}
.image:hover{
  background-color: #f1f1f1 !important;
}
.image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 75%;
    border: 1px solid;
    border-color: inherit;
    border-radius: 4px 4px 0 0;
    cursor: pointer;
    padding: 10px;
}.image.add{
  height: 100%;
}
.module .dropdown {
    position: absolute;
    bottom: 0;
    left: 0;
    height: calc(25% + 1px);
    line-height: 36px;
    text-align: center;
    width: 100%;
    font-size: 12px;
    cursor: pointer;
    border: 1px solid;
    border-color: inherit;
    border-radius: 0 0 4px 4px;

}.dropdown:hover{
  background-color: #f1f1f1;
}
.options {
  display: none;
  position: absolute;
  top: 160px;
  list-style: none !important;
  background: white;
  width: 100%;
  text-align: center;
  border: 1px solid;
  border-color: inherit;
  border-radius: 4px;
  z-index: 5;
  box-shadow: 0px 2px 3px 0px rgba(0, 0, 0, 0.09);
}
.options:before {
    content: "";
    display: block;
    position: absolute;
    top: -8px;
    right: 1px;
    width: 0;
    border-width: 0px 9px 8px;
    border-style: solid;
    border-color: #555 transparent;
}
.options:after {
    content: "";
    display: block;
    position: absolute;
    top: -7px;
    right: 0px;
    width: 0;
    border-width: 0px 10px 10px;
    border-style: solid;
    border-color: white transparent;
}.options.changeAfter:after {
    border-color: #f1f1f1 transparent ;
}

.image .src {
    width: 100%;
    height: 100%;
    background-position: center center;
    background-repeat: no-repeat;
    background-size: contain;
}
li.item {
    text-align: center;
    padding: 3px 20px;
    cursor: pointer;
}
li.item:first-child {
    border-radius: 4px 4px 0 0;
}
li.item:last-child {
    border-radius: 0 0 4px 4px;
}
li.item:hover {
  background-color: #f1f1f1;
}
li.item .fa {
    position: absolute;
    right: 20px;
    line-height: 25px;
}
li.item .fa-check-square-o {
    right: 18px;
}
.item.danger {
    color: white;
    background: #df3e3e;
}
.item.danger:hover {
    color: white;
    background: #ab3131;
}
</style>

<link rel="stylesheet" href="/css/popup.css">

<?php $modules = json_decode(file_get_contents(resource_path('json/modules.json')));
?>

@foreach($canvases as $canvas)
  <div class="module">
    <div class="image" data-action="/c/{{$canvas->url}}">
      <div class="src" style="background-image: url({{$canvas->image}})"> </div>
    </div>
    <div class="dropdown no-select">
      <span class="selected">
        @if($canvas->name)
          {{$canvas->name}}
        @else
          Unnamed Canvas
        @endif

      </span>
    </div>
    <div class="options">
        <li class="item" data-canvas='{{$canvas->url}}'>
          <span class="choice">Rename</span>
        </li>
        <li class="item">
          <span class="choice">Share</span>
        </li>
        <li class="item danger"
            data-action="/deleteCanvas"
            data-method="post"
            data-json='{
              "url": "{{$canvas->url}}"
            }'>
          <span class="choice ">Delete</span>
        </li>
    </div>
  </div>
@endforeach

<div  class="module add"
      data-action="/createCanvas"
      data-method="post"
      data-toggle="tooltip" data-placement="top" title="Create A Canvas">
  <i class="fa fa-plus" aria-hidden="true"></i>
</div>


<div id="dashboard-popup-wrapper" style="display: none;">
  <form id="changeCanvasName" action="/nameCanvas" method="post">
    {{csrf_field()}}
      <div class="form-group">
        <input type="text" class="form-control" id="canvasName" name="name" placeholder="Canvas Name" required="true">
        <input type="hidden" id="form-canvas-url" name="url" value="{{$canvas->url}}">
      </div>
  </form>
</div>
