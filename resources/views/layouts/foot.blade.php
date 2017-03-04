<script src="{{ asset('js/init.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="/js/popup.js"></script>
<script type="text/javascript">
window.__SNIDDL_AJAX__ = {
  data: {!! json_encode([
      '_token' => csrf_token(),
  ]) !!}
};

$(function(){
  rename = new Popup({
    title: 'Rename Canvas',
    el: '#changeCanvasName',
    closeable: true,
    buttons: ['Change', 'Cancel'],
    appendTo: '#dashboard-popup-wrapper',
    onDefault: function(){
      $('#changeCanvasName').submit()
    },
    onCancel: function(){
      rename.show = false
    }
  })

})

$('[data-canvas]').click(function(){
  a = $(this);
  data = a.data('canvas')
  a.parent().hide()
  $('#form-canvas-url').val(data)
  $('#dashboard-popup-wrapper').show()
  rename.show = true
  // rename.show = true;
  // rename.parent.style.display = "block"
})


// $(document).on('click', function(event) {
//   if (!$(event.target).closest('.module .dropdown, .module .image, .module .options').length) {
//     $('.module .options').hide();
//     $('.module').removeClass('disabled').removeClass('enabled')
//   }
// });
// $(function () {
//   $('[data-toggle="tooltip"]').tooltip()
// })
</script>
