jQuery(function($) {
  // Make Bootstrap Menu Dropdowns Work on Mobile
  $( '.dropdown-toggle' ).after( '<i class="fas fa-plus krakatoa-toggle" data-toggle="dropdown"></i>' );
  // Remove Gutenberg styles from Boostrap columns
  $('.row>.wp-block-column').removeClass('wp-block-column');
});
