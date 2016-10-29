(function ($, Drupal) {
  /**
   * Toggle show/hide links for off canvas layout.
   */
  Drupal.behaviors.omegaEwingchunFrontpageLayout = {
    attach: function (context) {
      $('#ewingchun').click(function(e) {
        if (!$(this).hasClass('is-visible')) {
          $(this).addClass('is-visible');
          e.preventDefault();
          e.stopPropagation();
        }
      });

      $('#ewingchun-hide').click(function(e) {
        $(this).parent().removeClass('is-visible');
        e.preventDefault();
        e.stopPropagation();
      });

      $('.l-page').click(function(e) {
        if($('#ewingchun').hasClass('is-visible') && $(e.target).closest('#ewingchun').length === 0) {
          $('#ewingchun').removeClass('is-visible');
          e.stopPropagation();
        }
      });
    }
  };

})(jQuery, Drupal);
