<script src="{{ asset('js/init.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript">
window.__SNIDDL_AJAX__ = {
  data: {!! json_encode([
      '_token' => csrf_token(),
  ]) !!}
};
$(document).on('click', function(event) {
  if (!$(event.target).closest('.module .dropdown, .module .image, .module .options').length) {
    $('.module .options').hide();
    $('.module').removeClass('disabled').removeClass('enabled')
  }
});
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>
