function setRegisterPending(email) {
  $('#confirm-modal i').removeClass();
  $('#confirm-modal i').addClass('fas fa-check-circle fa-3x alert-green');
  $('#confirm-modal .modal-header h2').html('Request pending');
  $('#confirm-modal .modal-alert-content').html('You request is currently pending.<br/><br/>A message will be sent to your email (<span id = "email-pending">' + email + '</span>) regarding the approval.<br><br>If you can not find the response in your normal inbox, it is worth checking in your spam or junk mail section.');
  $('#confirm-modal .modal-alert-button-holder').css('display', 'none');
  $('#confirm-modal .modal-alert-button-holder .save-close').attr('data-reload', 'true');
  $('#confirm-ok').css('display', 'flex');
  $('#confirm-modal').css('display', 'flex');
}

function setReactiveSuccess(email) {
  $('#confirm-modal i').removeClass();
  $('#confirm-modal i').addClass('fas fa-check-circle fa-3x alert-green');
  $('#confirm-modal .modal-header h2').html('Reactivation request sent');
  $('#confirm-modal .modal-alert-content').html('Your request to reactivate your account has been sent to the administrators.<br/><br/>Please wait for <b>2-3 working days</b> for the request to be approved. A message will be sent to your email (<span id = "email-pending">' + email + '</span>) regarding the approval.<br><br>If you can not find the recovery email in your normal inbox, it is worth checking in your spam or junk mail section.');
  $('#confirm-modal .modal-alert-button-holder').css('display', 'none');
  $('#confirm-modal .modal-alert-button-holder .save-close').attr('data-reload', 'true');
  $('#confirm-ok').css('display', 'flex');
  $('#confirm-modal').css('display', 'flex');
}

function setReactiveFailed() {
  $('#confirm-modal i').removeClass();
  $('#confirm-modal i').addClass('fas fa-times-circle fa-3x alert-red');
  $('#confirm-modal .modal-header h2').html('Reactivation request failed');
  $('#confirm-modal .modal-alert-content').html('There was an error sending your reactivation request. Please try again.');
  $('#confirm-modal .modal-alert-button-holder').css('display', 'none');
  $('#confirm-modal .modal-alert-button-holder .save-close').attr('data-reload', 'false');
  $('#confirm-ok-fail').css('display', 'flex');
  $('#confirm-modal').css('display', 'flex');
}

function setReportSuccess() {
  $('#confirm-modal i').removeClass();
  $('#confirm-modal i').addClass('fas fa-check-circle fa-3x alert-green');
  $('#confirm-modal .modal-header h2').html('Report submitted');
  $('#confirm-modal .modal-alert-content').html('We appreciate your taking the time to help us improve our service. We have received your report, will investigate it, and take the appropriate action.');
  $('#confirm-modal .modal-alert-button-holder').css('display', 'none');
  $('#confirm-ok').css('display', 'flex');
  $('#confirm-modal').css('display', 'flex');
}

function setReportFailed() {
  $('#confirm-modal i').removeClass();
  $('#confirm-modal i').addClass('fas fa-times-circle fa-3x alert-red');
  $('#confirm-modal .modal-header h2').html('Failed to submit');
  $('#confirm-modal .modal-alert-content').html('Your report was not submitted. Please try again.');
  $('#confirm-modal .modal-alert-button-holder').css('display', 'none');
  $('#confirm-ok-fail').css('display', 'flex');
  $('#confirm-modal').css('display', 'flex');
}

function setThreadDeleteSuccess(type) {
  $('#confirm-modal i').removeClass();
  $('#confirm-modal i').addClass('fas fa-check-circle fa-3x alert-green');
  $('#confirm-modal .modal-header h2').html('Deleted');
  $('#confirm-modal .modal-header .modal-dismiss').css('display', 'none');
  $('#confirm-modal .modal-alert-content').html('The ' + (type == 1 ? 'thread' : 'reply') + ' was successfully deleted.');
  $('#confirm-modal .modal-alert-button-holder').css('display', 'none');
  $('#confirm-modal .modal-alert-button-holder .save-close').attr('data-reload', type == 1 ? 'true' : 'false');

  if(type == 2)
    $('#confirm-modal .modal-alert-button-holder .save-close').addClass('reply-delete');
      
  $('#confirm-ok').css('display', 'flex');
  $('#confirm-modal').css('display', 'flex');
}

function setThreadDeleteFailed(type) {
  $('#confirm-modal i').removeClass();
  $('#confirm-modal i').addClass('fas fa-times-circle fa-3x alert-red');
  $('#confirm-modal .modal-header h2').html('Failed');
  $('#confirm-modal .modal-header .modal-dismiss').css('display', 'block');
  $('#confirm-modal .modal-alert-content').html('There was an error deleting the ' + (type == 1 ? 'thread' : 'reply') + '. Please try again.');
  $('#confirm-modal .modal-alert-button-holder').css('display', 'none');
  $('#confirm-modal .modal-alert-button-holder .save-close').attr('data-reload', 'false');
  $('#confirm-ok-fail').css('display', 'flex');
  $('#confirm-modal').css('display', 'flex');
}

$(document).on('click', '.modal-toggle', function() {
  $('#' + $(this).attr('data-target')).css('display', 'flex');
  setBodyFixed(true);
});

function setSuccessReg(email) {
  $('#email-pending').html(email);
  $('#register-modal').css('display', 'flex');
  setBodyFixed(true);
}

function htmlEncode(text) {
  let map = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#039;'
  };
  return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}

function htmlDecode(text) {
  let map = {
    '&amp;': '&',
    '&lt;': '<',
    '&gt;': '>',
    '&quot;': '"',
    '&#039;': "'"
  };
  return text.replace(/\b&amp|&lt;|&gt;|&quot;|&#039;\b/g, function(m) { return map[m]; });
}

$(document).on('click', '.modal-toggle', function() {
  $('#' + $(this).attr('data-target')).css('display', 'flex');
  setBodyFixed(true);
});

$(document).on('click', '.save-close', function() {
  $('.modal:not(#confirm-modal)').hide();
  setBodyFixed(false);
  $(this).parent().parent().parent().parent().parent().fadeOut(100);

  if($(this).attr('data-reload') == 'true')
    location.reload(true);
  
  if($(this).attr('data-re_login') == 'true')
    window.location = 'server/signout.php';

  if($(this).hasClass('reply-delete'))
    window.location = $(this).attr('data-thread_Link');
});

$(document).on('click', '#sign-up-btn', function(evt) {
  evt.preventDefault();
  let email = $('#sign-up-email').val();
  setSuccessReg(email);
});

$(document).on('click', '#log-in-btn', function(evt) {
    evt.preventDefault();
    window.location = 'index.php';
});

$(document).on('click', '#send-email-btn', function(evt) {
  evt.preventDefault();
  $('#email-container').css('display', 'none');
  $('#email-sent').css('display', 'flex');
  $('#sign-in-close').css('display', 'none');
});

$(document).on('click', '#reset-pass-btn', function(evt) {
  evt.preventDefault();
  $('#reset-success').css('display', 'flex');
    
  $('#reset-container').css('display', 'none');
  $('#sign-in-close').css('display', 'none');
});

$(document).on('click', '#post-thread-btn', function() {
  if($('#title-thread').val() == '' || $('#body-thread').find('.ql-editor').hasClass('ql-blank')) {
    if($('#title-thread').val() == '')
      $('#title-thread').css('border-color', '#B90009');

    if($('#body-thread').find('.ql-editor').hasClass('ql-blank'))
      $('#body-thread').css('border-color', '#B90009');

    $('#incomplete-modal').css('display', 'flex');
    setBodyFixed(true);
  } else {
    let threadTitle = $('#title-thread').val();
    let threadLink = threadTitle.toLowerCase();
    threadLink = threadLink.replaceAll(/[^a-zA-Z0-9 ]/g, '');
    threadLink = threadLink.replaceAll(' ', '-');
    let today = new Date();
    let dd = String(today.getDate()).padStart(2, '0');
    let mm = String(today.getMonth() + 1).padStart(2, '0');
    let yy = today.getFullYear().toString().substr(2,2);
    today = mm + dd + yy;
    window.location = 'thread.php?ID=1/' + today + '/' + threadLink;
  }
});

$(document).on('click', '#thread-reply-btn', function() {
  if($('#body-thread').find('.ql-editor').hasClass('ql-blank')) {
    $('#body-thread').css('border-color', '#B90009');
    $('#incomplete-modal').css('display', 'flex');
    setBodyFixed(true);
  } else {
    let threadDetail = $(this).attr('data-thread_Detail');
    window.location = 'thread.php?ID=1&reply=1' + threadDetail;
  }
});

$(document).on('click', '#thread-vote-up, #thread-vote-down', function() {
  let vote  = $(this).hasClass('vote-up') ? 1 : -1;

  let element = $(this);

  if($(element).hasClass('is-toggle')) {
    $(element).removeClass('is-toggle');
    vote = parseInt($('#thread-vote-value').html()) - vote;
  } else {
    if(($(element).hasClass('vote-up') && $(element).siblings('.vote-down').hasClass('is-toggle')) ||
      ($(element).hasClass('vote-down') && $(element).siblings('.vote-up').hasClass('is-toggle'))) {
      vote = parseInt($('#thread-vote-value').html()) + vote;
      $('#thread-vote-value').html(vote);
      vote  = $(this).hasClass('vote-up') ? 1 : -1;
    }
    
    if($(element).hasClass('vote-up'))
      $(element).siblings('.vote-down').removeClass('is-toggle');
    else if($(element).hasClass('vote-down'))
      $(element).siblings('.vote-up').removeClass('is-toggle');
    
    $(element).addClass('is-toggle');
    vote = parseInt($('#thread-vote-value').html()) + vote;
  }

  $('#thread-vote-value').html(vote);
});

$(document).on('click', '#submit-report', function() {
  if(!$(this).hasClass('disabled')) {
    let element = $(this);
    setReportSuccess();
    $('.report-reason').removeClass('selected-reason');
    $('#redundant-link-container').removeClass('redundant-selected');
    $('#redundant-link').val('');
    $('#report-detail').val('');
    $(element).addClass('disabled')
  }
});

$(document).ajaxStart(function() {
  $('#load-modal').css('display', 'flex');
});

$(document).ajaxStop(function() {
  $('#load-modal').css('display', '');
});