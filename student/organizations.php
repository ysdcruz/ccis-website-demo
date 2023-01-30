<!DOCTYPE html>
<html>
  <head>
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
		<meta content="utf-8" http-equiv="encoding">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Organizations – College of Computer and Information Sciences</title>
    <link rel="shortcut icon" type="image/x-icon" href="../images/content/general/icon.ico">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/fontawesome/css/all.css">
    <script src="../js/jquery-3.6.0.min.js"></script>
		<script src="../js/front.js"></script>
		<script src="../js/back.js"></script>
    <script>
      $(document).on('click', '.grp-box', function() {
        if($(this).find('.grp-box-inner').hasClass('grp-box-toggle'))
          $(this).find('.grp-box-inner').removeClass('grp-box-toggle');
        else {
          $('.grp-box-inner').removeClass('grp-box-toggle');
          $(this).find('.grp-box-inner').addClass('grp-box-toggle');
        }
      });

      $(document).on('click', '#main-content, #content-body', function(evt) {
        if(evt.target !== this)
          return;
        
        $('.grp-box-inner').removeClass('grp-box-toggle');
      });
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
            <li class="nav-tab nav-dropdown">
              <span>NEWS</span>
              <div class="chevron-container">
                <span class="chevron"></span>
              </div>
              <div class="dropdown">
                <ul class="sub-menu">
                  <a href="../news/news.php"><li class="sub-nav">News</li></a>
                  <a href="../news/announcements.php"><li class="sub-nav">Announcements</li></a>
                </ul>
              </div>
            </li>
            <li class="nav-tab nav-dropdown active">
              <a href="../student.php">STUDENT</a>
              <div class="chevron-container">
                <span class="chevron"></span>
              </div>
              <div class="dropdown">
                <ul class="sub-menu">
                  <a href="programs.php"><li class="sub-nav">Programs</li></a>
                  <a href="organizations.php"><li class="sub-nav">Student Organizations</li></a>
                  <a href="handbook.php"><li class="sub-nav">Student Handbook</li></a>
                  <a href="forms.php"><li class="sub-nav">Downloadable Forms</li></a>
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
          <p>STUDENT</p>
        </div>
      </div>
      <div id="breadcrumbs-container">
        <div id="breadcrumbs" class="width-limit">
          <span><a href="../index.php">Home</a></span>
          <span class="breadcrumbs-next"></span>
          <span><a href="../student.php">Student</a></span>
          <span class="breadcrumbs-next"></span>
          <span>Student Organizations</span>
        </div>
      </div>
      <div id="main-inner" class="width-limit">
        <div id="main-column">
          <div id="main-content">
            <h2>STUDENT ORGANIZATIONS</h2>
            <div id="content-body" class="flex-box">
              <div id="top-box" class="grp-box">
                <div class="grp-box-inner">
                  <div>
                    <div class="grp-box-img">
                      <img src="../images/content/student/org/1.jpeg" alt="CCIS-SC">
                    </div>
                    <div class="grp-box-description">
                      <h3>CCIS-SC</h3>
                      <span>College of Computer and Information Sciences - Student Council</span>
                    </div>
                  </div>
                  <div>
                    <div class="grp-box-name">
                      <div>
                        <img src="../images/content/student/org/1.jpeg" alt="CCIS-SC">
                      </div>
                      <span>CCIS-SC</span>
                    </div>
                    <div class="grp-box-info">
                      <p>The CCIS - Student Council is the highest constituted student government of CCIS. With the aim to provide genuine services to fellow students, CCIS-SC leads the fight for the rights and welfare of the studentry.</p>
                    </div>
                    <div class="grp-box-links">
                      <div>
                        <i class="fab fa-facebook-square fa-lg"></i><a href="https://www.facebook.com/PUPCCISStudentCouncil/" target="_blank">PUP CCIS Student Council</a>
                      </div>
                      <div>
                        <i class="fab fa-twitter fa-lg"></i><a href="https://twitter.com/CCISkolar" target="_blank">CCIS Student Council</a>
                      </div>
                      <div>
                        <i class="fas fa-envelope fa-lg"></i><a href="mailto:pupccis.studentcouncil@gmail.com">pupccis.studentcouncil@gmail.com</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="grp-box">
                <div class="grp-box-inner">
                  <div>
                    <div class="grp-box-img">
                      <img src="../images/content/student/org/2.png" alt="AsCII">
                    </div>
                    <div class="grp-box-description">
                      <h3>AsCII</h3>
                      <span>Association of Students for Computer Intelligence Integration</span>
                    </div>
                  </div>
                  <div>
                    <div class="grp-box-name">
                      <div>
                        <img src="../images/content/student/org/2.png" alt="AsCII">
                      </div>
                      <span>AsCII</span>
                    </div>
                    <div class="grp-box-info">
                      <p>AsCII is the official academic student organization of the Department of Computer Science in the Polytechnic University of the Philippines. AsCII is intended primarily to promote Computer Science as a frontier for creativity and innovation.</p>
                    </div>
                    <div class="grp-box-links">
                      <div>
                        <i class="fab fa-facebook-square fa-lg"></i><a href="https://www.facebook.com/PUPASCII/" target="_blank">AsCII</a>
                      </div>
                      <div>
                        <i class="fas fa-envelope fa-lg"></i><a href="mailto:pupasciiofficial@gmail.com">pupasciiofficial@gmail.com</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="grp-box">
                <div class="grp-box-inner">
                  <div>
                    <div class="grp-box-img">
                      <img src="../images/content/student/org/3.jpeg" alt="IBITS">
                    </div>
                    <div class="grp-box-description">
                      <h3>IBITS</h3>
                      <span>Institute of Bachelors in Information Technology Studies</span>
                    </div>
                  </div>
                  <div>
                    <div class="grp-box-name">
                      <div>
                        <img src="../images/content/student/org/3.jpeg" alt="IBITS">
                      </div>
                      <span>IBITS</span>
                    </div>
                    <div class="grp-box-info">
                      <p>IBITS is the official academic organization of the Bachelor of Science in Information Technology (BSIT) students of PUP Sta. Mesa.</p>
                    </div>
                    <div class="grp-box-links">
                      <div>
                        <i class="fab fa-facebook-square fa-lg"></i><a href="https://www.facebook.com/iBITS.Official/" target="_blank">IBITS</a>
                      </div>
                      <div>
                        <i class="fas fa-envelope fa-lg"></i><a href="mailto:ccis.ibits@gmail.com">ccis.ibits@gmail.com</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="grp-box">
                <div class="grp-box-inner">
                  <div>
                    <div class="grp-box-img">
                      <img src="../images/content/student/org/4.png" alt="The Compiler">
                    </div>
                    <div class="grp-box-description">
                      <h3>The Compiler</h3>
                      <span>The Compiler</span>
                    </div>
                  </div>
                  <div>
                    <div class="grp-box-name">
                      <div>
                        <img src="../images/content/student/org/4.png" alt="The Compiler">
                      </div>
                      <span>The Compiler</span>
                    </div>
                    <div class="grp-box-info">
                      <p>The Compiler, Department of Computer Science's Official Student Publication, provides the best service for responsible journalism as they intensify the contribution of young individuals to public service not only in the academe, but also in the society.</p>
                    </div>
                    <div class="grp-box-links">
                      <div>
                        <i class="fab fa-facebook-square fa-lg"></i><a href="https://www.facebook.com/TheCompilerOnline/" target="_blank">The Compiler Online</a>
                      </div>
                      <div>
                        <i class="fas fa-envelope fa-lg"></i><a href="mailto:thecompilerdcs@gmail.com">thecompilerdcs@gmail.com</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="grp-box">
                <div class="grp-box-inner">
                  <div>
                    <div class="grp-box-img">
                      <img src="../images/content/student/org/5.jpeg" alt="InfoBITS">
                    </div>
                    <div class="grp-box-description">
                      <h3>InfoBITS</h3>
                      <span>InfoBITS</span>
                    </div>
                  </div>
                  <div>
                    <div class="grp-box-name">
                      <div>
                        <img src="../images/content/student/org/5.jpeg" alt="InfoBITS">
                      </div>
                      <span>InfoBITS</span>
                    </div>
                    <div class="grp-box-info">
                      <p>InfoBITS is the official student publication of the College of Computer and Information Sciences (CCIS) Department of Information Technology at Polytechnic University of the Philippines, Manila (PUP).</p>
                    </div>
                    <div class="grp-box-links">
                      <div>
                        <i class="fab fa-facebook-square fa-lg"></i><a href="https://www.facebook.com/infobits.pup" target="_blank">PUP InfoBITS</a>
                      </div>
                      <div>
                        <i class="fas fa-envelope fa-lg"></i><a href="mailto:infobitspup@gmail.com">infobitspup@gmail.com</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="grp-box">
                <div class="grp-box-inner">
                  <div>
                    <div class="grp-box-img">
                      <img src="../images/content/student/org/6.jpeg" alt="TPG">
                    </div>
                    <div class="grp-box-description">
                      <h3>TPG</h3>
                      <span>The Programmers' Guild</span>
                    </div>
                  </div>
                  <div>
                    <div class="grp-box-name">
                      <div>
                        <img src="../images/content/student/org/6.jpeg" alt="TPG">
                      </div>
                      <span>TPG</span>
                    </div>
                    <div class="grp-box-info">
                      <p>The PUP Programmers' Guild is a university wide organization composed of different programmers and developers, conducting different events and activities related to the fields of programming and development.</p>
                    </div>
                    <div class="grp-box-links">
                      <div>
                        <i class="fab fa-facebook-square fa-lg"></i><a href="https://www.facebook.com/PUPTPG/" target="_blank">PUP The Programmers' Guild</a>
                      </div>
                      <div>
                        <i class="fas fa-envelope fa-lg"></i><a href="mailto:puptpg@gmail.com">puptpg@gmail.com</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="grp-box">
                <div class="grp-box-inner">
                  <div>
                    <div class="grp-box-img">
                      <img src="../images/content/student/org/7.jpeg" alt="OOC">
                    </div>
                    <div class="grp-box-description">
                      <h3>OOC</h3>
                      <span>Out of Codes</span>
                    </div>
                  </div>
                  <div>
                    <div class="grp-box-name">
                      <div>
                        <img src="../images/content/student/org/7.jpeg" alt="OOC">
                      </div>
                      <span>OOC</span>
                    </div>
                    <div class="grp-box-info">
                      <p>Out of Codes is the PUP Manila's College of Computer and Information Sciences official dance crew.</p>
                    </div>
                    <div class="grp-box-links">
                      <div>
                        <i class="fab fa-facebook-square fa-lg"></i><a href="https://www.facebook.com/oocdancecrew/" target="_blank">Out of Codes</a>
                      </div>
                      <div>
                        <i class="fas fa-envelope fa-lg"></i><a href="mailto:ccis.ooc@gmail.com">ccis.ooc@gmail.com</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="share-container">
              <h3>Share This Page</h3>
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
          <div id="content-menu">
            <div id="related-sidebar" class="content-sidebar">
              <h3>RELATED</h3>
              <ul>
                <li><a href="../about/mission-goals.php">Mission and Goals</a></li>
                <li><a href="../about/contact-us.php">Contact Us</a></li>
              </ul>
            </div>
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
                    <p class="glance-headline"><a href="../news/post.php?ID=1/announcements/011922/welcome-to-ccis-website">Welcome to CCIS Website!</a>
                    </p>
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
    </div>
    <footer>
      <div id="pre-foot-container">
        <div id="pre-foot" class="width-limit">
          <div id="pre-foot-content">
            <div>
              <h4>RELATED</h4>
              <ul>
                <li><a href="programs.php">Programs</a></li>
                <li><a href="handbook.php">Student Handbook</a></li>
                <li><a href="forms.php">Downloadable Forms</a></li>
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