<?php
	if(isset($_GET['ID'])) {
		$linkID = $_GET['ID'];
    $linkExplode = explode('/', $linkID);
    $ID = $linkExplode[0];
    $post_type = ucfirst($linkExplode[1]);
    $post_date = date_format(date_create_from_format("mdy", $linkExplode[2]), 'M d, Y');

  } else
    header('location:news.php');
?>

<!DOCTYPE html>
<html>
  <head>
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
		<meta content="utf-8" http-equiv="encoding">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to CCIS Website! | <?php echo $post_type; ?> – College of Computer and Information Sciences</title>
    <link rel="shortcut icon" type="image/x-icon" href="../images/content/general/icon.ico">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/fontawesome/css/all.css">
    <script src="../js/jquery-3.6.0.min.js"></script>
		<script src="../js/front.js"></script>
		<script src="../js/back.js"></script>
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
    <div id="main" class="space-above">
      <div id="breadcrumbs-container">
        <div id="breadcrumbs" class="width-limit">
          <span><a href="../index.php">Home</a></span>
          <span class="breadcrumbs-next"></span>
          <span><a href="../news-announcements.php">News and Announcements</a></span>
          <span class="breadcrumbs-next"></span>
          <span><a href="announcements.php"><?php echo $post_type; ?></a></span>
        </div>
      </div>
    </div>
    <div id="main-inner" class="width-limit">
      <div id="main-inner" class="width-limit">
        <div id="main-column">
          <div id="main-content">
            <h2>Welcome to CCIS Website! </h2>
            <div id="post-details">
              <div id="post-writer">
                <a href="../profile.php?ID=1&amp;ydelacruz#/about">Ysabel Dela Cruz</a>, <a href="#">Developer</a>
              </div>
              <div id="post-date">
                <i class="far fa-clock"></i>
                <span>Posted at <?php echo $post_date; ?> 02:42 PM</span>
              </div>
            </div>
            <div id="content-body" class="post-body">
              <div class="content-image-container">
                <div class="content-img">
                  <img src="../images/content/posts/announcements/cover/1/cover.png" alt="Welcome to CCIS Website!">
                </div>
                <div class="content-img-caption">
                </div>
              </div>
              <div id="post-content">
                <p>This website was created by <strong>Ysabel Dela Cruz</strong>, <strong>Ron-Arvil Villar</strong>, and <strong>Gerald Rongcales</strong> for their capstone entitled <strong>"College Website with Discussion Forum and Document Request System"</strong> as part of requirements for the courses Capstone Project 1 and 2. With the objective of generating <span style="color: black;">a centralized website that caters all the concerns, inquiries, news, and announcements in CCIS community, the developers built this system from April 2020 to January 2021.</span></p>
                <p><br></p><p>This project aimed to motivate collective and cooperative work from all constituents of the college. While the administration is given a greater responsibility in managing the whole system, student organizations could contribute by writing content such as news articles and announcements. Students, alumni, and the faculty will also be encouraged to do their part by sharing their thoughts and answers in the discussion forum.</p>
              </div>
              <div class="share-container">
                <h3>Share This Post</h3>
                <div class="share-button-container">
                  <div class="share-fb">
                    <i class="fab fa-facebook-square fa-2x"></i>
                    <span>Facebook</span>
                  </div>
                  <div class="share-twt">
                    <i class="fab fa-twitter fa-2x"></i>
                    <span>Twitter</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div id="content-menu">
            <div class="content-sidebar">
              <h3>AT A GLANCE</h3>
              <div id="content-announcements" class="headline-sidebar">
                <div class="sidebar-header">ANNOUNCEMENTS</div>
                  <article data-news_link="../news/post.php?ID=2/announcements/012622/suspension-of-synchronous-class-activities">
                    <div>
                      <p class="glance-headline"><a href="../news/post.php?ID=2/announcements/012622/suspension-of-synchronous-class-activities">Suspension of Synchronous Class Activities</a></p>
                      <span class="glance-date">January 26, 2022</span>
                    </div>
                  </article>
                  <article data-news_link="../news/post.php?ID=1/announcements/011922/welcome-to-ccis-website">
                    <div>
                      <p class="glance-headline"><a href="../news/post.php?ID=1/announcements/011922/welcome-to-ccis-website">Welcome to CCIS Website!</a></p>
                      <span class="glance-date">January 19, 2022</span>
                    </div>
                  </article>
                </div>
                <div id="content-news" class="headline-sidebar">
                  <div class="sidebar-header">NEWS</div>
                  <article data-news_link="../news/post.php?ID=3/news/012622/ccis-certified-level-iv">
                    <div>
                      <p class="glance-headline"><a href="../news/post.php?ID=3/news/012622/ccis-certified-level-iv">CCIS Certified Level IV</a></p>
                      <span class="glance-date">January 26, 2022</span>
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
                <li><?php if($post_type == 'News' ? '<a href="announcements.php">Announcements</a>' : '<a href="news.php">News</a>'); ?></li>
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