jQuery(document).ready(function($) {
  var customPostType = 'lfl_team'; // Replace with your custom post type
  if ($('body').hasClass('post-type-' + customPostType)) {
      $('#title-prompt-text').text('Add name'); 
  }
});

jQuery(document).ready(function($) {
  var customPostType = 'lfl_brands'; // Replace with your custom post type
  if ($('body').hasClass('post-type-' + customPostType)) {
      $('#title-prompt-text').text('Add brand name'); 
  }
});

jQuery(document).ready(function($) {
  var customPostType = 'lfl_wwd'; // Replace with your custom post type
  if ($('body').hasClass('post-type-' + customPostType)) {
      $('#title-prompt-text').text('Add What We Do title'); 
  }
});
