# setup our application with its own namespace
window.App = {}

###
  Init
###
App.init = ->
  App.canvas = document.createElement 'canvas' #create the canvas element
  App.canvas.height = 400
  App.canvas.width = 800  #size it up
  document.getElementsByTagName('article')[0].appendChild(App.canvas) #append it into the DOM

  App.ctx = App.canvas.getContext("2d") # Store the context

  # set some preferences for our line drawing.
  App.ctx.fillStyle = "solid"
  App.ctx.strokeStyle = "#ECD018"
  App.ctx.lineWidth = 21
  App.ctx.lineCap = "round"
  App.ctx.lineJoin = "round"

  App.img = document.getElementById 'img'
  App.ctx.drawImage App.img,0,0

  # Sockets!

  App.socket = io.connect('http://sniddl.app:8000')

  App.socket.on "draw:#{App.img.url}", (data) ->
    App.draw(data.x, data.y, data.type, data.color, data.size)

  # Draw Function
  App.draw = (x,y,type,color, size) ->
    App.ctx.strokeStyle = color
    App.ctx.lineWidth = size
    if type is "dragstart"
      App.ctx.beginPath()
      App.ctx.moveTo(x,y)
    else if type is "drag"
      App.ctx.lineTo(x,y)
      App.ctx.stroke()
    else
      App.ctx.closePath()
      App.canvas.data = App.canvas.toDataURL('image/png')
      App.socket.emit('save', String(App.canvas.data), App.img.url)
  return




###
	Draw Events
###
$('canvas').live 'drag dragstart dragend', (e) ->
  $('.slideout').hide()
  $("#colorpicker").hide();
  type = e.handleObj.type
  offset = $(this).offset()
  e.clientX = e.layerX + offset.left
  e.clientY = e.layerY - offset.top
  x = e.offsetX
  y = e.offsetY
  App.draw(x,y,type)
  App.socket.emit('drawClick', { x : x, y : y, type : type, channel : App.img.url, color: App.ctx.strokeStyle, size: App.ctx.lineWidth})
  return



$('.slideout').parent().click ->
  $(this) .find('.slideout') .toggle() .css('right', '-116px')
.children().not('i').click ->
  false


$('#brush-minus') .click ->
    App.ctx.lineWidth -= 5 if App.ctx.lineWidth >= 6

$('#brush-plus').click ->
    App.ctx.lineWidth += 5 if App.ctx.lineWidth <= 100











# jQuery document.ready
$ ->
  App.init()
