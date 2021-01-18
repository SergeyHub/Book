-- phpMyAdmin SQL Dump
-- version 4.6.0
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Jun 02, 2019 at 03:29 PM
-- Server version: 5.6.30
-- PHP Version: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `askskb70_chow`
--
CREATE DATABASE IF NOT EXISTS `askskb70_chow` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `askskb70_chow`;

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `author_id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(30) NOT NULL DEFAULT '',
  `family_name` varchar(30) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`author_id`, `first_name`, `family_name`) VALUES
(1, 'David', 'Powers'),
(2, 'Sham', 'Bhangal'),
(6, 'Michael', 'Kofler'),
(4, 'Rachel', 'Andrew'),
(5, 'Allan', 'Kent'),
(7, 'Owen', 'Briggs'),
(8, 'Steven', 'Champeon'),
(9, 'Eric', 'Costello'),
(10, 'Matt', 'Patterson'),
(11, 'Kristian', 'Besley'),
(12, 'Craig', 'Grannell'),
(13, 'George', 'McLachlan'),
(14, 'Jason', 'Gilmore'),
(15, 'Kevin', 'Peaty'),
(16, 'Glenn', 'Kirkpatrick'),
(17, 'Nathan', 'Good'),
(18, 'David', 'Hirmes'),
(19, 'JD', 'Hooge'),
(20, 'Ken', 'Jokol'),
(21, 'Pavel', 'Kaluzhny'),
(22, 'Ty', 'Lettau'),
(23, 'NULL', 'Lifaros'),
(24, 'Jamie', 'MacDonald'),
(25, 'Gabriel', 'Mulzer'),
(26, 'Kip', 'Parker'),
(27, 'Keith', 'Peters'),
(28, 'Paul', 'Prudence'),
(29, 'Glen', 'Rhodes'),
(30, 'Manny', 'Tan'),
(31, 'Jared', 'Tarbell'),
(32, 'Brandon', 'Williams'),
(33, 'Stack Overflow Documentation', ''),
(34, 'Stack Overflow Documentation', 'Stack Overflow Documentation'),
(35, 'Aratyn Tom', 'Aratyn Tom');

-- --------------------------------------------------------

--
-- Table structure for table `book_to_author`
--

CREATE TABLE `book_to_author` (
  `book_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `author_id` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `book_to_author`
--

INSERT INTO `book_to_author` (`book_id`, `author_id`) VALUES
(6, 6),
(7, 2),
(7, 11),
(8, 1),
(8, 12),
(8, 13),
(9, 7),
(9, 8),
(9, 9),
(9, 10),
(10, 2),
(11, 5),
(11, 20),
(11, 21),
(12, 1),
(12, 4),
(12, 5),
(13, 15),
(13, 16),
(14, 18),
(14, 19),
(14, 20),
(14, 21),
(14, 22),
(14, 23),
(14, 24),
(14, 25),
(14, 26),
(14, 27),
(14, 28),
(14, 29),
(14, 30),
(14, 31),
(14, 32),
(15, 17),
(16, 12),
(17, 1),
(19, 2),
(19, 4),
(19, 7),
(19, 11),
(20, 12),
(20, 14),
(20, 17),
(21, 7),
(26, 34),
(27, 35);

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_id` int(10) UNSIGNED NOT NULL,
  `pub_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `isbn` varchar(13) NOT NULL DEFAULT '',
  `title` varchar(150) NOT NULL DEFAULT '',
  `image` enum('y','n') NOT NULL DEFAULT 'y',
  `description` text NOT NULL,
  `list_price` varchar(10) DEFAULT NULL,
  `store_price` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `pub_id`, `isbn`, `title`, `image`, `description`, `list_price`, `store_price`) VALUES
(6, 2, '1590591445', 'The Definitive Guide to MySQL, 2nd Edition', 'y', 'This second edition of Michael Kofler\'s acclaimed MySQL book has updated and expanded to cover MySQL 4.0, the most recent production release of the popular open source database, which boasts more than 4 million users worldwide.\r\nLike the first edition, this revision, which has been renamed to reflect the breadth and depth of Kofler\'s coverage of the topic, provides a thorough introduction to the installation, configuration, implementation, and administration of MySQL. In addition, Kofler demonstrates how you can use MySQL in conjunction with various other technologies to create database-driven websites, and he gives practical advice on database design. Kofler also covers what\'s coming up next in MySQL 4.1.\r\nThe Definitive Guide to MySQL, Second Edition is an irreplaceable resource for MySQL novices and experts alike.', '$49.99', '$32.99'),
(7, 1, '1590593030', 'Python Cookbook: Recipes for Mastering Python 3 ', 'n', 'If you need help writing programs in Python 3, or want to update older Python 2 code, this book is just the ticket. Packed with practical recipes written and tested with Python 3.3, this unique cookbook is for experienced Python programmers who want to focus on modern tools and idioms.\r\n\r\nInside, you’ll find complete recipes for more than a dozen topics, covering the core Python language as well as tasks common to a wide variety of application domains. Each recipe contains code samples you can use in your projects right away, along with a discussion about how and why the solution works.', '$29.99', '$19.79'),
(18, 2, '1308202023', 'Python Programming An Introduction to Computer Science 3rd Revised edition ', 'y', 'This book is designed to be used as a primary textbook in a college-level first course in computing. It takes a fairly traditional approach, emphasizing problem solving, design, and programming as the core skills of computer science. However, these ideas are illustrated using a non-traditional language, namely Python. This textbook was written with a single overarching goal: to introduce fundamental computer science concepts as simply as possible without being simplistic. Using Python is central to this goal.Traditional systems languages such as C++, Ada, and Java evolved to solve problems in large-scale programming, where the primary emphasis is on structure and discipline. ', NULL, NULL),
(8, 3, '1590593081', 'Node.js Design Patterns', 'y', 'Create reusable patterns and modules by leveraging the new features of Node.js .\r\nUnderstand the asynchronous single thread design of node and grasp all its features and patterns to take advantage of various functions.\r\nThis unique guide will help you get the most out of Node.js and its ecosystem.\r\n', '$34.99', '$24.49'),
(22, 0, '6789qwert7', 'AngularJS Notes for Professionals ', 'y', 'This AngularJS Notes for Professionals book is compiled from Stack Overflow\r\nDocumentation, the content is written by the beautiful people at Stack Overflow.\r\nText content is released under Creative Commons BY-SA, see credits at the end\r\nof this book whom contributed to the various chapters. Images may be copyright\r\nof their respective owners unless otherwise specified\r\nThis is an unofficial free book created for educational purposes and is not\r\naffiliated with official AngularJS group(s) or company(s) nor Stack Overflow. All\r\ntrademarks and registered trademarks are the property of their respective\r\ncompany owners\r\nThe information presented in this book is not guaranteed to be correct nor\r\naccurate, use at your own risk\r\nPlease send feedback and corrections to web@petercv.com\r\n', NULL, NULL),
(23, 0, '1234567890ddd', 'AngularJS Notes for Professionals ', 'y', 'This AngularJS Notes for Professionals book is compiled from Stack Overflow\r\nDocumentation, the content is written by the beautiful people at Stack Overflow.\r\nText content is released under Creative Commons BY-SA, see credits at the end\r\nof this book whom contributed to the various chapters. Images may be copyright\r\nof their respective owners unless otherwise specified\r\nThis is an unofficial free book created for educational purposes and is not\r\naffiliated with official AngularJS group(s) or company(s) nor Stack Overflow. All\r\ntrademarks and registered trademarks are the property of their respective\r\ncompany owners\r\nThe information presented in this book is not guaranteed to be correct nor\r\naccurate, use at your own risk\r\nPlease send feedback and corrections to web@petercv.com\r\n', NULL, NULL),
(9, 1, '159059231X', 'Cascading Style Sheets: Separating Content from Presentation', 'y', 'CSS is one of the trio of core client-side web professional skills: HTML for markup, JavaScript for dynamism, and CSS for style. All web professionals who want to take their page design to the next level, with all the advantages that CSS brings, will need this book.\r\nThis book is a focused guide to using Cascading Style Sheets (CSS) for the visual design of web pages. It provides concise coverage of all the essential CSS concepts developers need to learn (such as separating content from presentation, block and inline elements, inheritance and cascade, the box model, typography, etc). It also covers the syntax needed to effectively use CSS with your markup document (for example CSS rules, how to structure a style sheet, linking style sheets to your (X)HTML documents, CSS boxes etc).\r\nCSS (Cascading Style Sheets) is a powerful technology that can be used to add style and structure to your web pages without needing to resort to "hacks" such as HTML table layouts and "spacer images". However, this is not the only advantage over other styling methods. You can specify your CSS styles in a separate file, then apply those styles to every page in your web site. When you want to change a style on your site, you can do it by modifying one style sheet, rather having to update every page. This is only one example of the many advantages CSS brings to your web development work.', '$39.99', '$27.19'),
(10, 1, '1590593057', 'Python Crash Course: A Hands-On, Project-Based Introduction to Programming', 'y', 'Python is the most popular programming language for beginners because it\'s fun, powerful, and easy to learn. So why should your introductory Python book be long and tedious? \r\n\r\nPython Crash Course gets you up and running with Python, teaching you the basics quickly so that you can solve problems, make things, and do cool stuff. Each chapter explains a new programming concept and includes a set of exercises to help reinforce your new knowledge. \r\n\r\nBut most important of all, Python Crash Course includes three hands-on projects to put your new programming skills into practice, so it\'s not just syntax and theory. You\'ll learn how to create a simple video game, use data visualization techniques to make interactive graphs and charts, and build a simple Web application. Python Crash Course teaches you Python the fun way—it\'s quick, hands-on, and totally useful.', '$34.99', '$24.49'),
(19, 2, '1234567890', 'Python Programming An Introduction to Computer Science 3rd Revised edition ', 'y', 'This book is designed to be used as a primary textbook in a college-level first course in computing. It takes a fairly traditional approach, emphasizing problem solving, design, and programming as the core skills of computer science. However, these ideas are illustrated using a non-traditional language, namely Python. This textbook was written with a single overarching goal: to introduce fundamental computer science concepts as simply as possible without being simplistic. Using Python is central to this goal.Traditional systems languages such as C++, Ada, and Java evolved to solve problems in large-scale programming, where the primary emphasis is on structure and discipline. ', NULL, NULL),
(11, 2, '1893115518', 'PHP 7 Data Structures and Algorithms', 'n', 'The book takes practical approach of solving problems and understanding data structure with lots of examples and analysis.\r\n\r\nFocusing on PHP 7 features, the book is written for both beginners and experience developers in PHP.\r\n\r\nThe book finishes with an introduction to functional data structures using functional programming.', '$39.99', '$26.39'),
(12, 2, '1590593502', 'PHP Web Development ', 'y', 'PHP is the most popular Open source server-side scripting language, with extensive support available in Dreamweaver MX. This concise, no-nonsense book teaches you how to develop accessible, standards-compliant PHP-driven websites using PHP 4 and Macromedia Dreamweaver MX 2004.\r\nPHP Web Development with Macromedia Dreamweaver MX 2004 presents real-world tutorials so you can expect fast results as you progress through the book. It also covers vital web development topics such as web standards principles and implementation, and it includes a useful setup section to get you up-and-running quickly and easily.', '$39.99', '$27.19'),
(13, 1, '9781118531648', 'JavaScript and JQuery: Interactive Front-End Web Development', 'n', 'The author of this book Jon Duckett is a renowned developer in the web design/dev space. He’s written many introductory books for the basics of web design and they’re all written beautifully for beginners.\r\n\r\nThat’s why JavaScript and JQuery makes such a great intro guide for novice developers. Over 640 pages you’ll learn the fundamentals of JavaScript contrasted with jQuery. This includes browser hacks and common mistakes made while studying JS scripting.\r\n\r\nYou can pick up this book from any level of experience and still work your way through the lessons. They start simple with the very basics of development including functions, objects, and loops. From there you’ll learn about the DOM and more advanced techniques like event handlers.\r\n\r\nThis book is huge but it’s also very easy to read. If you’re a beginner without even basic JS knowledge this book can take you far.', '$29.99', '$19.79'),
(14, 3, '1590594290', 'Beginning Web Application Development with Node', 'y', 'A comprehensive tutorial-style eBook that gets you from zero to native Web application development with JavaScript in no time.\r\n\r\nEach chapter will cover simple examples and explain the concepts in detail. Exercises provided at the end of each chapter will help practicing the concepts. In last chapter, we will develop end to end web application using MEAN (MongoDB, Express, AngularJs and Node), which will be cross-platform and cross-browser.\r\n\r\nFurthermore, the reader will be introduced to every tool and all JavaScript language constructs needed to fully master web application development with Node: Express, Bootstrap, Bower, Grunt, NPM, AngularJs, MongoDB, and more.', '$49.99', '$32.99'),
(15, 2, '159059441X', 'Regular Expression Recipes: A Problem-Solution Approach', 'n', 'Regular Expressions are an essential part of programming, but they sure are hard to come to grips with, aren\'t they? Fortunately, we have the answer for you! Regular Expression Recipes provides you with all the open source regular expressions you\'ll ever need, and explains how to use each one. This way, you can learn by example, rather than muddling through countless pages of explanatory syntax.\r\nAuthor Nathan A. Good includes syntax references only when necessary. Languages covered include Perl, PHP, grep, vim, Python, and shell. Web and applications developers, and system administrators will find the examples both accurate and relevant. And this book acts as a useful reference to keep handy for those moments when an answer is needed fast.', '$34.99', '$23.79'),
(16, 1, '1590594304', 'Web Designer\'s Reference', 'n', 'Most web design books concentrate on a single technology or piece of software, leaving the designer to figure out how to put all the pieces together. This book is different. Web Designer\'s Reference provides a truly integrated approach to web design. Each of the dozen chapters covers a specific aspect of creating a web page, such as working with typography, adding images, creating navigation, and crafting CSS layouts. In each case, relevant XHTML elements are explored along with associated CSS, and visual design ideas are discussed. Several practical examples are provided, which you can use to further your understanding of each subject. This highly modular and integrated approach means that you learn about technologies in context, at the appropriate time and, upon working through each chapter, you craft a number of web page elements that you can use on countless sites in the future.\r\nThis book is ideal for those making their first moves into standards-based web design, experienced designers who want to learn about modern design techniques and move toward creating CSS layouts, graphic designers who want to discover how to lay out their designs, and veteran web designers who want a concise reference guide.', '$34.99', '$23.09'),
(17, 1, '1590594665', 'Beginning PHP 5.3', 'y', 'Welcome to Beginning PHP 5.3 ! This book teaches you how to build interactive Web sites and\r\napplications using PHP, one of the most popular Web programming languages in use today. Using PHP\r\nyou can create anything from a simple form - to - email script all the way up to a Web forum application, a\r\nblogging platform, a content management system, or the next big Web 2.0 sensation. The sky is the limit!\r\n As programming languages go, PHP is easy to learn. However, it ’ s also a very extensive language, with\r\nhundreds of built - in functions and thousands more available through add - ons to the PHP engine. This\r\nbook doesn ’ t attempt to guide you through every nook and cranny of PHP ’ s capabilities. Instead, it aims\r\nto give you a good grounding in the most useful aspects of the language — the stuff you ’ ll use 99 percent\r\nof the time — and to teach you how to create solid, high - quality PHP applications. \r\n', '$44.99', '$29.70'),
(20, 1, '123qqq4567890', 'Python Pocket Reference (Pocket Reference (O\\\'Reilly))', 'y', 'Updated for both Python 3.4 and 2.7, this convenient pocket guide is the perfect on-the-job quick reference. You’ll find concise, need-to-know information on Python types and statements, special method names, built-in functions and exceptions, commonly used standard library modules, and other prominent Python tools. The handy index lets you pinpoint exactly what you need.\r\n\r\nWritten by Mark Lutz—widely recognized as the world’s leading Python trainer—Python Pocket Reference is an ideal companion to O’Reilly’s classic Python tutorials, Learning Python and Programming Python, also written by Mark.', NULL, NULL),
(21, 2, '1234567890www', 'PHP 7 from Scratch', 'y', 'The book takes practical approach of solving problems and understanding data structure with lots of examples and analysis.\r\n\r\nFocusing on PHP 7 features, the book is written for both beginners and experience developers in PHP.\r\n\r\nThe book finishes with an introduction to functional data structures using functional programming.', NULL, NULL),
(24, 0, '1234567890ddr', 'AngularJS Notes for Professionals ', 'y', 'This AngularJS Notes for Professionals book is compiled from Stack Overflow\r\nDocumentation, the content is written by the beautiful people at Stack Overflow.\r\nText content is released under Creative Commons BY-SA, see credits at the end\r\nof this book whom contributed to the various chapters. Images may be copyright\r\nof their respective owners unless otherwise specified\r\nThis is an unofficial free book created for educational purposes and is not\r\naffiliated with official AngularJS group(s) or company(s) nor Stack Overflow. All\r\ntrademarks and registered trademarks are the property of their respective\r\ncompany owners\r\nThe information presented in this book is not guaranteed to be correct nor\r\naccurate, use at your own risk\r\nPlease send feedback and corrections to web@petercv.com\r\n', NULL, NULL),
(25, 0, '1234567890123', 'AngularJS Notes for Professionals ', 'y', 'This AngularJS Notes for Professionals book is compiled from Stack Overflow\r\nDocumentation, the content is written by the beautiful people at Stack Overflow.\r\nText content is released under Creative Commons BY-SA, see credits at the end\r\nof this book whom contributed to the various chapters. Images may be copyright\r\nof their respective owners unless otherwise specified\r\nThis is an unofficial free book created for educational purposes and is not\r\naffiliated with official AngularJS group(s) or company(s) nor Stack Overflow. All\r\ntrademarks and registered trademarks are the property of their respective\r\ncompany owners\r\nThe information presented in this book is not guaranteed to be correct nor\r\naccurate, use at your own risk\r\nPlease send feedback and corrections to web@petercv.com\r\n', NULL, NULL),
(26, 4, '1235576789', 'AngularJS Notes for Professionals ', 'y', 'This AngularJS Notes for Professionals book is compiled from Stack Overflow\r\nDocumentation, the content is written by the beautiful people at Stack Overflow.\r\nText content is released under Creative Commons BY-SA, see credits at the end\r\nof this book whom contributed to the various chapters. Images may be copyright\r\nof their respective owners unless otherwise specified\r\nThis is an unofficial free book created for educational purposes and is not\r\naffiliated with official AngularJS group(s) or company(s) nor Stack Overflow. All\r\ntrademarks and registered trademarks are the property of their respective\r\ncompany owners\r\nThe information presented in this book is not guaranteed to be correct nor\r\naccurate, use at your own risk\r\nPlease send feedback and corrections to web@petercv.com\r\n', NULL, NULL),
(27, 5, '1788472489', 'Django 2 by Example', 'y', 'If you want to learn about the entire process of developing professional web applications with Django, then this book is for you. This book will walk you through the creation of four professional Django projects, teaching you how to solve common problems and implement best practices.\r\nYou will learn how to build a blog application, a social image-bookmarking website, an online shop, and an e-learning platform. The book will teach you how to enhance your applications with AJAX, create RESTful APIs, and set up a production environment for your Django projects. The book walks you through the creation of real-world applications, while solving common problems and implementing best practices. By the end of this book, you will have a deep understanding of Django and how to build advanced web applications.\r\nWhat You Will Learn\r\nBuild practical, real-world web applications with Django\r\nUse Django with other technologies, such as Redis and Celery\r\nDevelop pluggable Django applications\r\nCreate advanced features, optimize your code, and use the cache framework\r\n', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `publishers`
--

CREATE TABLE `publishers` (
  `pub_id` int(10) UNSIGNED NOT NULL,
  `publisher` varchar(50) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `publishers`
--

INSERT INTO `publishers` (`pub_id`, `publisher`) VALUES
(1, 'friends of ED'),
(2, 'Apress'),
(3, 'O\'Reily'),
(4, 'https://goalkicker.com/AngularJSBook'),
(5, 'Packt Publishing');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`author_id`);

--
-- Indexes for table `book_to_author`
--
ALTER TABLE `book_to_author`
  ADD PRIMARY KEY (`book_id`,`author_id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `publishers`
--
ALTER TABLE `publishers`
  ADD PRIMARY KEY (`pub_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `author_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `publishers`
--
ALTER TABLE `publishers`
  MODIFY `pub_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;--
-- Database: `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `test`;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
