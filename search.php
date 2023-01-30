<?php
	if(isset($_GET['search']) && !empty($_GET['search']))
		$search = $_GET['search'];
	else
		header('location:index.php');

	if(isset($_GET['type']))
		$type = $_GET['type'];
?>

<!DOCTYPE html>
<html>
	<head>
		<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
		<meta content="utf-8" http-equiv="encoding">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php echo htmlspecialchars_decode($search); ?> | Search – College of Computer and Information Sciences</title>
		<link rel="shortcut icon" type="image/x-icon" href="images/content/general/icon.ico">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/fontawesome/css/all.css">
		<script src="js/jquery-3.6.0.min.js"></script>
		<script src="js/front.js"></script>
		<script src="js/back.js"></script>
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
            <li class="nav-tab nav-trans nav-dropdown">
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
		<div id="main" class="space-above">
			<div id="main-inner">
				<div id="search-top">
					<div id="modal-search-container" class="width-limit">
						<i class="fas fa-search fa-lg"></i>
						<input type="text" id="modal-search" placeholder="Find Pages, News, &amp; Threads..." value="<?php echo htmlspecialchars_decode($search); ?>">
						<div id="search-btn">
							<i class="fas fa-search fa-lg"></i>
							<span>SEARCH</span>
						</div>
					</div>
					<div id="search-type" class="width-limit">
						<div id="search-page" <?php if($type == 'page') echo 'class="is-selected"'; ?>>Page</div>
						<div id="search-news" <?php if($type == 'news') echo 'class="is-selected"'; ?>>News</div>
						<div id="search-thread">Thread</div>
						<div id="search-type-selected"></div>
					</div>
					<div id="search-header" class="width-limit">
						<div id="all-search-result">
							<p>Search results for </p>
							<span>“<?php echo htmlspecialchars_decode($search); ?>”</span>
						</div>
					</div>
					<div id="wave">
						<svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
							<path d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z" class="shape-fill"></path>
						</svg>
					</div>
				</div><?php
					if($type == 'page') {
				?><div id="search-grid" class="width-limit">
					<a href="about/ccis-history.php" class="search-box">
						<p class="page-name">CCIS and Its History</p>
						<div class="page-loc">
							<span>About</span>
							<span class="loc-next"></span>
							<span>CCIS and Its History</span>
						</div>
						<p class="page-sneak-peek">The College of Computer and Information Sciences (CCIS) began its drive way back when the Polytechnic University of the Philippines (PUP) was still known as the Philippine College of Commerce (PCC) in 1969. It had formerly belonged to the Faculty of Accountancy in the era when mainframe computers were generally used to process accounting transactions. Primarily, short-term Electronic Data Processing (EDP) courses were offered, like keypunching, basic computer system, and COBOL and FORTRAN programming languages. At that time, only big firms could afford to install mainframe computers. This situation urged the then program head, Dr. Ofelia M. Carague, to forge linkages with companies that had mainframe installations with available computer time. From then on, students started to run their programs in various institutions, such as the National Computer Center (NCC), UP Diliman, and any other EDP-training institutions. Moreover, through the machines solicited from NCR Corporation, keypunching was done at the University grounds.After eight years, the Electronic Data Processing/Computer Data Processing Management (EDP/CDPM) unit was formed under the Faculty of Business and Cooperatives in 1977. It started to offer the Bachelor in Computer Data Processing Management (BCDPM), a four-year ladderized academic program.Through a memorandum signed by the then PUP President Nemesio E. Prudente in December 1986, the EPD/CDPM unit was elevated to the status of a full-fledged college and was called the College of Computer Management and Information Technology (CCMIT), with Dr. Carague as its first dean.The Bachelor in Information Technology (BIT) degree was then offered the following school year in 1987. The said major was mathematics-oriented while BCDPM was business-oriented. Likewise, degree holders from noncomputer programs were given the opportunity to acquire computer knowledge through the one-year Post-Baccalaureate Diploma in Computer Technology. The names BCDPM and BIT were retained for several years, and course syllabi were frequently evaluated and updated to meet the growing needs of the industry.In 1996, the battery test, which scrutinizes the student's ability in programming prior to second year level promotion, was defunct since the programs were nonboard degrees. The college, however, still upheld its quality program offerings through departmental examinations conducted during midterm and final-term periods.On March 9, 1997, in accordance with the Commission on Higher Education (CHED) Memorandum Order No. 60, Series of 1996, which pertains to restructured guidelines and standards for IT Education, the college suggested major changes for its two degree programs. The former BIT was changed to Bachelor of Science in Computer Science (BSCS) while BCDPM was renamed Bachelor of Science in Information Technology (BSIT). These propositions were applied in the school year 1997-1998, with the approval of the academic council.The college's impressive competency in teaching IT-oriented courses got the nod of approval of the Accrediting Agency for Chartered Colleges and Universities in the Philippines (AACCUP), which made it possible for CCMIT to attain its Level 1 Accredited Status in 2000. The same excellence was seen by the CHED's Center for Development and Excellence in Information Technology (CODE-IT) that gave a special recognition to the college. In 2003, AACCUP awarded the Level 2 Accredited Status of CCMIT; in November 2007, Level 2 Accredited Status (Resurvey) was given to the college. In June 2008, the college implemented the hands-on final departmental examinations on all programming languages, such as C, Java, COBOL, and C#.With a plan to re-organize and look into the effective use of campus facilities and streamline communication route, a room utilization project was commanded by Dr. Dante G. Guevarra in 2009. The result of which saw the transfer of CCMIT computer laboratories from its original location in the 3rd floor South Wing of the Main Student Building to its present location at the 5th floor South Wing.March 2012 saw the installation of a new university president in the person of Dr. Emanuel C. De Guzman and adhering with the president's vision of turning PUP into an epistemic community, the Board of Regents approved changes in the organizational structure which include realigning of units and programs, renaming of offices and colleges to fit into new, merged functions, and creating additional departments or centers. CCMIT is now aptly called the College of Computer and Information Sciences (CCIS). The rationale is that the importance of IT is no longer in the management of structures but more so on the relevance and importance of available information and being able to manage and utilize it (information).After four decades of changes, the College of Computer and Information Sciences continues its journey in molding globally competent and skillfully trained future IT professionals.</p>
					</a>
					<a href="student/programs.php" class="search-box">
						<p class="page-name">Programs</p>
						<div class="page-loc">
							<span>Programs</span>
						</div>
						<p class="page-sneak-peek">The trends in computing and the field of information and communications technology are rapidly evolving. The age of information and knowledge engineering is adherent. The importance of IT is no longer in the management of the structure (infra- and human capital) but more so on the relevance and importance of the available information. We no longer manage computers, we manage information. Thus a need to realign the name of the college to reflect the importance of computers and information in the advent of knowledge engineering in today's information age. </p>
					</a>
					<a href="faculty.php" class="search-box">
						<p class="page-name">Faculty</p>
						<div class="page-loc">
							<span>Faculty</span>
						</div>
					</a>
				</div><?php 
					} else {
				?><div id="no-post">
					<i class="fas fa-search fa-8x"></i>
					<h3>Hmm...we're not getting any results. Please try another search.</h3>
					<ul class="check-list">
						<li>Make sure that all words are spelled correctly.</li>
						<li>Try different keywords.</li>
						<li>Try more general keywords.</li>
					</ul>
				</div><?php
					}
			?></div>
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
    </div>
	</body>
</html>