<!DOCTYPE html>
<html>
  <head>
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
		<meta content="utf-8" http-equiv="encoding">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>News – College of Computer and Information Sciences</title>
    <link rel="shortcut icon" type="image/x-icon" href="../images/content/general/icon.ico">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/fontawesome/css/all.css">
    <script src="../js/jquery-3.6.0.min.js"></script>
		<script src="../js/front.js"></script>
		<script src="../js/back.js"></script>
    <script>
			let newsArray = [{"cover_Img":"images\/content\/posts\/news\/default.png","post_Title":"CCIS Certified Level IV","post_Create":"January 26, 2022 ","post_Create_Date":"January 26, 2022","post_Intro":"Programs of College of Computer and Information Sciences, namely Bachelor of Science in Computer Science and Bachelor of Science in Information Technology, were conferred with Level IV Accredited status by the Accrediting Agency of Chartered Colleges and Universities in the Philippines (AACCUP).","news_Link":"post.php?ID=3\/news\/012622\/ccis-certified-level-iv"}];

      let previewTimer; // recursive timer
      let previewSlides = newsArray.length <= 5 ? newsArray.length : 5; // total no. of .preview-article
      let previewIndex = -1;
      let newWindow = true; // if page is loaded for the first time
      let newPreview = true; // if new preview

      // set displayed image of banner, isSlide = true if prev/next banner, isSlide = false if .preview-article is selected
      function setBanner(index, isSlide) {
        // restart timer
        clearInterval(previewTimer);

        // if prev/next banner
        if(isSlide) {
          if(index < 0) // previous image
          previewIndex -= 2;
          if(previewIndex < -1) // go to back to last image if #prev-banner is clicked on the first image
          previewIndex = previewSlides - 2;
        } else
          previewIndex = index;
        
        newPreview = true;
        slidePreview();
      }
      
      function changePreview() {
        $('#preview-active-background').css('transform', 'translateY(' + (100 * previewIndex) + '%)');
        let activePreview = $('.preview-article').eq(previewIndex);
        $(activePreview).addClass('active-preview');
        $('.recent-dot').eq(previewIndex).addClass('active-dot');

        // get data of .preview-article and pass to #featured-news
        $('#featured-news').attr('href', $(activePreview).attr('data-news_Link'));
        $('#preview-thumbnail').find('img').attr({
          'src': $(activePreview).attr('data-img_Src'),
          'alt': $(activePreview).attr('data-img_Alt')
        });
        $('#featured-news-caption > div > h2').html($(activePreview).attr('data-prev_Head'));
        $('#featured-date').html($(activePreview).attr('data-prev_Date'));
        $('#featured-news').fadeIn('fast');
      }

      function slidePreview() {
        $('.preview-article').removeClass('active-preview');
        $('.recent-dot').removeClass('active-dot');

        // go back to first news if end is reached
        if(previewIndex >= previewSlides - 1)
          previewIndex = -1;

        if(newWindow)
          newWindow = false;
        else
          $('#featured-news').fadeOut('fast');
        
        previewIndex++;
        setTimeout(changePreview, 100);

        // reset timer to 5s if new index is selected
        if(newPreview) {
          previewTimer = setInterval(slidePreview, 10000);
          newPreview = false;
        }
      }

      window.onload = function() {
        if(newsArray.length > 0) {
          for(let i = 0; i < newsArray.length; i++)
            addRecentNews(newsArray[i]);

          slidePreview();
        }
      };
    </script>
  </head>
  <body>
    <header>
      <div id="website-header-container">
        <div id="website-header" class="width-limit">
          <i id="nav-bar" class="fas fa-bars fa-lg"></i>
          <div id="logo-container">
            <a id="logo-link" href="../index.php"><img id="logo-img" src="../images/content/general/logo.png" alt="Logo"></a>
            <a href="../index.php"><p id="ccis" data-web_init="CCIS" data-web_name="College of Computer and Information Sciences">College of Computer and Information Sciences</p></a>
          </div>
          <div id="right-options">
            <div id="search-container" class="modal-toggle" data-target="search-modal">
              <div id="search-img-container">
                <img src="../images/icons/search-icon.png" id="search-icon" alt="Search Icon">
              </div>
            </div>
            <div id="user-container">
              <div>
                <div id="user-img-container" style="">
                  <img src="../images/icons/user-icon.png" id="user-icon" alt="User Icon">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="nav-bg" class="bg"></div>
      <div id="nav-header-container">
        <div id="nav-header" class="width-limit">
          <ul id="nav">
            <div class="sidebar-close">
              <img src="../images/icons/close-white.png" alt="Close Icon">
            </div>
            <li class="nav-tab">
              <a href="../index.php">HOME</a>
            </li>
            <li class="nav-tab nav-dropdown">
              <a href="../about.php">ABOUT</a>
              <div class="chevron-container">
                <span class="chevron"></span>
              </div>
              <div class="dropdown">
                <ul class="sub-menu">
                  <a href="../about/ccis-history.php"><li class="sub-nav">CCIS and its History</li></a>
                  <a href="../about/mission-goals.php"><li class="sub-nav">Mission and Goals</li></a>
                  <a href="../about/contact-us.php"><li class="sub-nav">Contact Us</li></a>
                </ul>
              </div>
            </li>
            <li class="nav-tab nav-dropdown active">
              <span>NEWS</span>
              <div class="chevron-container">
                <span class="chevron"></span>
              </div>
              <div class="dropdown">
                <ul class="sub-menu">
                  <a href="news.php"><li class="sub-nav">News</li></a>
                  <a href="announcements.php"><li class="sub-nav">Announcements</li></a>
                </ul>
              </div>
            </li>
            <li class="nav-tab nav-dropdown">
              <a href="../student.php">STUDENT</a>
              <div class="chevron-container">
                <span class="chevron"></span>
              </div>
              <div class="dropdown">
                <ul class="sub-menu">
                  <a href="../student/programs.php"><li class="sub-nav">Programs</li></a>
                  <a href="../student/organizations.php"><li class="sub-nav">Student Organizations</li></a>
                  <a href="../student/handbook.php"><li class="sub-nav">Student Handbook</li></a>
                  <a href="../student/forms.php"><li class="sub-nav">Downloadable Forms</li></a>
                </ul>
              </div>
            </li>
            <li class="nav-tab">
              <a href="../faculty.php">FACULTY</a>
            </li>
            <li class="nav-tab nav-dropdown">
              <a href="../forum.php">FORUM</a>
              <div class="chevron-container">
                <span class="chevron"></span>
              </div>
              <div class="dropdown">
                <ul class="sub-menu">
                  <a href="../forum.php?ID=1&amp;category=general-forum"><li class="sub-nav">General Forum</li></a>
                  <a href="../forum.php?ID=2&amp;category=academic-concerns"><li class="sub-nav">Academic Concerns</li></a>
                  <a href="../forum.php?ID=3&amp;category=student-community-forum"><li class="sub-nav">Student Community Forum</li></a>
                  <a href="../forum.php?ID=4&amp;category=student-organization"><li class="sub-nav">Student Organization</li></a>
                </ul>
              </div>
            </li>
            <li class="nav-tab">
              <a href="../gallery.php">GALLERY</a>
            </li>
            <li class="nav-tab nav-dropdown">
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
          <div id="profile-nav">
            <div class="sidebar-close">
              <img src="../images/icons/close-white.png" alt="Close Icon">
            </div>
              <a href="../sign-in.php#sign-up" id="signup">Sign Up</a>
              <a href="../sign-in.php#log-in" id="login">Log In</a>
            </div>
        </div>
      </div>
    </header>
    <div id="top"><span></span></div>
		<div id="search-modal" class="modal">
      <div>
        <div id="search-close">
          <img src="../images/icons/close-white.png" alt="Close Icon">
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
              <img src="../images/icons/close.png" alt="Close Icon">
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
						<a href="../server/signout.php" id="sign-out" class="btn btn-red"><i class="fas fa-sign-out-alt"></i>Sign Out</a>
					</div>
				</div>
			</div>
		</div>
    <div id="main">
      <div id="cover-image-container">
        <img src="../images/content/general/cover.jpeg" class="cover-img" alt="">
        <div class="cover-shade"></div>
        <div class="cover-caption width-limit">
          <p>NEWS AND ANNOUNCEMENTS</p>
        </div>
      </div>
      <div id="breadcrumbs-container">
        <div id="breadcrumbs" class="width-limit">
          <span><a href="../index.php">Home</a></span>
          <span class="breadcrumbs-next"></span>
          <span>News and Announcements</span>
          <span class="breadcrumbs-next"></span>
          <span><a href="news.php">News</a></span>
        </div>
      </div>
    </div>
    <div id="main-inner" class="width-limit">
      <div id="main-content" class="news-content">
        <h2>RECENT NEWS</h2>
          <div id="content-body">
            <div id="recent-news-container">
              <a href="post.php?ID=3/news/012622/ccis-certified-level-iv" id="featured-news" style="">
                <div id="preview-thumbnail">
                  <img src="../images/content/posts/news/default.png" alt="CCIS Certified Level IV">
                  <div id="featured-news-shade"></div>
                  <div id="featured-news-caption">
                    <div>
                      <h2>CCIS Certified Level IV</h2>
                      <span class="news-read-more active-read-more">Read More »</span>
                    </div>
                    <p id="featured-date">January 26, 2022 </p>
                  </div>
                </div>
              </a>
              <div id="recent-news">
                <div id="preview-background">
                  <div id="preview-active-background" style="transform: translateY(0%);"></div>
                </div>
              </div>
              <div id="recent-news-responsive">
                <span class="recent-dot active-dot"></span>
              </div>
            </div>
          </div>
        </div>
        <div id="main-column">
          <div id="more-stories">
            <h3>MORE STORIES</h3>
            <div id="all-news">
              <article class="preview-article">
                <a href="post.php?ID=3/news/012622/ccis-certified-level-iv" class="recent-thumbnail"><img src="../images/content/posts/news/default.png" alt="CCIS Certified Level IV"></a>
                <div>
                  <p class="preview-headline"><a href="post.php?ID=3/news/012622/ccis-certified-level-iv">CCIS Certified Level IV</a></p><p class="preview-date">January 26, 2022</p>
                  <p class="preview-intro">Programs of College of Computer and Information Sciences, namely Bachelor of Science in Computer Science and Bachelor of Science in Information Technology, were conferred with Level IV Accredited status by the Accrediting Agency of Chartered Colleges and Universities in the Philippines (AACCUP).</p>
                </div>
              </article>
            </div>
            <div id="news-page-row">
              <div id="news-page-container">
                <div id="news-first-page" class="news-page-number news-page-arrow hidden" data-page="1"><span>«</span></div>
                <div id="news-prev-page" class="news-page-number news-page-arrow hidden" data-page="-1"><span>‹</span></div>
                <span id="news-first-ellipsis" class="page-ellipsis hidden">…</span>
                <div class="news-page-number page-active" data-page="1">1</div>
                <span id="news-last-ellipsis" class="page-ellipsis hidden">…</span>
                <div id="news-next-page" class="news-page-number news-page-arrow hidden" data-page="+1"><span>›</span></div>
                <div id="news-last-page" class="news-page-number news-page-arrow hidden" data-page="1"><span>»</span></div>
              </div>
            </div>
          </div>
          <div id="content-menu">
            <div class="content-sidebar">
              <h3>RECENT ANNOUNCEMENTS</h3>
              <div id="content-announcements" class="headline-sidebar">
                <article data-news_link="post.php?ID=2/announcements/012622/suspension-of-synchronous-class-activities">
                  <div>
                    <p class="glance-headline">
                      <a href="post.php?ID=2/announcements/012622/suspension-of-synchronous-class-activities">Suspension of Synchronous Class Activities</a>
                    </p>
                    <span class="glance-date">January 26, 2022</span>
                  </div>
                </article>
                <article data-news_link="post.php?ID=1/announcements/011922/welcome-to-ccis-website">
                  <div>
                    <p class="glance-headline">
                      <a href="post.php?ID=1/announcements/011922/welcome-to-ccis-website">Welcome to CCIS Website!</a>
                    </p>
                    <span class="glance-date">January 19, 2022</span>
                  </div>
                </article>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <footer>
      <div id="pre-foot-container">
        <div id="pre-foot" class="width-limit">
          <div id="pre-foot-content">
            <div>
              <h4>RELATED</h4>
              <ul>
                <li><a href="announcements.php">Announcements</a></li>
              </ul>
            </div>
            <div>
              <h4>QUICK LINKS</h4>
              <ul>
                <li><a href="https://www.pup.edu.ph/about/calendar" target="_blank">University Calendar</a></li>
                <li><a href="https://sisstudents.pup.edu.ph/" target="_blank">Student Information System</a></li>
                <li><a href="../forum.php">Forum</a></li>
              </ul>
            </div>
            <div>
              <h4>GET TO KNOW US</h4>
              <ul>
                <li><a href="../about.php">About</a></li>
                <li><a href="../faculty.php">Faculty</a></li>
                <li><a href="../gallery.php">Gallery</a></li>
                <li><a href="../about/contact-us.php">Contact</a></li>
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
                <img src="../images/content/general/univ.png" alt="University">
              </div>
              <div class="foot-logo">
                <img src="../images/content/general/logo.png" alt="College">
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
  </body>
</html>