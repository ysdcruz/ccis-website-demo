let windowSize = null; // innerWidth of window: S (w <= 500), M (500 < w < 1025), L (w >= 125)
let initSize = null;
let hasResized = false;
let lastScroll = 0;

function isBrowserIE() {
  let userAgent = window.navigator.userAgent;

  return userAgent.indexOf('MSIE') > -1 || userAgent.indexOf('Trident/') > -1 || userAgent.indexOf('Edge/') > -1;
}

function isElementVisible(element) {
  let position = element.getBoundingClientRect();
  let width = window.innerWidth || document.documentElement.clientWidth;
  let height  = window.innerHeight || document.documentElement.clientHeight;
  let topElement = function(x, y) {
    return document.elementFromPoint(x, y);
  };     

  // Return false if it's not in the viewport
  if(position.right < 0 || position.bottom < 0 || position.left > width || position.top > height)
    return false;

  // Return true if any of its four corners are visible
  return (element.contains(topElement(position.left, position.top))
    || element.contains(topElement(position.right, position.top))
    || element.contains(topElement(position.right, position.bottom))
    || element.contains(topElement(position.left, position.bottom))
  );
}

function getSize(width) {
  return width >= 1025 ? 'L' : (width > 500 ? 'M' : 'S');
}

function setResponsive(isResponsive) {
  if(isResponsive) {
    $('#nav').addClass('nav-responsive');
    $('#notif-nav').addClass('notif-responsive');
    $('#profile-nav').addClass('profile-responsive');
  } else {
    $('#nav').removeClass('nav-responsive');
    $('#notif-nav').removeClass('notif-responsive');
    $('#profile-nav').removeClass('profile-responsive');
  }
}

function setWindowStyle() {
  if(windowSize != null)
    initSize = windowSize;

  windowSize = getSize(window.innerWidth);
  setTitleBreak(windowSize);

  hasResized = initSize == null || (initSize != null && initSize != windowSize);

  if(windowSize == 'L') {
    setResponsive(false);
    $('.dropdown').removeClass('sub-menu-animation');
    if($('#nav').hasClass('nav-toggle'))
      $('#nav-bar').click();
    if($('#notif-nav').hasClass('notif-toggle')) {
      $('#notif-container').removeClass('notif-toggle');
      $('#notif-nav').removeClass('notif-toggle');
      $('#nav-bg').css('display', 'none');
      setBodyFixed(false);
    } else if($('#profile-nav').hasClass('profile-toggle')) {
      $('#user-container').removeClass('profile-toggle');
      $('#profile-nav').removeClass('profile-toggle');
      $('#nav-bg').css('display', 'none');
      setBodyFixed(false);
    }
  } else
    setTimeout(setResponsive(true), 200);

  if($('.home-header').length && window.scrollY == 0)
    setHeaderIcon(true);
  
  if($('.sign-in-header').length && hasResized)
    setSignupPage();

  if($('#program-inner').length)
    setTabName();

  if($('#grid-header').length) {
    if(windowSize == 'S')
      $('.grid-link').removeClass('swipe-animation');
    else {
      if(isElementVisible(document.getElementsByClassName('preview-grid')[0]))
        $('.grid-link').removeClass('swipe-animation');
    }
  }

  if($('#sort-selected').length) {
    if(windowSize == 'L')
      $('.forum-selection-responsive').css({
        'display': 'flex',
        'opacity': '1',
        'visibility': 'visible'
      });
    else 
      $('.forum-selection').css({
        'display': 'none',
        'opacity': '0',
        'visibility': 'hidden'
      });
  }

  if($('#gallery-sec').length && hasResized) {
    $('#slide-banner').css({
      'width': '',
      'transform': 'translateX(0)'
    });
    setTimeout(setBannerSize, 400);
  }

  if($('#profile-body').length && hasResized) {
    $('#docu-options > .dropdown-selected-content').removeClass('dropdown-active');
    $('#docu-filter').css({
      'display': (windowSize == 'L' ? 'flex' : 'none'),
      'opacity': (windowSize == 'L' ? '1' : '0'),
      'visibility': (windowSize == 'L' ? 'visible' : 'hidden')
    });
  }
}

function setTitleBreak(size) {
  if(!$('.sign-in-ccis').length) {
    if(size == 'S')
      $('#ccis').html($('#ccis').attr('data-web_Init'));
    else
      $('#ccis').html($('#ccis').attr('data-web_Name'));
  }
}

function setSticky(isSticky) {
  if(isSticky)
    $('header').addClass('sticky');
  else
    $('header').removeClass('sticky');
}

function setHeaderIcon(isTransparent) {
  if(isTransparent) {
    $('#search-icon-white').removeClass('hidden');
    $('#search-icon').addClass('hidden');
    $('#notif-icon-white').removeClass('hidden');
    $('#notif-icon').addClass('hidden');
    $('#user-icon-white').removeClass('hidden');
    $('#user-icon').addClass('hidden');
  } else {
    $('#search-icon-white').addClass('hidden');
    $('#search-icon').removeClass('hidden');
    $('#notif-icon-white').addClass('hidden');
    $('#notif-icon').removeClass('hidden');
    $('#user-icon-white').addClass('hidden');
    $('#user-icon').removeClass('hidden');
  }
}

function setStickyTitle(isDown) {
  if(isDown) {
    setSticky(true);
    setHeaderIcon(false);

    if(windowSize == 'L')
      $('header').css('transform', 'translateY(-' + $('#website-header-container').height() + 'px)');
  } else {
    if($('#nav-header-container').length)
      if(window.scrollY < document.getElementById('nav-header-container').offsetTop)
        setTimeout(function() {
          setSticky(false);
        }, 150);

    $('header').css('transform', 'translateY(0)');

    if($('.home-header').length && window.scrollY == 0)
      setHeaderIcon(true);
  }
}

function setBodyFixed(isFixed) {
  let windowScroll = $(document.body).css('top');
  let scrollPosition = window.scrollY;
  $(document.body).css({
    'overflow': isFixed ? 'hidden' : '',
    'position': isFixed ? 'fixed' : '',
    'top': isFixed ? -scrollPosition : '',
    'width': isFixed ? '100vw' : ''
  });
  $('header').removeClass('sticky');
  $('header').css('top', (isFixed && windowSize == 'L') ? scrollPosition : '');

  if(!isFixed)
    $(document).scrollTop(parseFloat(windowScroll) * -1);
}

function setSignupPage() {
  let isLogin = window.location.hash == '#log-in';

  if(isLogin) {
    $('#sign-up-prompt').addClass('prompt-active');
  } else {
    $('#sign-in-prompt').addClass('prompt-active');
  }

  $('#sign-up-container').css('left', isLogin ? '-100%' : '0');
  $('#sign-in-container').css('right', isLogin ? '0' : '-100%');
  $('#go-sign-up').css('display', isLogin ? 'flex' : 'none');
  $('#go-sign-in').css('display', isLogin ? 'none' : 'flex');

  if(windowSize == 'L') {
    $('#ccis').css('color', isLogin ? '#FFF' : '#2B463C');
    $('#overlay').css('transform', isLogin ? 'translateX(0)' : 'translateX(-50%)');
      
    if(isLogin) {
      $('#close-label').removeClass('has-bg');
      $('#close-white').addClass('hidden');
      $('#overlay-size').addClass('overlay-left');
      $('#overlay-size').removeClass('overlay-right');
    } else {
      $('#close-label').addClass('has-bg');
      $('#close-green').addClass('hidden');
      $('#overlay-size').removeClass('overlay-left');
      $('#overlay-size').addClass('overlay-right');
    }
  } else {
    $('#close-green').removeClass('hidden');
    $('#close-white').addClass('hidden');
    $('#overlay').css('transform', 'translateX(0)');
  }
}

function signupPageAnime() {
  let isSignUp = window.location.hash == '#sign-up';

  if(isSignUp) {
    $('#sign-up-prompt').removeClass('prompt-active');
    $('#sign-in-prompt').addClass('prompt-active');

    if(windowSize == 'L')
      setTimeout(function() {
        $('#close-green').addClass('hidden');
        $('#close-white').removeClass('hidden');
      }, 1000);
    
    $('#sign-in-container').css('right', '-100%');
    $('#sign-in-container').fadeOut(800);
        
    $('#sign-up-container').css('display', 'flex').hide().fadeIn(800)
    setTimeout(function() {
      $('#sign-up-container').css('left', '0');
    }, 300);

    $('#go-sign-up').fadeOut(800);
    
    setTimeout(function() {
      $('#go-sign-in').css('display', 'flex').hide().fadeIn(300);
    }, 800);
  } else {
    $('#sign-up-prompt').addClass('prompt-active');
    $('#sign-in-prompt').removeClass('prompt-active');

    if(windowSize == 'L')
      setTimeout(function() {
        $('#close-green').removeClass('hidden');
        $('#close-white').addClass('hidden');
      }, 500);
    
    $('#input-student-no').css('max-height', '0');

    $('#sign-in-container').css('display', 'flex').hide().fadeIn(800);
    setTimeout(function() {
      $('#sign-in-container').css('right', '0');
    }, 300);
    
    $('#sign-up-container').css('left', '-100%');
    $('#sign-up-container').fadeOut(800);

    setTimeout(function() {
      $('#go-sign-up').css('display', 'flex').hide().fadeIn(300);
    }, 800);
    
    $('#go-sign-in').fadeOut(800);
  }

  if(windowSize == 'L') {
    $('#ccis').css('color', isSignUp ? '#2B463C' : '#FFF');
    $('#overlay').css('transform', isSignUp ? 'translateX(-50%)' : 'translateX(0)');
    $('#overlay-size').addClass('overlay-anime');
    setTimeout(function() {
      $('#overlay-size').removeClass('overlay-anime');
    }, 1800);

    if(isSignUp) {
      $('#close-label').addClass('has-bg');
      $('#overlay-size').removeClass('overlay-left');
      $('#overlay-size').addClass('overlay-right');
    } else {
      $('#close-label').removeClass('has-bg');
      $('#overlay-size').addClass('overlay-left');
      $('#overlay-size').removeClass('overlay-right');
    }
  } else {
    $('#overlay').css('transform', 'translateX(0)');
  }
}

function checkEmail(strEmail) {
  let emailRegex = /^(([^.@()[\]\\;:"\s<>]+(\.[^.@()[\]\\;:"\s<>]+)*)|(".+"))@(([A-Za-z\-0-9]+\.)+[A-Za-z]{2,})$/;
  return strEmail.match(emailRegex) != null;
}

function strengthChecker(password) {
  let strongCheck = new RegExp('^(?=.{14,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$', 'g');
  let mediumCheck = new RegExp('^(?=.{8,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$', 'g');
  
  if(strongCheck.test(password))
    return 3;
  else if(mediumCheck.test(password))
    return 2;
  else
    return 1;
}

function brToli(str) {
  let info = str.split('<br/>');
  return '<li>' + info.join('</li><li>') + '</li>';
}

function addRecentNews(postInfo) {
  let article = document.createElement('article');
  $(article).attr({
    'class': 'preview-article',
    'data-news_Link': postInfo.news_Link,
    'data-img_Src': '../' + postInfo.cover_Img,
    'data-img_Alt': postInfo.post_Title,
    'data-prev_Head': postInfo.post_Title,
    'data-prev_Date': postInfo.post_Create
  });

  let link = document.createElement('a');
  $(link).attr({
    'href': postInfo.news_Link,
    'class': 'recent-thumbnail'
  });

  let thumbnail = document.createElement('img');
  $(thumbnail).attr({
    'src': '../' + postInfo.cover_Img,
    'alt': postInfo.post_Title,
  });

  $(link).append(thumbnail);

  let div = document.createElement('div');
  
  let previewHeadline = document.createElement('p');
  $(previewHeadline).attr('class', 'preview-headline');

  let headlineLink = document.createElement('a');
  $(headlineLink).attr('href', postInfo.news_Link);
  $(headlineLink).html(postInfo.post_Title);

  $(previewHeadline).append(headlineLink);

  let previewDate = document.createElement('p');
  $(previewDate).attr('class', 'preview-date');
  $(previewDate).html(postInfo.post_Create);

  $(div).append(previewHeadline, previewDate);
  $(article).append(link, div);
  $(article).insertBefore('#preview-background');
}

function cancelReplyUpdate(type) {
  $('#input-header').html('Your ' + (type == 1 ? 'reply' : 'answer'));
  $('#body-thread').find('.ql-editor').html('<p><br></p>');

  $('#thread-replies').removeClass('hidden');
  $('#create-reply').removeClass('hidden');
  $('#update-reply').addClass('hidden');

  if($('#reply-cancel-btn').attr('data-thread_Open') == '0')
    $('#write-reply').addClass('hidden');
}

function setUndergraduateInfo(element) {
  $('#program-header').html(htmlDecode($(element).attr('data-header')));
  $('#program-desc').html(htmlDecode($(element).attr('data-desc')));
  $('#program-mission').html(htmlDecode($(element).attr('data-mission')));
  $('#program-objective-intro').html(htmlDecode($(element).attr('data-objective-intro')));
  $('#program-objective').html(htmlDecode($(element).attr('data-objective')));
  $('#program-admission-intro').html(htmlDecode($(element).attr('data-admission-intro')));
  $('#program-reqs-freshmen').html(htmlDecode($(element).attr('data-reqs-freshmen')));
  $('#program-reqs-shiftee').html(htmlDecode($(element).attr('data-reqs-shiftee')));
  $('#program-reqs-transferee').html(htmlDecode($(element).attr('data-reqs-transferee')));
  $('#program-retention').html(htmlDecode($(element).attr('data-retention')));
  $('#program-reqs-graduation').html(htmlDecode($(element).attr('data-reqs-graduation')));
  $('#program-career').html(htmlDecode($(element).attr('data-career')));

  window.location.hash = $(element).attr('data-hash');
}

function setGraduateInfo(element) {
  $('#program-header').html(htmlDecode($(element).attr('data-header')));
  $('#program-desc').html(htmlDecode($(element).attr('data-desc')));
  $('#program-objective-intro').html(htmlDecode($(element).attr('data-objective-intro')));
  $('#program-objective').html(htmlDecode($(element).attr('data-objective')));
  $('#program-provisions').html(htmlDecode($(element).attr('data-provisions')));

  window.location.hash = $(element).attr('data-hash');
}

function resetProgram() {
  $('#program-header').html('');
  $('#program-desc').html('');
  $('#program-mission').html('');
  $('#program-provisions').html('');
  $('#program-objective-intro').html('');
  $('#program-objective').html('');
  $('#program-admission-intro').html('');
  $('#program-reqs-freshmen').html('');
  $('#program-reqs-shiftee').html('');
  $('#program-reqs-transferee').html('');
  $('#program-retention').html('');
  $('#program-reqs-graduation').html('');
  $('#program-career').html('');

  history.pushState(null, null, ' ');
}

function setGenSearch() {
  if($('#modal-search').val() != '') {
    let search = $('#modal-search').val();
    let searchArr = search.split(' ');
    let newSearch = '';
    
    let isSpace = false;
    for(let i = 0; i < searchArr.length; i++) {
      if(searchArr[i] == '') {
        if(i == 0)
          newSearch += ' ';
        else
          newSearch += '+ ';

        isSpace = true;
      } else {
        if(i != 0)
          newSearch += '+';

        newSearch += searchArr[i];

        isSpace = false;
      }
    }

    let path = window.location.pathname;
    let page = path.split('/').pop();
    let parentDir = $(location).prop('href').split(page)[0];
    parentDir = parentDir.split('/').slice(0,-1).pop();
    let type = '';

    if($('#search-type').length)
      type = '&type=' + ($('#search-page').hasClass('is-selected') ? 'page' : 'news');

    if(parentDir == 'CCIS_Website') {
      window.location = 'search.html?search=' + newSearch + type;
    } else
      window.location = '../search.html?search=' + newSearch + type;
  }
}

function setConfirmClose() {
  $('#confirm-modal i').removeClass();
  $('#confirm-modal i').addClass('fas fa-question-circle fa-3x alert-blue');
  $('#confirm-modal .modal-alert-header').html('Confirm');
  $('#confirm-modal .modal-alert-content').html('You haven\'t finished editing yet. Are you sure you want to close?');

  $('#confirm-yes-cancel').css('display', 'flex');
  $('#confirm-modal').css('display', 'flex');
}

$(document).on('click', '.modal:not(#load-modal)', function(evt) {
  if(evt.target !== evt.currentTarget)
    return;

  let isClose = true;

  if($(this).attr('id') == 'new-req-modal') {
    $(this).find('input:not([type = "checkbox"])').val('');
    $(this).find('input[type = "checkbox"]').prop('checked', false);
    $('#req-date-container').removeClass('is-urgent')
    $('#reqs-docu').removeClass('has-reqs');
  } else if($(this).attr('id') == 'change-dp-modal') {
    if($('#change-dp-container').find('i').hasClass('hidden')) {
      isClose = false;
      setConfirmClose();
    }
  }

  if(isClose) {
    $(this).fadeOut(100);
    setBodyFixed(false);
  }
});

$(document).on('click', '.modal-dismiss', function() {
  let modal = $(this).hasClass('modal-dismiss-btn') ? $(this).parent().parent().parent().parent().parent() : $(this).parent().parent().parent().parent();
  let isClose = true;

  if($(modal).attr('id') == 'new-req-modal') {
    $(modal).find('input:not([type = "checkbox"])').val('');
    $(modal).find('input[type = "checkbox"]').prop('checked', false);
    $('#req-date-container').removeClass('is-urgent')
    $('#reqs-docu').removeClass('has-reqs');
    $('.file-link').text('');
  } else if($(modal).attr('id') == 'change-dp-modal') {
    if($('#change-dp-container').find('i').hasClass('hidden')) {
      isClose = false;
      setConfirmClose();
    }
  } else if($(modal).attr('id') == 'delete-modal' || $(modal).attr('id') == 'report-modal') {
    $('.delete-reason').removeClass('selected-reason');
    $('.report-reason').removeClass('selected-reason');

    $('#redundant-link-container').removeClass('redundant-selected');
    $('#report-detail-container').removeClass('delete-detail-selected');
    $('#report-detail-container').removeClass('report-detail-selected');

    $('#redundant-link').val('');
    $('#delete-detail').val('');
    $('#report-detail').val('');
  } else if($(modal).attr('id') == 'docu-req-modal'){
    setTimeout(function() {
      $('#req-control').html('');
      $('#datereq').html('');
      $('#req-urgency').html('');
      $('#req-purpose').html('');
      $('.process-admin-name').text('');
      $('#req-docus').find('tbody>tr>td').html('');
      $('#req-docus').find('tbody>tr>td').html('');
      $('#process-pending').removeClass('hidden');
      $('#process-approved').removeClass('hidden');
      $('#process-reject').removeClass('hidden');
      $('#process-resubmit').removeClass('hidden');
      $('#process-complete').removeClass('hidden');
      $('#resubmit-upload').val('');
      $('.file-link').text('');
    }, 150);
  }

  if(isClose) {
    $(modal).fadeOut(100);
    setBodyFixed(false);
  }
});

$(document).on('click', '.confirm-close', function() {
  if($(this).attr('id') == 'cancel-update')
    cancelReplyUpdate($(this).attr('data-thread_Type') == 'D' ? 1 : 2);
  if(window.location.hash == '#/about')
    setAboutUneditable();
  if(window.location.hash == '#/settings')
    clearChangePass();

  if($('#change-dp-container').css('display') == 'flex') {
    $('#change-dp-container').find('i').removeClass('hidden');
    $('#change-dp-container').find('img').attr({
      'src': '',
      'class': 'hidden'
    });
    $('#user-dp').val('');
  }

  $('.modal:not(#confirm-modal)').hide();
  setBodyFixed(false);
  $(this).parent().parent().parent().parent().parent().fadeOut(100);
});

$(document).on('click', '#nav-bg, .sidebar-close', function() {
  $('#nav').removeClass('nav-toggle');
  $('#notif-container').removeClass('notif-toggle');
  $('#notif-nav').removeClass('notif-toggle');
  $('#user-container').removeClass('profile-toggle');
  $('#profile-nav').removeClass('profile-toggle');
  $('.dropdown').removeClass('sub-menu-animation');
  $('.chevron-container').removeClass('active-dropdown');
  $('#nav-bg').css('display', 'none');
  setBodyFixed(false);
});

$(document).on('click', '#nav-bar', function() {
  $('#nav').toggleClass('nav-toggle');
  $('.dropdown').removeClass('sub-menu-animation');
  $('.chevron-container').removeClass('active-dropdown');
  $('#nav-bg').css('display', $('#nav').hasClass('nav-toggle') ? 'block' : 'none');
  setBodyFixed($('#nav').hasClass('nav-toggle'));
});

$(document).on('mouseenter', '.nav-tab', function() {
  if(window.innerWidth > 1024)
    $(this).find('.dropdown').addClass('sub-menu-animation');
});

$(document).on('mouseleave', '.nav-tab', function() {
  if(window.innerWidth > 1024)
    $(this).find('.dropdown').removeClass('sub-menu-animation');
});

$(document).on('click', '.nav-tab', function(evt) {
  let goLink = false;

  if(evt.target === this.querySelector('a'))
    goLink = true;
  else if(evt.target === this.querySelector('.dropdown') || evt.target === this.querySelector('.sub-menu') || $(this).is(':last-child'))
    goLink = false;

  if(windowSize != 'L' && !goLink) {
    $(this).find('.chevron-container').toggleClass('active-dropdown');
    $(this).find('.dropdown').toggleClass('sub-menu-animation');
    return;
  } else if(windowSize == 'L' && !goLink) {
    if($(this).children('a').length > 0)
      goLink = true;
  }
  
  if(goLink)
    window.location = $(this).children('a').attr('href');
});

$(document).on('click', '#home-down > div', function() {
  $([document.documentElement, document.body]).animate({
    scrollTop: $('#main-inner').offset().top
  }, 1000);
});

$(document).on('click', '#notif-container', function() {
  $(this).toggleClass('notif-toggle');
  $('#notif-nav').toggleClass('notif-toggle');

  if($('#profile-nav').hasClass('profile-toggle')) {
    $('#user-container').removeClass('profile-toggle');
    $('#profile-nav').removeClass('profile-toggle');
  }

  if(windowSize != 'L') {
    $('#nav-bg').css('display', $('#notif-nav').hasClass('notif-toggle') ? 'block' : 'none');
    setBodyFixed($('#notif-nav').hasClass('notif-toggle'));
  }
});

$(document).on('click', '#user-container', function() {
  if($('#profile-nav').length) {
    $(this).toggleClass('profile-toggle');
    $('#profile-nav').toggleClass('profile-toggle');

    if($('#notif-nav').hasClass('notif-toggle')) {
      $('#notif-container').removeClass('notif-toggle');
      $('#notif-nav').removeClass('notif-toggle');
    }

    if(windowSize != 'L') {
      $('#nav-bg').css('display', $('#profile-nav').hasClass('profile-toggle') ? 'block' : 'none');
      setBodyFixed($('#profile-nav').hasClass('profile-toggle'));
    }
  } else
    window.location = 'sign-in.html#log-in';
});

$(document).on('click', '#sign-in-close', function() {
  if($('#forgot-pass-container').length)
    window.location = 'sign-in.html#log-in';
  else
    window.history.back();
});

$(document).on('click', '#sign-up-prompt', function() {
  window.location.hash = '#sign-up';
});

$(document).on('click', '#sign-in-prompt', function() {
  window.location.hash = '#log-in';
});

$(document).on('click', '.input-icon', function() {
  $(this).next().find('.sign-up-input').focus();
  $(this).next().find('.sign-in-input').focus();
});

$(document).on('focus', '.sign-up-input, .sign-in-input', function() {
  $(this).parent().parent().addClass('focus');
  $(this).parent().parent().removeClass('error');
  
  if($(this).attr('id') == 'sign-up-no') {
    let account;
    $('.account-radio').each(function() {
      if($(this).prop('checked')) {
        account = $(this).val();
        return false;
      }
    });
    $(this).attr('placeholder', account === '3' ? '20**-*****-MN-0' : (account === '1' ? 'CCIS-20**-****' : '*****'));
    $('#id-taken').css('max-height', '0');
  }

  if($(this).attr('id') === 'sign-up-pass') {
    if(windowSize == 'S') {
      $('#pass-strength').css('max-height', '2em');
      $('#pass-reqs').css('max-height', '5em');
    } else {
      $('#pass-strength').css('max-height', '2em');
      $('#pass-reqs').css('max-height', '4em');
    }
  }

  if($(this).hasClass('sign-in-input')) {
    $('#log-in-error').css('max-height', '0');
    $('#email-error').css('max-height', '0');
  }
});

$(document).on('blur', '.sign-up-input, .sign-in-input', function() {
  if($(this).val().length == 0)
    $(this).parent().parent().removeClass('focus');
  
  if($(this).attr('id') == 'sign-up-no') 
    $(this).attr('placeholder', '');

  if($(this).attr('id') === 'sign-up-pass') {
    $('#pass-strength').css('max-height', '0');
    $('#pass-reqs').css('max-height', '0');

    if(strengthChecker($(this).val()) < 2)
      $(this).parent().parent().addClass('error');
  }

  if($(this).attr('id') === 'sign-up-re-pass') {
    $('#pass-match').css('max-height', '0');

    if($(this).val() != $('#sign-up-pass').val())
      $(this).parent().parent().addClass('error');
  }
});

$(document).on('change', '.account-radio', function() {
  $('#input-user-no i').removeClass();

  if($(this).val() === '1') {
    $('#input-user-no i').addClass('fas fa-user-graduate');
    $('#input-user-no h5').html('Alumni ID');
  } else if($(this).val() === '2') {
    $('#input-user-no i').addClass('fas fa-user-tie');
    $('#input-user-no h5').html('Employee ID');
  } else if($(this).val() === '3') {
    $('#input-user-no i').addClass('fas fa-graduation-cap');
    $('#input-user-no h5').html('Student Number');
  } 

  $('#input-user-no').css('max-height', '4em');
});

$(document).on('blur', '#sign-in-email, #sign-up-email, #email-container input', function() {
  let isValid = checkEmail($(this).val());

  if($(this).val().length == 0)
    $(this).parent().parent().removeClass('focus');
  else if(!isValid)
    $(this).parent().parent().addClass('error');
  else
    $(this).parent().parent().removeClass('error');
});

$(document).on('input change cut paste drop keyup', '#sign-in-container input, #email-container input', function() {
  if($(this).attr('id') === 'sign-in-email' || $(this).attr('id') === 'sign-in-pass') {
    let isValid = checkEmail($('#sign-in-email').val());

    if(!isValid)
      $('#sign-in-email').parent().parent().addClass('error');
    else
      $('#sign-in-email').parent().parent().removeClass('error');

    $('#send-email-btn').attr('disabled', !isValid);

    if($(this).attr('id') == 'sign-in-pass') {
      if($(this).val().length < 8)
        $(this).parent().parent().addClass('error');
      else
        $(this).parent().parent().removeClass('error');
    }
  }

  if($('#sign-in-container').length) {
    let isComplete = ($('#sign-in-email').val().length > 0 && !$('#sign-in-email').parent().parent().hasClass('error')) && $('#sign-in-pass').val().length >= 8;

    $('#log-in-btn').attr('disabled', !isComplete);
  }
});

$(document).on('keypress', '#sign-up-no', function(evt) {
  let allowedChars = new RegExp('^[a-zA-Z0-9\-]+$');
  let str = String.fromCharCode(!evt.charCode ? evt.which : evt.charCode);
  if(allowedChars.test(str)) {
    return true;
  }

  evt.preventDefault();
  return false;
});

$(document).on('input change cut paste drop keyup', '#sign-up-container input, #reset-container input', function() {
  if($(this).attr('id') === 'sign-up-email') {
    let isValid = checkEmail($(this).val());

    if(!isValid)
      $(this).parent().parent().addClass('error');
    else
      $(this).parent().parent().removeClass('error');
  }

  if($(this).attr('id') === 'sign-up-pass') {
    if($(this).val().length < 8) {
      $('#bar-value').css({
        'background-color': '#8D8D8D',
        'max-width': $(this).val().length == 0 ? '0' : '5%'
      });
      $('#bar-description').html($(this).val().length == 0 ? 'Password is blank' : 'Too short');
      $('#bar-description').css('color', '#8D8D8D');
    } else {
      switch(strengthChecker($(this).val())) {
        case 1:
          $('#bar-value').css({
            'background-color': '#D8000C',
            'max-width': '30%'
          });
          $('#bar-description').html('Weak');
          $('#bar-description').css('color', '#D8000C');
          break;
        case 2:
          $('#bar-value').css({
            'background-color': '#F6E70E',
            'max-width': '70%'
          });
          $('#bar-description').html('Good');
          $('#bar-description').css('color', '#F6E70E');
          break;
        case 3:
          $('#bar-value').css({
            'background-color': '#2B463C',
            'max-width': '100%'
          });
          $('#bar-description').html('Strong');
          $('#bar-description').css('color', '#2B463C');
          break;
      }
    }
  }

  if($(this).attr('id') === 'sign-up-re-pass') {
    if($(this).val() != $('#sign-up-pass').val()) {
      $(this).parent().parent().addClass('error');
      $('#pass-match').css('max-height', '2em');
    } else {
      $(this).parent().parent().removeClass('error');
      $('#pass-match').css('max-height', '0');
    }
  }

  if($('#sign-up-container').length) {
    let isComplete = $('.account-radio:checked').val() && 
                    $('#sign-up-no').val().length > 0 &&
                    $('#sign-up-fname').val().length > 0 && 
                    $('#sign-up-lname').val().length > 0 && 
                    ($('#sign-up-email').val().length > 0 && !$('#sign-up-email').parent().parent().hasClass('error')) && 
                    (strengthChecker($('#sign-up-pass').val()) >= 2) && 
                    $('#sign-up-pass').val() === $('#sign-up-re-pass').val();

    $('#sign-up-btn').attr('disabled', !isComplete);
  } else if($('#reset-container').length) {
    let isComplete = (strengthChecker($('#sign-up-pass').val()) >= 2) && 
                    $('#sign-up-pass').val() === $('#sign-up-re-pass').val();
    
    $('#reset-pass-btn').attr('disabled', !isComplete);
  }
});

$(document).on('click', '#reset-fail-btn', function() {
  window.location = 'forgot-password.html';
});

$(document).on('click', '#reset-success-btn', function() {
  window.location = 'sign-in.html#log-in';
});

$(document).on('click', '#recent-news > .preview-article, .recent-dot', function() {
  setBanner($(this).index() - 1, false);
});

$(document).on('click', '.programs-prompt', function() {
  if($(this).attr('id') === 'bscs' || $(this).attr('id') === 'bsit') {
    $('#program-content').addClass('undergraduate');
    setUndergraduateInfo($(this));
  } else {
    $('#program-content').addClass('graduate');
    setGraduateInfo($(this));
  }

  $('#main-inner').css('transform', 'translateX(-50%)');
  $('.programs-info').eq(0).css('display', 'block');
  $('.programs-info').addClass('programs-swipe-up');
  $('.programs-info').eq(0).removeClass('programs-swipe-up');

  $([document.documentElement, document.body]).animate({
    scrollTop: $('#breadcrumbs-container').offset().top - 35
  }, 500);
});

$(document).on('click', '#back-prompt', function() {
  $('#main-inner').css('transform', 'translateX(0)');
  $('#program-content').attr('class', '');
  $('.programs-info').css('display', 'none');
  $('.programs-info').removeClass('programs-swipe-up');

  $([document.documentElement, document.body]).animate({
    scrollTop: $('#breadcrumbs-container').offset().top - 35
  }, 500);

  setTimeout(resetProgram, 500);
});

$(document).on('click', '#new-thread', function() {
  window.location = 'forum/submit.html';
});

$(document).on('click', '#search-sidebar, #search-sidebar > i', function() {
  $('#forum-search').focus();
});

$(document).on('focus', '#forum-search', function() {
  $(this).parent().css({
    'border-color': '#3E6A50',
    'box-shadow': '0 0 10px rgba(62, 106, 80, 1)'
  });
  $('#search-sidebar > i').css('color', '#3E6A50');
  $('#search-tooltip').css({
    'display': 'block',
    'opacity': '1',
    'visibility': 'visible'
  });
});

$(document).on('blur', '#forum-search', function() {
  $(this).parent().css({
    'border-color': '',
    'box-shadow': ''
  });
  $('#search-sidebar > i').css('color', '');
  $('#search-tooltip').css({
    'display': '',
    'opacity': '',
    'visibility': ''
  });
});

$(document).on('keypress', '#forum-search', function(evt) {
  if(evt.which == 13) {
    evt.preventDefault();
    let path = location.pathname;
    let index = path.lastIndexOf('/') + 1;
    let current = path.substring(index);

    if($('#forum-search').val() != '') {
      let search = $('#forum-search').val();
      let searchArr = search.split(' ');
      let newSearch = '';
      
      let isSpace = false;
      for(let i = 0; i < searchArr.length; i++) {
        if(searchArr[i] == '') {
          if(i == 0)
            newSearch += ' ';
          else
            newSearch += '+ ';

          isSpace = true;
        } else {
          if(i != 0)
            newSearch += '+';

          newSearch += searchArr[i];

          isSpace = false;
        }
      }

      if(current == 'forum.html') {
        window.location = 'forum/search.html?search=' + newSearch;
      } else
        window.location = 'search.html?search=' + newSearch;
    }
  }
});

$(document).on('click', '.tag', function() {
  let path = location.pathname;
  let index = path.lastIndexOf('/') + 1;
  let current = path.substring(index);
  let search = '[' + $(this).html() + ']';

  if(current == 'forum.html') {
    window.location = 'forum/search.html?search=' + search;
  } else
    window.location = 'search.html?search=' + search;
});

$(document).on('click', '#search-new-thread', function() {
  window.location = 'submit.html';
});

$(document).on('click', '.forum-dropdown-selected', function() {
  if($(this).attr('id') === 'sort-selected' && windowSize == 'L')
    return;

  if($(this).hasClass('dropdown-active')) {
    $(this).removeClass('dropdown-active');
    $(this).find('.forum-selection').css({
      'opacity': '0',
      'visibility': 'hidden'
    });
    
    let element = $(this);
    setTimeout(function() {
      $(element).find('.forum-selection').css('display', 'none');
    }, 200);
  } else {
    $('.forum-dropdown-selected').removeClass('dropdown-active');

    if(windowSize != 'L')
      $('.forum-selection').css({
        'display': 'none',
        'opacity': '0',
        'visibility': 'hidden'
      });

    $(this).addClass('dropdown-active');
    $(this).find('.forum-selection').css('display', 'block');
    
    let element = $(this);
    setTimeout(function() {
      $(element).find('.forum-selection').css({
        'opacity': '1',
        'visibility': 'visible'
      });
    }, 80);
  }
});

$(document).on('click', '.forum-selection > div', function() {
  $(this).parent().children('div').removeClass('selected-option');
  $(this).addClass('selected-option');

  if($(this).attr('id') === 'filter-latest'|| $(this).attr('id') === 'filter-popular') {
    if($(this).attr('id') === 'filter-popular') {
      $('#popular-type-selected').css('display', 'block');
      setTimeout(function() {
        $('#popular-type-selected').css('max-width', windowSize === 'S' ? '6.5em' : (windowSize === 'M' ? '6em' : '7em'));
      }, 100);
      setTimeout(function() {
        $('#popular-type-selected').css({
          'opacity': '1',
          'visibility': 'visible'
        });
      }, 150);

      let hasSelected = false;
      $('.filter-popular-option').each(function() {
        if($(this).hasClass('selected-option')) {
          $(this).click();
          $('document, body').click();
          hasSelected = true;
          return false;
        }
      });

      if(!hasSelected) {
        $('#filter-today').click();
        $('document, body').click();
      }
    } else if($(this).attr('id') === 'filter-latest') {
      $('#popular-type-selected').css({
        'max-width': '0',
        'opacity': '0',
        'visibility': 'hidden'
      });
      setTimeout(function() {
        $('#popular-type-selected').css('display', 'none');
      }, 400);
      
      let pageDetail = window.location.toString();

      if(pageDetail.search('\\?') != -1) {
        if(pageDetail.search('sort=') != -1)
          window.location = window.location.toString().replace(/popular-today|popular-week|popular-month|popular-all/gi, 'latest');
        else
          window.location = window.location + '&sort=latest';
      } else
          window.location = window.location + '?sort=latest';
    }
  } else if($(this).attr('id') === 'filter-today' || $(this).attr('id') === 'filter-week' || $(this).attr('id') === 'filter-month' || $(this).attr('id') === 'filter-all') {
    let pageDetail = window.location.toString();
    let filter = $(this).attr('id') === 'filter-today' ? 'popular-today' : ($(this).attr('id') === 'filter-week') ? 'popular-week' : ($(this).attr('id') === 'filter-month' ? 'popular-month' : 'popular-all');

    if(pageDetail.search('\\?') != -1) {
      if(pageDetail.search('sort=') != -1)
        window.location = window.location.toString().replace(/latest|popular-today|popular-week|popular-month|popular-all/gi, filter);
      else
        window.location = window.location + '&sort=' + filter;
    } else
      window.location = window.location + '?sort=' + filter;

  } else if($(this).attr('id') === 'filter-all-type' || $(this).attr('id') === 'filter-discussion' || $(this).attr('id') === 'filter-question') {
    let pageDetail = window.location.toString();
    let type = $(this).attr('id') === 'filter-all-type' ? 'all' : ($(this).attr('id') === 'filter-discussion' ? 'discussion' : 'question');

    if(pageDetail.search('\\?') != -1) {
      if(pageDetail.search('type=') != -1)
        window.location = window.location.toString().replace(/all|discussion|question/gi, type);
      else
        window.location = window.location + '&type=' + type;
    } else
      window.location = window.location + '?type=' + type;
  }

  $(this).parent().siblings('.dropdown-selected-content').html($(this).html());
});

$(document).on('click', '#new-tag-prompt', function() {
  if(!$('.tag-option.tag-empty').length) {
    let newTag = document.createElement('div');
    $(newTag).attr('class', 'tag-option tag-empty');

    let tagContent = document.createElement('span');
    $(tagContent).attr('contenteditable', 'true');
    $(tagContent).html('Tag name');

    let tagRemove = document.createElement('i');
    $(tagRemove).attr('class', 'fas fa-times tag-remove');

    $(newTag).append(tagContent, tagRemove);
    $(newTag).insertBefore(this);
    $(newTag).click();
  } else
    $('.tag-option.tag-empty').click();
});

function setCaretPosition(element, isStart) {
  let range;
  let selection;
  if(document.createRange) {
    range = document.createRange();
    range.selectNodeContents(element);
    range.collapse(isStart);
    selection = window.getSelection();
    selection.removeAllRanges();
    selection.addRange(range);
  } else if(document.selection) { 
    range = document.body.createTextRange();
    range.moveToElementText(element);
    range.collapse(isStart);
    range.select();
  }
}

$(document).on('click focus', '.tag-empty', function() {
  setCaretPosition(this.querySelector('span'), true);
});

$(document).on('input change cut paste drop keydown', '.tag-option > span', function(evt) {
  if(evt.keyCode == 13)
    evt.preventDefault();

  if($(this).parent().hasClass('tag-empty') && evt.keyCode != 13) {
    evt.preventDefault();

    if(String.fromCharCode(evt.keyCode).match(/(\w|\s)/g)) {
      $(this).parent().removeClass('tag-empty');
      $(this).html(evt.key);
      setCaretPosition(this, false);
    }
  } else {
    if($(this).html() == '<br>' || $(this).html() == '') {
      $(this).parent().addClass('tag-empty');
      $(this).html('Tag name');
    }
  }
});

$(document).on('paste', '.tag-option > span', function(evt) {
  evt.preventDefault();

  let text = (evt.originalEvent || evt).clipboardData.getData('text/plain').replace(/\r?\n|\r/g, '');

  document.execCommand("insertHTML", false, text);
});

$(document).on('blur', '.tag-empty > span', function() {
  $(this).parent().remove();
});

$(document).on('click', '.tag-remove', function() {
  $(this).parent().remove();
});

$(document).on('click', '.forum-option', function() {
  $(this).parent().children('.forum-option').removeClass('selected-option');
  $(this).addClass('selected-option');
});

$(document).on('click', '.forum-content', function(evt) {
  if(($(evt.target).is('div') && ($(evt.target).hasClass('thread-share') || $(evt.target).hasClass('thread-copy-link') || $(evt.target).hasClass('thread-edit') || $(evt.target).hasClass('thread-report'))) ||
    ($(evt.target).is('i') && ($(evt.target).parent().hasClass('thread-share') || $(evt.target).parent().hasClass('thread-copy-link') || $(evt.target).parent().hasClass('thread-edit') || $(evt.target).parent().hasClass('thread-report'))) ||
    ($(evt.target).is('span') && ($(evt.target).parent().hasClass('thread-share') || $(evt.target).parent().hasClass('thread-copy-link') || $(evt.target).parent().hasClass('thread-edit') || $(evt.target).parent().hasClass('thread-report'))) ||
    $(evt.target).hasClass('tag'))
    evt.preventDefault();
});

$(document).on('click', '.thread-settings', function() {
  if($(this).hasClass('settings-active'))
    $(this).removeClass('settings-active');
  else {
    $('.thread-settings').removeClass('settings-active');
    $(this).addClass('settings-active');
  }
});

$(document).on('click', '.thread-share', function() {
  if($(this).hasClass('thread-share-active'))
    $(this).removeClass('thread-share-active');
  else {
    $('.thread-share').removeClass('thread-share-active');
    $(this).addClass('thread-share-active');
  }
});

$(document).on('click', '#reply-cancel-btn', function() {
  let cancel = true;
  let replyContent = $('#body-thread').find('.ql-editor').html();

  if($(this).attr('data-reply_Content').replace(/\s+/g,'') != htmlEncode(replyContent).replace(/\s+/g,'')) {
    setConfirmClose();
    $('#cancel-update').attr('data-thread_Type', $(this).attr('data-thread_Type'));
    cancel = false;
  }

  if(cancel)
    cancelReplyUpdate($(this).attr('data-thread_Type') == 'D' ? 1 : 2);
});

$(document).on('click', '.thread-copy-link', function() {
  let link = $(this).attr('data-URL');
  let temp = document.createElement('input');
  $(temp).attr({
    'type': 'text',
    'value': link
  });
  $('body').append(temp);
  $(temp).select();
  document.execCommand("copy");
  $(temp).remove();

  $('.thread-share').removeClass('thread-share-active');
  $('#link-copied').fadeIn(200);
  setTimeout(function() {
    $('#link-copied').fadeOut(300);
  }, 3000)
});

$(document).on('click', '#thread-starter .thread-reply', function() {
  $([document.documentElement, document.body]).animate({
    scrollTop: $('#write-reply').offset().top - 80
  }, 800);
});

$(document).on('click', '.thread-report', function() {
  $('#submit-report').attr({
    'data-thread_ID': $(this).attr('data-thread_ID'),
    'data-reply_ID': $(this).attr('data-reply_ID'),
    'data-post_Ver': $(this).attr('data-post_Ver')
  });

  $('#redundant').css('display', $(this).attr('data-reply_ID') != '' ? 'none' : 'inline-block');
});

$(document).on('click', '.delete-reason, .report-reason', function() {
  let reason = $(this).parent().parent().parent().parent().attr('id') == 'delete-modal' ? $('.delete-reason') : $('.report-reason');
  
  if($(this).attr('id') == 'redundant') {
    $('#report-detail-container').removeClass('report-detail-selected');

    if($('.report-reason').hasClass('selected-reason'))
      setTimeout(function() {
        $('#redundant-link-container').addClass('redundant-selected');
      }, 250);
    else
      $('#redundant-link-container').addClass('redundant-selected');
  } else {
    $('#redundant-link-container').removeClass('redundant-selected');

    let container = $(this).parent().parent().parent().parent().attr('id') == 'delete-modal' ? $('#delete-detail-container') : $('#report-detail-container');
    let selected = $(this).parent().parent().parent().parent().attr('id') == 'delete-modal' ? 'delete-detail-selected' : 'report-detail-selected';
    if($(reason).hasClass('selected-reason'))
      setTimeout(function() {
        $(container).addClass(selected);
      }, 250);
    else
      $(container).addClass(selected);
  }

  $(reason).removeClass('selected-reason');
  $(this).addClass('selected-reason');

  let element = $(this).parent().parent().parent().parent().attr('id') == 'delete-modal' ? $('#admin-delete') : $('#submit-report');
  $(element).removeClass('disabled');

  if($(this).attr('id') == 'redundant' && $('#redundant-link').val() == '')
    $(element).addClass('disabled');
});

$(document).on('input change cut paste drop keyup', '#similar-link', function() {
    // validate url
    if($(this).val() != '')
      $('#admin-close').removeClass('disabled');
    else
      $('#admin-close').addClass('disabled');
});

$(document).on('input change cut paste drop keyup', '#redundant-link', function() {
    // validate url
    if($(this).val() != '')
      $('#submit-report').removeClass('disabled');
    else
      $('#submit-report').addClass('disabled');
});

$(document).on('click', '#search-modal, #search-modal > div, #search-close', function(evt) {
  if($('#search-modal').is(evt.target) || $('#search-modal > div').is(evt.target) || $('#search-close').is(evt.target) || $('#search-close').has(evt.target).length > 0) {
    $('#modal-search').val('');
    $('#search-modal').fadeOut(100);
    setBodyFixed(false);
  }
});

$(document).on('click', '#modal-search-container, #modal-search-container > i', function() {
  $('#modal-search').focus();
});

$(document).on('focus', '#modal-search', function() {
  $(this).parent().css({
    'border-color': '#3E6A50',
    'box-shadow': '0 0 10px rgba(62, 106, 80, 1)'
  });
  $('#modal-search-container > i').css('color', '#3E6A50');
});

$(document).on('blur', '#modal-search', function() {
  $(this).parent().css({
    'border-color': '',
    'box-shadow': ''
  });
  $('#modal-search-container > i').css('color', '');
});

$(document).on('keypress', '#modal-search', function(evt) {
  if(evt.which == 13) {
    evt.preventDefault();
    setGenSearch();
  }
});

$(document).on('click', '#search-btn', function(evt) {
  setGenSearch();
});

$(document).on('click', '#search-type > div:not(#search-type-selected)', function() {
  let url = new URL(window.location.href);
  let search = url.searchParams.get('search');

  if($(this).attr('id') == 'search-thread') {
    window.location = 'forum/search.html?search=' + search;
  } else {
    let type = $(this).attr('id') == 'search-page' ? 'page' : 'news';
  
    window.location = 'search.html?search=' + search + '&type=' + type;
  }
});

$(document).on('click focus', '#redundant-link, #report-detail, #title-thread, #body-thread-style, #body-thread, input.personal-input, textarea.personal-input, select.personal-input, input.educ-input, textarea.educ-input, select.educ-input, .pass-container input, #deact-pass', function() {
  let element;

  if($(this).attr('id') == 'body-thread-style' || $(this).attr('id') == 'body-thread')
    element = $('#body-thread');
  else
    element = $(this);
  
  $(element).css('border-color', '#3E6A50');
});

$(document).on('blur', '#redundant-link, #report-detail, #title-thread, #body-thread, input.personal-input, textarea.personal-input, select.personal-input, input.educ-input, textarea.educ-input, select.educ-input, #deact-pass', function() {
  let element;

  if($(this).attr('id') == 'body-thread-style' || $(this).attr('id') == 'body-thread')
    element = $('#body-thread');
  else
    element = $(this);

  $(element).css('border-color', '#D3D3D3');
});

$(document).on('input change cut paste drop keyup', '#title-thread', function() {
  $(this).next().find('.char-count').html($(this).val().length);

  if($(this).val().length == 255)
    $(this).next().css('color', '#D8000C');
  else
    $(this).next().css('color', '');
});

$(document).on('click', '#prev-banner, #next-banner', function() {
  setBanner($(this).attr('id') == 'prev-banner' ? -1 : 1, true);
});

$(document).on('click', '.mini-img', function() {
  setBanner($(this).index() - 1, false);
});

$(document).on('click', '#prev-slide, #next-slide', function() {
  setSlide($(this).attr('id') == 'prev-slide' ? -1 : 1);
});

$(document).on('click', '#change-pass', function() {
  $(this).addClass('hidden');
  $('#change-pass-container').removeClass('hidden');

  setTimeout(function() {
    $('#change-pass-container').css('max-height', '50em');
  }, 80);
});

$(document).on('click', '.share-fb', function() {
  let URL = 'https://facebook.com/sharer.html?u=' + encodeURI(document.location.href) + '&text=' + encodeURI(document.title);
  window.open(URL);
  return false;
});

$(document).on('click', '.share-twt', function() {
  let URL = 'https://twitter.com/share?url=' + encodeURI(document.location.href) + '&text=' + encodeURI(document.title);
  window.open(URL);
  return false;
});

$(document).on('click', '.pass-toggle', function() {
  if($(this).hasClass('fa-eye')) {
    $(this).attr('class', 'pass-toggle far fa-eye-slash');
    $(this).prev().attr('type', 'text');
  } else {
    $(this).attr('class', 'pass-toggle far fa-eye');
    $(this).prev().attr('type', 'password');
  }
});

$(document).on('click', '#top', function() {
  $([document.documentElement, document.body]).animate({
    scrollTop: 0
  }, 800);
});

$(document).on('click', function(evt) {
  if($('#notif-nav').length) {
    if($(evt.target).closest('#notif-container').length === 0 && (!$('#notif-nav').is(evt.target) && $('#notif-nav').has(evt.target).length === 0)) {
      $('#notif-container').removeClass('notif-toggle');
      $('#notif-nav').removeClass('notif-toggle');
    }
  }
  if($('#profile-nav').length) {
    if($(evt.target).closest('#user-container').length === 0 && (!$('#profile-nav').is(evt.target) && $('#profile-nav').has(evt.target).length === 0)) {
      $('#user-container').removeClass('profile-toggle');
      $('#profile-nav').removeClass('profile-toggle');
    }
  }

  if($('.forum-dropdown-selected').length) {
    if($(evt.target).closest('.forum-dropdown-selected').length === 0 && (!$('.forum-dropdown-selected').is(evt.target) || $('.forum-dropdown-selected').has(evt.target).length === 0)) {
      $('.forum-dropdown-selected').removeClass('dropdown-active');

      let dpSelection = windowSize === 'L' ? $('.forum-selection:not(.forum-selection-responsive)') : $('.forum-selection');
      $(dpSelection).css({
        'display': 'none',
        'opacity': '0',
        'visibility': 'hidden'
      });
    }
  }

  if($('.thread-extra').length) {
    if($(evt.target).closest('.thread-extra').length === 0 && (!$('.thread-settings').is(evt.target) && $('.thread-settings').has(evt.target).length === 0)) {
      $('.thread-settings').removeClass('settings-active');
    }
  }

  if($('.thread-share').length) {
    if($(evt.target).closest('.thread-share').length === 0 && (!$('.thread-share').is(evt.target) && $('.thread-share').has(evt.target).length === 0) && (!$('.thread-copy-link').is(evt.target) && $('.thread-copy-link').has(evt.target).length === 0)) {
      $('.thread-share').removeClass('thread-share-active');
    }
  }

  if($('#body-thread').length) {
    if($(evt.target).attr('id') != 'body-thread-style' || $(evt.target).closest('#body-thread-style').length === 0)
      $('#body-thread').css('border-color', '#D3D3D3');
  }
});

$(document).ready(function() {
  setWindowStyle();
  setStickyTitle(false);

  $(window).scroll(function() {
    $('#top').css('display', window.scrollY > 250 ? 'block' : 'none');
    
    if(!$('#main-sign-in').length) {
      let currentScroll = $(this).scrollTop();
      let isDown = currentScroll > lastScroll ? true : false;
      setStickyTitle(isDown);

      lastScroll = currentScroll;
    }

    if($('#grid-header').length) {
      if(windowSize != 'S') {
        let animationPos = $('#grid-header').offset().top - $(window).height() + 100;
        if(window.scrollY > animationPos)
          $('.grid-link').removeClass('swipe-animation');
      }
    }

    if($('.programs-info').length) {
      let matrix = $('#main-inner').css('transform').replace(/[^0-9\-.,]/g, '').split(',');
      if(matrix[4] != '0') {
        let animationPos = $('#pre-foot-container').offset().top - 700;

        if(window.scrollY > animationPos) {
          let element = $('#program-content > .width-limit > *:visible:last').next();
          $(element).css('display', 'block');

          while($(element).css('display') === 'none') {
            element = element.next();
            $(element).css('display', 'block');
          }
          
          setTimeout(function() {
            $(element).removeClass('programs-swipe-up');
          }, 50);
          return false;
        }
      }
    }
  });

  $(window).resize(function() {
    setWindowStyle();
    let path = window.location.pathname;
    let page = path.split('/').pop();

    if(windowSize == 'L' && page != 'home.html' && window.scrollY > 0)
      setStickyTitle(true);
    else
      setStickyTitle(false);
  });
});