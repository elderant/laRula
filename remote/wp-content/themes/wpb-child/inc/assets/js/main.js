( function( $ ) {

  function getUrlVars() {
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
  } 

  $(document).ready(function () {
    if($('.woocommerce.archive').length > 0) {
      let params = getUrlVars();
      if(jQuery.inArray('id', params) != -1) {
        $id = params['id'];

        jQuery("html, body").animate({ scrollTop: jQuery('.products  #post-106').offset().top - 128}, 500);
      }
      
    }
  });
} (jQuery) );