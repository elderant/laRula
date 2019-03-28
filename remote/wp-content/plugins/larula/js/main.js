( function( $ ) {

  var larula_update_timer = function() {
    var x = setInterval(function() {
      let $countdown = $('.page-id-10 .main-banner-section .countdown');
      let interval = $countdown.attr('milliseconds');
      
      interval = interval - 1;
      $countdown.attr('milliseconds', interval);

      if (interval < 0) {
        clearInterval(x);
        $countdown.html("Expiro");
      }
      else {
        let days = Math.floor(interval / (60 * 60 * 24));
        let hours = Math.floor((interval % (60 * 60 * 24)) / (60 * 60));
        let minutes = Math.floor((interval % (60 * 60)) / (60));
        let seconds = Math.floor(interval % (60));
        $countdown.html(days + ' dias ' + hours + ' horas ' + minutes + ' minutos ' + seconds + ' segundos');
      }
    }, 1000);
  }

  var larula_handle_display_overlay = function(event) {
    let $banner = $(event.target);
    if(!$banner.hasClass('banner')) {
      $banner = $banner.parents('.banner');
    }
    
    let $overlay = $banner.siblings('.overlay');
    $overlay.stop(true, true);
    $overlay.fadeIn(500, function() {
      $(this).removeClass('hidden');
      $(this).css('display', '');
    });
  }

  var larula_handle_hide_overlay = function(event) {
    let $overlay = $(event.currentTarget);

    $overlay.stop(true, true);
    $overlay.fadeOut(500, function() {
      $(this).addClass('hidden');
      $(this).css('display', '');
    });
  }

  /* Slider events */
  var larula_slider_handle_page_change = function(event) {
    let $sliderContainer = $(event.target).parents('.slider-container');
    let slideCount = parseInt($sliderContainer.attr('data-slides'));

    let newSlideNumber = parseInt($(event.target).attr('data-page'));

    let $currentSlide = $sliderContainer.find('.slides li.active');
    let $newSlide = $sliderContainer.find('.slides li[data-page="' + newSlideNumber + '"]');
    
    let currentSlideNumber = parseInt($currentSlide.attr('data-page'));

    let $currentButton = $sliderContainer.find('.slider-paging .page-button[data-page="' + currentSlideNumber + '"]');

    if(slideCount == 2) {
      // change buttons
      $(event.target).toggleClass('active');
      $currentButton.toggleClass('active');

      // Change slide
      $currentSlide.fadeOut(500, function() {
        if(newSlideNumber == 1) {
          $currentSlide.toggleClass('right');
        }
        else {
          $currentSlide.toggleClass('left');
        }
        $currentSlide.toggleClass('active');
        $newSlide.css('display', 'none');
        $newSlide.removeClass('left');
        $newSlide.removeClass('right');
        $newSlide.toggleClass('active');
        $newSlide.fadeIn(500, function() {  
          $newSlide.css('display', '');
          $currentSlide.css('display', '');
        });
      });
      
    }
    else if(slideCount > 2) {
      // change buttons
      $(event.target).toggleClass('active');
      $currentButton.toggleClass('active');

      $sliderContainer.find('.slides li.left').toggleClass('left');
      $sliderContainer.find('.slides li.right').toggleClass('right');

      $currentSlide.fadeOut(500, function() {
        //assing left and right slides
        $sliderContainer.find('.slides li[data-page="' + String(newSlideNumber - 1) + '"]').toggleClass('left');
        $sliderContainer.find('.slides li[data-page="' + String(newSlideNumber + 1) + '"]').toggleClass('right');
        if(newSlideNumber == 1) {
          $sliderContainer.find('.slides li[data-page="' + slideCount + '"]').toggleClass('left');
        }
        if( newSlideNumber == slideCount) {
          $sliderContainer.find('.slides li[data-page="' + 1 + '"]').toggleClass('right');
        }
        $currentSlide.toggleClass('active');
        $newSlide.css('display', 'none');
        $newSlide.toggleClass('active');
        $newSlide.fadeIn(500, function() {  
          $newSlide.css('display', '');
          $currentSlide.css('display', '');
        });
      });
    }

  }

  var larula_slider_handle_direction_event = function(event) {
    let $sliderContainer = $(event.currentTarget).parents('.slider-container');
    let slideCount = parseInt($sliderContainer.attr('data-slides'));

    let $currentSlide = $sliderContainer.find('.slides li.active');
    let currentSlideNumber = parseInt($currentSlide.attr('data-page'));
    let direction = $(event.currentTarget).attr('data-direction');

    if (slideCount == 2) {
      if(currentSlideNumber == 1) {
        if (direction == 'left') {
          $currentSlide.toggleClass('fail-left');
          setTimeout(function(){
            $currentSlide.toggleClass('fail-left');
          },300);
        }
        else {
          $sliderContainer.find('.slider-paging .page-button.active').toggleClass('active');
          let $newbutton = $sliderContainer.find('.slider-paging .page-button[data-page=2]');
          $newbutton.toggleClass('active');

          $newSlide = $sliderContainer.find('.slides li[data-page="' + String(currentSlideNumber + 1) + '"]');
          $newSlide.toggleClass('active');
          $newSlide.toggleClass('right');
          $currentSlide.toggleClass('left');
          $currentSlide.toggleClass('active');
        }
      }
      else {
        if (direction == 'right') {
          $currentSlide.toggleClass('fail-right');
          setTimeout(function(){
            $currentSlide.toggleClass('fail-right');
          },300);
        }
        else {
          $sliderContainer.find('.slider-paging .page-button.active').toggleClass('active');
          let $newbutton = $sliderContainer.find('.slider-paging .page-button[data-page=1]');
          $newbutton.toggleClass('active');

          $newSlide = $sliderContainer.find('.slides li[data-page="' + String(currentSlideNumber -1) + '"]');
          $newSlide.toggleClass('active');
          $newSlide.toggleClass('left');
          $currentSlide.toggleClass('right');
          $currentSlide.toggleClass('active');
        }
      }
    }
    else if(slideCount > 2) {
      if (direction == 'left') {
        $sliderContainer.find('.slides li.right').toggleClass('right');
        $sliderContainer.find('.slider-paging .page-button.active').toggleClass('active');
        
        let $newSlide = $sliderContainer.find('.slides li.left');
        let newButtonNumber = currentSlideNumber == 1? slideCount: currentSlideNumber - 1;
        let $newbutton = $sliderContainer.find('.slider-paging .page-button[data-page=' + newButtonNumber + ']');
        
        $newbutton.toggleClass('active');
        $newSlide.toggleClass('active');
        $newSlide.toggleClass('left');
        $currentSlide.toggleClass('right');
        $currentSlide.toggleClass('active');

        setTimeout(function(){
          if(currentSlideNumber == 1) {
            $leftSlide = $sliderContainer.find('.slides li[data-page="' + String(slideCount - 1) + '"]');
          }
          else if(currentSlideNumber == 2) {
            $leftSlide = $sliderContainer.find('.slides li[data-page="' + String(slideCount) + '"]');
          }
          else {
            $leftSlide = $sliderContainer.find('.slides li[data-page="' + String(currentSlideNumber - 2) + '"]');
          }
          $leftSlide.css('display', 'none');
          $leftSlide.toggleClass('left');
          $leftSlide.fadeIn(1000, function(){
            $(this).css('display', '');
          });
        }, 20);
      }
      else {
        $sliderContainer.find('.slides li.left').toggleClass('left');
        $sliderContainer.find('.slider-paging .page-button.active').toggleClass('active');
        
        let $newSlide = $sliderContainer.find('.slides li.right');
        let newButtonNumber = currentSlideNumber == slideCount? 1: currentSlideNumber + 1;
        let $newbutton = $sliderContainer.find('.slider-paging .page-button[data-page=' + newButtonNumber + ']');

        $newbutton.toggleClass('active');
        $newSlide.toggleClass('active');
        $newSlide.toggleClass('right');
        $currentSlide.toggleClass('left');
        $currentSlide.toggleClass('active');

        setTimeout(function(){
          if(currentSlideNumber == slideCount) {
            $rightSlide = $sliderContainer.find('.slides li[data-page="' + 2 + '"]');
          }
          else if(currentSlideNumber + 1 == slideCount) {
            $rightSlide = $sliderContainer.find('.slides li[data-page="' + 1 + '"]');
          }
          else {
            $rightSlide = $sliderContainer.find('.slides li[data-page="' + String(currentSlideNumber + 2) + '"]')
          }
          $rightSlide.css('display', 'none');
          $rightSlide.toggleClass('right');
          $rightSlide.fadeIn(1000, function(){
            $(this).css('display', '');
          });
        }, 20);
      }
    }
  }
  /* END Slider events */

  $(document).ready(function () {
    if($('.page-id-10 .main-banner-section').length > 0) {
      larula_update_timer();
      
      $('.main-banner-section .banner').on('mouseenter', function(event) {
        larula_handle_display_overlay(event);
      });
      $('.main-banner-section .additional-info').on('mouseenter', function(event) {
        if(!$(this).hasClass('hidden')) {
          $(this).stop(true, true);
        }
      });
      $('.main-banner-section .additional-info').on('mouseleave', function(event) {
        larula_handle_hide_overlay(event);
      });

      $('.page-id-10 .slider-container .slider-paging .page-button').each(function(){
        $(this).on('click', function(event){
          larula_slider_handle_page_change(event);
        });
      });

      $('.page-id-10 .slider-container .slider-direction .direction-button').each(function(){
        $(this).on('click', function(event){
          larula_slider_handle_direction_event(event);
        });
      });
    }
  });
} (jQuery) );