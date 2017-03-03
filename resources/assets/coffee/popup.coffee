Function::property = (prop, desc) ->
  Object.defineProperty @prototype, prop, desc

class window.Popup
  constructor: (params) ->

    p          = params      || {}
    _this      = this
    @appendTo  = p.appendTo  || 'body'
    @buttons   = p.buttons   || ['Continue', 'Cancel']
    @closeable = p.closeable || false
    @draggable = p.draggable || false
    @el        = p.el           if p.el
    @genID     = true
    @pinnable  = p.pinnable  || false
    @text      = p.text         if p.text
    @title     = p.title     || 'Popup'


    # --------------------------
    #   Create Window, Add to parent, show
    # --------------------------
    _window           = document.createElement "div"
    _window.className = 'window'
    _window.id        = "popup-window-#{@id}"
    @parent.appendChild(_window)
    @setWindow        = true
    @show             = true


    # --------------------------
    #   Create Tray for pinnable
    # --------------------------
    _tray = document.createElement "div"
    _tray.id = 'popup-tray'
    document.body.appendChild(_tray)

    # --------------------------
    #   Create Header and make draggable as specified
    # --------------------------
    xpos = ypos = 0
    _header = document.createElement "div"
    _header.className = 'header'
    _window.appendChild(_header)
    headerDown = (e)->
      if _this.draggable is true
        xpos = e.clientX - _window.offsetLeft
        ypos = e.clientY - _window.offsetTop
        window.addEventListener 'mousemove', headerMove, true
    headerMove = (e)->
      _this.minimize = false
      if parseInt(_window.style.top) + _window.clientHeight > window.innerHeight + 50 && _this.pinnable is true
        _this.minimize = true
      _window.style.position = "absolute"
      _window.style.top = (e.clientY) + 'px'
      _window.style.left = (e.clientX) + 'px'
    headerUp = ->
      window.removeEventListener('mousemove', headerMove, true)
    _header.addEventListener('mousedown', headerDown, false)
    window.addEventListener('mouseup', headerUp, false)


    # --------------------------
    #   Create Header Buttons and parent, make closeable if specified
    # --------------------------
    if @closeable is true
      _buttons = document.createElement "div"
      _buttons.className = 'buttons'
      _header.appendChild(_buttons)
      _color = ['red', 'yellow', 'green']
      i = 0
      while  i < 3
        _button = document.createElement "button"
        _button.className = 'button '
        _button.className += _color[i]
        _button.id = _but_ ="popup-#{_color[i]}-#{@id}"
        _buttons.appendChild(_button)
        _but = document.getElementById(_but_)
        if _color[i] is 'red'
            _button.addEventListener "click", ->
              _this.show = false
            , _this
        else if _color[i] is 'yellow'
            _button.addEventListener "click", ->
              _this.minimize = true
            , _this
        else
            _button.addEventListener "click", ->
              _this.minimize = false
            , _this
        i++



    # --------------------------
    #   Create Title
    # --------------------------
    _title = document.createElement "div"
    _title.className = "title"
    _title.innerHTML = @title
    _header.appendChild(_title)


    # --------------------------
    #   Create Body
    # --------------------------
    _body = document.createElement "div"
    _body.className = 'body'
    _body.innerHTML = @body
    _window.appendChild(_body)


    # --------------------------
    #   Create Footer
    # --------------------------
    _footer = document.createElement "div"
    _footer.className = 'footer'
    _window.appendChild(_footer)


    # --------------------------
    #   Create footer buttons and parent, define default button
    # --------------------------
    _buttons = document.createElement "div"
    _buttons.className = 'buttons'
    _footer.appendChild(_buttons)
    i = 0

    while  i < Object.keys(@actions).length
      _current = Object.keys(@actions)[i]
      if _current isnt 'default'
        _button = document.createElement "button"
        _button.className = 'button '
        _button.id = "popup-#{_current}-#{@id}"
        _button.innerHTML = _current
        _button.onClickMethod = _current
        _buttons.appendChild(_button)

        _button.addEventListener "click", ->
          eval "if(p.on#{@onClickMethod}){p.on#{@onClickMethod}()}"
          _this.show = false
        , _this
      i++
    _button = document.createElement "button"
    _button.className = 'button '
    _button.id = "popup-default-#{@id}"
    _button.classList.add('default')
    _button.addEventListener "click", ->
      p.onDefault() if p.onDefault
      _this.show = false
    , _this
    _button.innerHTML = @actions.default
    _buttons.appendChild(_button)



  # --------------------------
  #   Define getters and setters
  # --------------------------
  @property 'genID',
    set: -> @id = window.popup_incr = ++window.popup_incr || 1

  @property 'show',
    set: (bool) ->
      if bool is true
        @window.style.display = "block"
      else
        @window.style.display = "none"
      @isVisible = bool

  @property 'minimize',
    set: (bool) ->
      if bool is true
        _tray = document.getElementById('popup-tray')
        @window.children[1].style.display = "none"
        @window.children[2].style.display = "none"
        @window.classList.add('minimized')
        _tray.appendChild(@window)
      else
        @window.children[1].style.display = "block"
        @window.children[2].style.display = "block"
        @window.classList.remove('minimized')
        @parent.appendChild(@window)
      @isVisible = bool

  @property 'text',
    set: (str) -> @body = str

  @property 'el',
    set: (str) -> @body = document.querySelector(str).outerHTML

  @property 'setWindow',
    set: -> @window = document.getElementById("popup-window-#{@id}")

  @property 'appendTo',
    set: (str) -> @parent = document.querySelector(str)

  @property 'buttons',
    set: (buttons) ->
      @actions = {}
      for b in buttons
        if buttons.indexOf(b) is 0
          @actions.default = buttons[0]
        else
          eval "this.actions.#{b} = '#{b}'"
