$('.module .dropdown, .module .image').click(function(){
  this_option = $(this).siblings('.options')
  this_parent = $(this).parent()
  $('.module .options').not(this_option).hide();
  $('.module').removeClass('disabled').removeClass('enabled')
  $('.module').not(this_parent).addClass('disabled')
  $(this_parent).addClass('enabled')
  this_option.toggle();
})

$('.module .options .item:first-child').hover(function(){
  $(this).parent().toggleClass('changeAfter')
})
$('.module .options .item').click(function(){
  option_html = $(this).find('.choice').html()
  $(this).parent().children('.item').not(this).find('i').addClass('fa-square-o').removeClass('fa-check-square-o');
  $(this).find('i').toggleClass('fa-square-o').toggleClass('fa-check-square-o');
  if ($(this).find('i').hasClass('fa-check-square-o')) {
    $(this).parent().siblings('.dropdown').find('.selected').html(option_html)
  }
})
