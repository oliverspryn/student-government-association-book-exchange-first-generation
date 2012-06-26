-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 26, 2012 at 09:03 AM
-- Server version: 5.5.8
-- PHP Version: 5.3.5



/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sga`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookcategories`
--

CREATE TABLE IF NOT EXISTS "bookcategories" (
  "id" int(11) NOT NULL COMMENT 'Primary key of the table, and ID of the category',
  "name" longtext NOT NULL COMMENT 'The title of the category',
  "course" text NOT NULL COMMENT 'The short ID name of the course',
  "description" longtext NOT NULL COMMENT 'An optional description for the category',
  "color1" varchar(7) NOT NULL COMMENT 'The color scheme for the category and the color of the very top border for the category <header>',
  "color2" varchar(7) NOT NULL COMMENT 'Color of the border around the <h1> tag in the category <header>',
  "color3" varchar(7) NOT NULL COMMENT 'Color of the background of the <h1> tag in the category <header>',
  "textColor" varchar(7) NOT NULL COMMENT 'Color of the text of the <h1> tag in the category <header>',
  PRIMARY KEY ("id")
) AUTO_INCREMENT=40 ;

--
-- Dumping data for table `bookcategories`
--

INSERT INTO `bookcategories` (`id`, `name`, `course`, `description`, `color1`, `color2`, `color3`, `textColor`) VALUES
(1, 'Mathematics', 'MATH', 'You know + - * /. That kind of stuff.', '#E7D2EF', '#F1E4F5', '#F7EFF9', ''),
(2, 'Physics', 'PHYS', 'You know, why stuff works.', '#5F6B79', '', '', ''),
(3, 'Accounting', 'ACCT', '', '#26878E', '', '', ''),
(4, 'Art', 'ART', '', '#9BCA9C', '#C3DFC4', '#DBECDC', '#9BCA9C'),
(5, 'Astronomy', 'ASTR', '', '#899C2D', '', '', ''),
(6, 'Biology', 'BIO', '', '#D9A600', '', '', ''),
(7, 'Business', 'BUSS', '', '#FECE2C', '', '', ''),
(8, 'Chemistry', 'CHEM', '', '#E04749', '', '', ''),
(9, 'Chinese', 'CHIN', '', '#B43F76', '', '', ''),
(10, 'Computer Science', 'COMP', '', '#B086B6', '', '', ''),
(11, 'Economics', 'ECON', '', '#5660C1', '', '', ''),
(12, 'Education', 'EDUC', '', '#007ACB', '', '', ''),
(13, 'Electrical Engineering', 'EENG', '', '#527591', '', '', ''),
(14, 'Engineering', 'ENGR', '', '#5E6C79', '', '', ''),
(15, 'English', 'ENGL', '', '#9198AA', '', '', ''),
(16, 'Entreprenuership', 'ENTR', '', '#8387AA', '', '', ''),
(17, 'Exercise Science', 'ESCI', '', '#978D81', '', '', ''),
(18, 'French', 'FREN', '', '#5DDCD3', '', '', ''),
(19, 'General Science', 'GSCI', '', '#D9EFD8', '', '', ''),
(20, 'Geology', 'GEOL', '', '#C8DD53', '', '', ''),
(21, 'German', 'GERM', '', '#D28DFA', '', '', ''),
(22, 'Global Studies', 'GLOB', '', '#FECE2C', '', '', ''),
(23, 'Greek', 'GREK', '', '#E97802', '', '', ''),
(24, 'Hebrew', 'HEBR', '', '#D1692C', '', '', ''),
(25, 'History', 'HIST', '', '#48D6FD', '', '', ''),
(26, 'Humanities', 'HUMA', '', '#FFAE61', '', '', ''),
(27, 'Japanese', 'JAPN', '', '#FB97C9', '', '', ''),
(28, 'Mechanical Engineering', 'MECH', '', '#5861BE', '', '', ''),
(29, 'Music', 'MUSC', '', '#48D6FD', '', '', ''),
(30, 'Philosophy', 'PHIL', '', '#96CCE4', '', '', ''),
(31, 'Political Science', 'POLY', '', '#CAD3E2', '', '', ''),
(32, 'Psychology', 'PYCH', '', '#C3D1EC', '', '', ''),
(33, 'Religion', 'RELI', '', '#D2C9CA', '', '', ''),
(34, 'Science Faith & Tech', 'SSFT', '', '#D9D9CF', '', '', ''),
(35, 'Sociology', 'SOCI', '', '#3398CB', '', '', ''),
(36, 'Spanish', 'SPAN', '', '#98FECB', '', '', ''),
(37, 'Special Education', 'SPED', '', '#FE6600', '', '', ''),
(38, 'Theater', 'THEA', '', '#986600', '', '', ''),
(39, 'Communications', 'COMM', '', '#775390', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE IF NOT EXISTS "books" (
  "id" int(11) NOT NULL COMMENT 'Primary key of the table, and ID of the book',
  "userID" int(11) NOT NULL COMMENT 'The ID of the current book''s owner',
  "upload" int(10) NOT NULL COMMENT 'Time which this book was added',
  "sold" int(1) NOT NULL COMMENT 'Whether or not this book has been sold',
  "linkID" varchar(32) NOT NULL COMMENT 'A hashed identifier to link a single book, which was used for multiple and stored in the database once for each class, together by a common ID',
  "ISBN" varchar(13) NOT NULL COMMENT 'The ISBN-10 or ISBN-13 number, without the dashes',
  "title" varchar(300) NOT NULL COMMENT 'Title of the book',
  "author" varchar(200) NOT NULL COMMENT 'Author(s) of the book',
  "edition" varchar(200) NOT NULL COMMENT 'The edition of the book',
  "course" int(11) NOT NULL COMMENT 'The system ID for the course for which this book is intended',
  "number" varchar(3) NOT NULL COMMENT 'The course number for which this book is intended',
  "section" varchar(1) NOT NULL COMMENT 'The class section for which this book is intended',
  "price" decimal(10,2) NOT NULL COMMENT 'Asking price of the book',
  "condition" text NOT NULL COMMENT 'The books condition: excellent, very good, good, fair, or poor',
  "written" tinytext NOT NULL COMMENT 'Whether or not this book was underlined, highlighted, or written in',
  "comments" longtext NOT NULL COMMENT 'Any comments about the book from the seller',
  "imageURL" longtext NOT NULL COMMENT 'The URL of the book''s cover image',
  "awaitingImage" longtext NOT NULL COMMENT 'The unverified URL of the image that is awaiting staff approval',
  "imageID" varchar(32) NOT NULL COMMENT 'The identifier key for the current image. This is used whenever an image for an existing book is suggested. This key will link all books with the same cover together. That way if one is approved for use, they all have become approved for use: past, present, and future.',
  PRIMARY KEY ("id"),
  FULLTEXT KEY "title" ("title"),
  FULLTEXT KEY "author" ("author"),
  FULLTEXT KEY "course" ("number","section")
) AUTO_INCREMENT=63 ;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `userID`, `upload`, `sold`, `linkID`, `ISBN`, `title`, `author`, `edition`, `course`, `number`, `section`, `price`, `condition`, `written`, `comments`, `imageURL`, `awaitingImage`, `imageID`) VALUES
(1, 278, 1340452194, 0, 'c4ca4238a0b923820dcc509a6f75849b', '1234567890', 'Leonardo: He was Awesome!', 'Oliver Spryn the Great', '1st', 4, '201', 'G', '149.99', 'Excellent', 'No', 'Awesomeness is commin'' to town!', 'http://www.coverbrowser.com/image/donald-duck/34-1.jpg', '', '36565795dd09ce8da646941a3f2a7fd5'),
(2, 278, 1340452156, 0, 'c81e728d9d4c2f636f067f89cc14862c', '1234567890', 'Leonardo: He was Awesome!', 'Oliver Spryn the Great', '1st', 4, '102', 'F', '99.99', 'Excellent', 'No', '<p>Awesomeness is commin'' to town!</p>', 'http://www.coverbrowser.com/image/donald-duck/39-1.jpg', '', 'b7b0974e6cd9ad0a633d081646a405e9'),
(3, 278, 1324357200, 0, 'eccbc87e4b5ce2fe28308fd9f2a7baf3', '1234567890', 'Leonardo: He was Awesome!', 'Oliver Spryn the Great', '1st', 4, '101', 'C', '149.99', 'Excellent', 'No', 'Awesomeness is commin'' to town!', 'http://www.coverbrowser.com/image/donald-duck/30-1.jpg', '', 'c822cb12fefd1f0affa76f379bfecebd'),
(4, 278, 1324357200, 0, 'b261807d4663f1371171d57b7d40893f', '1234567890', 'Leonardo: He was Awesome!', 'Oliver Spryn the Great', '1st', 4, '201', 'I', '149.99', 'Excellent', 'No', 'Awesomeness is commin'' to town!', 'http://www.bookbyte.com/image.aspx?isbn=9780077366698', '', '468b8928ff38ad6d94feb27403db8eed'),
(5, 278, 1340438123, 0, 'a87ff679a2f3e71d9181a67b7542122c', '1234567890', 'Leonardo: He was Awesome!', 'Oliver Spryn the Great', '1st', 4, '102', 'B', '149.99', 'Excellent', 'No', '<p>Awesomeness is commin'' to town!</p>', 'http://www.coverbrowser.com/image/donald-duck/29-1.jpg', '', '741df930057e34e6d8096d0432ed835a'),
(6, 278, 1324357200, 0, 'e4da3b7fbbce2345d7772b0674a318d5', '1234567890', 'Leonardo: He was Awesome!', 'Oliver Spryn the Great', '1st', 4, '101', 'D', '149.99', 'Excellent', 'No', 'Awesomeness is commin'' to town!', 'http://www.coverbrowser.com/image/donald-duck/26-1.jpg', '', '4af148afce0ba964bc11b26d5bea7f09'),
(7, 278, 1324357200, 0, '1679091c5a880faf6fb5e6087eb1b2dc', '1234567890', 'Leonardo: He was Awesome!', 'Oliver Spryn the Great', '1st', 4, '101', 'A', '149.99', 'Excellent', 'No', 'Awesomeness is commin'' to town!', 'http://www.coverbrowser.com/image/super-team-family/1-1.jpg', '', 'c10b946bc4acb6db9fabc87cb110a8ca'),
(8, 278, 1324357200, 0, '8f14e45fceea167a5a36dedd4bea2543', '1234567890', 'Leonardo: He was Awesome!', 'Oliver Spryn the Great', '1st', 4, '201', 'N', '149.99', 'Excellent', 'No', 'Awesomeness is commin'' to town!', 'http://www.coverbrowser.com/image/super-team-family/3-1.jpg', '', 'e8456a4b61602ecfde63ebd211bf42fb'),
(9, 0, 1324357200, 0, 'c9f0f895fb98ab9159f51fd0297e236d', '1234567890', 'Leonardo: He was Awesome!', 'Oliver Spryn the Great', '1st', 4, '101', 'A', '149.99', 'Excellent', 'No', 'Awesomeness is commin'' to town!', 'http://www.coverbrowser.com/image/super-team-family/8-1.jpg', '', '84691ecd8a38f140ab924da388df6a6b'),
(10, 278, 1324357200, 0, '45c48cce2e2d7fbdea1afc51c7c6ad26', '1234567890', 'Leonardo: He was Awesome!', 'Oliver Spryn the Great', '1st', 4, '101', 'A', '149.99', 'Excellent', 'No', 'Awesomeness is commin'' to town!', 'http://www.coverbrowser.com/image/super-team-family/13-1.jpg', '', 'cc73ec397e376d4d917dd254e6ec90f6'),
(11, 278, 1324357200, 0, 'd3d9446802a44259755d38e6d163e820', '1234567890', 'Leonardo: He was Awesome!', 'Oliver Spryn the Great', '1st', 4, '127', 'A', '149.99', 'Excellent', 'No', 'Awesomeness is commin'' to town!', 'http://www.coverbrowser.com/image/almanaque-disney/3-1.jpg', '', 'f226d1301aa7d38c886715d28a9ea023'),
(12, 278, 1340494508, 0, '6512bd43d9caa6e02c990b0a82652dca', '1234567890', 'Leonardo: He was Uncool!', 'Oliver Spryn the Great', '1st', 4, '201', 'G', '149.99', 'Excellent', 'No', 'Awesomeness is commin'' to town!', 'http://www.coverbrowser.com/image/captain-america-2004/4-1.jpg', '', '97fafdedbfa0f0c205c6b39966bd3ac0'),
(13, 278, 1324357200, 0, 'c20ad4d76fe97759aa27a0c99bff6710', '1234567890', 'Leonardo: He was Uncool!', 'Oliver Spryn the Great', '1st', 4, '127', 'A', '149.99', 'Excellent', 'No', 'Awesomeness is commin'' to town!', 'http://www.coverbrowser.com/image/uncle-scrooge/6-1.jpg', '', 'a850bf2db5d50f37c333deb6166e2c09'),
(14, 278, 1324357200, 0, 'c51ce410c124a10e0db5e4b97fc2af39', '1234567890', 'Leonardo: He was Uncool!', 'Oliver Spryn the Great', '1st', 4, '127', 'F', '149.99', 'Excellent', 'No', 'Awesomeness is commin'' to town!', 'http://www.coverbrowser.com/image/uncle-scrooge/9-1.jpg', '', '786012d5f6a5db468bb5b7dce1e5f7e8'),
(15, 278, 1324357200, 0, 'aab3238922bcc25a6f606eb525ffdc56', '1234567890', 'Leonardo: He was Uncool!', 'Oliver Spryn the Great', '1st', 4, '201', 'G', '149.99', 'Excellent', 'No', 'Awesomeness is commin'' to town!', 'http://www.coverbrowser.com/image/uncle-scrooge/12-1.jpg', '', '0795b24e75c97b11592515b53de92571'),
(16, 278, 1324357200, 0, '9bf31c7ff062936a96d3c8bd1f8f2ff3', '1234567890', 'Leonardo: He was Uncool!', 'Oliver Spryn the Great', '1st', 4, '102', 'I', '149.99', 'Excellent', 'No', 'Awesomeness is commin'' to town!', 'http://www.coverbrowser.com/image/uncle-scrooge/20-1.jpg', '', '4822bd141d107589ec2e1ee59ba4e2ae'),
(17, 278, 1324357200, 0, 'c74d97b01eae257e44aa9d5bade97baf', '1234567890', 'Leonardo: He was the Most Average Joe You''d Ever Meet in Your Entire Existance', 'Oliver Spryn the Great', '1st', 4, '102', 'B', '149.99', 'Excellent', 'No', 'Awesomeness is commin'' to town!', 'http://www.coverbrowser.com/image/uncle-scrooge/23-1.jpg', '', '3f92abfaf047b62280b7f9e596193e92'),
(18, 278, 1324357200, 0, '70efdf2ec9b086079795c442636b55fb', '1234567890', 'Leonardo: He was the Most Average Joe You''d Ever Meet in Your Entire Existance', 'Oliver Spryn the Great', '1st', 4, '202', 'A', '149.99', 'Excellent', 'No', 'Awesomeness is commin'' to town!', 'http://www.coverbrowser.com/image/uncle-scrooge/26-1.jpg', '', 'e0a9a5dadc99bb329f07dd2bb1a4e9e0'),
(23, 278, 1338777581, 0, '4c40942ca253dcd79ecb8691484cdd58', '741424282', 'the long walk home', 'anatole kurdsjuk', '', 15, '221', 'C', '10.00', 'Very Good', 'No', '<p>very good book</p>', 'http://ecx.images-amazon.com/images/I/41ascOiF3AL.jpg?gdapi', '', '71fbe7390dc1436ab53c1a19e5f7349f'),
(24, 278, 1339391947, 0, '4cdee8e4cd621e1c8924af0156532e60', '73853532', 'The Pennsylvania Turnpike', 'Mitchell E. Dakelman, Neal A. Schorr', '', 25, '323', 'C', '14.99', 'Excellent', 'No', '', 'http://i.ebayimg.com/00/s/NTAwWDM1MQ==/%24%28KGrHqJ,%21noE-z%29J%29NILBPu%29GsoemQ%7E%7E60_1.JPG?set_id=8800005007', '', 'f90f67e8b9e86ed9286e4104616f3097'),
(25, 278, 1339453221, 0, '6e5f6e95fe22582b1d8766f00d4bfc2b', '1111426732', 'Calculus', 'James Stewart', 'Hybrid Edition', 1, '161', 'C', '75.99', 'Excellent', 'No', '<p>I made a few marginal notes in the beginning of chapter 1. It is not a hard cover book, and I accidentally made a crease line across the back cover of the book. In every other respect, this book is as good as new. It also includes the Webassign access card.</p>', 'http://images.bookbyte.com/isbn.aspx?isbn=9781111426736', '', '9b27e119920b6a27dc2b458e382830a8'),
(26, 278, 1339453221, 0, '6e5f6e95fe22582b1d8766f00d4bfc2b', '1111426732', 'Calculus', 'James Stewart', 'Hybrid Edition', 1, '162', 'D', '75.99', 'Very Good', 'Yes', '<p>I made a few marginal notes in the beginning of chapter 1. It is not a hard cover book, and I accidentally made a crease line across the back cover of the book. In every other respect, this book is as good as new. It also includes the Webassign access card.</p>', 'http://images.bookbyte.com/isbn.aspx?isbn=9781111426736', '', '9b27e119920b6a27dc2b458e382830a8'),
(27, 278, 1339453221, 0, '6e5f6e95fe22582b1d8766f00d4bfc2b', '1111426732', 'Calculus', 'James Stewart', 'Hybrid Edition', 1, '262', 'C', '75.99', 'Very Good', 'Yes', '<p>I made a few marginal notes in the beginning of chapter 1. It is not a hard cover book, and I accidentally made a crease line across the back cover of the book. In every other respect, this book is as good as new. It also includes the Webassign access card.</p>', 'http://images.bookbyte.com/isbn.aspx?isbn=9781111426736', '', 'aa0fb0510cccf42fd6e25a71c2a7c370'),
(28, 278, 1339454560, 0, '7c05ff61ff9472c2ad65fd831a4f5b46', '1111426732', 'Calculus', 'James Stewart', 'Hybrid Edition', 1, '161', 'C', '49.99', 'Very Good', 'Yes', '', 'http://images.bookbyte.com/isbn.aspx?isbn=9781111426736', '', '70d7bd2ecde095f05b03985526c5a8e4'),
(29, 278, 1339454560, 0, '7c05ff61ff9472c2ad65fd831a4f5b46', '1111426732', 'Calculus', 'James Stewart', 'Hybrid Edition', 1, '162', 'D', '49.99', 'Very Good', 'Yes', '', 'http://images.bookbyte.com/isbn.aspx?isbn=9781111426736', '', '80baf3055f59a3f0fb258d886c01e7d7'),
(30, 278, 1339454560, 0, '7c05ff61ff9472c2ad65fd831a4f5b46', '1111426732', 'Calculus', 'James Stewart', 'Hybrid Edition', 1, '262', 'C', '49.99', 'Very Good', 'Yes', '', 'http://images.bookbyte.com/isbn.aspx?isbn=9781111426736', '', 'b98a9397f88b3138fedaf83484933b0c'),
(31, 278, 1339455754, 0, 'e87986d463b1883fbd825eea0e17d025', '763776467', 'Computer Science Illuminated', 'Nell Dale, John Lewis', 'Fourth Edition', 10, '141', 'A', '14.99', 'Good', 'Yes', '<p>LOTS of comments in here. They should be helpful.</p>', 'http://www.saanjhi.com/images/products/large/9780763776466.jpg', '', 'cfdcc362ef5939509e3f8811e468d27b'),
(32, 278, 1339456542, 0, 'b41d6cb7d8adce7a63f28ddb53757852', '1111426732', 'Calculus', 'James Stewart', 'Hybrid Edition', 1, '161', 'C', '59.99', 'Very Good', 'Yes', '', 'http://images.bookbyte.com/isbn.aspx?isbn=9781111426736', '', 'c5d0d1f2278152ce59895d6b01d0f7ef'),
(33, 278, 1339456542, 0, 'b41d6cb7d8adce7a63f28ddb53757852', '1111426732', 'Calculus', 'James Stewart', 'Hybrid Edition', 1, '162', 'D', '59.99', 'Very Good', 'Yes', '', 'http://images.bookbyte.com/isbn.aspx?isbn=9781111426736', '', 'c5d0d1f2278152ce59895d6b01d0f7ef'),
(34, 278, 1339456542, 0, 'b41d6cb7d8adce7a63f28ddb53757852', '1111426732', 'Calculus', 'James Stewart', 'Hybrid Edition', 1, '262', 'C', '59.99', 'Very Good', 'Yes', '', 'http://images.bookbyte.com/isbn.aspx?isbn=9781111426736', '', 'c5d0d1f2278152ce59895d6b01d0f7ef'),
(38, 278, 1339694212, 0, '1cfbc56ab506a499ce635e260de379a8', '1234567890', 'Leonardo: He was Awesome!', 'Oliver Spryn the Great', '1st', 4, '101', 'A', '149.99', 'Very Good', 'No', '', 'http://www.coverbrowser.com/image/almanaque-disney/14-1.jpg', '', 'fcabb483c770a0532330f738c023cf56'),
(39, 278, 1339694225, 0, 'd8eb62b8ba4c279fdbfad11344643a77', '1234567890', 'Leonardo: He was Awesome!', 'Oliver Spryn the Great', '1st', 4, '101', 'A', '149.99', 'Very Good', 'No', '', 'http://www.coverbrowser.com/image/almanaque-disney/20-1.jpg', '', '9dc9aaf6cb9cc0eb63afdc71fb54ba92'),
(40, 278, 1339771282, 0, '31e0110d0ca29d0044ee66d8b39f88c6', '740750054', 'Driving Under the Influence of Children', 'Rick Kirkman, Jerry Scott', '', 4, '101', 'A', '14.99', 'Very Good', 'No', '', 'http://i.ebayimg.com/00/%24%28KGrHqYOKjQE3%21lkJ-%29rBNzZ%29gZYJg%7E%7E0_1.JPG?set_id=8800005007', '', 'a4b1b1e046dbaf0941b1f93d606b314f'),
(41, 278, 1339771344, 0, '37fa59fef280c868134917e7709e8219', '7183844', 'Collins Thesaurus A-Z', 'Collins', '', 4, '101', 'A', '9.99', 'Very Good', 'No', '', 'http://ecx.images-amazon.com/images/I/31kUJo5v6-L.jpg?gdapi', '', 'b72fa81cd4dd7ab31d4fcb019bb2c79d'),
(42, 278, 1339771438, 0, 'bccd7fb9a5fa43a939916f39ffc2eca2', '740761943', 'Baby Blues Framed!', 'Rick Kirkman, Jerry Scott', '', 4, '101', 'A', '14.99', 'Fair', 'No', '', 'http://ecx.images-amazon.com/images/I/61Y0gx%2BO18L.jpg?gdapi', '', '6d6dae25f4d6e111c55baa475bf444be'),
(43, 278, 1339771514, 0, 'aa0f44d3b553412f90a9322dcc12ec89', '740700081', 'Ten Years and Still In Diapers', 'Rick Kirkman, Jerry Scott', '', 4, '101', 'A', '14.99', 'Fair', 'No', '', 'http://ecx.images-amazon.com/images/I/51VVlTDAtlL.jpg?aWQ9MDc0MDcwMDA4MSZwZD0xOTk5LTA4LTAxJmJkPVBhcGVyYmFjayZhdT0iSmVycnkgU2NvdHQiLCIgUmljayBLaXJrbWFuIiZ0aT0mc2k9', '', '1f1c5331eb83b3f68f443b97db885b85'),
(44, 278, 1339771605, 1, '74f0887e0498b516006c0c355e35565e', '2147483647', 'Destination Moon', 'Rod Pyle', '', 4, '101', 'A', '7.99', 'Excellent', 'No', '', 'http://images.bookbyte.com/isbn.aspx?isbn=9780060873493', '', 'ba860aa5ab4db00e0b09a4662c7e3a28'),
(45, 278, 1340241165, 0, '39bfc208e0bfffaf7d0c788bd37adf57', '764560204', 'Teach Yourself the Internet and World Wide Web Visually', 'maranGraphics', '', 10, '101', 'A', '4.99', 'Excellent', 'No', '', 'http://www.qualitybargainmall.com/image/?sku=7733625', '', '1583e96ca3fb268b6892f9faa202e92c'),
(46, 0, 1340304991, 0, '5c47c405ab6f29313df4b4b9de027e39', '764560204', 'Teach Yourself the Internet and World Wide Web Visually', 'maranGraphics', '', 10, '101', 'A', '4.99', 'Very Good', 'No', '', 'http://www.qualitybargainmall.com/image/?sku=7733625', '', '1583e96ca3fb268b6892f9faa202e92c'),
(47, 278, 1340305080, 0, '104136fbb6b5a233e613b49aebd5ddb2', '0738535176', 'Butler County', 'Larry D. Parisi', '', 25, '323', 'C', '7.99', 'Very Good', 'No', '', 'http://localhost/SGA/book-exchange/system/images/icons/default_book.png', 'http://ecx.images-amazon.com/images/I/51oYh4HWDWL.jpg?aWQ9MDczODUzNTE3NiZwZD0yMDA0LTAzLTAxJmJkPVBhcGVyYmFjayZhdT0iTGFycnkgRC4gUGFyaXNpIiZ0aT0mc2k9', 'cc52c0c5349726a477308e1c8c359c9a'),
(48, 278, 1340305656, 0, 'b7041a002bdaca0cc5f817fa0331f7fd', '0738535176', 'Butler County', 'Larry D. Parisi', '', 25, '323', 'C', '7.99', 'Very Good', 'No', '', 'http://localhost/SGA/book-exchange/system/images/icons/default_book.png', 'http://ecx.images-amazon.com/images/I/51oYh4HWDWL.jpg?aWQ9MDczODUzNTE3NiZwZD0yMDA0LTAzLTAxJmJkPVBhcGVyYmFjayZhdT0iTGFycnkgRC4gUGFyaXNpIiZ0aT0mc2k9', 'f1ba5433409f95b59efe60b11dd45b0f'),
(55, 278, 1340305726, 0, '308dd1905871cac5de55b5be61c63649', '073853532X', 'The Pennsylvania Turnpike - Images of America', 'Mitchell E. Dakelman and Neal A. Schorr', '', 25, '107', 'P', '19.99', 'Very Good', 'No', '<p>Test</p>', 'http://i.ebayimg.com/00/s/NTAwWDM1MQ==/%24%28KGrHqJ,%21noE-z%29J%29NILBPu%29GsoemQ%7E%7E60_1.JPG?set_id=8800005007', '', 'f90f67e8b9e86ed9286e4104616f3097');

-- --------------------------------------------------------

--
-- Table structure for table `collaboration`
--

CREATE TABLE IF NOT EXISTS "collaboration" (
  "id" int(11) NOT NULL,
  "position" int(11) NOT NULL,
  "visible" text NOT NULL,
  "type" text NOT NULL,
  "fromDate" longtext NOT NULL,
  "fromTime" longtext NOT NULL,
  "toDate" longtext NOT NULL,
  "toTime" longtext NOT NULL,
  "title" longtext NOT NULL,
  "content" longtext NOT NULL,
  "assignee" longtext NOT NULL,
  "task" longtext NOT NULL,
  "description" longtext NOT NULL,
  "dueDate" longtext NOT NULL,
  "priority" longtext NOT NULL,
  "completed" longtext NOT NULL,
  "directories" longtext NOT NULL,
  "questions" longtext NOT NULL,
  "responses" longtext NOT NULL,
  "name" longtext NOT NULL,
  "date" longtext NOT NULL,
  "comment" longtext NOT NULL,
  PRIMARY KEY ("id")
) AUTO_INCREMENT=140 ;

--
-- Dumping data for table `collaboration`
--

INSERT INTO `collaboration` (`id`, `position`, `visible`, `type`, `fromDate`, `fromTime`, `toDate`, `toTime`, `title`, `content`, `assignee`, `task`, `description`, `dueDate`, `priority`, `completed`, `directories`, `questions`, `responses`, `name`, `date`, `comment`) VALUES
(136, 1, 'on', 'Announcement', '', '', '', '', 'This is serious!!!', '<p><span style="background-color: #ffff00;">Pay attention!!!!!!</span></p>', '', '', '', '', '', '', '', '', '', '', '', ''),
(139, 2, 'on', 'Agenda', '04/17/2012', '12:00', '04/24/2012', '12:00', 'Agenda this Week', '<p>Please look at the agenda below for our to-do list:</p>', 'a:2:{i:0;s:30:"Anyone, Everyone, Oliver Spryn";i:1;s:12:"Oliver Spryn";}', 'a:2:{i:0;s:26:"Complete the Sign-Up Sheet";i:1;s:6:"Task 2";}', 'a:2:{i:0;s:66:"Please place this on Google Docs when you are finished! Thank you!";i:1;s:0:"";}', 'a:2:{i:0;s:0:"";i:1;s:10:"04/18/2012";}', 'a:2:{i:0;s:1:"1";i:1;s:1:"3";}', 'a:2:{i:0;s:4:"true";i:1;s:4:"true";}', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `dailyhits`
--

CREATE TABLE IF NOT EXISTS "dailyhits" (
  "id" int(255) NOT NULL,
  "date" varchar(255) NOT NULL,
  "hits" int(255) NOT NULL,
  PRIMARY KEY ("id")
) AUTO_INCREMENT=605 ;

--
-- Dumping data for table `dailyhits`
--

INSERT INTO `dailyhits` (`id`, `date`, `hits`) VALUES
(564, 'Mar-24-2012', 2),
(565, 'Mar-25-2012', 7),
(566, 'Mar-27-2012', 68),
(567, 'Mar-28-2012', 63),
(568, 'Mar-31-2012', 1),
(569, 'Apr-06-2012', 49),
(570, 'Apr-12-2012', 32),
(571, 'Apr-13-2012', 3),
(572, 'Apr-14-2012', 2),
(573, 'Apr-15-2012', 1),
(574, 'Apr-16-2012', 1),
(575, 'Apr-17-2012', 1),
(576, 'Apr-18-2012', 1),
(577, 'Apr-19-2012', 8),
(578, 'Apr-21-2012', 7),
(579, 'Apr-24-2012', 3),
(580, 'Apr-25-2012', 1),
(581, 'May-21-2012', 25),
(582, 'May-22-2012', 2),
(583, 'May-23-2012', 1),
(584, 'May-24-2012', 14),
(585, 'May-26-2012', 5),
(586, 'May-27-2012', 5),
(587, 'May-29-2012', 1),
(588, 'May-30-2012', 1),
(589, 'Jun-02-2012', 2),
(590, 'Jun-10-2012', 42),
(591, 'Jun-11-2012', 96),
(592, 'Jun-12-2012', 3),
(593, 'Jun-13-2012', 6),
(594, 'Jun-14-2012', 3),
(595, 'Jun-15-2012', 1),
(596, 'Jun-16-2012', 1),
(597, 'Jun-18-2012', 8),
(598, 'Jun-19-2012', 1),
(599, 'Jun-20-2012', 15),
(600, 'Jun-21-2012', 1),
(601, 'Jun-22-2012', 2),
(602, 'Jun-24-2012', 15),
(603, 'Jun-25-2012', 74),
(604, 'Jun-26-2012', 58);

-- --------------------------------------------------------

--
-- Table structure for table `exchangesettings`
--

CREATE TABLE IF NOT EXISTS "exchangesettings" (
  "id" int(11) NOT NULL,
  "expires" int(11) NOT NULL,
  PRIMARY KEY ("id")
) AUTO_INCREMENT=2 ;

--
-- Dumping data for table `exchangesettings`
--

INSERT INTO `exchangesettings` (`id`, `expires`) VALUES
(1, 15724800);

-- --------------------------------------------------------

--
-- Table structure for table `external`
--

CREATE TABLE IF NOT EXISTS "external" (
  "id" int(255) NOT NULL,
  "position" int(11) NOT NULL,
  "visible" text NOT NULL,
  "published" int(1) NOT NULL,
  "display" int(1) NOT NULL,
  "content1" longtext NOT NULL,
  "content2" longtext NOT NULL,
  "content3" longtext NOT NULL,
  "content4" longtext NOT NULL,
  "content5" longtext NOT NULL,
  "content6" longtext NOT NULL,
  "content7" longtext NOT NULL,
  "content8" longtext NOT NULL,
  "content9" longtext NOT NULL,
  "content10" longtext NOT NULL,
  "content11" longtext NOT NULL,
  "content12" longtext NOT NULL,
  PRIMARY KEY ("id")
) AUTO_INCREMENT=30 ;

--
-- Dumping data for table `external`
--


-- --------------------------------------------------------

--
-- Table structure for table `failedlogins`
--

CREATE TABLE IF NOT EXISTS "failedlogins" (
  "id" int(11) NOT NULL,
  "timeStamp" longtext NOT NULL,
  "computerName" longtext NOT NULL,
  "userName" longtext NOT NULL,
  PRIMARY KEY ("id")
) AUTO_INCREMENT=5 ;

--
-- Dumping data for table `failedlogins`
--

INSERT INTO `failedlogins` (`id`, `timeStamp`, `computerName`, `userName`) VALUES
(1, '1340660604', '2CE13206FM.GCC.edu', 'wot200@gmail.com'),
(2, '1340660617', '2CE13206FM.GCC.edu', 'wot200@gmail.com'),
(3, '1340660624', '2CE13206FM.GCC.edu', 'wot200@gmail.com'),
(4, '1340677695', '2CE13206FM.GCC.edu', 'wot200@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `pagehits`
--

CREATE TABLE IF NOT EXISTS "pagehits" (
  "id" int(1) NOT NULL,
  "page" varchar(255) NOT NULL,
  "hits" int(255) NOT NULL,
  PRIMARY KEY ("id")
) AUTO_INCREMENT=140 ;

--
-- Dumping data for table `pagehits`
--

INSERT INTO `pagehits` (`id`, `page`, `hits`) VALUES
(130, '123', 428),
(131, '124', 18),
(132, '125', 64),
(133, '128', 2),
(134, '127', 10),
(135, '130', 24),
(136, '131', 17),
(137, '132', 46),
(138, '126', 12),
(139, '129', 2);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS "pages" (
  "id" int(255) NOT NULL,
  "type" varchar(4) NOT NULL,
  "linkTitle" longtext NOT NULL,
  "locked" int(1) NOT NULL,
  "URL" longtext NOT NULL,
  "position" int(11) NOT NULL,
  "parentPage" int(11) NOT NULL,
  "subPosition" int(11) NOT NULL,
  "visible" text NOT NULL,
  "published" int(1) NOT NULL,
  "display" longtext NOT NULL,
  "content1" longtext NOT NULL,
  PRIMARY KEY ("id")
) AUTO_INCREMENT=138 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `type`, `linkTitle`, `locked`, `URL`, `position`, `parentPage`, `subPosition`, `visible`, `published`, `display`, `content1`) VALUES
(123, 'page', '', 0, '', 1, 0, 0, 'on', 2, '1', 'a:7:{s:5:"title";s:4:"Test";s:7:"content";s:11:"<p>test</p>";s:8:"comments";s:1:"0";s:7:"message";s:0:"";s:4:"user";s:3:"278";s:4:"time";i:1332875470;s:7:"changes";s:1:"1";}'),
(124, 'page', '', 0, '', 2, 0, 0, 'on', 2, '1', 'a:7:{s:5:"title";s:10:"More stuff";s:7:"content";s:9:"<p>hi</p>";s:8:"comments";s:1:"0";s:7:"message";s:0:"";s:4:"user";s:3:"278";s:4:"time";i:1332876729;s:7:"changes";s:1:"1";}'),
(125, 'page', '', 0, '', 0, 123, 1, 'on', 2, '1', 'a:7:{s:5:"title";s:25:"We are going to the store";s:7:"content";s:19:"<p>Yes, we are.</p>";s:8:"comments";s:1:"0";s:7:"message";s:0:"";s:4:"user";s:3:"278";s:4:"time";i:1332893714;s:7:"changes";s:1:"1";}'),
(126, 'page', '', 0, '', 0, 123, 2, 'on', 2, '1', 'a:7:{s:5:"title";s:27:"It''s Wal-Mart to be percise";s:7:"content";s:18:"<p>Yes, it is.</p>";s:8:"comments";s:1:"0";s:7:"message";s:0:"";s:4:"user";s:3:"278";s:4:"time";i:1332894467;s:7:"changes";s:1:"1";}'),
(127, 'page', '', 0, '', 0, 123, 3, 'on', 2, '1', 'a:7:{s:5:"title";s:21:"Or was it Sam''s Club?";s:7:"content";s:17:"<p>Don''t know</p>";s:8:"comments";s:1:"0";s:7:"message";s:0:"";s:4:"user";s:3:"278";s:4:"time";i:1332894482;s:7:"changes";s:1:"1";}'),
(128, 'page', '', 0, '', 0, 124, 1, 'on', 2, '1', 'a:7:{s:5:"title";s:7:"Whateve";s:7:"content";s:9:"<p>*r</p>";s:8:"comments";s:1:"0";s:7:"message";s:0:"";s:4:"user";s:3:"278";s:4:"time";i:1332894605;s:7:"changes";s:1:"1";}'),
(129, 'page', '', 0, '', 0, 124, 2, 'on', 2, '1', 'a:7:{s:5:"title";s:3:"Yes";s:7:"content";s:19:"<p>So, whatever</p>";s:8:"comments";s:1:"0";s:7:"message";s:0:"";s:4:"user";s:3:"278";s:4:"time";i:1332894622;s:7:"changes";s:1:"1";}'),
(130, 'page', '', 0, '', 0, 125, 1, 'on', 2, '1', 'a:7:{s:5:"title";s:12:"Which store?";s:7:"content";s:18:"<p>HIH???* HUH</p>";s:8:"comments";s:1:"0";s:7:"message";s:0:"";s:4:"user";s:3:"278";s:4:"time";i:1332948461;s:7:"changes";s:1:"1";}'),
(131, 'page', '', 0, '', 0, 130, 1, 'on', 2, '1', 'a:7:{s:5:"title";s:5:"Title";s:7:"content";s:14:"<p>Content</p>";s:8:"comments";s:1:"0";s:7:"message";s:0:"";s:4:"user";s:3:"278";s:4:"time";i:1332948894;s:7:"changes";s:1:"1";}'),
(132, 'page', '', 0, '', 0, 131, 1, 'on', 2, '1', 'a:7:{s:5:"title";s:10:"More stuff";s:7:"content";s:11:"<p>Nice</p>";s:8:"comments";s:1:"1";s:7:"message";s:0:"";s:4:"user";s:3:"278";s:4:"time";i:1332948906;s:7:"changes";s:1:"1";}'),
(133, 'link', 'Book Exchange', 0, 'http://localhost/SGA/book-exchange/', 3, 0, 1, 'on', 1, '1', ''),
(134, 'link', 'Search Books', 0, 'http://localhost/SGA/book-exchange/search/', 0, 133, 2, 'on', 1, '1', ''),
(135, 'link', 'Book Categories', 0, 'http://localhost/SGA/book-exchange/listings/', 0, 133, 3, 'on', 1, '1', ''),
(136, 'link', 'Sell Books', 1, 'http://localhost/SGA/book-exchange/sell-books/', 0, 133, 4, 'on', 1, '1', ''),
(137, 'link', 'View my Books', 1, 'http://localhost/SGA/book-exchange/account/', 0, 133, 4, 'on', 1, '1', '');

-- --------------------------------------------------------

--
-- Table structure for table `privileges`
--

CREATE TABLE IF NOT EXISTS "privileges" (
  "id" int(1) NOT NULL,
  "deleteFile" int(1) NOT NULL,
  "uploadFile" int(1) NOT NULL,
  "deleteForumComments" int(1) NOT NULL,
  "sendEmail" int(1) NOT NULL,
  "viewStaffPage" int(1) NOT NULL,
  "createStaffPage" int(1) NOT NULL,
  "editStaffPage" int(1) NOT NULL,
  "deleteStaffPage" int(1) NOT NULL,
  "publishStaffPage" int(1) NOT NULL,
  "addStaffComments" int(1) NOT NULL,
  "deleteStaffComments" int(1) NOT NULL,
  "createPage" int(1) NOT NULL,
  "editPage" int(1) NOT NULL,
  "deletePage" int(1) NOT NULL,
  "publishPage" int(1) NOT NULL,
  "createSideBar" int(1) NOT NULL,
  "editSideBar" int(1) NOT NULL,
  "deleteSideBar" int(1) NOT NULL,
  "publishSideBar" int(1) NOT NULL,
  "siteSettings" int(1) NOT NULL,
  "sideBarSettings" int(1) NOT NULL,
  "deleteComments" int(1) NOT NULL,
  "createExternal" int(1) NOT NULL,
  "editExternal" int(1) NOT NULL,
  "deleteExternal" int(1) NOT NULL,
  "publishExternal" int(1) NOT NULL,
  "viewStatistics" int(1) NOT NULL,
  "autoEmail" int(1) NOT NULL
);

--
-- Dumping data for table `privileges`
--


-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE IF NOT EXISTS "purchases" (
  "id" int(11) NOT NULL COMMENT 'The ID of the purchase transaction',
  "buyerID" int(11) NOT NULL COMMENT 'The ID of the user who made this purchase',
  "sellerID" int(11) NOT NULL COMMENT 'The ID of the seller',
  "bookID" int(11) NOT NULL COMMENT 'The ID of the book that was purcahsed',
  "time" int(11) NOT NULL COMMENT 'The time at which the transaction took place',
  PRIMARY KEY ("id")
) AUTO_INCREMENT=2 ;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `buyerID`, `sellerID`, `bookID`, `time`) VALUES
(1, 278, 278, 44, 1340452924);

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE IF NOT EXISTS "question" (
  "id" int(11) NOT NULL COMMENT 'Holds the primary key of a question',
  "timeStart" int(10) NOT NULL COMMENT 'The start day of the question''s duration',
  "timeEnd" int(10) NOT NULL COMMENT 'The end day of the question''s duration',
  "title" longtext NOT NULL COMMENT 'A brief title for the question',
  "question" longtext NOT NULL COMMENT 'The text of the question',
  "responseValue" longtext NOT NULL COMMENT 'The total number of responses to a question',
  "responses" longtext NOT NULL COMMENT 'The responses received for each question',
  PRIMARY KEY ("id")
) AUTO_INCREMENT=4 ;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`id`, `timeStart`, `timeEnd`, `title`, `question`, `responseValue`, `responses`) VALUES
(1, 1334440800, 1335045600, 'This is our question.', '<p>\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent quis dui a elit interdum molestie vitae a erat. In sit amet turpis a ligula fringilla dapibus. Nulla congue condimentum sem, non scelerisque elit tempor vel. Nullam metus metus, volutpat porttitor auctor in, suscipit ac quam. Vestibulum suscipit molestie malesuada. In hac habitasse platea dictumst. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Mauris auctor egestas quam, ac scelerisque velit mattis a. Nulla ac venenatis quam. Fusce at nisl in magna imperdiet scelerisque. Phasellus interdum fringilla est vel sodales. Mauris dapibus nulla nibh. Vestibulum orci sem, lobortis ut adipiscing vel, tincidunt non ante. Vivamus augue ligula, venenatis rutrum porta quis, rutrum eget urna. Donec tincidunt nibh vel nisi placerat vitae posuere metus posuere. In libero elit, adipiscing ut pretium in, porta quis ipsum.\r\n</p>\r\n<p>\r\nFusce vestibulum rutrum metus a aliquam. Sed vitae augue magna, a placerat enim. Duis in eros nisl, a suscipit lectus. Integer ac tellus quis erat lobortis feugiat eget ac urna. Duis nunc libero, vehicula vitae consequat at, tempor non ipsum. Phasellus leo urna, porta et vestibulum pellentesque, volutpat non massa. Suspendisse vel enim mauris, et gravida erat.\r\n</p>\r\n<p>\r\nAliquam tincidunt lobortis eros, at commodo eros semper ac. Curabitur dignissim, sapien sit amet hendrerit bibendum, odio lorem sollicitudin elit, id pretium arcu orci at eros. Nunc molestie, eros eu euismod dictum, risus leo imperdiet nulla, ut vestibulum libero massa sed diam. Vestibulum sit amet congue ante. Nullam ut tellus libero, a sagittis sapien. Vivamus rhoncus lacinia gravida. Vestibulum vitae est at arcu molestie ultrices vel mattis risus. Donec malesuada vehicula nisi et cursus. Cras nec imperdiet mi. Donec vitae ligula pulvinar velit tempor sodales. Integer massa lacus, sollicitudin quis pretium in, accumsan sit amet quam. Duis dolor felis, ultrices id facilisis eu, congue non erat. Nulla facilisi. Mauris imperdiet orci sit amet nisl ultricies nec pharetra ligula imperdiet. In hac habitasse platea dictumst. Morbi ut libero posuere elit tristique adipiscing a ac magna.\r\n</p>\r\n<p>\r\nPhasellus sapien velit, hendrerit at laoreet vitae, lacinia in dui. Maecenas tincidunt mauris et augue sagittis eget rutrum dolor iaculis. Integer sem velit, dapibus eu faucibus id, pulvinar sit amet velit. In et turpis lectus. In in quam id ipsum vulputate congue. Praesent facilisis metus sed urna mollis in condimentum ligula adipiscing. Curabitur tincidunt tempor mi, id adipiscing dolor porttitor eget. Etiam blandit tempus interdum. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec massa leo, hendrerit ut placerat vehicula, gravida ac risus. Aenean ornare congue felis quis hendrerit. Mauris sit amet diam augue. Duis non condimentum quam. Quisque consequat tortor odio. Etiam ornare risus sit amet nibh euismod lacinia.\r\n</p>\r\n<p>\r\nVestibulum in odio odio, nec fermentum diam. Vivamus sed erat ipsum, quis lobortis tortor. Nunc eget feugiat dui. Morbi ornare, arcu ut vulputate mattis, lectus mi ullamcorper turpis, non accumsan velit tortor at neque. Suspendisse quis mi metus. Aliquam congue imperdiet nibh, sit amet venenatis felis ornare sit amet. Nunc imperdiet mattis dui non pellentesque. Quisque sit amet elit quam, et faucibus mi. Donec in varius augue. Fusce vulputate turpis dictum arcu fringilla tristique.\r\n</p>', 'a:5:{s:5:"total";s:2:"67";i:1;s:2:"36";i:2;s:2:"12";i:3;s:1:"9";i:4;s:1:"9";}', 'a:10:{i:0;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:1;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:2;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:3;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:4;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:5;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:6;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:7;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:8;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:9;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}}'),
(2, 1333231200, 1333836000, 'Old Question', 'Old answer', 'a:5:{s:5:"total";s:2:"67";i:1;s:2:"36";i:2;s:2:"12";i:3;s:1:"9";i:4;s:1:"9";}', 'a:10:{i:0;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:1;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:2;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:3;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:4;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:5;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:6;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:7;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:8;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:9;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}}'),
(3, 1335823200, 1336428000, 'New Question', 'Stuff', '0', '');

-- --------------------------------------------------------

--
-- Table structure for table `saptcha`
--

CREATE TABLE IF NOT EXISTS "saptcha" (
  "id" int(11) NOT NULL,
  "question" longtext NOT NULL,
  "answer" longtext NOT NULL,
  PRIMARY KEY ("id")
) AUTO_INCREMENT=9 ;

--
-- Dumping data for table `saptcha`
--


-- --------------------------------------------------------

--
-- Table structure for table `sidebar`
--

CREATE TABLE IF NOT EXISTS "sidebar" (
  "id" int(255) NOT NULL,
  "position" int(11) NOT NULL,
  "visible" text NOT NULL,
  "published" int(1) NOT NULL,
  "display" int(1) NOT NULL,
  "type" text NOT NULL,
  "content1" longtext NOT NULL,
  "content2" longtext NOT NULL,
  PRIMARY KEY ("id")
) AUTO_INCREMENT=12 ;

--
-- Dumping data for table `sidebar`
--

INSERT INTO `sidebar` (`id`, `position`, `visible`, `published`, `display`, `type`, `content1`, `content2`) VALUES
(10, 1, 'on', 2, 1, 'Custom Content', 'a:7:{s:5:"title";s:4:"Nice";s:7:"content";s:17:"<p>Who cares?</p>";s:8:"comments";N;s:7:"message";s:0:"";s:4:"user";s:3:"278";s:4:"time";i:1332711701;s:7:"changes";s:1:"1";}', ''),
(11, 2, 'on', 2, 1, 'Login', 'a:7:{s:5:"title";s:5:"Login";s:7:"content";s:30:"<p>Hi, please login below:</p>";s:8:"comments";N;s:7:"message";s:0:"";s:4:"user";s:3:"278";s:4:"time";i:1333763218;s:7:"changes";s:1:"1";}', '');

-- --------------------------------------------------------

--
-- Table structure for table `siteprofiles`
--

CREATE TABLE IF NOT EXISTS "siteprofiles" (
  "id" int(11) NOT NULL,
  "siteName" varchar(200) NOT NULL,
  "paddingTop" tinyint(4) NOT NULL,
  "paddingLeft" tinyint(4) NOT NULL,
  "paddingRight" tinyint(4) NOT NULL,
  "paddingBottom" tinyint(4) NOT NULL,
  "width" int(3) NOT NULL,
  "height" int(3) NOT NULL,
  "sideBar" text NOT NULL,
  "auto" text NOT NULL,
  "siteFooter" text NOT NULL,
  "author" varchar(200) NOT NULL,
  "language" varchar(15) NOT NULL,
  "copyright" varchar(200) NOT NULL,
  "description" varchar(20000) NOT NULL,
  "meta" text NOT NULL,
  "timeZone" varchar(20) NOT NULL,
  "welcome" text NOT NULL,
  "style" varchar(200) NOT NULL,
  "iconType" text NOT NULL,
  "spellCheckerAPI" varchar(50) NOT NULL,
  "saptcha" text NOT NULL,
  "question" longtext NOT NULL,
  "answer" longtext NOT NULL,
  "failedLogins" int(2) NOT NULL,
  PRIMARY KEY ("siteName")
);

--
-- Dumping data for table `siteprofiles`
--

INSERT INTO `siteprofiles` (`id`, `siteName`, `paddingTop`, `paddingLeft`, `paddingRight`, `paddingBottom`, `width`, `height`, `sideBar`, `auto`, `siteFooter`, `author`, `language`, `copyright`, `description`, `meta`, `timeZone`, `welcome`, `style`, `iconType`, `spellCheckerAPI`, `saptcha`, `question`, `answer`, `failedLogins`) VALUES
(1, 'The Bell News Magazine', 0, 0, 0, 0, 260, 180, 'Right', '', '<p>&copy; 2011 The Bell News Magazine</p>', 'The Bell News Magazine', 'en-US', '© 2011 The Bell News Magazine', 'The collaborative, innovative Bell News Magazine', 'The Bell News Magazine, The PAVCS Bell News Magazine, The Pennsylvania Virtual Charter School Bell News Magazine, Pennsylvania Virtual Charter School Bell News Magazine, Bell News Magazine, Bell News, Bell Magazine, The Bell Magazine, The Bell News', 'America/New_York', 'Ads', 'onlineUniversity.css', 'gif', 'jmyppg6c5k5ajtqcra7u4eql4l864mps48auuqliy3cccqrb6b', 'auto', 'What is the school''s principal''s last name?', 'Perney', 5);

-- --------------------------------------------------------

--
-- Table structure for table `staffpages`
--

CREATE TABLE IF NOT EXISTS "staffpages" (
  "id" int(255) NOT NULL,
  "position" int(11) NOT NULL,
  "published" int(1) NOT NULL,
  "display" int(11) NOT NULL,
  "content1" longtext NOT NULL,
  "name" longtext NOT NULL,
  "date" longtext NOT NULL,
  "comment" longtext NOT NULL,
  "content2" longtext NOT NULL,
  "content3" longtext NOT NULL,
  "content4" longtext NOT NULL,
  "content5" longtext NOT NULL,
  "content6" longtext NOT NULL,
  "content7" longtext NOT NULL,
  "content8" longtext NOT NULL,
  "content9" longtext NOT NULL,
  "content10" longtext NOT NULL,
  "content11" longtext NOT NULL,
  "content12" longtext NOT NULL,
  "content13" longtext NOT NULL,
  "content14" longtext NOT NULL,
  "content15" longtext NOT NULL,
  "content16" longtext NOT NULL,
  "content17" longtext NOT NULL,
  "content18" longtext NOT NULL,
  "content19" longtext NOT NULL,
  "content20" longtext NOT NULL,
  "content21" longtext NOT NULL,
  PRIMARY KEY ("id")
) AUTO_INCREMENT=36 ;

--
-- Dumping data for table `staffpages`
--


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS "users" (
  "id" int(50) NOT NULL,
  "active" varchar(20) NOT NULL,
  "activation" varchar(15) NOT NULL,
  "firstName" longtext NOT NULL,
  "lastName" longtext NOT NULL,
  "passWord" longtext NOT NULL,
  "changePassword" text NOT NULL,
  "emailAddress1" longtext NOT NULL,
  "emailAddress2" longtext NOT NULL,
  "emailAddress3" longtext NOT NULL,
  "role" longtext NOT NULL,
  PRIMARY KEY ("id"),
  FULLTEXT KEY "name" ("firstName","lastName")
) AUTO_INCREMENT=283 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `active`, `activation`, `firstName`, `lastName`, `passWord`, `changePassword`, `emailAddress1`, `emailAddress2`, `emailAddress3`, `role`) VALUES
(278, '1332876734', '', 'Oliver', 'Spryn', '*F8F0B5DC76103B96A83887EFC253D4643DED29AF', '', 'wot200@gmail.com', '', '', 'Administrator'),
(282, '1000000000', '', 'Oliver', 'Spryn', '*F8F0B5DC76103B96A83887EFC253D4643DED29AF', '', 'sprynoj1@gcc.edu', '', '', 'User');
