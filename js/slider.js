(function ($) {
    $.fn.showHide = function (options) {
        var defaults = {
            speed: 100,
            easing: '',
            changeText: 0,
            showText: 'Show',
            hideText: 'Hide'
        };
        var options = $.extend(defaults, options);
        $(this).click(function () {
                      $('.toggleDiv').slideUp(options.speed, options.easing);
             var toggleClick = $(this);
             var toggleDiv = $(this).attr('rel');
             $(toggleDiv).slideToggle(options.speed, options.easing, function() {
             if(options.changeText==1){
             $(toggleDiv).is(":visible") ? toggleClick.text(options.hideText) : toggleClick.text(options.showText);
             }
              });
          return false;
        });
    };
})(jQuery);
$(document).ready(function(){
   $('.show_hide').showHide({});
});