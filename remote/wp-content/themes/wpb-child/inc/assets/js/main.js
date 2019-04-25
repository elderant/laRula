( function( $ ) {
  window.debounce_timer = 0;

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
  
  /**
  * Disables all links and changes cursor for the website, used in ajax calls.
  */
 var webStateWaiting = function(waiting){
    if(waiting) {
      $('body').css('cursor', 'progress');
    }
    else {
      $('body').css('cursor', 'default');
    }
    
    $('a').each(function() {
      if(!$(this).hasClass('disabled') && waiting && !$(this).hasClass('language-option') && !$(this).hasClass('menu-end-post-denominacion-a')) {
        $(this).addClass('disabled');	
      }
      else if ($(this).hasClass('disabled') && !waiting && !$(this).hasClass('language-option') && !$(this).hasClass('menu-end-post-denominacion-a')) {
        $(this).removeClass('disabled');
      }
    });
  }

  var larula_handle_show_proteccion_datos = function(event) {
    // Add modal dialog if necesary
    let $modal = $('body > .modal');
    if( $modal.length == 0 ) {
      $modalObject = $('<div></div>')
        .addClass('modal')
        .append(
          $('<div></div>')
          .addClass('modal-overlay')
        );

      $('body').append($modalObject);
      $modal = $('body > .modal');

      $modal.find('.modal-overlay').on('click', larula_handle_hide_proteccion_datos);
    }

    // Retreive privacy policy if necesary
    let $contentContainer = $(event.target).parents('.proteccion-datos').find('.terms-and-conditions-content');
    if($contentContainer.children().length == 0) {
      $.ajax({
        url : ajax_params.ajax_url,
        type : 'post',
        data : {
          action : 'get_privacy_policy_html',
        },
        success : function( response ) {
          $contentContainer.append(response);

          // add policy to modal and display.
          let $modalDialog = $modal.find('.modal-dialog.privacy-policy');

          if( $modalDialog.length > 0 ) {
            $modalDialog.toggleClass('hidden');
          }
          else {
            $modalDialog = $contentContainer.find('.modal-dialog').clone();
            $modal.append($modalDialog);
          }

          $modal.fadeIn(500);

          webStateWaiting(false);
        },
        beforeSend: function() {
          webStateWaiting(true);
          return true;
        },
      });
    }

    // add policy to modal and display.
    let $modalDialog = $modal.find('.modal-dialog.privacy-policy');

    if( $modalDialog.length > 0 ) {
      $modalDialog.toggleClass('hidden');
    }
    else {
      $modalDialog = $contentContainer.find('.modal-dialog').clone();
      $modal.append($modalDialog);
    }

    $modal.fadeIn(500);
  }

  var larula_handle_hide_proteccion_datos = function () {
    $modal = $(this).parents('.modal');
    $modal.fadeOut(500);
    $modal.find('.modal-dialog:not(.hidden)').toggleClass('hidden');
  }

  //************** Window Scroll ************************//
	var goToTopDebouncer = function(event) {
		if(window.debounce_timer) {
			window.clearTimeout(debounce_timer);
		}
		
		debounce_timer = window.setTimeout(function() {
      if(window.scrollY > 500){
        let $goToTop = $('#footer-widget .go-to-top');
        if(!$goToTop.hasClass('display')) {
          $goToTop.toggleClass('display');
        }
      }
      else {
        let $goToTop = $('#footer-widget .go-to-top');
        if($goToTop.hasClass('display')) {
          $goToTop.toggleClass('display');
        }
      }
      //console.log(window.scrollY);
		}, 100);
	}
	
	$(window).on( 'scroll', goToTopDebouncer );

  //************** Document Ready ************************//
  $(document).ready(function () {
    if($('.woocommerce.archive').length > 0) {
      let params = getUrlVars();
      if($.inArray('id', params) != -1) {
        $id = params['id'];

        if($('.products #' + $id).length > 0) {
          $("html, body").animate({ scrollTop: $('.products #' + $id).offset().top - 128}, 500);
        }
        else if($('#' + $id + '.featured').length > 0) {
          $("html, body").animate({ scrollTop: $('#' + $id + '.featured').offset().top - 128}, 500);
        }
      }
    }
    if($('#footer-widget .go-to-top').length > 0) {
      let $goToTop = $('#footer-widget .go-to-top');
      $goToTop.on('click', function(event) {
        $('html, body').animate({scrollTop:0}, '1000');
      });
    }

    $('.wpcf7-form.preins-form').each(function(){
      $(this).find('.privacy-policy-link').on('click', function(event){
        larula_handle_show_proteccion_datos(event);
      });
    });

  });
} (jQuery) );