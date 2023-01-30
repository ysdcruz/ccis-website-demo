-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 10, 2022 at 04:18 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ccis`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `cat_ID` int(11) NOT NULL,
  `cat_name` varchar(25) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cat_ID`, `cat_name`) VALUES
(1, 'General Forum'),
(2, 'Academic Concerns'),
(3, 'Student Community Forum'),
(4, 'Student Organization');

-- --------------------------------------------------------

--
-- Table structure for table `cms`
--

CREATE TABLE `cms` (
  `cms_ID` int(11) NOT NULL,
  `cms_purpose` int(11) NOT NULL,
  `cms_desc` varchar(50) CHARACTER SET utf8mb4 NOT NULL,
  `cms_content` longtext CHARACTER SET utf8mb4 DEFAULT NULL,
  `cms_info` varchar(25) CHARACTER SET utf8mb4 DEFAULT NULL,
  `cms_align` varchar(25) CHARACTER SET utf8mb4 DEFAULT NULL,
  `cms_link` text CHARACTER SET utf8mb4 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `cms`
--

INSERT INTO `cms` (`cms_ID`, `cms_purpose`, `cms_desc`, `cms_content`, `cms_info`, `cms_align`, `cms_link`) VALUES
(1, 1, 'name', 'College of Computer and Information Sciences', NULL, NULL, NULL),
(2, 1, 'initialism', 'CCIS', NULL, NULL, NULL),
(3, 1, 'logo', 'images/content/general/logo.png', NULL, NULL, NULL),
(4, 1, 'logo icon', 'images/content/general/icon.ico', NULL, NULL, ''),
(5, 1, 'univ', 'images/content/general/univ.png', NULL, NULL, NULL),
(6, 1, 'cover', 'images/content/general/cover.jpeg', NULL, NULL, NULL),
(9, 3, 'cover', 'images/content/home/cover.jpeg', NULL, NULL, NULL),
(10, 3, 'tagline', 'Your Dreams.<br>Our Mission.', NULL, '   caption-left', NULL),
(11, 3, 'overview', 'Why CCIS?<br>', NULL, NULL, NULL),
(12, 3, 'overview content', 'The College of Computer and Information Sciences with its two departments, the Department of Computer Science and the Department of Information Technology, provides quality IT education relevant to the changing needs of the fast-paced industry. The college commits to produce passionate, intellectual, and ingenious graduates and entrepreneurs that serve the society.<br><br>With four decades of history, the College of Computer and Information Sciences continues its journey and reputation in molding globally competent and skillfully trained future professionals.', NULL, NULL, NULL),
(13, 3, 'banner', 'images/content/home/preview.jpeg', 'green-trans-ll-ur', NULL, NULL),
(14, 3, 'banner med', 'Four decades of providing', NULL, 'caption-left', NULL),
(15, 3, 'banner large', 'Quality IT Education', NULL, 'caption-left', NULL),
(16, 3, 'banner small', 'relevant to the&nbsp;changing needs of the Society', NULL, 'caption-left', NULL),
(17, 3, 'banner button', 'LEARN MORE', NULL, 'caption-right', 'about/ccis-history.php'),
(18, 4, 'overview', 'Who are We', NULL, NULL, NULL),
(19, 4, 'overview content', 'The College of Computer and Information Sciences is a college founded December 1986 in the Polytechnic University of the Philippines - A. Mabini Campus. With the initiation of its first dean, Dr. Ofelia M. Carague, the college continues training and developing the skills of inspiring students under it\\\'s two bachelor\\\'s degrees and a master degree.<br><br>Previously named as the College of Computer Management and Information Technology, the CCIS embodies the fundamental values of education while embracing the importance of computers and information in the advent of knowledge engineering in today\\\'s information age.', NULL, NULL, NULL),
(20, 4, 'banner', 'images/content/about/preview.jpeg', 'black-trans-ll-ur', NULL, NULL),
(21, 4, 'banner med', 'The Beginning of<br>', NULL, 'caption-left', NULL),
(22, 4, 'banner large', 'The College of Computer <br>and Information Science<br>', NULL, 'caption-left', NULL),
(23, 4, 'banner small', NULL, NULL, 'caption-left', NULL),
(24, 4, 'banner button', 'DISCOVER', NULL, 'caption-left', 'about/ccis-history.php'),
(25, 4, 'preview image 1', 'images/content/about/preview-1.jpeg', NULL, NULL, NULL),
(26, 4, 'preview 1', 'Understand the college\\\'s sense of purpose and objectives', NULL, NULL, 'about/mission-goals.php'),
(27, 4, 'preview image 2', 'images/content/about/preview-2.jpeg', NULL, NULL, NULL),
(28, 4, 'preview 2', 'Getting in touch is easy!', NULL, NULL, 'about/contact-us.php'),
(29, 5, 'content', '\\n							\\n							\\n							\\n							\\n							<div class=\\\"content-image-container\\\"></div><p>The College of Computer and Information Sciences (CCIS) began its drive way back when the Polytechnic University of the Philippines (PUP) was still known as the Philippine College of Commerce (PCC) in 1969. It had formerly belonged to the Faculty of Accountancy in the era when mainframe computers were generally used to process accounting transactions. Primarily, short-term Electronic Data Processing (EDP) courses were offered, like keypunching, basic computer system, and COBOL and FORTRAN programming languages. At that time, only big firms could afford to install mainframe computers. This situation urged the then program head, Dr. Ofelia M. Carague, to forge linkages with companies that had mainframe installations with available computer time. From then on, students started to run their programs in various institutions, such as the National Computer Center (NCC), UP Diliman, and any other EDP-training institutions. Moreover, through the machines solicited from NCR Corporation, keypunching was done at the University grounds.<br><br>After eight years, the Electronic Data Processing/Computer Data Processing Management (EDP/CDPM) unit was formed under the Faculty of Business and Cooperatives in 1977. It started to offer the Bachelor in Computer Data Processing Management (BCDPM), a four-year ladderized academic program.<br><br>Through a memorandum signed by the then PUP President Nemesio E. Prudente in December 1986, the EPD/CDPM unit was elevated to the status of a full-fledged college and was called the College of Computer Management and Information Technology (CCMIT), with Dr. Carague as its first dean.</p><div class=\\\"content-image-container\\\"></div><p>The Bachelor in Information Technology (BIT) degree was then offered the following school year in 1987. The said major was mathematics-oriented while BCDPM was business-oriented. Likewise, degree holders from noncomputer programs were given the opportunity to acquire computer knowledge through the one-year Post-Baccalaureate Diploma in Computer Technology. The names BCDPM and BIT were retained for several years, and course syllabi were frequently evaluated and updated to meet the growing needs of the industry.<br><br>In 1996, the battery test, which scrutinizes the student\\\'s ability in programming prior to second year level promotion, was defunct since the programs were nonboard degrees. The college, however, still upheld its quality program offerings through departmental examinations conducted during midterm and final-term periods.<br><br>On March 9, 1997, in accordance with the Commission on Higher Education (CHED) Memorandum Order No. 60, Series of 1996, which pertains to restructured guidelines and standards for IT Education, the college suggested major changes for its two degree programs. The former BIT was changed to Bachelor of Science in Computer Science (BSCS) while BCDPM was renamed Bachelor of Science in Information Technology (BSIT). These propositions were applied in the school year 1997-1998, with the approval of the academic council.<br><br>The college\\\'s impressive competency in teaching IT-oriented courses got the nod of approval of the Accrediting Agency for Chartered Colleges and Universities in the Philippines (AACCUP), which made it possible for CCMIT to attain its Level 1 Accredited Status in 2000. The same excellence was seen by the CHED\\\'s Center for Development and Excellence in Information Technology (CODE-IT) that gave a special recognition to the college. In 2003, AACCUP awarded the Level 2 Accredited Status of CCMIT; in November 2007, Level 2 Accredited Status (Resurvey) was given to the college. In June 2008, the college implemented the hands-on final departmental examinations on all programming languages, such as C, Java, COBOL, and C#.<br><br>With a plan to re-organize and look into the effective use of campus facilities and streamline communication route, a room utilization project was commanded by Dr. Dante G. Guevarra in 2009. The result of which saw the transfer of CCMIT computer laboratories from its original location in the 3rd floor South Wing of the Main Student Building to its present location at the 5th floor South Wing.<br><br>March 2012 saw the installation of a new university president in the person of Dr. Emanuel C. De Guzman and adhering with the president\\\'s vision of turning PUP into an epistemic community, the Board of Regents approved changes in the organizational structure which include realigning of units and programs, renaming of offices and colleges to fit into new, merged functions, and creating additional departments or centers. CCMIT is now aptly called the College of Computer and Information Sciences (CCIS). The rationale is that the importance of IT is no longer in the management of structures but more so on the relevance and importance of available information and being able to manage and utilize it (information).<br><br>After four decades of changes, the College of Computer and Information Sciences continues its journey in molding globally competent and skillfully trained future IT professionals.</p>							\\n                        							\\n                        							\\n                        							\\n                        							\\n                        							\\n                        							\\n                        							\\n                        							\\n                        							\\n                        							\\n                        							\\n                        							\\n                        							\\n                        							\\n                        ', NULL, NULL, NULL),
(30, 6, 'mission', '<p>Consistent with the mission of the Polytechnic University of the Philippines, the College of Computer and Information Sciences commits to the achievement of the following goals:</p><ul class=\"check-list overview-check-list\"><li>Provide quality IT education relevant and responsive to the changing needs of the industry and society;</li><li>Develop innovative programs focusing on ubiquitous computing environment as an alternative to costly and limited resources offered by traditional education;</li><li>Produce globally competitive graduates and entrepreneurs who have passion, intellect, and ingenuity to serve the society;</li><li>Embed a culture of research by applying learned theories, creating innovation, enhancing product features, and venturing on its viability for commercialization;</li><li>Strengthen linkages with industry and other research and development institutions in order to upgrade and update the knowledge and skills of faculty, administrative staff and students;</li><li>Undertake outreach and extension programs while utilizing the expertise and competence of existing human resources for the improvement of the community;</li><li>Build a community of life-long learners; and</li><li>Inculcate among administrators, faculty members, administrative staff, and students the highest standard of personal integrity, behaviour, ethical and professional conduct.</li></ul>																																		', NULL, NULL, NULL),
(31, 7, 'address', '2/F North Wing (N-206) Main Student Building, PUP A. Mabini Campus, Anonas St., Sta. Mesa, Manila, Philippines 1016', NULL, NULL, NULL),
(32, 7, 'email', 'ccis@pup.edu.ph', NULL, NULL, NULL),
(33, 7, 'facebook', 'College of Computer and Information Sciences', NULL, NULL, 'https://www.facebook.com/PUPCCISOfficial'),
(34, 7, 'twitter', NULL, NULL, NULL, NULL),
(35, 7, 'direct 1', 'Dean', NULL, NULL, '(+63 2) 716-4032'),
(36, 7, 'direct 2', 'Server Room', NULL, NULL, '(+63 2) 713-0345'),
(37, 7, 'trunk', '(+63 2) 5335-1PUP (5335-1787)<br>(+63 2) 5335-1777', NULL, NULL, NULL),
(38, 7, 'local 1', 'Dean', NULL, NULL, '264'),
(39, 7, 'local 2', 'Chairpersons', NULL, NULL, '272'),
(40, 7, 'local 3', 'Faculty Room', NULL, NULL, '271'),
(41, 8, 'overview', 'Why CCIS?<br>', NULL, NULL, NULL),
(42, 8, 'overview content', 'The College of Computer and Information Sciences with its two departments, the Department of Computer Science and the Department of Information Technology, provides quality IT education relevant to the changing needs of the fast-paced industry. The college commits to produce passionate, intellectual, and ingenious graduates and entrepreneurs that serve the society.<br><br>With four decades of history, the College of Computer and Information Sciences continues its journey and reputation in molding globally competent and skillfully trained future professionals.', NULL, NULL, NULL),
(43, 8, 'banner', 'images/content/student/preview.jpeg', 'black-trans-ll-ur', NULL, NULL),
(44, 8, 'banner med', 'PROGRAMS IN', NULL, 'caption-right', NULL),
(45, 8, 'banner large', 'COMPUTER SCIENCE AND<br>INFORMATION TECHNOLOGY', NULL, 'caption-right', NULL),
(46, 8, 'banner small', NULL, NULL, 'caption-right', NULL),
(47, 8, 'banner button', 'DISCOVER', NULL, 'caption-right', 'student/programs.php'),
(48, 8, 'preview image 1', 'images/content/student/preview-1.jpeg', NULL, NULL, NULL),
(49, 8, 'preview 1', 'Seven student organizations to choose from', NULL, NULL, 'student/organizations.php'),
(50, 8, 'preview image 2', 'images/content/student/preview-2.jpeg', NULL, NULL, NULL),
(51, 8, 'preview 2', 'Understand the policies and procedures for students', NULL, NULL, 'student/handbook.php'),
(52, 8, 'preview image 3', 'images/content/student/preview-3.jpeg', NULL, NULL, NULL),
(53, 8, 'preview 3', 'View all downloadable forms', NULL, NULL, 'student/forms.php'),
(54, 9, 'overview content', 'The trends in computing and the field of information and communications technology are rapidly evolving. The age of information and knowledge engineering is adherent. The importance of IT is no longer in the management of the structure (infra- and human capital) but more so on the relevance and importance of the available information. We no longer manage computers, we manage information. Thus a need to realign the name of the college to reflect the importance of computers and information in the advent of knowledge engineering in today\'s information age.', NULL, NULL, NULL),
(55, 9, 'program 1', 'Bachelor of Science in Computer Science', NULL, NULL, NULL),
(56, 9, 'program 1 desc', 'The Bachelor of Science in Computer Science (BSCS) program is a four-year degree program which focuses on the study of concepts and theories, algorithmic foundations, implementation and application of information and computing solutions.<br><br>The program prepares students to become IT professionals and researchers and to be proficient in designing and developing computing solutions.<br><br>Thesis is a requirement for the BSCS program. Contents must be focused on the theories and concepts of computing and it should be in the form of scientific works that may be presented in public.', NULL, NULL, NULL),
(57, 9, 'program 1 mission', 'To produce computer science graduates who, trained in the design, implementation, and analysis of computational systems and skilled in technical communication, will contribute towards the advancement of computing science and technology', NULL, NULL, NULL),
(58, 9, 'program 1 obj intro', 'The Department of Computer Science aims:', NULL, NULL, NULL),
(59, 9, 'program 1 obj', '<li>To provide students with an understanding and appreciation of the societal consequences of technology, including computers, and of the ethical issues that may arise with new technologies;</li><li>To prepare students who will have the theoretical, practical, and professional knowledge to be immediately productive upon entering the workforce or advanced study;</li><li>To demonstrate awareness of emerging technologies and the ability to evaluate and utilize currently available software development tools;</li><li>To show an ability to acquire new knowledge in the computing discipline and to engage in life-long learning;</li><li>To provide a strong grounding in the body of knowledge and theories of computer science;</li><li>To understand and apply these essential concepts, principles and practices, showing judgment in the selection, design and application of tools and techniques;</li><li>To enhance skills and embrace new technologies through life-long professional development;</li><li>To develop conceptual knowledge and contribute to the scientific, mathematical and theoretical foundation on which technologies are built; and</li><li>To recognize and be guided by social, professional and ethical standards involved in the use of computing technologies.</li>', NULL, NULL, NULL),
(60, 9, 'program 1 adm intro', 'The admission requirements for the BSCS programs are as follows:', NULL, NULL, NULL),
(61, 9, 'program 1 reqs freshmen', '<li>Must have attained a high school general average not lower than 88%.</li><li>Must have a grade not lower than 85% for English, Math, and Science subjects taken in high school.</li><li>Passed the PUP College Entrance Test with a raw score not lower than 110 points (subject to changes depending on current University set qualification mark for PUPCET - either by percentile or raw score).</li><li>Passed the college screening.</li>', NULL, NULL, NULL),
(62, 9, 'program 1 reqs shiftee', '<li>Must have completed at least one (1) year residence in previous college with a GWA of 2.0 or higher and with no failing grade, incomplete, and/or withdrawn/dropped course.</li><li>Passed the college screening.</li><li>Filed a Shifting Form duly released, accepted and acknowledged by the releasing college, accepting college, and OUR respectively.</li><li>Acceptance of application for shifting to the program is subject to the availability of slots.</li>', NULL, NULL, NULL),
(63, 9, 'program 1 reqs transferee', '<li>Must have completed at least one (1) year residence in previous college/university with no failing grade, incomplete, and/or withdrawn/dropped course.</li><li>Passed the college screening.</li><li>Acceptance of application for transferees to the program is subject to the availability of slots.</li>', NULL, NULL, NULL),
(64, 9, 'program 1 retention', 'CCIS shall implement the policies and guidelines on \"SCHOLASTIC DELINQUENCY\" found in Section 12 of the PUP Student Handbook.', NULL, NULL, NULL),
(65, 9, 'program 1 grad', '<li>A candidate for graduation shall file his application for graduation with the University Registrar\'s Office at the start of his last semester.</li><li>A student shall be recommended for graduation when he has satisfied all academic and other requirements prescribed by the University.</li><li>No student shall be allowed to graduate from the University unless he has earned therein more than fifty (50) percent of the academic units required in the curriculum.</li><li>A candidate for graduation shall have his deficiencies made up and his record cleared not later than two weeks before the end of his last semester.</li><li>No student shall be issued a diploma and a transcript of records unless he has been cleared of all accountabilities.</li>', NULL, NULL, NULL),
(66, 9, 'program 1 career', '<li>Research Assistant</li><li>Computer Operator</li><li>Technical Writer</li><li>Database Programmer/Designer</li><li>Junior Java Programmer</li><li>Junior Software Engineer</li><li>Junior Systems Analyst</li><li>Systems Developer</li><li>Applications Developer</li><li>Quality Assurance Engineer</li><li>Information Security Engineer</li><li>Researcher</li><li>Network Specialist</li><li>Computer Science Instructor</li><li>Systems Administrator</li><li>Systems Analyst</li>', NULL, NULL, NULL),
(67, 9, 'program 2', 'Bachelor of Science in Information Technology', NULL, NULL, NULL),
(68, 9, 'program 2 desc', 'The Bachelor of Science in Information Technology program is a four-year program, which focuses on the study of computer utilization and computer software to plan, install, customize, operate, manage, administer, and maintain information technology infrastructure. It likewise deals with the design and development of computer-based information systems for real-world business solutions.<br><br>The programs prepared students to become IT professionals with primary competencies in the areas of the systems analysis and design, applications development, database administration, network administration, and systems implementation and maintenance.<br><br>The program also requires a Capstone project. It should be in the form of an IT application development as a business solution for an industry need.', NULL, NULL, NULL),
(69, 9, 'program 2 mission', 'To produce IT professionals competent in the areas of system analysis and design, application development, database administration, network administration, and systems implementation and maintenance among others', NULL, NULL, NULL),
(70, 9, 'program 2 obj intro', 'The Department of Information Technology aims:', NULL, NULL, NULL),
(71, 9, 'program 2 obj', '<li>To provide students with an understanding and appreciation of the societal consequences of technology, including computers, and of the ethical issues that may arise with new technologies;</li><li>To prepare students who will have the theoretical, practical, and professional knowledge to be immediately productive upon entering the workforce or advanced study;</li><li>To demonstrate awareness of emerging technologies and the ability to evaluate and utilize currently available software development tools;</li><li>To show an ability to acquire new knowledge in the computing discipline and to engage in life-long learning;</li><li>To provide a strong grounding in the body of knowledge and theories of computer science;</li><li>To understand and apply these essential concepts, principles and practices, showing judgment in the selection, design and application of tools and techniques;</li><li>To enhance skills and embrace new technologies through life-long professional development;</li><li>To develop conceptual knowledge and contribute to the scientific, mathematical and theoretical foundation on which technologies are built; and</li><li>To recognize and be guided by social, professional and ethical standards involved in the use of computing technologies.</li>', NULL, NULL, NULL),
(72, 9, 'program 2 adm intro', 'Admission requirements for the BSIT programs are as follows:', NULL, NULL, NULL),
(73, 9, 'program 2 reqs freshmen', '><li>Must have attained a high school general average not lower than 88%.</li><li>Must have a grade not lower than 85% for English, Math, and Science subjects taken in high school.</li><li>Passed the PUP College Entrance Test with a raw score not lower than 110 points (subject to changes depending on current University set qualification mark for PUPCET - either by percentile or raw score).</li><li>Passed the college screening.</li>', NULL, NULL, NULL),
(74, 9, 'program 2 reqs shiftee', '<li>Must have completed at least one (1) year residence in previous college with a GWA of 2.0 or higher and with no failing grade, incomplete, and/or withdrawn/dropped course.</li><li>Passed the college screening.</li><li>Filed a Shifting Form duly released, accepted and acknowledged by the releasing college, accepting college, and OUR respectively.</li><li>Acceptance of application for shifting to the program is subject to the availability of slots.</li>', NULL, NULL, NULL),
(75, 9, 'program 2 reqs transferee', '<li>Must have completed at least one (1) year residence in previous college/university with no failing grade, incomplete, and/or withdrawn/dropped course.</li><li>Passed the college screening.</li><li>Acceptance of application for transferees to the program is subject to the availability of slots.</li>', NULL, NULL, NULL),
(76, 9, 'program 2 retention', 'CCIS shall implement the policies and guidelines on \"SCHOLASTIC DELINQUENCY\" found in Section 12 of the PUP Student Handbook.', NULL, NULL, NULL),
(77, 9, 'program 2 grad', '<li>A candidate for graduation shall file his application for graduation with the University Registrar\'s Office at the start of his last semester.</li><li>A student shall be recommended for graduation when he has satisfied all academic and other requirements prescribed by the University.</li><li>No student shall be allowed to graduate from the University unless he has earned therein more than fifty (50) percent of the academic units required in the curriculum.</li><li>A candidate for graduation shall have his deficiencies made up and his record cleared not later than two weeks before the end of his last semester.</li><li>No student shall be issued a diploma and a transcript of records unless he has been cleared of all accountabilities.</li>', NULL, NULL, NULL),
(78, 9, 'program 2 career', '<li>Research Assistant</li><li>Computer Operator</li><li>Technical Writer</li><li>Database Programmer/Designer</li><li>Junior Java Programmer</li><li>Junior Software Engineer</li><li>Junior Systems Analyst</li><li>Systems Developer</li><li>Applications Developer</li><li>Quality Assurance Engineer</li><li>Information Security Engineer</li><li>Researcher</li><li>Network Specialist</li><li>Computer Science Instructor</li><li>Systems Administrator</li><li>Systems Analyst</li>', NULL, NULL, NULL),
(79, 9, 'program 3', 'Master of Science in Information Technology', NULL, NULL, NULL),
(80, 9, 'program 3 desc', 'The Bachelor of Science in Information Technology program is a four-year program, which focuses on the study of computer utilization and computer software to plan, install, customize, operate, manage, administer, and maintain information technology infrastructure. It likewise deals with the design and development of computer-based information systems for real-world business solutions.<br><br>The programs prepared students to become IT professionals with primary competencies in the areas of the systems analysis and design, applications development, database administration, network administration, and systems implementation and maintenance.<br><br>The program also requires a Capstone project. It should be in the form of an IT application development as a business solution for an industry need.', NULL, NULL, NULL),
(81, 9, 'program 3 prov', 'If the student has not taken undergraduate courses in a field of specialization, he is required to take twelve (12) units of qualifying courses to be determined by the Academic Program Chairperson unless otherwise specified in the curriculum;<br><br>The student may take more than the prescribed units in any distribution in the curriculum to meet his career objective and professional needs;<br><br>Free electives may be chosen from among the courses offered which are outside the required subjects in the student’s curriculum;<br><br>If the student has completed courses substantially equivalent to the required courses, he may waive the latter by application to the Dean.', NULL, NULL, NULL),
(82, 9, 'program 3 obj intro', 'The Master of Science in Information Technology (MSIT) program has the following objectives.<br><br>After completing the MSIT program the alumni shall:', NULL, NULL, NULL),
(83, 9, 'program 3 obj', '<li>Be skillful at creating, evaluating and administering computer-based systems that are globally competitive in terms of quality and price;</li><li>Apply advanced technical knowledge and skills in evaluating existing technology and in creating new software applications;</li><li>Be able to design marketable IT products from basic research outputs;</li><li>Skillfully manage the use of information technology-based systems which address the specific needs of the organization;</li><li>Demonstrate the role of information systems for gaining competitive advantage in an expanding global marketplace and recognize opportunities for continued career growth and life-long learning as IT professionals.</li>', NULL, NULL, NULL),
(84, 10, 'handbook', 'The  PUP  Student  Handbook  is  a  compendium  of  information  on student concerns and interests.<br><br>This  work  serves  as  an  enduring  landmark  of  the  PUP  community, reflecting the external and internal substance of life in the academe.<br><br>The  Handbook  also  echoes  the  sounds  and  nuances  of  learning, including  the  code  of  conduct,  scholastic  standards,  cultural  and  religious guidelines,  and  such  other  policies  and  directives  that  lend  distinction  to PUP as a fount of knowledge and skills.<br><br>Prefaced by the PUP philosophy, vision, and 8-point agenda, the PUP Student Handbook is a veritable gateway to students\' holistic development.<br>', NULL, NULL, 'files/handbook/PUP-Student-Handbook-2019.pdf'),
(85, 11, 'file', 'Accreditation Form for Bridge Courses', '281 KB', NULL, 'files/forms/85-Accreditation-Form-for-Bridge-Courses.pdf'),
(86, 11, 'file', 'Accreditation Form for Shiftee', '203 KB', NULL, 'files/forms/86-Accreditation-Form-for-Shiftee.pdf'),
(87, 11, 'file', 'Accreditation Form for Transferee', '250 KB', NULL, 'files/forms/87-Accreditation-Form-for-Transferee.pdf'),
(88, 11, 'file', 'Application for Change of Enrollment (ACE) Form for Withdrawal of Subjects', '76 KB', NULL, 'files/forms/88-Application-for-Change-of-Enrollment-ACE-Form-for-Withdrawal-of-Subjects.pdf'),
(89, 11, 'file', 'Application for Duplicate of Lost Registration Certificate', '114 KB', NULL, 'files/forms/89-Application-for-Duplicate-of-Lost-Registration-Certificate.pdf'),
(90, 11, 'file', 'Application for Re-admission', '66 KB', NULL, 'files/forms/90-Application-for-Re-admission.pdf'),
(91, 11, 'file', 'Application for Replacement of Lost/Stolen Identification Card', '112 KB', NULL, 'files/forms/91-Application-for-Replacement-of-Lost-Stolen-Identification-Card.pdf'),
(92, 11, 'file', 'Completion Form R-1', '553.08 KB', NULL, 'files/forms/92-Completion-Form-R-1.xlsx'),
(93, 11, 'file', 'Reference Slip for Transferee/Request for Endorsement', '22 KB', NULL, 'files/forms/93-Reference-Slip-for-Transferee-Request-for-Endorsement.pdf'),
(94, 11, 'more', 'PUP Downloads for Students', NULL, NULL, 'https://www.pup.edu.ph/downloads/students/?fbclid=IwAR3IUB2pTxKU7kjnmmQevI_BhA20Ba7EcejvPPe_V7DUsONMMrb9SNInvBA'),
(95, 13, 'image', 'images/content/gallery/95.jpg', NULL, NULL, NULL),
(96, 13, 'image', 'images/content/gallery/96.png', NULL, NULL, NULL),
(97, 13, 'image', 'images/content/gallery/97.jpg', NULL, NULL, NULL),
(98, 13, 'image', 'images/content/gallery/98.jpg', NULL, NULL, NULL),
(99, 13, 'image', 'images/content/gallery/99.jpg', NULL, NULL, NULL),
(100, 13, 'image', 'images/content/gallery/100.jpg', NULL, NULL, NULL),
(101, 13, 'image', 'images/content/gallery/101.jpg', NULL, NULL, NULL),
(102, 13, 'image', 'images/content/gallery/102.jpg', NULL, NULL, NULL),
(123, 2, 'quick link', 'University Calendar', NULL, NULL, 'https://www.pup.edu.ph/about/calendar'),
(124, 2, 'quick link', 'Student Information System', NULL, NULL, 'https://sisstudents.pup.edu.ph/'),
(125, 2, 'quick link', 'CCISko', NULL, NULL, 'http://ccisko.000webhostapp.com/'),
(126, 2, 'quick link', 'CCISoc', NULL, NULL, 'http://ccisolc.tk/');

-- --------------------------------------------------------

--
-- Table structure for table `cms_history_img`
--

CREATE TABLE `cms_history_img` (
  `img_ID` int(11) NOT NULL,
  `img_path` text COLLATE latin1_general_ci NOT NULL,
  `img_credit` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `img_link` text COLLATE latin1_general_ci DEFAULT NULL,
  `img_desc` varchar(255) COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `cms_history_img`
--

INSERT INTO `cms_history_img` (`img_ID`, `img_path`, `img_credit`, `img_link`, `img_desc`) VALUES
(1, 'images/content/about/history/20220126-61f0e3ba2f2cf2.06082420.jpeg', 'Polytechnic University of the Philippines (Official)', 'https://www.facebook.com/ThePUPOfficial/', 'The PUP Pylon'),
(2, 'images/content/about/history/20220126-61f0e3ba305ac0.99539879.png', 'Polytechnic University of the Philippines (Official)', 'https://www.facebook.com/ThePUPOfficial/', 'Dr. Ofelia M. Carague, former PUP president from 1998 to 2003.');

-- --------------------------------------------------------

--
-- Table structure for table `cms_purpose`
--

CREATE TABLE `cms_purpose` (
  `purpose_ID` int(11) NOT NULL,
  `purpose_desc` varchar(50) CHARACTER SET utf8mb4 NOT NULL,
  `page_name` varchar(25) COLLATE latin1_general_ci DEFAULT NULL,
  `page_url` text COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `cms_purpose`
--

INSERT INTO `cms_purpose` (`purpose_ID`, `purpose_desc`, `page_name`, `page_url`) VALUES
(1, 'general', NULL, NULL),
(2, 'quick link', NULL, NULL),
(3, 'home', 'Home', 'index.php'),
(4, 'about overview', 'About', 'about.php'),
(5, 'about history', 'CCIS and Its History', 'about/ccis-history.php'),
(6, 'about goals', 'Mission and Goals', 'about/mission-goals.php'),
(7, 'about contact', 'Contact Us', 'about/contact-us.php'),
(8, 'student overview', 'Student', 'student.php'),
(9, 'student programs', 'Programs', 'student/programs.php'),
(10, 'student handbook', 'Student Handbook', 'student/handbook.php'),
(11, 'student forms', 'Downloadable Forms', 'student/forms.php'),
(12, 'faculty', 'Faculty', 'faculty.php'),
(13, 'gallery', 'Gallery', 'gallery.php');

-- --------------------------------------------------------

--
-- Table structure for table `drs`
--

CREATE TABLE `drs` (
  `drs_ID` int(11) NOT NULL,
  `Req_ControlNum` varchar(11) NOT NULL,
  `Req_AuthorID` varchar(20) NOT NULL,
  `Req_Date` datetime NOT NULL,
  `Req_Purpose` text NOT NULL,
  `Req_Urgency` date DEFAULT NULL,
  `Req_Status` varchar(20) NOT NULL,
  `Req_DelDate` datetime DEFAULT NULL,
  `Handler_ID` varchar(20) DEFAULT NULL,
  `Remarks` text DEFAULT NULL,
  `Process_Date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `drs`
--

INSERT INTO `drs` (`drs_ID`, `Req_ControlNum`, `Req_AuthorID`, `Req_Date`, `Req_Purpose`, `Req_Urgency`, `Req_Status`, `Req_DelDate`, `Handler_ID`, `Remarks`, `Process_Date`) VALUES
(1, '2022-0001', '2018-00046-MN-0', '2022-02-03 21:30:01', 'Scholarship', NULL, 'Accepted', NULL, '88888', NULL, '2022-02-03 21:30:09');

-- --------------------------------------------------------

--
-- Table structure for table `drs_docreqs`
--

CREATE TABLE `drs_docreqs` (
  `DocReq_ID` int(11) NOT NULL,
  `Req_ControlNum` varchar(11) NOT NULL,
  `Req_TypeID` int(11) NOT NULL,
  `Req_File_ID` int(11) DEFAULT NULL,
  `Prereq_File_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `drs_docreqs`
--

INSERT INTO `drs_docreqs` (`DocReq_ID`, `Req_ControlNum`, `Req_TypeID`, `Req_File_ID`, `Prereq_File_ID`) VALUES
(1, '2022-0001', 9, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `drs_files`
--

CREATE TABLE `drs_files` (
  `File_ID` int(11) NOT NULL,
  `File_ControlNum` varchar(11) NOT NULL,
  `File_Desc` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `drs_history`
--

CREATE TABLE `drs_history` (
  `drs_history_ID` int(11) NOT NULL,
  `drs_ctrlnum` varchar(11) NOT NULL,
  `drs_process` int(11) NOT NULL,
  `drs_date` datetime NOT NULL,
  `drs_status` varchar(20) NOT NULL,
  `drs_file_ID` int(11) DEFAULT NULL,
  `drs_Handler_ID` varchar(20) DEFAULT NULL,
  `Remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `drs_history`
--

INSERT INTO `drs_history` (`drs_history_ID`, `drs_ctrlnum`, `drs_process`, `drs_date`, `drs_status`, `drs_file_ID`, `drs_Handler_ID`, `Remarks`) VALUES
(1, '2022-0001', 0, '2022-02-01 13:51:15', 'Pending', NULL, NULL, NULL),
(2, '2022-0001', 1, '2022-02-01 13:59:48', 'Accepted', NULL, '88888', NULL),
(3, '2022-0001', 2, '2022-02-02 00:20:07', 'Completed', 1, '88888', NULL),
(4, '2022-0002', 0, '2022-02-03 17:57:09', 'Pending', NULL, NULL, NULL),
(5, '2022-0002', 1, '2022-02-03 18:08:12', 'Cancelled', NULL, NULL, NULL),
(6, '2022-0003', 0, '2022-02-03 18:20:47', 'Pending', 2, NULL, NULL),
(7, '2022-0003', 1, '2022-02-03 18:21:01', 'Resubmission', 2, '88888', 'Try'),
(8, '2022-0003', 2, '2022-02-03 19:20:01', 'Accepted', 3, '88888', 'Try'),
(9, '2022-0003', 3, '2022-02-03 19:28:35', 'Resubmission', 3, '88888', 'try again'),
(10, '2022-0001', 3, '2022-02-03 21:30:01', 'Pending', NULL, NULL, NULL),
(11, '2022-0001', 4, '2022-02-03 21:30:09', 'Accepted', NULL, '88888', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `drs_type`
--

CREATE TABLE `drs_type` (
  `type_ID` int(11) NOT NULL,
  `Doc_Type` varchar(255) NOT NULL,
  `Doc_Prereq` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `drs_type`
--

INSERT INTO `drs_type` (`type_ID`, `Doc_Type`, `Doc_Prereq`) VALUES
(1, 'Accreditation of Subjects for Bridge Courses Approval', NULL),
(2, 'Accreditation of Subjects for Shiftees Approval', NULL),
(3, 'Accreditation of Subjects for Transferee Students Approval', NULL),
(4, 'Application for Change of Enrollment (ACE) Form for Withdrawal of Subjects Approval', NULL),
(5, 'Application for Duplicate of Lost Registration Certificate Attestation', NULL),
(6, 'Application for Re-admission Evaluation', NULL),
(7, 'Application for Replacement of Lost/Stolen Identification Card Attestation', NULL),
(8, 'Certificate of Graduation', NULL),
(9, 'Certification of Enrollment (signature of the dean/chairperson)', NULL),
(10, 'Completion Form Approval', NULL),
(11, 'Informative Copy of Grades (signature of the dean/chairperson)', NULL),
(12, 'Reference Slip for Transferee/Request for Endorsement Approval', NULL),
(13, 'Validation of Identification Card', 'Identification Card'),
(14, 'Validation of Registration Card', 'Registration Card');

-- --------------------------------------------------------

--
-- Table structure for table `faculty_staff`
--

CREATE TABLE `faculty_staff` (
  `emp_ID` int(11) NOT NULL,
  `emp_img` longtext COLLATE latin1_general_ci NOT NULL,
  `emp_name` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `emp_role` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `emp_job` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `is_faculty` tinyint(1) NOT NULL DEFAULT 1,
  `is_head` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `faculty_staff`
--

INSERT INTO `faculty_staff` (`emp_ID`, `emp_img`, `emp_name`, `emp_role`, `emp_job`, `is_faculty`, `is_head`) VALUES
(1, 'images/content/faculty-staff/1.jpg', 'Benilda Eleonor V. Comendador, DIT', 'Dean', 'Associate Professor V', 0, 1),
(2, 'images/content/faculty-staff/default.jpg', 'Melvin C. Roxas, MSGITS', 'Chairperson, Department of Computer Science', 'Assistant Professor IV', 0, 0),
(3, 'images/content/faculty-staff/default.jpg', 'Marian G. Arada, MIT', 'Chairperson, Department of Information Technology', 'Assistant Professor', 0, 0),
(4, 'images/content/faculty-staff/default.jpg', 'Augusto Sandino B. Cardenas', 'Dean\'s and Chairperson\'s Office Staff', NULL, 0, 0),
(5, 'images/content/faculty-staff/5.jpeg', 'Rachel A. Nayre, MSIT<br>', NULL, NULL, 1, 0),
(6, 'images/content/faculty-staff/default.jpg', 'Fermin S. Aguila<br>', NULL, NULL, 1, 0),
(7, 'images/content/faculty-staff/default.jpg', 'Florante V. Andres<br>', NULL, NULL, 1, 0),
(8, 'images/content/faculty-staff/default.jpg', 'Elias A. Austria<br>', NULL, NULL, 1, 0),
(9, 'images/content/faculty-staff/default.jpg', 'Monina D. Barretto<br>', NULL, NULL, 1, 0),
(10, 'images/content/faculty-staff/default.jpg', 'Rosita E. Canlas<br>', NULL, NULL, 1, 0),
(11, 'images/content/faculty-staff/default.jpg', 'Norberto V. Caturay<br>', NULL, NULL, 1, 0),
(12, 'images/content/faculty-staff/default.jpg', 'Lydinar D. Dastas<br>', NULL, NULL, 1, 0),
(13, 'images/content/faculty-staff/default.jpg', 'Michael B. Dela Fuente<br>', NULL, NULL, 1, 0),
(14, 'images/content/faculty-staff/default.jpg', 'Iluminada Vivien R. Domingo<br>', NULL, NULL, 1, 0),
(15, 'images/content/faculty-staff/default.jpg', 'Juancho D. Espineli<br>', NULL, NULL, 1, 0),
(16, 'images/content/faculty-staff/default.jpg', 'Aleta C. Fabregas, DIT<br>', NULL, NULL, 1, 0),
(17, 'images/content/faculty-staff/default.jpg', 'Carlo G. Inovero<br>', NULL, NULL, 1, 0),
(18, 'images/content/faculty-staff/default.jpg', 'Antonio T. Luna<br>', NULL, NULL, 1, 0),
(19, 'images/content/faculty-staff/default.jpg', 'Segundina Y. Miclat<br>', NULL, NULL, 1, 0),
(20, 'images/content/faculty-staff/default.jpg', 'Montaigne G. Molejon<br>', NULL, NULL, 1, 0),
(21, 'images/content/faculty-staff/default.jpg', 'Teresita G. MoÃ±eza<br>', NULL, NULL, 1, 0),
(22, 'images/content/faculty-staff/default.jpg', 'Joel Munsayac<br>', NULL, NULL, 1, 0),
(23, 'images/content/faculty-staff/default.jpg', 'Alfred M. Pagalilawan<br>', NULL, NULL, 1, 0),
(24, 'images/content/faculty-staff/default.jpg', 'Maria Esperanza H. Reyes<br>', NULL, NULL, 1, 0),
(25, 'images/content/faculty-staff/default.jpg', 'Ria A. Sagum<br>', NULL, NULL, 1, 0),
(26, 'images/content/faculty-staff/default.jpg', 'Mary Jane M. Tan<br>', NULL, NULL, 1, 0),
(27, 'images/content/faculty-staff/default.jpg', 'Sherilyn B. Usero<br>', NULL, NULL, 1, 0),
(28, 'images/content/faculty-staff/default.jpg', 'Jayson James M. Mayor<br>', NULL, NULL, 1, 0),
(29, 'images/content/faculty-staff/default.jpg', 'Janelle Kyra A. Sagum<br>', NULL, NULL, 1, 0),
(30, 'images/content/faculty-staff/default.jpg', 'John Dustin D. Santos<br>', NULL, NULL, 1, 0),
(31, 'images/content/faculty-staff/default.jpg', 'Mariel Leo T. Violeta<br>', NULL, NULL, 1, 0),
(32, 'images/content/faculty-staff/default.jpg', 'Celso T. Agos Jr.<br>', NULL, NULL, 1, 0),
(33, 'images/content/faculty-staff/default.jpg', 'Maria Leonila C. Amata<br>', NULL, NULL, 1, 0),
(34, 'images/content/faculty-staff/default.jpg', 'Leoven R. Basista<br>', NULL, NULL, 1, 0),
(35, 'images/content/faculty-staff/default.jpg', 'Eugene Andrew S. Bato<br>', NULL, NULL, 1, 0),
(36, 'images/content/faculty-staff/default.jpg', 'Fernando A. Belarmino<br>', NULL, NULL, 1, 0),
(37, 'images/content/faculty-staff/default.jpg', 'Ma. Lorena D. Beltran<br>', NULL, NULL, 1, 0),
(38, 'images/content/faculty-staff/default.jpg', 'Renz Angelo V. Cadaoas<br>', NULL, NULL, 1, 0),
(39, 'images/content/faculty-staff/default.jpg', 'Arlene B. Canlas<br>', NULL, NULL, 1, 0),
(40, 'images/content/faculty-staff/default.jpg', 'Edward Lois Del Valle<br>', NULL, NULL, 1, 0),
(41, 'images/content/faculty-staff/default.jpg', 'Anne P. Enguerra<br>', NULL, NULL, 1, 0),
(42, 'images/content/faculty-staff/default.jpg', 'Arnie Fabregas<br>', NULL, NULL, 1, 0),
(43, 'images/content/faculty-staff/default.jpg', 'Dale Anthony N. Frias<br>', NULL, NULL, 1, 0),
(44, 'images/content/faculty-staff/default.jpg', 'Flordeliz C. Garcia<br>', NULL, NULL, 1, 0),
(45, 'images/content/faculty-staff/default.jpg', 'Snacho Glenn Lastimosa<br>', NULL, NULL, 1, 0),
(46, 'images/content/faculty-staff/default.jpg', 'Alexis A. Libunao<br>', NULL, NULL, 1, 0),
(47, 'images/content/faculty-staff/default.jpg', 'Angela R. Ligumbres<br>', NULL, NULL, 1, 0),
(48, 'images/content/faculty-staff/default.jpg', 'Roberto S. Lim<br>', NULL, NULL, 1, 0),
(49, 'images/content/faculty-staff/default.jpg', 'Cecilia V. Marbella<br>', NULL, NULL, 1, 0),
(50, 'images/content/faculty-staff/default.jpg', 'Norberto R. Mendoza<br>', NULL, NULL, 1, 0),
(51, 'images/content/faculty-staff/default.jpg', 'Ranil M. Montaril<br>', NULL, NULL, 1, 0),
(52, 'images/content/faculty-staff/default.jpg', 'Marilou F. Novida<br>', NULL, NULL, 1, 0),
(53, 'images/content/faculty-staff/default.jpg', 'Eliza M. Pascual<br>', NULL, NULL, 1, 0),
(54, 'images/content/faculty-staff/default.jpg', 'Angelica Payne<br>', NULL, NULL, 1, 0),
(55, 'images/content/faculty-staff/default.jpg', 'Ma. Angela M. Salaya<br>', NULL, NULL, 1, 0),
(56, 'images/content/faculty-staff/default.jpg', 'Marygin E. Sarmiento<br>', NULL, NULL, 1, 0),
(57, 'images/content/faculty-staff/default.jpg', 'Madzmir S. Taib<br>', NULL, NULL, 1, 0),
(58, 'images/content/faculty-staff/default.jpg', 'Jeanne Clementine P. Jalique', 'Dean\'s and Chairperson\'s Office Staff', NULL, 0, 0),
(59, 'images/content/faculty-staff/default.jpg', 'Jheo Marco O. Testor', 'Laboratory Office Assistant', NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `org`
--

CREATE TABLE `org` (
  `org_ID` int(11) NOT NULL,
  `org_init` varchar(20) COLLATE latin1_general_ci DEFAULT NULL,
  `org_name` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `org_img` longtext CHARACTER SET utf8mb4 NOT NULL,
  `org_desc` text CHARACTER SET utf8mb4 DEFAULT NULL,
  `org_fb` text CHARACTER SET utf8mb4 DEFAULT NULL,
  `org_fb_link` longtext COLLATE latin1_general_ci DEFAULT NULL,
  `org_twt` text CHARACTER SET utf8mb4 DEFAULT NULL,
  `org_twt_link` longtext COLLATE latin1_general_ci DEFAULT NULL,
  `org_email` text CHARACTER SET utf8mb4 DEFAULT NULL,
  `is_head` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `org`
--

INSERT INTO `org` (`org_ID`, `org_init`, `org_name`, `org_img`, `org_desc`, `org_fb`, `org_fb_link`, `org_twt`, `org_twt_link`, `org_email`, `is_head`) VALUES
(1, 'CCIS-SC', 'College of Computer and Information Sciences - Student Council', 'images/content/student/org/1.jpeg', 'The CCIS - Student Council is the highest constituted student government of CCIS. With the aim to provide genuine services to fellow students, CCIS-SC leads the fight for the rights and welfare of the studentry.', 'PUP CCIS Student Council', 'https://www.facebook.com/PUPCCISStudentCouncil/', 'CCIS Student Council', 'https://twitter.com/CCISkolar', 'pupccis.studentcouncil@gmail.com', 1),
(2, 'AsCII', 'Association of Students for Computer Intelligence Integration', 'images/content/student/org/2.png', 'AsCII is the official academic student organization of the Department of Computer Science in the Polytechnic University of the Philippines. AsCII is intended primarily to promote Computer Science as a frontier for creativity and innovation.', 'AsCII', 'https://www.facebook.com/PUPASCII/', NULL, NULL, 'pupasciiofficial@gmail.com', 0),
(3, 'IBITS', 'Institute of Bachelors in Information Technology Studies', 'images/content/student/org/3.jpeg', 'IBITS is the official academic organization of the Bachelor of Science in Information Technology (BSIT) students of PUP Sta. Mesa.', 'IBITS', 'https://www.facebook.com/iBITS.Official/', NULL, NULL, 'ccis.ibits@gmail.com', 0),
(4, NULL, 'The Compiler', 'images/content/student/org/4.png', 'The Compiler, Department of Computer Science\'s Official Student Publication, provides the best service for responsible journalism as they intensify the contribution of young individuals to public service not only in the academe, but also in the society.', 'The Compiler Online', 'https://www.facebook.com/TheCompilerOnline/', NULL, NULL, 'thecompilerdcs@gmail.com', 0),
(5, NULL, 'InfoBITS', 'images/content/student/org/5.jpeg', 'InfoBITS is the official student publication of the College of Computer and Information Sciences (CCIS) Department of Information Technology at Polytechnic University of the Philippines, Manila (PUP).', 'PUP InfoBITS', 'https://www.facebook.com/infobits.pup', NULL, NULL, 'infobitspup@gmail.com', 0),
(6, 'TPG', 'The Programmers\' Guild', 'images/content/student/org/6.jpeg', 'The PUP Programmers\' Guild is a university wide organization composed of different programmers and developers, conducting different events and activities related to the fields of programming and development.', 'PUP The Programmers\' Guild', 'https://www.facebook.com/PUPTPG/', NULL, NULL, 'puptpg@gmail.com', 0),
(7, 'OOC', 'Out of Codes', 'images/content/student/org/7.jpeg', 'Out of Codes is the PUP Manila\'s College of Computer and Information Sciences official dance crew.', 'Out of Codes', 'https://www.facebook.com/oocdancecrew/', NULL, NULL, 'ccis.ooc@gmail.com', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pass_reset`
--

CREATE TABLE `pass_reset` (
  `reset_ID` int(11) NOT NULL,
  `reset_email` text COLLATE latin1_general_ci NOT NULL,
  `reset_selector` text COLLATE latin1_general_ci NOT NULL,
  `reset_token` longtext COLLATE latin1_general_ci NOT NULL,
  `reset_exp` text COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `pass_reset`
--

INSERT INTO `pass_reset` (`reset_ID`, `reset_email`, `reset_selector`, `reset_token`, `reset_exp`) VALUES
(10, 'ysdelacruz@iskolarngbayan.pup.edu.ph', '7aea47e0ff9cd49c', '$2y$10$0WvJrFT4bTLjTNnfwAnlMOyHgkhdQPkcRQXHUgu5V5unxly.rgOsq', '1643143316'),
(12, 'olafkjelberg123@gmail.com', '31b98965d40759f6', '$2y$10$xJRSOxeSITiX2pgcpX1uTOacDOL7TdB/MSbJsdO1v.wQdgHz6HzcG', '1643263811');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `post_ID` int(11) NOT NULL,
  `post_writer_ID` int(11) NOT NULL,
  `post_create` datetime NOT NULL,
  `post_update` datetime DEFAULT NULL,
  `post_title` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `post_content` text CHARACTER SET utf8mb4 NOT NULL,
  `post_type` varchar(1) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_ID`, `post_writer_ID`, `post_create`, `post_update`, `post_title`, `post_content`, `post_type`) VALUES
(1, 1, '2022-01-19 14:42:59', '2022-01-19 14:42:59', 'Welcome to CCIS Website!', '<p>This website was created by <strong>Ysabel Dela Cruz</strong>, <strong>Ron-Arvil Villar</strong>, and <strong>Gerald Rongcales</strong> for their capstone entitled <strong>\\\"College Website with Discussion Forum and Document Request System\\\"</strong> as part of requirements for the courses Capstone Project 1 and 2. With the objective of generating <span style=\\\"color: black;\\\">a centralized website that caters all the concerns, inquiries, news, and announcements in CCIS community, the developers built this system from April 2020 to January 2021.</span></p><p><br></p><p>This project aims to motivate collective and cooperative work from all constituents of the college. While the administration is given a greater responsibility in managing the whole system, student organizations could contribute by writing content such as news articles and announcements. Students, alumni, and the faculty will also be encouraged to do their part by sharing their thoughts and answers in the discussion forum.</p>', 'A'),
(2, 1, '2022-01-26 07:51:36', '2022-01-26 07:51:36', 'Suspension of Synchronous Class Activities', '<p><span>ADVISORY 6 S 2022</span></p><p><br></p><p><span>In consideration of the still increasing number of students and faculty members experiencing COVID-19 and flu-like symptoms, PUP is extending the suspension of synchronous class activities in all levels to be implemented University-wide from January 22 to January 31, 2022.</span></p><p><br></p><p><span>Members of the faculty are instructed to proceed with assigning asynchronous activities that adhere to the memorandum on the Easing of Academic Requirements and Grading System Due to Pandemic Limitations.</span></p><p><br></p><p><span>For strict compliance.</span></p><p><br></p><p><img src=\\\"path_to_post_img\\\"></p>', 'A'),
(3, 1, '2022-01-26 08:04:21', '2022-01-26 08:04:21', 'CCIS Certified Level IV', '<p><span>Programs of College of Computer and Information Sciences, namely Bachelor of Science in Computer Science and Bachelor of Science in Information Technology, were conferred with Level IV Accredited status by the Accrediting Agency of Chartered Colleges and Universities in the Philippines (AACCUP).</span></p>', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `post_backup`
--

CREATE TABLE `post_backup` (
  `post_ID` int(11) NOT NULL,
  `post_writer_ID` int(11) NOT NULL,
  `post_create` datetime NOT NULL,
  `post_update` datetime DEFAULT NULL,
  `post_title` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `post_content` text CHARACTER SET utf8mb4 NOT NULL,
  `post_type` varchar(1) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post_cover`
--

CREATE TABLE `post_cover` (
  `post_ID` int(11) NOT NULL,
  `cover_img` text COLLATE latin1_general_ci NOT NULL,
  `cover_credits` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `cover_link` text COLLATE latin1_general_ci DEFAULT NULL,
  `cover_desc` varchar(255) COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `post_cover`
--

INSERT INTO `post_cover` (`post_ID`, `cover_img`, `cover_credits`, `cover_link`, `cover_desc`) VALUES
(1, 'images/content/posts/announcements/cover/1/cover.png', NULL, NULL, NULL),
(2, 'images/content/posts/announcements/default.png', NULL, NULL, NULL),
(3, 'images/content/posts/news/default.png', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `post_cover_backup`
--

CREATE TABLE `post_cover_backup` (
  `post_ID` int(11) NOT NULL,
  `cover_img` text COLLATE latin1_general_ci NOT NULL,
  `cover_credits` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `cover_link` text COLLATE latin1_general_ci DEFAULT NULL,
  `cover_desc` varchar(255) COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post_img`
--

CREATE TABLE `post_img` (
  `img_ID` int(11) NOT NULL,
  `post_ID` int(11) NOT NULL,
  `img_path` text COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `post_img`
--

INSERT INTO `post_img` (`img_ID`, `post_ID`, `img_path`) VALUES
(1, 2, 'images/content/posts/announcements/2/20220126-61f0fd88e06f04.20709724.png');

-- --------------------------------------------------------

--
-- Table structure for table `post_img_backup`
--

CREATE TABLE `post_img_backup` (
  `img_ID` int(11) NOT NULL,
  `post_ID` int(11) NOT NULL,
  `img_path` text COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reactivate_req`
--

CREATE TABLE `reactivate_req` (
  `req_ID` int(11) NOT NULL,
  `user_ID` int(11) NOT NULL,
  `req_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `Reg_ID` int(11) NOT NULL,
  `Personal_ID` varchar(20) NOT NULL,
  `Type` int(11) NOT NULL,
  `FName` varchar(50) NOT NULL,
  `LName` varchar(50) NOT NULL,
  `Email` text NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`Reg_ID`, `Personal_ID`, `Type`, `FName`, `LName`, `Email`, `Password`) VALUES
(6, '2018-05062-MN-0', 3, 'Juan Manuel', 'Rodriguez', 'juanmanuelmrodriguez@iskolarngbayan.pup.edu.ph', '$2y$10$eriXNGS4tDYkIn2DNDihFusnVnZ3kh5K5Ss2w04RWsD5AG39tCBTK'),
(7, '2018-05056-MN-0', 3, 'Leovyle', 'Sarili', 'llsarili@iskolarngbayan.pup.edu.ph', '$2y$10$C5srLKkG21acOoHSFK7OwOaIXco6o/I.nSBK/1o9r73T1tMnXgUVK'),
(8, '2018-05631-MN-0', 3, 'Louther', 'Olayres', 'ldolayres@iskolarngbayan.pup.edu.ph', '$2y$10$Wu5jjhlQNVc3OIZz405smeOqFZRHze3KK1kYz9zEPLi9DVlRZnDwG'),
(9, '2018-04235-MN-0', 3, 'Allen', 'Natividad', 'avnatividad@iskolarngbayan.pup.edu.ph', '$2y$10$QC.e87BzW3Yij8Phr2P/GOo2.HAva7O6RH/R2DtgViaJzA7vj/nB6'),
(10, '2018-10498-MN-0', 3, 'Shaira Khazel', 'Usero', 'skbusero@iskolarngbayan.pup.edu.ph', '$2y$10$ujnah0p2twSk57r68b3GoOSCTYmNwVaitkhwEt2s8u7V8oyuX9oIG');

-- --------------------------------------------------------

--
-- Table structure for table `reply`
--

CREATE TABLE `reply` (
  `reply_ID` int(11) NOT NULL,
  `thread_ID` int(11) NOT NULL,
  `reply_author_ID` int(11) NOT NULL,
  `reply_create` datetime NOT NULL,
  `reply_upvotes` int(11) NOT NULL,
  `is_answer` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reply_backup`
--

CREATE TABLE `reply_backup` (
  `reply_ID` int(11) NOT NULL,
  `thread_ID` int(11) NOT NULL,
  `action_user_ID` int(11) NOT NULL,
  `reply_author_ID` int(11) NOT NULL,
  `reply_create` datetime NOT NULL,
  `reply_update` datetime DEFAULT NULL,
  `reply_content` text CHARACTER SET utf8mb4 NOT NULL,
  `reply_upvotes` int(11) NOT NULL,
  `is_answer` tinyint(1) NOT NULL DEFAULT 0,
  `delete_reason` text CHARACTER SET utf8mb4 DEFAULT NULL,
  `delete_desc` text COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `reply_backup`
--

INSERT INTO `reply_backup` (`reply_ID`, `thread_ID`, `action_user_ID`, `reply_author_ID`, `reply_create`, `reply_update`, `reply_content`, `reply_upvotes`, `is_answer`, `delete_reason`, `delete_desc`) VALUES
(1, 3, 5, 5, '2022-02-03 09:36:04', '2022-02-03 09:36:04', '<p>try</p>', 0, 0, 'reply deleted', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reply_history`
--

CREATE TABLE `reply_history` (
  `reply_ID` int(11) NOT NULL,
  `reply_ver` int(11) NOT NULL,
  `event_date` datetime NOT NULL,
  `reply_content` text COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reply_img`
--

CREATE TABLE `reply_img` (
  `img_ID` int(11) NOT NULL,
  `reply_ID` int(11) NOT NULL,
  `reply_ver` int(11) NOT NULL,
  `img_path` text COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reply_img_backup`
--

CREATE TABLE `reply_img_backup` (
  `img_ID` int(11) NOT NULL,
  `reply_ID` int(11) NOT NULL,
  `img_path` text COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reply_votes`
--

CREATE TABLE `reply_votes` (
  `reply_ID` int(11) NOT NULL,
  `user_ID` int(11) NOT NULL,
  `user_vote` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `Report_ID` int(11) NOT NULL,
  `Report_Date` datetime NOT NULL,
  `Report_By` int(11) NOT NULL,
  `Thread_ID` int(11) NOT NULL,
  `Reply_ID` int(11) DEFAULT NULL,
  `Post_Ver` int(11) NOT NULL,
  `Report_Reason` varchar(100) NOT NULL,
  `Report_Desc` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`Report_ID`, `Report_Date`, `Report_By`, `Thread_ID`, `Reply_ID`, `Post_Ver`, `Report_Reason`, `Report_Desc`) VALUES
(1, '2022-01-28 09:52:16', 4, 4, NULL, 1, 'Spam', 'Spam post');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `Role_ID` int(11) NOT NULL,
  `Role_Desc` varchar(20) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`Role_ID`, `Role_Desc`) VALUES
(1, 'Dean'),
(2, 'Chairperson'),
(3, 'Faculty'),
(4, 'Moderator'),
(5, 'Organization'),
(6, 'Developer');

-- --------------------------------------------------------

--
-- Table structure for table `student_background`
--

CREATE TABLE `student_background` (
  `Personal_ID` varchar(20) CHARACTER SET utf8mb4 NOT NULL,
  `Address` text CHARACTER SET utf8mb4 NOT NULL,
  `is_address_show` tinyint(1) NOT NULL DEFAULT 0,
  `Admit_Status` varchar(15) COLLATE latin1_general_ci NOT NULL,
  `Admit_Yr` year(4) NOT NULL,
  `Admit_As` varchar(10) CHARACTER SET utf8mb4 NOT NULL,
  `Grad_Yr` year(4) DEFAULT NULL,
  `Course` varchar(5) CHARACTER SET utf8mb4 NOT NULL,
  `College` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `College_Yr` year(4) DEFAULT NULL,
  `College_Course` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `HS` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `HS_Yr` year(4) NOT NULL,
  `Elem` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `Elem_Yr` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `student_background`
--

INSERT INTO `student_background` (`Personal_ID`, `Address`, `is_address_show`, `Admit_Status`, `Admit_Yr`, `Admit_As`, `Grad_Yr`, `Course`, `College`, `College_Yr`, `College_Course`, `HS`, `HS_Yr`, `Elem`, `Elem_Yr`) VALUES
('2018-00046-MN-0', 'Blk. 3 Lot 44, Ph. 3d, No. 4 Tambakol St., Bgy. 28, Caloocan City, Metro Manila', 0, 'undergraduate', 2018, 'freshman', NULL, 'bsit', NULL, NULL, NULL, 'Caloocan City Science High School', 2018, 'La Consolacion College - Caloocan', 2012),
('2018-03991-MN-0', 'Magtanggol Caloocan City', 0, '', 2018, '', NULL, '', NULL, NULL, NULL, '', 0000, '', 0000),
('2018-05125-MN-0', 'B-5 L-2 Miara Heights, Bundagul, Mabalacat City, Pampanga', 0, 'undergraduate', 2018, 'freshman', NULL, 'bsit', NULL, NULL, NULL, 'Technological Institute of the Philippines - SHS\n\n', 2018, 'Malaya Elementary School', 2012);

-- --------------------------------------------------------

--
-- Table structure for table `student_org`
--

CREATE TABLE `student_org` (
  `Personal_ID` varchar(20) CHARACTER SET utf8mb4 NOT NULL,
  `stud_org` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `student_org`
--

INSERT INTO `student_org` (`Personal_ID`, `stud_org`) VALUES
('2022-00001-MN-0', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `tag_ID` int(11) NOT NULL,
  `tag_Name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`tag_ID`, `tag_Name`) VALUES
(4, 'Admission'),
(2, 'Advice'),
(3, 'Enrollment'),
(6, 'Feedback'),
(1, 'Programming'),
(7, 'Test post'),
(5, 'Web Programming');

-- --------------------------------------------------------

--
-- Table structure for table `thread`
--

CREATE TABLE `thread` (
  `thread_ID` int(11) NOT NULL,
  `thread_author_ID` int(11) NOT NULL,
  `cat_ID` int(11) NOT NULL,
  `thread_create` datetime NOT NULL,
  `thread_type` varchar(1) CHARACTER SET utf8mb4 NOT NULL,
  `thread_to` varchar(1) CHARACTER SET utf8mb4 NOT NULL,
  `thread_open` tinyint(1) NOT NULL,
  `thread_upvotes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `thread`
--

INSERT INTO `thread` (`thread_ID`, `thread_author_ID`, `cat_ID`, `thread_create`, `thread_type`, `thread_to`, `thread_open`, `thread_upvotes`) VALUES
(1, 1, 1, '2022-01-17 17:19:44', 'D', 'E', 0, 1),
(2, 8, 1, '2022-01-27 05:25:26', 'D', 'E', 1, 0),
(3, 1, 1, '2022-01-28 09:37:42', 'D', 'A', 1, 0),
(4, 1, 1, '2022-01-28 09:50:36', 'D', 'E', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `thread_backup`
--

CREATE TABLE `thread_backup` (
  `thread_ID` int(11) NOT NULL,
  `action_user_ID` int(11) NOT NULL,
  `cat_ID` int(11) NOT NULL,
  `thread_author_ID` int(11) DEFAULT NULL,
  `thread_create` datetime NOT NULL,
  `thread_update` datetime DEFAULT NULL,
  `thread_title` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `thread_content` text CHARACTER SET utf8mb4 NOT NULL,
  `thread_type` varchar(1) CHARACTER SET utf8mb4 NOT NULL,
  `thread_to` varchar(1) CHARACTER SET utf8mb4 NOT NULL,
  `thread_open` tinyint(1) NOT NULL,
  `thread_upvotes` int(11) NOT NULL,
  `delete_reason` text CHARACTER SET utf8mb4 DEFAULT NULL,
  `delete_desc` text COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `thread_close`
--

CREATE TABLE `thread_close` (
  `thread_ID` int(11) NOT NULL,
  `close_author` int(11) NOT NULL,
  `close_date` datetime NOT NULL,
  `close_link` longtext COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `thread_history`
--

CREATE TABLE `thread_history` (
  `thread_ID` int(11) NOT NULL,
  `thread_ver` int(11) NOT NULL,
  `event_date` datetime NOT NULL,
  `thread_title` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `thread_content` text COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `thread_history`
--

INSERT INTO `thread_history` (`thread_ID`, `thread_ver`, `event_date`, `thread_title`, `thread_content`) VALUES
(1, 1, '2022-01-17 17:19:44', 'Welcome to CCIS Discussion Forum!', '<h1>Welcome to CCIS Discussion Forum!</h1><p><img src=\\\"path_to_thread_img\\\"></p><p>The CCIS Website itself was developed by <strong>Ysabel Dela Cruz</strong> (me), <strong>Ron-Arvil Villar</strong>, and <strong>Gerald Rongcales</strong> as part of requirements for the courses Capstone Project 1 and 2. We integrated this discussion forum to have the proper platform to acknowledge the concerns of CCIS constituents.</p><p><br></p><p>Thank you!</p>'),
(2, 1, '2022-01-27 05:25:26', 'Website Feedback', '<p>The website be bussin 10/10 <a href=\\\"https://emojipedia.org/ok-hand/\\\" target=\\\"_blank\\\">?</a></p>'),
(3, 1, '2022-01-28 09:37:42', 'Creating a thread directed to officials/moderators', '<p>In creating a thread, a user should select a forum category to identify the focus of the post. Tags may also be used to specify the topic of the thread. The writer should also identify if the post is for discussion purposes or is a question.</p><p><img src=\\\"path_to_thread_img\\\"></p><p><br></p><p>The user should also select who can reply to their thread. Threads that are directed to officials/moderators are immediately viewable by the administrator on the admin site.</p><p><img src=\\\"path_to_thread_img\\\"></p>'),
(4, 1, '2022-01-28 09:50:36', 'This is a spam', '<p>Hey check this out!</p><p><br></p><p>I just got myself a free $500 gift card to jollibee</p><p><br></p><p>I\\\'m gonna have so much fun!</p><p><br></p><p>You all should get one yourself</p><p><br></p><p>check out the url below!</p><p><br></p><p><strong><em>(some url)</em></strong></p><p><br></p><p>Users may report threads/replies so that appropriate action may be performed.</p>');

-- --------------------------------------------------------

--
-- Table structure for table `thread_img`
--

CREATE TABLE `thread_img` (
  `img_ID` int(11) NOT NULL,
  `thread_ID` int(11) NOT NULL,
  `thread_ver` int(11) NOT NULL,
  `img_path` text COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `thread_img`
--

INSERT INTO `thread_img` (`img_ID`, `thread_ID`, `thread_ver`, `img_path`) VALUES
(1, 1, 1, 'images/thread/1/20220117-61e534b5183be0.73842684.jpg'),
(2, 3, 1, 'images/thread/3/20220128-61f3b96674e262.51229716.png'),
(3, 3, 1, 'images/thread/3/20220128-61f3b96674ea73.13965546.png');

-- --------------------------------------------------------

--
-- Table structure for table `thread_img_backup`
--

CREATE TABLE `thread_img_backup` (
  `img_ID` int(11) NOT NULL,
  `thread_ID` int(11) NOT NULL,
  `img_path` text COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `thread_tags`
--

CREATE TABLE `thread_tags` (
  `thread_ID` int(11) NOT NULL,
  `tag_ID` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `thread_tags`
--

INSERT INTO `thread_tags` (`thread_ID`, `tag_ID`) VALUES
(1, 7),
(2, 6),
(3, 7),
(4, 7);

-- --------------------------------------------------------

--
-- Table structure for table `thread_votes`
--

CREATE TABLE `thread_votes` (
  `thread_ID` int(11) NOT NULL,
  `user_ID` int(11) NOT NULL,
  `user_vote` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `User_ID` int(11) NOT NULL,
  `Personal_ID` varchar(20) NOT NULL,
  `FName` varchar(50) NOT NULL,
  `MName` varchar(25) DEFAULT NULL,
  `LName` varchar(25) NOT NULL,
  `Sex` varchar(1) NOT NULL,
  `Bday` date NOT NULL,
  `is_bday_show` tinyint(1) NOT NULL,
  `Mobile` varchar(11) NOT NULL,
  `is_mobile_show` tinyint(1) NOT NULL,
  `Phone` varchar(11) DEFAULT NULL,
  `is_phone_show` tinyint(1) NOT NULL,
  `Type` int(11) NOT NULL,
  `Role` int(11) DEFAULT NULL,
  `Email` text NOT NULL,
  `is_email_show` tinyint(1) NOT NULL DEFAULT 1,
  `Pass` varchar(255) NOT NULL,
  `Img` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`User_ID`, `Personal_ID`, `FName`, `MName`, `LName`, `Sex`, `Bday`, `is_bday_show`, `Mobile`, `is_mobile_show`, `Phone`, `is_phone_show`, `Type`, `Role`, `Email`, `is_email_show`, `Pass`, `Img`) VALUES
(1, '2018-00046-MN-0', 'Ysabel', 'San Pedro', 'Dela Cruz', 'F', '2000-03-23', 0, '09554170304', 0, NULL, 0, 3, 6, 'ysdelacruz@iskolarngbayan.pup.edu.ph', 1, '$2y$10$ngIz2TW6zWPF06g/4T9Gr.6/p3inuvXBBisvynp117V3jsGE9eAO6', 'images/user/1/1.jpeg'),
(2, '2018-05125-MN-0', 'Ron-Arvil', 'Blanza', 'Villar', 'M', '2000-04-25', 0, '09563628695', 0, NULL, 0, 3, 6, 'rbvillar@iskolarngbayan.pup.edu.ph', 1, '$2y$10$ECwWGhLPXjvyNOPvuy9GgO.XDIz1zUNArNcZBxON6zqhiLBre7XVa', 'images/user/default.jpg'),
(3, '2018-04141-MN-0', 'Gerald', NULL, 'Rongcales', '', '0000-00-00', 0, '', 0, NULL, 0, 3, NULL, 'grongcales@iskolarngbayan.pup.edu.ph', 1, '$2y$10$iKkwn6HN3.1.hJv4/sUqduTM9rhlgcUGOzNUKip4nRBXwBMbVffTa', 'images/user/default.jpg'),
(4, '2022-00001-MN-0', 'Juan', NULL, 'Dela Cruz', '', '0000-00-00', 0, '', 0, NULL, 0, 3, 5, 'jdelacruz.ccis@gmail.com', 1, '$2y$10$.63m3hMYKsyqStpMRPLBCOTPLK808uIxJdBxtF5XtLcId5AadW/W.', 'images/user/default.jpg'),
(5, '88888', 'Andres', NULL, 'Bonifacio', '', '0000-00-00', 0, '', 0, NULL, 0, 2, 1, 'abonifacio.ccis@gmail.com', 1, '$2y$10$l1b2eK7YSWHck6auI1nJje.gO86/bpHFL3sXTtizbzdrXPihv17Ru', 'images/user/default.jpg'),
(6, '2018-00953-MN-0', 'Mark Daniel', NULL, 'Baje', '', '0000-00-00', 0, '', 0, NULL, 0, 3, NULL, 'markdanielbaje@gmail.com', 1, '$2y$10$lTMJhppb55BdnRz/.dytX./9dKF4W4n9ml31OL1ZRjvFsd1a9ayde', 'images/user/default.jpg'),
(7, '2018-05374-MN-0', 'John Kim', NULL, 'Querobines', '', '0000-00-00', 0, '', 0, NULL, 0, 3, NULL, 'olafkjelberg123@gmail.com', 1, '$2y$10$dteem/KWijugm7PFYjcyCuvQhg1MfdYEQ3A1OUcY4TiWwZLdEBZO.', 'images/user/default.jpg'),
(8, '2018-03991-MN-0', 'Marc Justyn', 'Soriano', 'Villanueva', 'M', '1999-05-24', 0, '09208808133', 0, NULL, 0, 3, NULL, 'mjsvillanueva2440@gmail.com', 1, '$2y$10$684UBWnjsUdL7OaLQwU36uPiEj.iQPWcXpWhV7BPAGGEWpMuc7FnK', 'images/user/default.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user_activation`
--

CREATE TABLE `user_activation` (
  `User_ID` int(11) NOT NULL,
  `Activated` tinyint(1) NOT NULL DEFAULT 1,
  `Deactivation_Date` datetime DEFAULT NULL,
  `Deactivation_Reason` text DEFAULT NULL,
  `Deactivation_Detail` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_activation`
--

INSERT INTO `user_activation` (`User_ID`, `Activated`, `Deactivation_Date`, `Deactivation_Reason`, `Deactivation_Detail`) VALUES
(1, 1, NULL, NULL, NULL),
(2, 1, NULL, NULL, NULL),
(3, 1, NULL, NULL, NULL),
(4, 1, NULL, NULL, NULL),
(5, 1, NULL, NULL, NULL),
(6, 1, NULL, NULL, NULL),
(7, 1, NULL, NULL, NULL),
(8, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `Type_ID` int(11) NOT NULL,
  `Type_Desc` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`Type_ID`, `Type_Desc`) VALUES
(1, 'Alumni'),
(2, 'Employee'),
(3, 'Student');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cat_ID`);

--
-- Indexes for table `cms`
--
ALTER TABLE `cms`
  ADD PRIMARY KEY (`cms_ID`),
  ADD KEY `cms_purpose` (`cms_purpose`);

--
-- Indexes for table `cms_history_img`
--
ALTER TABLE `cms_history_img`
  ADD PRIMARY KEY (`img_ID`);

--
-- Indexes for table `cms_purpose`
--
ALTER TABLE `cms_purpose`
  ADD PRIMARY KEY (`purpose_ID`);

--
-- Indexes for table `drs`
--
ALTER TABLE `drs`
  ADD PRIMARY KEY (`drs_ID`),
  ADD KEY `Req_AuthorID` (`Req_AuthorID`),
  ADD KEY `Req_ControlNum` (`Req_ControlNum`);

--
-- Indexes for table `drs_docreqs`
--
ALTER TABLE `drs_docreqs`
  ADD PRIMARY KEY (`DocReq_ID`),
  ADD KEY `Req_ControlNum` (`Req_ControlNum`),
  ADD KEY `Req_TypeID` (`Req_TypeID`,`Req_File_ID`),
  ADD KEY `Req_File_ID` (`Req_File_ID`),
  ADD KEY `Prereq_File_ID` (`Prereq_File_ID`);

--
-- Indexes for table `drs_files`
--
ALTER TABLE `drs_files`
  ADD PRIMARY KEY (`File_ID`),
  ADD KEY `File_ControlNum` (`File_ControlNum`);

--
-- Indexes for table `drs_history`
--
ALTER TABLE `drs_history`
  ADD PRIMARY KEY (`drs_history_ID`);

--
-- Indexes for table `drs_type`
--
ALTER TABLE `drs_type`
  ADD PRIMARY KEY (`type_ID`);

--
-- Indexes for table `faculty_staff`
--
ALTER TABLE `faculty_staff`
  ADD PRIMARY KEY (`emp_ID`);

--
-- Indexes for table `org`
--
ALTER TABLE `org`
  ADD PRIMARY KEY (`org_ID`);

--
-- Indexes for table `pass_reset`
--
ALTER TABLE `pass_reset`
  ADD PRIMARY KEY (`reset_ID`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_ID`),
  ADD KEY `post_writer_S` (`post_writer_ID`);

--
-- Indexes for table `post_backup`
--
ALTER TABLE `post_backup`
  ADD PRIMARY KEY (`post_ID`),
  ADD KEY `post_writer_S` (`post_writer_ID`);

--
-- Indexes for table `post_cover`
--
ALTER TABLE `post_cover`
  ADD PRIMARY KEY (`post_ID`);

--
-- Indexes for table `post_cover_backup`
--
ALTER TABLE `post_cover_backup`
  ADD PRIMARY KEY (`post_ID`);

--
-- Indexes for table `post_img`
--
ALTER TABLE `post_img`
  ADD PRIMARY KEY (`img_ID`),
  ADD KEY `post_ID` (`post_ID`);

--
-- Indexes for table `post_img_backup`
--
ALTER TABLE `post_img_backup`
  ADD PRIMARY KEY (`img_ID`),
  ADD KEY `post_ID` (`post_ID`);

--
-- Indexes for table `reactivate_req`
--
ALTER TABLE `reactivate_req`
  ADD PRIMARY KEY (`req_ID`),
  ADD UNIQUE KEY `user_ID_2` (`user_ID`),
  ADD KEY `user_ID` (`user_ID`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`Reg_ID`);

--
-- Indexes for table `reply`
--
ALTER TABLE `reply`
  ADD PRIMARY KEY (`reply_ID`),
  ADD KEY `thread_ID` (`thread_ID`,`reply_author_ID`),
  ADD KEY `reply_author_E` (`reply_author_ID`);

--
-- Indexes for table `reply_backup`
--
ALTER TABLE `reply_backup`
  ADD PRIMARY KEY (`reply_ID`),
  ADD KEY `thread_ID` (`thread_ID`,`reply_author_ID`),
  ADD KEY `reply_author` (`reply_author_ID`),
  ADD KEY `reply_notif` (`is_answer`),
  ADD KEY `action_user_ID` (`action_user_ID`);

--
-- Indexes for table `reply_history`
--
ALTER TABLE `reply_history`
  ADD PRIMARY KEY (`reply_ID`,`reply_ver`);

--
-- Indexes for table `reply_img`
--
ALTER TABLE `reply_img`
  ADD PRIMARY KEY (`img_ID`,`reply_ID`),
  ADD KEY `thread_ID` (`reply_ID`);

--
-- Indexes for table `reply_img_backup`
--
ALTER TABLE `reply_img_backup`
  ADD PRIMARY KEY (`img_ID`,`reply_ID`),
  ADD KEY `thread_ID` (`reply_ID`);

--
-- Indexes for table `reply_votes`
--
ALTER TABLE `reply_votes`
  ADD PRIMARY KEY (`reply_ID`,`user_ID`),
  ADD KEY `user_ID` (`user_ID`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`Report_ID`),
  ADD KEY `Thread_ID` (`Thread_ID`),
  ADD KEY `Reply_ID` (`Reply_ID`),
  ADD KEY `Report_By` (`Report_By`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`Role_ID`);

--
-- Indexes for table `student_background`
--
ALTER TABLE `student_background`
  ADD PRIMARY KEY (`Personal_ID`),
  ADD UNIQUE KEY `Personal_ID_2` (`Personal_ID`),
  ADD KEY `Personal_ID` (`Personal_ID`);

--
-- Indexes for table `student_org`
--
ALTER TABLE `student_org`
  ADD PRIMARY KEY (`Personal_ID`),
  ADD KEY `stud_org` (`stud_org`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`tag_ID`),
  ADD UNIQUE KEY `tag_Name` (`tag_Name`);

--
-- Indexes for table `thread`
--
ALTER TABLE `thread`
  ADD PRIMARY KEY (`thread_ID`),
  ADD KEY `cat_ID` (`cat_ID`,`thread_author_ID`),
  ADD KEY `thread_author_E` (`thread_author_ID`);

--
-- Indexes for table `thread_backup`
--
ALTER TABLE `thread_backup`
  ADD PRIMARY KEY (`thread_ID`),
  ADD KEY `cat_ID` (`cat_ID`,`thread_author_ID`),
  ADD KEY `thread_ibfk_4` (`thread_author_ID`),
  ADD KEY `action_user_ID` (`action_user_ID`),
  ADD KEY `action_user_ID_2` (`action_user_ID`);

--
-- Indexes for table `thread_close`
--
ALTER TABLE `thread_close`
  ADD PRIMARY KEY (`thread_ID`),
  ADD KEY `close_author` (`close_author`);

--
-- Indexes for table `thread_history`
--
ALTER TABLE `thread_history`
  ADD PRIMARY KEY (`thread_ID`,`thread_ver`);

--
-- Indexes for table `thread_img`
--
ALTER TABLE `thread_img`
  ADD PRIMARY KEY (`img_ID`,`thread_ID`),
  ADD KEY `thread_ID` (`thread_ID`);

--
-- Indexes for table `thread_img_backup`
--
ALTER TABLE `thread_img_backup`
  ADD PRIMARY KEY (`img_ID`,`thread_ID`),
  ADD KEY `thread_ID` (`thread_ID`);

--
-- Indexes for table `thread_tags`
--
ALTER TABLE `thread_tags`
  ADD PRIMARY KEY (`thread_ID`,`tag_ID`),
  ADD KEY `tag_ID` (`tag_ID`);

--
-- Indexes for table `thread_votes`
--
ALTER TABLE `thread_votes`
  ADD PRIMARY KEY (`thread_ID`,`user_ID`),
  ADD KEY `user_ID` (`user_ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`User_ID`),
  ADD UNIQUE KEY `Personal_ID` (`Personal_ID`),
  ADD KEY `User_Role_FK` (`Role`),
  ADD KEY `Type` (`Type`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `user_activation`
--
ALTER TABLE `user_activation`
  ADD PRIMARY KEY (`User_ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`Type_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `cat_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cms`
--
ALTER TABLE `cms`
  MODIFY `cms_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT for table `cms_purpose`
--
ALTER TABLE `cms_purpose`
  MODIFY `purpose_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `drs`
--
ALTER TABLE `drs`
  MODIFY `drs_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `drs_docreqs`
--
ALTER TABLE `drs_docreqs`
  MODIFY `DocReq_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `drs_files`
--
ALTER TABLE `drs_files`
  MODIFY `File_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `drs_history`
--
ALTER TABLE `drs_history`
  MODIFY `drs_history_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `drs_type`
--
ALTER TABLE `drs_type`
  MODIFY `type_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `faculty_staff`
--
ALTER TABLE `faculty_staff`
  MODIFY `emp_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `org`
--
ALTER TABLE `org`
  MODIFY `org_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pass_reset`
--
ALTER TABLE `pass_reset`
  MODIFY `reset_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `post_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `post_backup`
--
ALTER TABLE `post_backup`
  MODIFY `post_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post_img`
--
ALTER TABLE `post_img`
  MODIFY `img_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reactivate_req`
--
ALTER TABLE `reactivate_req`
  MODIFY `req_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `Reg_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `reply`
--
ALTER TABLE `reply`
  MODIFY `reply_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reply_backup`
--
ALTER TABLE `reply_backup`
  MODIFY `reply_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reply_img`
--
ALTER TABLE `reply_img`
  MODIFY `img_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reply_img_backup`
--
ALTER TABLE `reply_img_backup`
  MODIFY `img_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `Report_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `Role_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `tag_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `thread`
--
ALTER TABLE `thread`
  MODIFY `thread_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `thread_backup`
--
ALTER TABLE `thread_backup`
  MODIFY `thread_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `thread_img`
--
ALTER TABLE `thread_img`
  MODIFY `img_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `thread_img_backup`
--
ALTER TABLE `thread_img_backup`
  MODIFY `img_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `Type_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cms`
--
ALTER TABLE `cms`
  ADD CONSTRAINT `cms_ibfk_1` FOREIGN KEY (`cms_purpose`) REFERENCES `cms_purpose` (`purpose_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `drs`
--
ALTER TABLE `drs`
  ADD CONSTRAINT `drs_ibfk_1` FOREIGN KEY (`Req_AuthorID`) REFERENCES `user` (`Personal_ID`);

--
-- Constraints for table `drs_docreqs`
--
ALTER TABLE `drs_docreqs`
  ADD CONSTRAINT `drs_docreqs_ibfk_1` FOREIGN KEY (`Req_TypeID`) REFERENCES `drs_type` (`type_ID`),
  ADD CONSTRAINT `drs_docreqs_ibfk_2` FOREIGN KEY (`Req_File_ID`) REFERENCES `drs_files` (`File_ID`),
  ADD CONSTRAINT `drs_docreqs_ibfk_3` FOREIGN KEY (`Prereq_File_ID`) REFERENCES `drs_files` (`File_ID`);

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`post_writer_ID`) REFERENCES `user` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post_backup`
--
ALTER TABLE `post_backup`
  ADD CONSTRAINT `post_backup_ibfk_1` FOREIGN KEY (`post_writer_ID`) REFERENCES `user` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post_cover`
--
ALTER TABLE `post_cover`
  ADD CONSTRAINT `post_cover_ibfk_1` FOREIGN KEY (`post_ID`) REFERENCES `post` (`post_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post_cover_backup`
--
ALTER TABLE `post_cover_backup`
  ADD CONSTRAINT `post_cover_backup_ibfk_1` FOREIGN KEY (`post_ID`) REFERENCES `post_backup` (`post_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post_img`
--
ALTER TABLE `post_img`
  ADD CONSTRAINT `post_img_ibfk_1` FOREIGN KEY (`post_ID`) REFERENCES `post` (`post_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post_img_backup`
--
ALTER TABLE `post_img_backup`
  ADD CONSTRAINT `post_img_backup_ibfk_1` FOREIGN KEY (`post_ID`) REFERENCES `post_backup` (`post_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reactivate_req`
--
ALTER TABLE `reactivate_req`
  ADD CONSTRAINT `reactivate_req_ibfk_1` FOREIGN KEY (`user_ID`) REFERENCES `user` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reply`
--
ALTER TABLE `reply`
  ADD CONSTRAINT `reply_ibfk_2` FOREIGN KEY (`thread_ID`) REFERENCES `thread` (`thread_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reply_ibfk_3` FOREIGN KEY (`reply_author_ID`) REFERENCES `user` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reply_backup`
--
ALTER TABLE `reply_backup`
  ADD CONSTRAINT `reply_backup_ibfk_1` FOREIGN KEY (`action_user_ID`) REFERENCES `user` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reply_backup_ibfk_2` FOREIGN KEY (`reply_author_ID`) REFERENCES `user` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reply_history`
--
ALTER TABLE `reply_history`
  ADD CONSTRAINT `reply_history_ibfk_1` FOREIGN KEY (`reply_ID`) REFERENCES `reply` (`reply_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reply_img`
--
ALTER TABLE `reply_img`
  ADD CONSTRAINT `reply_img_ibfk_1` FOREIGN KEY (`reply_ID`) REFERENCES `reply` (`reply_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reply_img_backup`
--
ALTER TABLE `reply_img_backup`
  ADD CONSTRAINT `reply_img_backup_ibfk_1` FOREIGN KEY (`reply_ID`) REFERENCES `reply_backup` (`reply_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reply_votes`
--
ALTER TABLE `reply_votes`
  ADD CONSTRAINT `reply_votes_ibfk_1` FOREIGN KEY (`reply_ID`) REFERENCES `reply` (`reply_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reply_votes_ibfk_2` FOREIGN KEY (`user_ID`) REFERENCES `user` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`Thread_ID`) REFERENCES `thread` (`thread_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reports_ibfk_2` FOREIGN KEY (`Reply_ID`) REFERENCES `reply` (`reply_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reports_ibfk_3` FOREIGN KEY (`Report_By`) REFERENCES `user` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_background`
--
ALTER TABLE `student_background`
  ADD CONSTRAINT `student_background_ibfk_1` FOREIGN KEY (`Personal_ID`) REFERENCES `user` (`Personal_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_org`
--
ALTER TABLE `student_org`
  ADD CONSTRAINT `student_org_ibfk_3` FOREIGN KEY (`Personal_ID`) REFERENCES `user` (`Personal_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_org_ibfk_4` FOREIGN KEY (`stud_org`) REFERENCES `org` (`org_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `thread`
--
ALTER TABLE `thread`
  ADD CONSTRAINT `thread_ibfk_2` FOREIGN KEY (`cat_ID`) REFERENCES `category` (`cat_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `thread_ibfk_3` FOREIGN KEY (`thread_author_ID`) REFERENCES `user` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `thread_backup`
--
ALTER TABLE `thread_backup`
  ADD CONSTRAINT `thread_backup_ibfk_1` FOREIGN KEY (`action_user_ID`) REFERENCES `user` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `thread_backup_ibfk_2` FOREIGN KEY (`thread_author_ID`) REFERENCES `user` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `thread_backup_ibfk_3` FOREIGN KEY (`cat_ID`) REFERENCES `category` (`cat_ID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `thread_close`
--
ALTER TABLE `thread_close`
  ADD CONSTRAINT `thread_close_ibfk_1` FOREIGN KEY (`thread_ID`) REFERENCES `thread` (`thread_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `thread_close_ibfk_2` FOREIGN KEY (`close_author`) REFERENCES `user` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `thread_history`
--
ALTER TABLE `thread_history`
  ADD CONSTRAINT `thread_history_ibfk_1` FOREIGN KEY (`thread_ID`) REFERENCES `thread` (`thread_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `thread_img`
--
ALTER TABLE `thread_img`
  ADD CONSTRAINT `thread_img_ibfk_1` FOREIGN KEY (`thread_ID`) REFERENCES `thread` (`thread_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `thread_img_backup`
--
ALTER TABLE `thread_img_backup`
  ADD CONSTRAINT `thread_img_backup_ibfk_1` FOREIGN KEY (`thread_ID`) REFERENCES `thread_backup` (`thread_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `thread_tags`
--
ALTER TABLE `thread_tags`
  ADD CONSTRAINT `thread_tags_ibfk_1` FOREIGN KEY (`thread_ID`) REFERENCES `thread` (`thread_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `thread_tags_ibfk_2` FOREIGN KEY (`tag_ID`) REFERENCES `tags` (`tag_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `thread_votes`
--
ALTER TABLE `thread_votes`
  ADD CONSTRAINT `thread_votes_ibfk_1` FOREIGN KEY (`thread_ID`) REFERENCES `thread` (`thread_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `thread_votes_ibfk_2` FOREIGN KEY (`user_ID`) REFERENCES `user` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`Role`) REFERENCES `roles` (`Role_ID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `user_ibfk_3` FOREIGN KEY (`Type`) REFERENCES `user_type` (`Type_ID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `user_activation`
--
ALTER TABLE `user_activation`
  ADD CONSTRAINT `user_activation_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
