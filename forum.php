<?php
  if(isset($_GET['ID'])) {
    $catID = (int) $_GET['ID'];
    $category = ucwords(str_replace("-", " ", $_GET['category']));
  } else {
    $catID = 0;
    $category = 'Forum';
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
		<meta content="utf-8" http-equiv="encoding">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forum – College of Computer and Information Sciences</title>
    <link rel="shortcut icon" type="image/x-icon" href="images/content/general/icon.ico">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/fontawesome/css/all.css">
    <script src="js/jquery-3.6.0.min.js"></script>
		<script src="js/front.js"></script>
		<script src="js/back.js"></script>
    <script>
      function setForumFilter() {
      <?php
        if(isset($_GET['sort']))
          $sort =$_GET['sort'];
        else
          $sort = 'latest';

        $sortElement = $sort == 'latest' ? '#filter-latest' : ($sort == 'popular-today' ? '#filter-today' : ($sort == 'popular-week' ? '#filter-week' : ($sort == 'popular-month' ? '#filter-month' : '#filter-all')));

        if($sort === 'latest') {
      ?>
        $('#popular-type-selected').css({
          'max-width': '0',
          'opacity': '0',
          'visibility': 'hidden'
        });
        setTimeout(function() {
            $('#popular-type-selected').css('display', 'none');
        }, 400);
      <?php
        } else if(strpos($sort, 'popular') !== false) {
      ?>
        $('#filter-popular').parent().children('div').removeClass('selected-option');
        $('#filter-popular').addClass('selected-option');
        $('#filter-popular').parent().siblings('.dropdown-selected-content').html($('#filter-popular').html());

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
      <?php
        }
      ?>

        $(<?php echo '"'.$sortElement.'"'; ?>).parent().children('div').removeClass('selected-option');
        $(<?php echo '"'.$sortElement.'"'; ?>).addClass('selected-option');
        $(<?php echo '"'.$sortElement.'"'; ?>).parent().siblings('.dropdown-selected-content').html($(<?php echo '"'.$sortElement.'"'; ?>).html());

      <?php
        if(isset($_GET['type']))
          $type = $_GET['type'];
        else
          $type = 'all';

        $typeElement = $type == 'all' ? '#filter-all-type' : ($type == 'discussion' ? '#filter-discussion' : '#filter-question');
      ?>

        $(<?php echo '"'.$typeElement.'"'; ?>).parent().children('div').removeClass('selected-option');
        $(<?php echo '"'.$typeElement.'"'; ?>).addClass('selected-option');
        $(<?php echo '"'.$typeElement.'"'; ?>).parent().siblings('.dropdown-selected-content').html($(<?php echo '"'.$typeElement.'"'; ?>).html());
      }

      window.onload = function() {
        setForumFilter();
      };
    </script>
  </head>
  <body>
    <header>
      <div id="website-header-container">
        <div id="website-header" class="width-limit">
          <i id="nav-bar" class="fas fa-bars fa-lg"></i>
          <div id="logo-container">
            <a id="logo-link" href="index.php"><img id="logo-img" src="images/content/general/logo.png" alt="Logo"></a>
            <a href="index.php"><p id="ccis" data-web_init="CCIS" data-web_name="College of Computer and Information Sciences">CCIS</p></a>
          </div>
          <div id="right-options">
            <div id="search-container" class="modal-toggle" data-target="search-modal">
              <div id="search-img-container">
                <img src="images/icons/search-icon-white.png" id="search-icon-white" alt="Search Icon">
                <img src="images/icons/search-icon.png" id="search-icon" class="hidden" alt="Search Icon">
              </div>
            </div>
            <div id="user-container">
              <div>
                <div id="user-img-container">
                  <img src="images/icons/user-icon-white.png" id="user-icon-white" alt="User Icon">
                  <img src="images/icons/user-icon.png" id="user-icon" class="hidden" alt="User Icon">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="nav-bg" class="bg"></div>
      <div id="nav-header-container">
        <div id="nav-header" class="width-limit">
          <ul id="nav" class="nav-responsive">
            <div class="sidebar-close">
              <img src="images/icons/close-white.png" alt="Close Icon">
            </div>
            <li class="nav-tab nav-trans">
              <a href="index.php">HOME</a>
            </li>
            <li class="nav-tab nav-trans nav-dropdown">
              <a href="about.php">ABOUT</a>
              <div class="chevron-container">
                <span class="chevron"></span>
              </div>
              <div class="dropdown">
                <ul class="sub-menu">
                  <a href="about/ccis-history.php"><li class="sub-nav">CCIS and its History</li></a>
                  <a href="about/mission-goals.php"><li class="sub-nav">Mission and Goals</li></a>
                  <a href="about/contact-us.php"><li class="sub-nav">Contact Us</li></a>
                </ul>
              </div>
            </li>
            <li class="nav-tab nav-trans nav-dropdown">
              <span>NEWS</span>
              <div class="chevron-container">
                <span class="chevron"></span>
              </div>
              <div class="dropdown">
                <ul class="sub-menu">
                  <a href="news/news.php"><li class="sub-nav">News</li></a>
                  <a href="news/announcements.php"><li class="sub-nav">Announcements</li></a>
                </ul>
              </div>
            </li>
            <li class="nav-tab nav-trans nav-dropdown">
              <a href="student.php">STUDENT</a>
              <div class="chevron-container">
                <span class="chevron"></span>
              </div>
              <div class="dropdown">
                <ul class="sub-menu">
                  <a href="student/programs.php"><li class="sub-nav">Programs</li></a>
                  <a href="student/organizations.php"><li class="sub-nav">Student Organizations</li></a>
                  <a href="student/handbook.php"><li class="sub-nav">Student Handbook</li></a>
                  <a href="student/forms.php"><li class="sub-nav">Downloadable Forms</li></a>
                </ul>
              </div>
            </li>
            <li class="nav-tab nav-trans">
              <a href="faculty.php">FACULTY</a>
            </li>
            <li class="nav-tab nav-trans nav-dropdown active">
              <a href="forum.php">FORUM</a>
              <div class="chevron-container">
                <span class="chevron"></span>
              </div>
              <div class="dropdown">
                <ul class="sub-menu">
                  <a href="forum.php?ID=1&amp;category=general-forum"><li class="sub-nav">General Forum</li></a>
                  <a href="forum.php?ID=2&amp;category=academic-concerns"><li class="sub-nav">Academic Concerns</li></a>
                  <a href="forum.php?ID=3&amp;category=student-community-forum"><li class="sub-nav">Student Community Forum</li></a>
                  <a href="forum.php?ID=4&amp;category=student-organization"><li class="sub-nav">Student Organization</li></a>
                </ul>
              </div>
            </li>
            <li class="nav-tab nav-trans">
              <a href="gallery.php">GALLERY</a>
            </li>
            <li class="nav-tab nav-trans nav-dropdown">
              <span>LINKS</span>
              <div class="chevron-container">
                <span class="chevron"></span>
              </div>
              <div class="dropdown">
                <ul class="sub-menu">
                  <a href="https://www.pup.edu.ph/about/calendar" target="_blank"><li class="sub-nav">University Calendar</li></a>
                  <a href="https://sisstudents.pup.edu.ph/" target="_blank"><li class="sub-nav">Student Information System</li></a>
                </ul>
              </div>
            </li>
          </ul>
          <div id="notif-nav" class="notif-responsive">
            <div class="sidebar-close">
              <img src="images/icons/close.png" alt="Close Icon">
            </div>
            <h3>Notifications</h3>
            <div id="all-notif">
              <div class="notif notif-new">
                <div class="notif-user">
                  <img src="images/icons/user-icon.png">
                </div>
                <div class="notif-info">
                  <p class="notif-desc"><strong>Ysabel Dela Cruz</strong> replied to your thread.</p>
                  <p class="notif-time">September 24, 12:02 am</p>
                </div>
              </div>
              <div class="notif">
                <div class="notif-user">
                  <img src="images/icons/user-icon.png">
                </div>
                <div class="notif-info">
                  <p class="notif-desc"><strong>Ysabel Dela Cruz</strong> replied to your thread.</p>
                  <p class="notif-time">September 24, 12:02 am</p>
                </div>
              </div>
              <!-- div id = "no-notif"> IF NO NOTIF
                <i class = "fas fa-bell fa-3x"></i>
                <h4>No notifications yet</h4>
                <p>You're all caught up!</p>
                <p>Check again later for new updates.</p>
              </div -->
            </div>
          </div>
          <div id="profile-nav" class="profile-responsive">
            <div class="sidebar-close">
              <img src="images/icons/close-white.png" alt="Close Icon">
            </div>
            <a href="sign-in.php#sign-up" id="signup">Sign Up</a>
            <a href="sign-in.php#log-in" id="login">Log In</a>
          </div>
        </div>
      </div>
    </header>
    <div id="top" style="display: none;"><span></span></div>
    <div id="link-copied">
      <span>Link copied to clipboard.</span>
    </div>
    <div id="search-modal" class="modal">
      <div>
        <div id="search-close">
          <img src="images/icons/close-white.png" alt="Close Icon">
        </div>
        <div id="modal-search-container">
          <i class="fas fa-search fa-lg"></i>
          <input type="text" id="modal-search" placeholder="Find Pages, News, &amp; Threads...">
          <div id="search-btn">
            <i class="fas fa-search fa-lg"></i>
            <span>SEARCH</span>
          </div>
        </div>
      </div>
    </div>
    <div id="sign-out-modal" class="modal">
      <div class="modal-content">
        <div class="modal-body">
          <div class="modal-header">
            <h2></h2>
            <div class="modal-close modal-dismiss">
              <img src="images/icons/close.png" alt="Close Icon">
            </div>
          </div>
          <div class="modal-alert">
            <div>
              <i class="fas fa-exclamation-circle fa-3x alert-yellow"></i>
            </div>
            <div>
              <p class="modal-alert-header">Sign Out</p>
              <p>Are you sure you want to sign out?</p>
            </div>
          </div>
          <div class="modal-button-holder modal-alert-button-holder">
            <div class="btn btn-default modal-dismiss">Cancel</div>
            <a href="server/signout.php" id="sign-out" class="btn btn-red"><i class="fas fa-sign-out-alt"></i>Sign Out</a>
          </div>
        </div>
      </div>
    </div>
		<div id="report-modal" class="modal">
			<div class="modal-content">
				<div class="modal-body">
					<div class="modal-header">
						<h2>Submit a Report</h2>
						<div class="modal-close modal-dismiss">
                            <img src="images/icons/close.png" alt="Close Icon">
						</div>
					</div>
          <p>Help us understand what's happening with this post. Describe it and we'll see what we can do.</p>
          <div id="report-container">
            <span id="redundant" class="report-reason">Redundant Post</span>
            <span class="report-reason">Harassment</span>
            <span class="report-reason">Threatening violence</span>
            <span class="report-reason">Hate</span>
            <span class="report-reason">Sexualization of minors</span>
            <span class="report-reason">Sharing personal information</span>
            <span class="report-reason">Pornography</span>
            <span class="report-reason">Prohibited transaction</span>
            <span class="report-reason">Self-harm or suicide</span>
            <span class="report-reason">Misinformation</span>
            <span class="report-reason">Spam</span>
          </div>
          <div id="redundant-link-container">
            <i class="fas fa-link"></i>
            <input type="text" name="redundant-link" id="redundant-link" placeholder="Link of similar post">
          </div>
          <div id="report-detail-container">
            <p><span>(Optional)</span> Describe what happened...</p>
            <textarea name="report-detail" id="report-detail" placeholder="Elaborate what is wrong with this post..."></textarea>
          </div>
					<div class="modal-button-holder modal-alert-button-holder">
						<div class="btn btn-default modal-dismiss">Cancel</div>
						<div id="submit-report" class="btn btn-red disabled" data-thread_id="" data-reply_id="" data-post_ver="" data-user_id="0">Report</div>
					</div>
				</div>
			</div>
		</div>
		<div id="confirm-modal" class="modal">
			<div class="modal-content">
				<div class="modal-body">
					<div class="modal-header">
						<h2></h2>
						<div class="modal-close modal-dismiss">
							<img src="images/icons/close.png" alt="Close Icon">
						</div>
					</div>
					<div class="modal-alert">
						<div>
							<i></i>
						</div>
						<div>
							<p class="modal-alert-header"></p>
							<p class="modal-alert-content"></p>
						</div>
					</div>
					<div id="confirm-yes-cancel" class="modal-button-holder modal-alert-button-holder">
						<div></div>
						<div>
							<div class="btn btn-default modal-dismiss modal-dismiss-btn">Cancel</div>
							<div class="btn btn-green confirm-close">Yes</div>
						</div>
					</div>
					<div id="confirm-ok" class="modal-button-holder modal-alert-button-holder">
						<div></div>
						<div>
							<div class="btn btn-green confirm-close">OK</div>
						</div>
					</div>
					<div id="confirm-ok-fail" class="modal-button-holder modal-alert-button-holder">
						<div></div>
						<div>
							<div class="btn btn-green modal-dismiss modal-dismiss-btn">OK</div>
						</div>
					</div>
				</div>
			</div>
		</div>
    <div id="main">
      <div id="cover-image-container">
        <img src="images/content/general/cover.jpeg" class="cover-img" alt="">
        <div class="cover-shade"></div>
        <div class="cover-caption width-limit">
          <p>FORUM</p>
        </div>
      </div>
      <div id="breadcrumbs-container">
        <div id="breadcrumbs" class="width-limit">
          <span><a href = "index.php">Home</a></span>
          <span class = "breadcrumbs-next"></span>
          <span><?php echo ($catID == 0 ? $category : '<a href = "forum.php">Forum</a>'); ?></span>
          <?php
            if($catID > 0) {
          ?>
          <span class = "breadcrumbs-next"></span>
          <span><?php echo $category; ?></span>
          <?php
            }
          ?>
        </div>
      </div>
      <div id="main-inner" class="width-limit thread-layout">
        <div id = "main-content" class = "forum-header">
            <h2><?php echo strtoupper($category); ?></h2>
            <div id = "new-thread" class = "btn btn-green"><i class="fas fa-plus-square"></i><span class = "btn-label btn-label-responsive">New Thread</span></div>
        </div>
        <div id="forum-content-container">
          <div id="forum-filter" class="forum-content">
            <div id="filter-icon">
              <i class="fas fa-filter fa-lg"></i>
            </div>
            <div>
              <div id="forum-sort">
                <div id="sort-selected" class="forum-dropdown-selected">
                  <div class="dropdown-selected-content"><i class="fas fa-certificate"></i>Latest</div>
                  <div class="chevron-container">
                    <span class="chevron chevron-green"></span>
                  </div>
                  <div class="forum-selection forum-selection-responsive" style="display: flex; opacity: 1; visibility: visible;">
                    <div id="filter-latest" class="forum-radio selected-option"><i class="fas fa-certificate"></i>Latest</div>
                    <div id="filter-popular" class="forum-radio"><i class="fas fa-fire"></i>Popular</div>
                  </div>
                </div>
                <div id="popular-type-selected" class="forum-dropdown-selected" style="max-width: 0px; opacity: 0; visibility: hidden; display: none;">
                  <div class="dropdown-selected-content">
                  </div>
                  <div class="chevron-container">
                    <span class="chevron chevron-green"></span>
                  </div>
                  <div class="forum-selection">
                    <div id="filter-today">Today</div>
                    <div id="filter-week">This week</div>
                    <div id="filter-month">This month</div>
                    <div id="filter-all">All Time</div>
                  </div>
                </div>
              </div>
              <div id="thread-type-selected" class="forum-dropdown-selected">
                <div class="dropdown-selected-content">All</div>
                <div class="chevron-container">
                  <span class="chevron chevron-green"></span>
                </div>
                <div class="forum-selection">
                  <div id="filter-all-type" class="selected-option">All</div>
                  <div id="filter-discussion"><i class="fas fa-comment-alt"></i>Discussion</div>
                  <div id="filter-question"><i class="fas fa-question"></i>Question</div>
                </div>
              </div>
            </div>
          </div>
          <a href="forum/thread.php?ID=4/012822/this-is-a-spam" class="forum-content">
            <div class="thread-type">
              <i class="far fa-comment-alt fa-2x"></i>
            </div>
            <div class="thread-header">
              <p class="thread-category">General Forum</p>
              <p class="thread-author">Ysabel Dela Cruz</p>
            </div>
            <div class="thread-upvote">
              <div class="upvote-container">
                <p class="upvote-value">0</p>
                <p class="upvote-label">votes</p>
              </div>
            </div>
            <div class="thread-content">
              <div class="thread-title">This is a spam</div>
              <div class="thread-tag">
                <div class="tag">Test post</div>
              </div>
            </div>
            <div class="thread-action">
              <div>
                <div class="thread-reply">
                  <i class="fas fa-comment-dots fa-lg"></i>
                  <span>0 replies</span>
                </div>
                <div>
                  <div class="thread-share">
                    <i class="fas fa-share-square fa-lg"></i>
                    <span>Share</span>
                  </div>
                  <div class="thread-copy-link" data-url="forum/thread.php?ID=4/012822/this-is-a-spam">
                    <i class="fas fa-link fa-lg"></i>
                    <span>Copy Link</span>
                  </div>
                </div>
                <div class="thread-report modal-toggle" data-target="report-modal" data-thread_id="4" data-reply_id="" data-post_ver="1">
                  <i class="fas fa-flag fa-lg"></i>
                  <span>Report</span>
                </div>
              </div>
              <p>created Jan 28, 2022</p>
            </div>
          </a>
          <a href="forum/thread.php?ID=3/012822/creating-a-thread-directed-to-officialsmoderators" class="forum-content">
            <div class="thread-type">
              <i class="far fa-comment-alt fa-2x"></i>
            </div>
            <div class="thread-header">
              <p class="thread-category">General Forum</p>
              <p class="thread-author">Ysabel Dela Cruz</p>
            </div>
            <div class="thread-upvote">
              <div class="upvote-container">
                <p class="upvote-value">0</p>
                <p class="upvote-label">votes</p>
              </div>
            </div>
            <div class="thread-content">
              <div class="thread-title">Creating a thread directed to officials/moderators</div>
              <div class="thread-tag">
                <div class="tag">Test post</div>
              </div>
            </div>
            <div class="thread-action">
              <div>
                <div class="thread-reply">
                  <i class="fas fa-comment-dots fa-lg"></i>
                  <span>0 replies</span>
                </div>
                <div>
                  <div class="thread-share">
                    <i class="fas fa-share-square fa-lg"></i>
                    <span>Share</span>
                  </div>
                  <div class="thread-copy-link" data-url="forum/thread.php?ID=3/012822/creating-a-thread-directed-to-officialsmoderators">
                    <i class="fas fa-link fa-lg"></i>
                    <span>Copy Link</span>
                  </div>
                </div>
                <div class="thread-report modal-toggle" data-target="report-modal" data-thread_id="3" data-reply_id="" data-post_ver="1">
                  <i class="fas fa-flag fa-lg"></i>
                  <span>Report</span>
                </div>
              </div>
              <p>created Jan 28, 2022</p>
            </div>
          </a>
          <a href="forum/thread.php?ID=2/012722/website-feedback" class="forum-content">
            <div class="thread-type">
              <i class="far fa-comment-alt fa-2x"></i>
            </div>
            <div class="thread-header">
              <p class="thread-category">General Forum</p>
              <p class="thread-author">Marc Justyn Villanueva</p>
            </div>
            <div class="thread-upvote">
              <div class="upvote-container">
                <p class="upvote-value">0</p>
                <p class="upvote-label">votes</p>
              </div>
            </div>
            <div class="thread-content">
              <div class="thread-title">Website Feedback</div>
              <div class="thread-tag">
                <div class="tag">Feedback</div>
              </div>
            </div>
            <div class="thread-action">
              <div>
                <div class="thread-reply">
                  <i class="fas fa-comment-dots fa-lg"></i>
                  <span>0 replies</span>
                </div>
                <div>
                  <div class="thread-share">
                    <i class="fas fa-share-square fa-lg"></i>
                    <span>Share</span>
                  </div>
                  <div class="thread-copy-link" data-url="forum/thread.php?ID=2/012722/website-feedback">
                    <i class="fas fa-link fa-lg"></i>
                    <span>Copy Link</span>
                  </div>
                </div>
                <div class="thread-report modal-toggle" data-target="report-modal" data-thread_id="2" data-reply_id="" data-post_ver="1">
                  <i class="fas fa-flag fa-lg"></i>
                  <span>Report</span>
                </div>
              </div>
              <p>created Jan 27, 2022</p>
            </div>
          </a>
          <a href="forum/thread.php?ID=1/011722/welcome-to-ccis-discussion-forum" class="forum-content">
            <div class="thread-type">
              <i class="far fa-comment-alt fa-2x"></i>
            </div>
            <div class="thread-header">
              <p class="thread-category">General Forum</p>
              <p class="thread-author">Ysabel Dela Cruz</p>
            </div>
            <div class="thread-upvote">
              <div class="upvote-container">
                <p class="upvote-value">0</p>
                <p class="upvote-label">votes</p>
              </div>
            </div>
            <div class="thread-content">
              <div class="thread-title">Welcome to CCIS Discussion Forum!</div>
              <div class="thread-tag">
                <div class="tag">Test post</div>
              </div>
            </div>
            <div class="thread-action">
              <div>
                <div class="thread-reply">
                  <i class="fas fa-comment-dots fa-lg"></i>
                  <span>0 replies</span>
                </div>
                <div>
                  <div class="thread-share">
                    <i class="fas fa-share-square fa-lg"></i>
                    <span>Share</span>
                  </div>
                  <div class="thread-copy-link" data-url="forum/thread.php?ID=1/011722/welcome-to-ccis-discussion-forum">
                    <i class="fas fa-link fa-lg"></i>
                    <span>Copy Link</span>
                  </div>
                </div>
                <div class="thread-report modal-toggle" data-target="report-modal" data-thread_id="1" data-reply_id="" data-post_ver="1">
                  <i class="fas fa-flag fa-lg"></i>
                  <span>Report</span>
                </div>
              </div>
              <p>created Jan 17, 2022</p>
            </div>
          </a>
          <div id="page-row">
            <div id="page-container">
              <div class="page-number page-active" data-page="1">1</div>
            </div>
          </div>
        </div>
        <div id="content-menu">
          <div id="search-sidebar">
            <i class="fas fa-search fa-lg"></i>
            <input type="text" id="forum-search" placeholder="Search for a keyword or tag...">
            <div id="search-tooltip">
              Use <span>[tag]</span> to search for tags
            </div>
          </div>
          <div class="content-sidebar">
            <h3>CATEGORIES</h3>
            <ul>
              <li><a href="forum.php?ID=1&amp;category=general-forum">General Forum</a></li>
              <li><a href="forum.php?ID=2&amp;category=academic-concerns">Academic Concerns</a></li>
              <li><a href="forum.php?ID=3&amp;category=student-community-forum">Student Community Forum</a></li>
              <li><a href="forum.php?ID=4&amp;category=student-organization">Student Organization</a></li>
            </ul>
          </div>
          <div class="content-sidebar">
            <h3>POPULAR TAGS</h3>
            <div class="tag" data-tag_id="7">Test post</div>
            <div class="tag" data-tag_id="6">Feedback</div>
            <div class="tag" data-tag_id="4">Admission</div>
            <div class="tag" data-tag_id="2">Advice</div>
            <div class="tag" data-tag_id="3">Enrollment</div>
            <div class="tag" data-tag_id="1">Programming</div>
            <div class="tag" data-tag_id="5">Web Programming</div>
          </div>
        </div>
      </div>
    </div>
    <footer>
      <div id="pre-foot-container">
        <div id="pre-foot" class="width-limit">
          <div id="pre-foot-content">
            <div>
              <h4>CCIS</h4>
              <ul>
                <li><a href="news/news.php">News</a></li>
                <li><a href="student.php">Student</a></li>
                <li><a href="faculty.php">Faculty</a></li>
              </ul>
            </div>
            <div>
              <h4>QUICK LINKS</h4>
              <ul>
                <li><a href="https://www.pup.edu.ph/about/calendar" target="_blank">University Calendar</a></li>
                <li><a href="https://sisstudents.pup.edu.ph/" target="_blank">Student Information System</a></li>
                <li><a href="forum.php">Forum</a></li>
              </ul>
            </div>
            <div>
              <h4>GET TO KNOW US</h4>
              <ul>
                <li><a href="about.php">About</a></li>
                <li><a href="gallery.php">Gallery</a></li>
                <li><a href="about/contact-us.php">Contact</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div id="page-foot-container">
        <div id="page-foot" class="width-limit">
          <div id="page-foot-content">
            <div id="foot-logo-container">
              <div class="foot-logo">
                <img src="images/content/general/univ.png" alt="University">
              </div>
              <div class="foot-logo">
                <img src="images/content/general/logo.png" alt="College">
              </div>
            </div>
            <div class="page-foot-info">
              <div class="page-foot-icon-container">
                  <i class="fas fa-map-marker-alt fa-lg"></i>
              </div>
              <div class="page-foot-description">2/F North Wing (N-206) Main Student Building, PUP A. Mabini Campus, Anonas St., Sta. Mesa, Manila, Philippines 1016</div>
            </div>
            <div class="page-foot-info">
              <div class="page-foot-icon-container">
                <a href="https://www.facebook.com/PUPCCISOfficial" target="_blank"><i class="fab fa-facebook-square fa-lg"></i></a>
              </div>
              <div class="page-foot-description">
                <a href="https://www.facebook.com/PUPCCISOfficial" target="_blank">College of Computer and Information Sciences</a>
              </div>
            </div>
            <div class="page-foot-info">
              <div class="page-foot-icon-container">
                <i class="fas fa-phone fa-lg"></i>
              </div>
              <div class="page-foot-description">(+63 2) 716-4032</div>
            </div>
            <div class="page-foot-info">
              <div class="page-foot-icon-container">
                <a href="mailto:ccis@pup.edu.ph"><i class="fas fa-envelope fa-lg"></i></a>
              </div>
              <div class="page-foot-description">
                <a href="mailto:ccis@pup.edu.ph">ccis@pup.edu.ph</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer>
    <div id="load-modal" class="modal" data-backdrop="static" data-keyboard="false">
      <svg>
        <g>
          <path d="M 50,100 A 1,1 0 0 1 50,0"></path>
        </g>
        <g>
          <path d="M 50,75 A 1,1 0 0 0 50,-25"></path>
        </g>
        <defs>
          <linearGradient id="gradient" x1="0%" y1="0%" x2="0%" y2="100%">
            <stop offset="0%" style="stop-color: #047c5a; stop-opacity: 1"></stop>
            <stop offset="100%" style="stop-color: #00A879; stop-opacity: 1"></stop>
          </linearGradient>
        </defs>
      </svg>
    </div>
    <script>
      if(window.location.search != '')
        $(window).scrollTop($('#breadcrumbs-container').offset().top);
    </script>
  </body>
</html>