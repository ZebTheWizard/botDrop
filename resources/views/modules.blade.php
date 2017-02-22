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
  -moz-filter:grayscale(100%);
  -webkit-filter:grayscale(100%);
  -o-filter:grayscale(100%);
  -ms-filter:grayscale(100%);
  filter:grayscale(100%);
}
.module.enabled{
  border-color: #0081ff !important;
  border-radius: 6px;
}
.module {
    display: inline-block;
    width: 150px;
    height: 150px;
    position: relative;
    border-color: #bbb;
    background: white;
    margin: 10px;
    box-shadow: 0px 2px 3px 0px rgba(0, 0, 0, 0.09);
    border-radius: 4px;
}.module.current{
  border-color: #0081ff;
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
    border-color: #0081ff transparent;
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
    text-align: left;
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
</style>

<?php $modules = json_decode(file_get_contents(resource_path('json/modules.json')));
?>

@foreach($modules as $module)
  <div class="module">
    <div class="image">
      <div class="src" style="background-image: url({{$module->image}})"> </div>
    </div>
    <div class="dropdown no-select">
      <span class="selected">{{$module->dropdown}}</span>
    </div>
    <div class="options">
      @foreach($module->options as $option)
        <li class="item">
          <span class="choice">{{$option}} </span>
          <i class="fa fa-square-o" aria-hidden="true"></i>
        </li>
      @endforeach
    </div>
  </div>
@endforeach
