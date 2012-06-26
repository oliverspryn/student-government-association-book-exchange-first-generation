-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 26, 2012 at 09:03 AM
-- Server version: 5.5.8
-- PHP Version: 5.3.5



/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */
/*!40101 SET NAMES utf8 */

--
-- Database: sga
--

-- --------------------------------------------------------

--
-- Table structure for table bookcategories
--

CREATE TABLE bookcategories (
  "id" int NOT NULL,
  "name" NTEXT NOT NULL,
  "course" text NOT NULL,
  "description" NTEXT NOT NULL,
  "color1" varchar(7) NOT NULL,
  "color2" varchar(7) NOT NULL,
  "color3" varchar(7) NOT NULL,
  "textColor" varchar(7) NOT NULL,
  PRIMARY KEY ("id")
);

--
-- Dumping data for table bookcategories
--

INSERT INTO bookcategories (id, name, course, description, color1, color2, color3, textColor) VALUES
(1, 'Mathematics', 'MATH', 'You know + - * /. That kind of stuff.', '#E7D2EF', '#F1E4F5', '#F7EFF9', '');

INSERT INTO bookcategories (id, name, course, description, color1, color2, color3, textColor) VALUES
(2, 'Physics', 'PHYS', 'You know, why stuff works.', '#5F6B79', '', '', '');

INSERT INTO bookcategories (id, name, course, description, color1, color2, color3, textColor) VALUES
(3, 'Accounting', 'ACCT', '', '#26878E', '', '', '');

INSERT INTO bookcategories (id, name, course, description, color1, color2, color3, textColor) VALUES
(4, 'Art', 'ART', '', '#9BCA9C', '#C3DFC4', '#DBECDC', '#9BCA9C');

INSERT INTO bookcategories (id, name, course, description, color1, color2, color3, textColor) VALUES
(5, 'Astronomy', 'ASTR', '', '#899C2D', '', '', '');

INSERT INTO bookcategories (id, name, course, description, color1, color2, color3, textColor) VALUES
(6, 'Biology', 'BIO', '', '#D9A600', '', '', '');

INSERT INTO bookcategories (id, name, course, description, color1, color2, color3, textColor) VALUES
(7, 'Business', 'BUSS', '', '#FECE2C', '', '', '');

INSERT INTO bookcategories (id, name, course, description, color1, color2, color3, textColor) VALUES
(8, 'Chemistry', 'CHEM', '', '#E04749', '', '', '');

INSERT INTO bookcategories (id, name, course, description, color1, color2, color3, textColor) VALUES
(9, 'Chinese', 'CHIN', '', '#B43F76', '', '', '');

INSERT INTO bookcategories (id, name, course, description, color1, color2, color3, textColor) VALUES
(10, 'Computer Science', 'COMP', '', '#B086B6', '', '', '');

INSERT INTO bookcategories (id, name, course, description, color1, color2, color3, textColor) VALUES
(11, 'Economics', 'ECON', '', '#5660C1', '', '', '');

INSERT INTO bookcategories (id, name, course, description, color1, color2, color3, textColor) VALUES
(12, 'Education', 'EDUC', '', '#007ACB', '', '', '');

INSERT INTO bookcategories (id, name, course, description, color1, color2, color3, textColor) VALUES
(13, 'Electrical Engineering', 'EENG', '', '#527591', '', '', '');

INSERT INTO bookcategories (id, name, course, description, color1, color2, color3, textColor) VALUES
(14, 'Engineering', 'ENGR', '', '#5E6C79', '', '', '');

INSERT INTO bookcategories (id, name, course, description, color1, color2, color3, textColor) VALUES
(15, 'English', 'ENGL', '', '#9198AA', '', '', '');

INSERT INTO bookcategories (id, name, course, description, color1, color2, color3, textColor) VALUES
(16, 'Entreprenuership', 'ENTR', '', '#8387AA', '', '', '');

INSERT INTO bookcategories (id, name, course, description, color1, color2, color3, textColor) VALUES
(17, 'Exercise Science', 'ESCI', '', '#978D81', '', '', '');

INSERT INTO bookcategories (id, name, course, description, color1, color2, color3, textColor) VALUES
(18, 'French', 'FREN', '', '#5DDCD3', '', '', '');

INSERT INTO bookcategories (id, name, course, description, color1, color2, color3, textColor) VALUES
(19, 'General Science', 'GSCI', '', '#D9EFD8', '', '', '');

INSERT INTO bookcategories (id, name, course, description, color1, color2, color3, textColor) VALUES
(20, 'Geology', 'GEOL', '', '#C8DD53', '', '', '');

INSERT INTO bookcategories (id, name, course, description, color1, color2, color3, textColor) VALUES
(21, 'German', 'GERM', '', '#D28DFA', '', '', '');

INSERT INTO bookcategories (id, name, course, description, color1, color2, color3, textColor) VALUES
(22, 'Global Studies', 'GLOB', '', '#FECE2C', '', '', '');

INSERT INTO bookcategories (id, name, course, description, color1, color2, color3, textColor) VALUES
(23, 'Greek', 'GREK', '', '#E97802', '', '', '');

INSERT INTO bookcategories (id, name, course, description, color1, color2, color3, textColor) VALUES
(24, 'Hebrew', 'HEBR', '', '#D1692C', '', '', '');

INSERT INTO bookcategories (id, name, course, description, color1, color2, color3, textColor) VALUES
(25, 'History', 'HIST', '', '#48D6FD', '', '', '');

INSERT INTO bookcategories (id, name, course, description, color1, color2, color3, textColor) VALUES
(26, 'Humanities', 'HUMA', '', '#FFAE61', '', '', '');

INSERT INTO bookcategories (id, name, course, description, color1, color2, color3, textColor) VALUES
(27, 'Japanese', 'JAPN', '', '#FB97C9', '', '', '');

INSERT INTO bookcategories (id, name, course, description, color1, color2, color3, textColor) VALUES
(28, 'Mechanical Engineering', 'MECH', '', '#5861BE', '', '', '');

INSERT INTO bookcategories (id, name, course, description, color1, color2, color3, textColor) VALUES
(29, 'Music', 'MUSC', '', '#48D6FD', '', '', '');

INSERT INTO bookcategories (id, name, course, description, color1, color2, color3, textColor) VALUES
(30, 'Philosophy', 'PHIL', '', '#96CCE4', '', '', '');

INSERT INTO bookcategories (id, name, course, description, color1, color2, color3, textColor) VALUES
(31, 'Political Science', 'POLY', '', '#CAD3E2', '', '', '');

INSERT INTO bookcategories (id, name, course, description, color1, color2, color3, textColor) VALUES
(32, 'Psychology', 'PYCH', '', '#C3D1EC', '', '', '');

INSERT INTO bookcategories (id, name, course, description, color1, color2, color3, textColor) VALUES
(33, 'Religion', 'RELI', '', '#D2C9CA', '', '', '');

INSERT INTO bookcategories (id, name, course, description, color1, color2, color3, textColor) VALUES
(34, 'Science Faith & Tech', 'SSFT', '', '#D9D9CF', '', '', '');

INSERT INTO bookcategories (id, name, course, description, color1, color2, color3, textColor) VALUES
(35, 'Sociology', 'SOCI', '', '#3398CB', '', '', '');

INSERT INTO bookcategories (id, name, course, description, color1, color2, color3, textColor) VALUES
(36, 'Spanish', 'SPAN', '', '#98FECB', '', '', '');

INSERT INTO bookcategories (id, name, course, description, color1, color2, color3, textColor) VALUES
(37, 'Special Education', 'SPED', '', '#FE6600', '', '', '');

INSERT INTO bookcategories (id, name, course, description, color1, color2, color3, textColor) VALUES
(38, 'Theater', 'THEA', '', '#986600', '', '', '');

INSERT INTO bookcategories (id, name, course, description, color1, color2, color3, textColor) VALUES
(39, 'Communications', 'COMM', '', '#775390', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table books
--

CREATE TABLE books (
  "id" int NOT NULL,
  "userID" int NOT NULL,
  "upload" int NOT NULL,
  "sold" int NOT NULL,
  "linkID" varchar(32) NOT NULL,
  "ISBN" varchar(13) NOT NULL,
  "title" varchar(300) NOT NULL,
  "author" varchar(200) NOT NULL,
  "edition" varchar(200) NOT NULL,
  "course" int NOT NULL,
  "number" varchar(3) NOT NULL,
  "section" varchar(1) NOT NULL,
  "price" decimal(10,2) NOT NULL,
  "condition" text NOT NULL,
  "written" text NOT NULL,
  "comments" NTEXT NOT NULL,
  "imageURL" NTEXT NOT NULL,
  "awaitingImage" NTEXT NOT NULL,
  "imageID" varchar(32) NOT NULL,
  PRIMARY KEY ("id")
) ;

--
-- Dumping data for table books
--

INSERT INTO books (id, userID, upload, sold, linkID, ISBN, title, author, edition, course, number, section, price, condition, written, comments, imageURL, awaitingImage, imageID) VALUES
(1, 278, 1340452194, 0, 'c4ca4238a0b923820dcc509a6f75849b', '1234567890', 'Leonardo: He was Awesome!', 'Oliver Spryn the Great', '1st', 4, '201', 'G', '149.99', 'Excellent', 'No', 'Awesomeness is commin'' to town!', 'http://www.coverbrowser.com/image/donald-duck/34-1.jpg', '', '36565795dd09ce8da646941a3f2a7fd5');

INSERT INTO books (id, userID, upload, sold, linkID, ISBN, title, author, edition, course, number, section, price, condition, written, comments, imageURL, awaitingImage, imageID) VALUES
(2, 278, 1340452156, 0, 'c81e728d9d4c2f636f067f89cc14862c', '1234567890', 'Leonardo: He was Awesome!', 'Oliver Spryn the Great', '1st', 4, '102', 'F', '99.99', 'Excellent', 'No', '<p>Awesomeness is commin'' to town!</p>', 'http://www.coverbrowser.com/image/donald-duck/39-1.jpg', '', 'b7b0974e6cd9ad0a633d081646a405e9');

INSERT INTO books (id, userID, upload, sold, linkID, ISBN, title, author, edition, course, number, section, price, condition, written, comments, imageURL, awaitingImage, imageID) VALUES
(3, 278, 1324357200, 0, 'eccbc87e4b5ce2fe28308fd9f2a7baf3', '1234567890', 'Leonardo: He was Awesome!', 'Oliver Spryn the Great', '1st', 4, '101', 'C', '149.99', 'Excellent', 'No', 'Awesomeness is commin'' to town!', 'http://www.coverbrowser.com/image/donald-duck/30-1.jpg', '', 'c822cb12fefd1f0affa76f379bfecebd');

INSERT INTO books (id, userID, upload, sold, linkID, ISBN, title, author, edition, course, number, section, price, condition, written, comments, imageURL, awaitingImage, imageID) VALUES
(4, 278, 1324357200, 0, 'b261807d4663f1371171d57b7d40893f', '1234567890', 'Leonardo: He was Awesome!', 'Oliver Spryn the Great', '1st', 4, '201', 'I', '149.99', 'Excellent', 'No', 'Awesomeness is commin'' to town!', 'http://www.bookbyte.com/image.aspx?isbn=9780077366698', '', '468b8928ff38ad6d94feb27403db8eed');

INSERT INTO books (id, userID, upload, sold, linkID, ISBN, title, author, edition, course, number, section, price, condition, written, comments, imageURL, awaitingImage, imageID) VALUES
(5, 278, 1340438123, 0, 'a87ff679a2f3e71d9181a67b7542122c', '1234567890', 'Leonardo: He was Awesome!', 'Oliver Spryn the Great', '1st', 4, '102', 'B', '149.99', 'Excellent', 'No', '<p>Awesomeness is commin'' to town!</p>', 'http://www.coverbrowser.com/image/donald-duck/29-1.jpg', '', '741df930057e34e6d8096d0432ed835a');

INSERT INTO books (id, userID, upload, sold, linkID, ISBN, title, author, edition, course, number, section, price, condition, written, comments, imageURL, awaitingImage, imageID) VALUES
(6, 278, 1324357200, 0, 'e4da3b7fbbce2345d7772b0674a318d5', '1234567890', 'Leonardo: He was Awesome!', 'Oliver Spryn the Great', '1st', 4, '101', 'D', '149.99', 'Excellent', 'No', 'Awesomeness is commin'' to town!', 'http://www.coverbrowser.com/image/donald-duck/26-1.jpg', '', '4af148afce0ba964bc11b26d5bea7f09');

INSERT INTO books (id, userID, upload, sold, linkID, ISBN, title, author, edition, course, number, section, price, condition, written, comments, imageURL, awaitingImage, imageID) VALUES
(7, 278, 1324357200, 0, '1679091c5a880faf6fb5e6087eb1b2dc', '1234567890', 'Leonardo: He was Awesome!', 'Oliver Spryn the Great', '1st', 4, '101', 'A', '149.99', 'Excellent', 'No', 'Awesomeness is commin'' to town!', 'http://www.coverbrowser.com/image/super-team-family/1-1.jpg', '', 'c10b946bc4acb6db9fabc87cb110a8ca');

INSERT INTO books (id, userID, upload, sold, linkID, ISBN, title, author, edition, course, number, section, price, condition, written, comments, imageURL, awaitingImage, imageID) VALUES
(8, 278, 1324357200, 0, '8f14e45fceea167a5a36dedd4bea2543', '1234567890', 'Leonardo: He was Awesome!', 'Oliver Spryn the Great', '1st', 4, '201', 'N', '149.99', 'Excellent', 'No', 'Awesomeness is commin'' to town!', 'http://www.coverbrowser.com/image/super-team-family/3-1.jpg', '', 'e8456a4b61602ecfde63ebd211bf42fb');

INSERT INTO books (id, userID, upload, sold, linkID, ISBN, title, author, edition, course, number, section, price, condition, written, comments, imageURL, awaitingImage, imageID) VALUES
(9, 0, 1324357200, 0, 'c9f0f895fb98ab9159f51fd0297e236d', '1234567890', 'Leonardo: He was Awesome!', 'Oliver Spryn the Great', '1st', 4, '101', 'A', '149.99', 'Excellent', 'No', 'Awesomeness is commin'' to town!', 'http://www.coverbrowser.com/image/super-team-family/8-1.jpg', '', '84691ecd8a38f140ab924da388df6a6b');

INSERT INTO books (id, userID, upload, sold, linkID, ISBN, title, author, edition, course, number, section, price, condition, written, comments, imageURL, awaitingImage, imageID) VALUES
(10, 278, 1324357200, 0, '45c48cce2e2d7fbdea1afc51c7c6ad26', '1234567890', 'Leonardo: He was Awesome!', 'Oliver Spryn the Great', '1st', 4, '101', 'A', '149.99', 'Excellent', 'No', 'Awesomeness is commin'' to town!', 'http://www.coverbrowser.com/image/super-team-family/13-1.jpg', '', 'cc73ec397e376d4d917dd254e6ec90f6');

INSERT INTO books (id, userID, upload, sold, linkID, ISBN, title, author, edition, course, number, section, price, condition, written, comments, imageURL, awaitingImage, imageID) VALUES
(11, 278, 1324357200, 0, 'd3d9446802a44259755d38e6d163e820', '1234567890', 'Leonardo: He was Awesome!', 'Oliver Spryn the Great', '1st', 4, '127', 'A', '149.99', 'Excellent', 'No', 'Awesomeness is commin'' to town!', 'http://www.coverbrowser.com/image/almanaque-disney/3-1.jpg', '', 'f226d1301aa7d38c886715d28a9ea023');

INSERT INTO books (id, userID, upload, sold, linkID, ISBN, title, author, edition, course, number, section, price, condition, written, comments, imageURL, awaitingImage, imageID) VALUES
(12, 278, 1340494508, 0, '6512bd43d9caa6e02c990b0a82652dca', '1234567890', 'Leonardo: He was Uncool!', 'Oliver Spryn the Great', '1st', 4, '201', 'G', '149.99', 'Excellent', 'No', 'Awesomeness is commin'' to town!', 'http://www.coverbrowser.com/image/captain-america-2004/4-1.jpg', '', '97fafdedbfa0f0c205c6b39966bd3ac0');

INSERT INTO books (id, userID, upload, sold, linkID, ISBN, title, author, edition, course, number, section, price, condition, written, comments, imageURL, awaitingImage, imageID) VALUES
(13, 278, 1324357200, 0, 'c20ad4d76fe97759aa27a0c99bff6710', '1234567890', 'Leonardo: He was Uncool!', 'Oliver Spryn the Great', '1st', 4, '127', 'A', '149.99', 'Excellent', 'No', 'Awesomeness is commin'' to town!', 'http://www.coverbrowser.com/image/uncle-scrooge/6-1.jpg', '', 'a850bf2db5d50f37c333deb6166e2c09');

INSERT INTO books (id, userID, upload, sold, linkID, ISBN, title, author, edition, course, number, section, price, condition, written, comments, imageURL, awaitingImage, imageID) VALUES
(14, 278, 1324357200, 0, 'c51ce410c124a10e0db5e4b97fc2af39', '1234567890', 'Leonardo: He was Uncool!', 'Oliver Spryn the Great', '1st', 4, '127', 'F', '149.99', 'Excellent', 'No', 'Awesomeness is commin'' to town!', 'http://www.coverbrowser.com/image/uncle-scrooge/9-1.jpg', '', '786012d5f6a5db468bb5b7dce1e5f7e8');

INSERT INTO books (id, userID, upload, sold, linkID, ISBN, title, author, edition, course, number, section, price, condition, written, comments, imageURL, awaitingImage, imageID) VALUES
(15, 278, 1324357200, 0, 'aab3238922bcc25a6f606eb525ffdc56', '1234567890', 'Leonardo: He was Uncool!', 'Oliver Spryn the Great', '1st', 4, '201', 'G', '149.99', 'Excellent', 'No', 'Awesomeness is commin'' to town!', 'http://www.coverbrowser.com/image/uncle-scrooge/12-1.jpg', '', '0795b24e75c97b11592515b53de92571');

INSERT INTO books (id, userID, upload, sold, linkID, ISBN, title, author, edition, course, number, section, price, condition, written, comments, imageURL, awaitingImage, imageID) VALUES
(16, 278, 1324357200, 0, '9bf31c7ff062936a96d3c8bd1f8f2ff3', '1234567890', 'Leonardo: He was Uncool!', 'Oliver Spryn the Great', '1st', 4, '102', 'I', '149.99', 'Excellent', 'No', 'Awesomeness is commin'' to town!', 'http://www.coverbrowser.com/image/uncle-scrooge/20-1.jpg', '', '4822bd141d107589ec2e1ee59ba4e2ae');

INSERT INTO books (id, userID, upload, sold, linkID, ISBN, title, author, edition, course, number, section, price, condition, written, comments, imageURL, awaitingImage, imageID) VALUES
(17, 278, 1324357200, 0, 'c74d97b01eae257e44aa9d5bade97baf', '1234567890', 'Leonardo: He was the Most Average Joe You''d Ever Meet in Your Entire Existance', 'Oliver Spryn the Great', '1st', 4, '102', 'B', '149.99', 'Excellent', 'No', 'Awesomeness is commin'' to town!', 'http://www.coverbrowser.com/image/uncle-scrooge/23-1.jpg', '', '3f92abfaf047b62280b7f9e596193e92');

INSERT INTO books (id, userID, upload, sold, linkID, ISBN, title, author, edition, course, number, section, price, condition, written, comments, imageURL, awaitingImage, imageID) VALUES
(18, 278, 1324357200, 0, '70efdf2ec9b086079795c442636b55fb', '1234567890', 'Leonardo: He was the Most Average Joe You''d Ever Meet in Your Entire Existance', 'Oliver Spryn the Great', '1st', 4, '202', 'A', '149.99', 'Excellent', 'No', 'Awesomeness is commin'' to town!', 'http://www.coverbrowser.com/image/uncle-scrooge/26-1.jpg', '', 'e0a9a5dadc99bb329f07dd2bb1a4e9e0');

INSERT INTO books (id, userID, upload, sold, linkID, ISBN, title, author, edition, course, number, section, price, condition, written, comments, imageURL, awaitingImage, imageID) VALUES
(23, 278, 1338777581, 0, '4c40942ca253dcd79ecb8691484cdd58', '741424282', 'the long walk home', 'anatole kurdsjuk', '', 15, '221', 'C', '10.00', 'Very Good', 'No', '<p>very good book</p>', 'http://ecx.images-amazon.com/images/I/41ascOiF3AL.jpg?gdapi', '', '71fbe7390dc1436ab53c1a19e5f7349f');

INSERT INTO books (id, userID, upload, sold, linkID, ISBN, title, author, edition, course, number, section, price, condition, written, comments, imageURL, awaitingImage, imageID) VALUES
(24, 278, 1339391947, 0, '4cdee8e4cd621e1c8924af0156532e60', '73853532', 'The Pennsylvania Turnpike', 'Mitchell E. Dakelman, Neal A. Schorr', '', 25, '323', 'C', '14.99', 'Excellent', 'No', '', 'http://i.ebayimg.com/00/s/NTAwWDM1MQ==/%24%28KGrHqJ,%21noE-z%29J%29NILBPu%29GsoemQ%7E%7E60_1.JPG?set_id=8800005007', '', 'f90f67e8b9e86ed9286e4104616f3097');

INSERT INTO books (id, userID, upload, sold, linkID, ISBN, title, author, edition, course, number, section, price, condition, written, comments, imageURL, awaitingImage, imageID) VALUES
(25, 278, 1339453221, 0, '6e5f6e95fe22582b1d8766f00d4bfc2b', '1111426732', 'Calculus', 'James Stewart', 'Hybrid Edition', 1, '161', 'C', '75.99', 'Excellent', 'No', '<p>I made a few marginal notes in the beginning of chapter 1. It is not a hard cover book, and I accidentally made a crease line across the back cover of the book. In every other respect, this book is as good as new. It also includes the Webassign access card.</p>', 'http://images.bookbyte.com/isbn.aspx?isbn=9781111426736', '', '9b27e119920b6a27dc2b458e382830a8');

INSERT INTO books (id, userID, upload, sold, linkID, ISBN, title, author, edition, course, number, section, price, condition, written, comments, imageURL, awaitingImage, imageID) VALUES
(26, 278, 1339453221, 0, '6e5f6e95fe22582b1d8766f00d4bfc2b', '1111426732', 'Calculus', 'James Stewart', 'Hybrid Edition', 1, '162', 'D', '75.99', 'Very Good', 'Yes', '<p>I made a few marginal notes in the beginning of chapter 1. It is not a hard cover book, and I accidentally made a crease line across the back cover of the book. In every other respect, this book is as good as new. It also includes the Webassign access card.</p>', 'http://images.bookbyte.com/isbn.aspx?isbn=9781111426736', '', '9b27e119920b6a27dc2b458e382830a8');

INSERT INTO books (id, userID, upload, sold, linkID, ISBN, title, author, edition, course, number, section, price, condition, written, comments, imageURL, awaitingImage, imageID) VALUES
(27, 278, 1339453221, 0, '6e5f6e95fe22582b1d8766f00d4bfc2b', '1111426732', 'Calculus', 'James Stewart', 'Hybrid Edition', 1, '262', 'C', '75.99', 'Very Good', 'Yes', '<p>I made a few marginal notes in the beginning of chapter 1. It is not a hard cover book, and I accidentally made a crease line across the back cover of the book. In every other respect, this book is as good as new. It also includes the Webassign access card.</p>', 'http://images.bookbyte.com/isbn.aspx?isbn=9781111426736', '', 'aa0fb0510cccf42fd6e25a71c2a7c370');

INSERT INTO books (id, userID, upload, sold, linkID, ISBN, title, author, edition, course, number, section, price, condition, written, comments, imageURL, awaitingImage, imageID) VALUES
(28, 278, 1339454560, 0, '7c05ff61ff9472c2ad65fd831a4f5b46', '1111426732', 'Calculus', 'James Stewart', 'Hybrid Edition', 1, '161', 'C', '49.99', 'Very Good', 'Yes', '', 'http://images.bookbyte.com/isbn.aspx?isbn=9781111426736', '', '70d7bd2ecde095f05b03985526c5a8e4');

INSERT INTO books (id, userID, upload, sold, linkID, ISBN, title, author, edition, course, number, section, price, condition, written, comments, imageURL, awaitingImage, imageID) VALUES
(29, 278, 1339454560, 0, '7c05ff61ff9472c2ad65fd831a4f5b46', '1111426732', 'Calculus', 'James Stewart', 'Hybrid Edition', 1, '162', 'D', '49.99', 'Very Good', 'Yes', '', 'http://images.bookbyte.com/isbn.aspx?isbn=9781111426736', '', '80baf3055f59a3f0fb258d886c01e7d7');

INSERT INTO books (id, userID, upload, sold, linkID, ISBN, title, author, edition, course, number, section, price, condition, written, comments, imageURL, awaitingImage, imageID) VALUES
(30, 278, 1339454560, 0, '7c05ff61ff9472c2ad65fd831a4f5b46', '1111426732', 'Calculus', 'James Stewart', 'Hybrid Edition', 1, '262', 'C', '49.99', 'Very Good', 'Yes', '', 'http://images.bookbyte.com/isbn.aspx?isbn=9781111426736', '', 'b98a9397f88b3138fedaf83484933b0c');

INSERT INTO books (id, userID, upload, sold, linkID, ISBN, title, author, edition, course, number, section, price, condition, written, comments, imageURL, awaitingImage, imageID) VALUES
(31, 278, 1339455754, 0, 'e87986d463b1883fbd825eea0e17d025', '763776467', 'Computer Science Illuminated', 'Nell Dale, John Lewis', 'Fourth Edition', 10, '141', 'A', '14.99', 'Good', 'Yes', '<p>LOTS of comments in here. They should be helpful.</p>', 'http://www.saanjhi.com/images/products/large/9780763776466.jpg', '', 'cfdcc362ef5939509e3f8811e468d27b');

INSERT INTO books (id, userID, upload, sold, linkID, ISBN, title, author, edition, course, number, section, price, condition, written, comments, imageURL, awaitingImage, imageID) VALUES
(32, 278, 1339456542, 0, 'b41d6cb7d8adce7a63f28ddb53757852', '1111426732', 'Calculus', 'James Stewart', 'Hybrid Edition', 1, '161', 'C', '59.99', 'Very Good', 'Yes', '', 'http://images.bookbyte.com/isbn.aspx?isbn=9781111426736', '', 'c5d0d1f2278152ce59895d6b01d0f7ef');

INSERT INTO books (id, userID, upload, sold, linkID, ISBN, title, author, edition, course, number, section, price, condition, written, comments, imageURL, awaitingImage, imageID) VALUES
(33, 278, 1339456542, 0, 'b41d6cb7d8adce7a63f28ddb53757852', '1111426732', 'Calculus', 'James Stewart', 'Hybrid Edition', 1, '162', 'D', '59.99', 'Very Good', 'Yes', '', 'http://images.bookbyte.com/isbn.aspx?isbn=9781111426736', '', 'c5d0d1f2278152ce59895d6b01d0f7ef');

INSERT INTO books (id, userID, upload, sold, linkID, ISBN, title, author, edition, course, number, section, price, condition, written, comments, imageURL, awaitingImage, imageID) VALUES
(34, 278, 1339456542, 0, 'b41d6cb7d8adce7a63f28ddb53757852', '1111426732', 'Calculus', 'James Stewart', 'Hybrid Edition', 1, '262', 'C', '59.99', 'Very Good', 'Yes', '', 'http://images.bookbyte.com/isbn.aspx?isbn=9781111426736', '', 'c5d0d1f2278152ce59895d6b01d0f7ef');

INSERT INTO books (id, userID, upload, sold, linkID, ISBN, title, author, edition, course, number, section, price, condition, written, comments, imageURL, awaitingImage, imageID) VALUES
(38, 278, 1339694212, 0, '1cfbc56ab506a499ce635e260de379a8', '1234567890', 'Leonardo: He was Awesome!', 'Oliver Spryn the Great', '1st', 4, '101', 'A', '149.99', 'Very Good', 'No', '', 'http://www.coverbrowser.com/image/almanaque-disney/14-1.jpg', '', 'fcabb483c770a0532330f738c023cf56');

INSERT INTO books (id, userID, upload, sold, linkID, ISBN, title, author, edition, course, number, section, price, condition, written, comments, imageURL, awaitingImage, imageID) VALUES
(39, 278, 1339694225, 0, 'd8eb62b8ba4c279fdbfad11344643a77', '1234567890', 'Leonardo: He was Awesome!', 'Oliver Spryn the Great', '1st', 4, '101', 'A', '149.99', 'Very Good', 'No', '', 'http://www.coverbrowser.com/image/almanaque-disney/20-1.jpg', '', '9dc9aaf6cb9cc0eb63afdc71fb54ba92');

INSERT INTO books (id, userID, upload, sold, linkID, ISBN, title, author, edition, course, number, section, price, condition, written, comments, imageURL, awaitingImage, imageID) VALUES
(40, 278, 1339771282, 0, '31e0110d0ca29d0044ee66d8b39f88c6', '740750054', 'Driving Under the Influence of Children', 'Rick Kirkman, Jerry Scott', '', 4, '101', 'A', '14.99', 'Very Good', 'No', '', 'http://i.ebayimg.com/00/%24%28KGrHqYOKjQE3%21lkJ-%29rBNzZ%29gZYJg%7E%7E0_1.JPG?set_id=8800005007', '', 'a4b1b1e046dbaf0941b1f93d606b314f');

INSERT INTO books (id, userID, upload, sold, linkID, ISBN, title, author, edition, course, number, section, price, condition, written, comments, imageURL, awaitingImage, imageID) VALUES
(41, 278, 1339771344, 0, '37fa59fef280c868134917e7709e8219', '7183844', 'Collins Thesaurus A-Z', 'Collins', '', 4, '101', 'A', '9.99', 'Very Good', 'No', '', 'http://ecx.images-amazon.com/images/I/31kUJo5v6-L.jpg?gdapi', '', 'b72fa81cd4dd7ab31d4fcb019bb2c79d');

INSERT INTO books (id, userID, upload, sold, linkID, ISBN, title, author, edition, course, number, section, price, condition, written, comments, imageURL, awaitingImage, imageID) VALUES
(42, 278, 1339771438, 0, 'bccd7fb9a5fa43a939916f39ffc2eca2', '740761943', 'Baby Blues Framed!', 'Rick Kirkman, Jerry Scott', '', 4, '101', 'A', '14.99', 'Fair', 'No', '', 'http://ecx.images-amazon.com/images/I/61Y0gx%2BO18L.jpg?gdapi', '', '6d6dae25f4d6e111c55baa475bf444be');

INSERT INTO books (id, userID, upload, sold, linkID, ISBN, title, author, edition, course, number, section, price, condition, written, comments, imageURL, awaitingImage, imageID) VALUES
(43, 278, 1339771514, 0, 'aa0f44d3b553412f90a9322dcc12ec89', '740700081', 'Ten Years and Still In Diapers', 'Rick Kirkman, Jerry Scott', '', 4, '101', 'A', '14.99', 'Fair', 'No', '', 'http://ecx.images-amazon.com/images/I/51VVlTDAtlL.jpg?aWQ9MDc0MDcwMDA4MSZwZD0xOTk5LTA4LTAxJmJkPVBhcGVyYmFjayZhdT0iSmVycnkgU2NvdHQiLCIgUmljayBLaXJrbWFuIiZ0aT0mc2k9', '', '1f1c5331eb83b3f68f443b97db885b85');

INSERT INTO books (id, userID, upload, sold, linkID, ISBN, title, author, edition, course, number, section, price, condition, written, comments, imageURL, awaitingImage, imageID) VALUES
(44, 278, 1339771605, 1, '74f0887e0498b516006c0c355e35565e', '2147483647', 'Destination Moon', 'Rod Pyle', '', 4, '101', 'A', '7.99', 'Excellent', 'No', '', 'http://images.bookbyte.com/isbn.aspx?isbn=9780060873493', '', 'ba860aa5ab4db00e0b09a4662c7e3a28');

INSERT INTO books (id, userID, upload, sold, linkID, ISBN, title, author, edition, course, number, section, price, condition, written, comments, imageURL, awaitingImage, imageID) VALUES
(45, 278, 1340241165, 0, '39bfc208e0bfffaf7d0c788bd37adf57', '764560204', 'Teach Yourself the Internet and World Wide Web Visually', 'maranGraphics', '', 10, '101', 'A', '4.99', 'Excellent', 'No', '', 'http://www.qualitybargainmall.com/image/?sku=7733625', '', '1583e96ca3fb268b6892f9faa202e92c');

INSERT INTO books (id, userID, upload, sold, linkID, ISBN, title, author, edition, course, number, section, price, condition, written, comments, imageURL, awaitingImage, imageID) VALUES
(46, 0, 1340304991, 0, '5c47c405ab6f29313df4b4b9de027e39', '764560204', 'Teach Yourself the Internet and World Wide Web Visually', 'maranGraphics', '', 10, '101', 'A', '4.99', 'Very Good', 'No', '', 'http://www.qualitybargainmall.com/image/?sku=7733625', '', '1583e96ca3fb268b6892f9faa202e92c');

INSERT INTO books (id, userID, upload, sold, linkID, ISBN, title, author, edition, course, number, section, price, condition, written, comments, imageURL, awaitingImage, imageID) VALUES
(47, 278, 1340305080, 0, '104136fbb6b5a233e613b49aebd5ddb2', '0738535176', 'Butler County', 'Larry D. Parisi', '', 25, '323', 'C', '7.99', 'Very Good', 'No', '', 'http://localhost/SGA/book-exchange/system/images/icons/default_book.png', 'http://ecx.images-amazon.com/images/I/51oYh4HWDWL.jpg?aWQ9MDczODUzNTE3NiZwZD0yMDA0LTAzLTAxJmJkPVBhcGVyYmFjayZhdT0iTGFycnkgRC4gUGFyaXNpIiZ0aT0mc2k9', 'cc52c0c5349726a477308e1c8c359c9a');

INSERT INTO books (id, userID, upload, sold, linkID, ISBN, title, author, edition, course, number, section, price, condition, written, comments, imageURL, awaitingImage, imageID) VALUES
(48, 278, 1340305656, 0, 'b7041a002bdaca0cc5f817fa0331f7fd', '0738535176', 'Butler County', 'Larry D. Parisi', '', 25, '323', 'C', '7.99', 'Very Good', 'No', '', 'http://localhost/SGA/book-exchange/system/images/icons/default_book.png', 'http://ecx.images-amazon.com/images/I/51oYh4HWDWL.jpg?aWQ9MDczODUzNTE3NiZwZD0yMDA0LTAzLTAxJmJkPVBhcGVyYmFjayZhdT0iTGFycnkgRC4gUGFyaXNpIiZ0aT0mc2k9', 'f1ba5433409f95b59efe60b11dd45b0f');

INSERT INTO books (id, userID, upload, sold, linkID, ISBN, title, author, edition, course, number, section, price, condition, written, comments, imageURL, awaitingImage, imageID) VALUES
(55, 278, 1340305726, 0, '308dd1905871cac5de55b5be61c63649', '073853532X', 'The Pennsylvania Turnpike - Images of America', 'Mitchell E. Dakelman and Neal A. Schorr', '', 25, '107', 'P', '19.99', 'Very Good', 'No', '<p>Test</p>', 'http://i.ebayimg.com/00/s/NTAwWDM1MQ==/%24%28KGrHqJ,%21noE-z%29J%29NILBPu%29GsoemQ%7E%7E60_1.JPG?set_id=8800005007', '', 'f90f67e8b9e86ed9286e4104616f3097');

-- --------------------------------------------------------

--
-- Table structure for table collaboration
--

CREATE TABLE collaboration (
  "id" int NOT NULL,
  "position" int NOT NULL,
  "visible" text NOT NULL,
  "type" text NOT NULL,
  "fromDate" NTEXT NOT NULL,
  "fromTime" NTEXT NOT NULL,
  "toDate" NTEXT NOT NULL,
  "toTime" NTEXT NOT NULL,
  "title" NTEXT NOT NULL,
  "content" NTEXT NOT NULL,
  "assignee" NTEXT NOT NULL,
  "task" NTEXT NOT NULL,
  "description" NTEXT NOT NULL,
  "dueDate" NTEXT NOT NULL,
  "priority" NTEXT NOT NULL,
  "completed" NTEXT NOT NULL,
  "directories" NTEXT NOT NULL,
  "questions" NTEXT NOT NULL,
  "responses" NTEXT NOT NULL,
  "name" NTEXT NOT NULL,
  "date" NTEXT NOT NULL,
  "comment" NTEXT NOT NULL,
  PRIMARY KEY ("id")
) ;

--
-- Dumping data for table collaboration
--

INSERT INTO collaboration (id, position, visible, type, fromDate, fromTime, toDate, toTime, title, content, assignee, task, description, dueDate, priority, completed, directories, questions, responses, name, date, comment) VALUES
(136, 1, 'on', 'Announcement', '', '', '', '', 'This is serious!!!', '<p><span style="background-color: #ffff00;">Pay attention!!!!!!</span></p>', '', '', '', '', '', '', '', '', '', '', '', '');

INSERT INTO collaboration (id, position, visible, type, fromDate, fromTime, toDate, toTime, title, content, assignee, task, description, dueDate, priority, completed, directories, questions, responses, name, date, comment) VALUES
(139, 2, 'on', 'Agenda', '04/17/2012', '12:00', '04/24/2012', '12:00', 'Agenda this Week', '<p>Please look at the agenda below for our to-do list:</p>', 'a:2:{i:0;s:30:"Anyone, Everyone, Oliver Spryn";i:1;s:12:"Oliver Spryn";}', 'a:2:{i:0;s:26:"Complete the Sign-Up Sheet";i:1;s:6:"Task 2";}', 'a:2:{i:0;s:66:"Please place this on Google Docs when you are finished! Thank you!";i:1;s:0:"";}', 'a:2:{i:0;s:0:"";i:1;s:10:"04/18/2012";}', 'a:2:{i:0;s:1:"1";i:1;s:1:"3";}', 'a:2:{i:0;s:4:"true";i:1;s:4:"true";}', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table dailyhits
--

CREATE TABLE dailyhits (
  "id" int NOT NULL,
  "date" varchar(255) NOT NULL,
  "hits" int NOT NULL,
  PRIMARY KEY ("id")
) ;

--
-- Dumping data for table dailyhits
--

-- --------------------------------------------------------

--
-- Table structure for table exchangesettings
--

CREATE TABLE exchangesettings (
  "id" int NOT NULL,
  "expires" int NOT NULL,
  PRIMARY KEY ("id")
) ;

--
-- Dumping data for table exchangesettings
--

INSERT INTO exchangesettings (id, expires) VALUES
(1, 15724800);

-- --------------------------------------------------------

--
-- Table structure for table external
--

CREATE TABLE external (
  "id" int NOT NULL,
  "position" int NOT NULL,
  "visible" text NOT NULL,
  "published" int NOT NULL,
  "display" int NOT NULL,
  "content1" NTEXT NOT NULL,
  PRIMARY KEY ("id")
) ;

--
-- Dumping data for table external
--


-- --------------------------------------------------------

--
-- Table structure for table failedlogins
--

CREATE TABLE failedlogins (
  "id" int NOT NULL,
  "timeStamp" NTEXT NOT NULL,
  "computerName" NTEXT NOT NULL,
  "userName" NTEXT NOT NULL,
  PRIMARY KEY ("id")
) ;

--
-- Dumping data for table failedlogins
--

-- --------------------------------------------------------

--
-- Table structure for table pagehits
--

CREATE TABLE pagehits (
  "id" int NOT NULL,
  "page" varchar(255) NOT NULL,
  "hits" int NOT NULL,
  PRIMARY KEY ("id")
) ;

--
-- Dumping data for table pagehits
--


-- --------------------------------------------------------

--
-- Table structure for table pages
--

CREATE TABLE pages (
  "id" int NOT NULL,
  "type" varchar(4) NOT NULL,
  "linkTitle" NTEXT NOT NULL,
  "locked" int NOT NULL,
  "URL" NTEXT NOT NULL,
  "position" int NOT NULL,
  "parentPage" int NOT NULL,
  "subPosition" int NOT NULL,
  "visible" text NOT NULL,
  "published" int NOT NULL,
  "display" NTEXT NOT NULL,
  "content1" NTEXT NOT NULL,
  PRIMARY KEY ("id")
) ;

--
-- Dumping data for table pages
--

INSERT INTO pages (id, type, linkTitle, locked, URL, position, parentPage, subPosition, visible, published, display, content1) VALUES
(123, 'page', '', 0, '', 1, 0, 0, 'on', 2, '1', 'a:7:{s:5:"title";s:4:"Test";s:7:"content";s:11:"<p>test</p>";s:8:"comments";s:1:"0";s:7:"message";s:0:"";s:4:"user";s:3:"278";s:4:"time";i:1332875470;s:7:"changes";s:1:"1";}');

INSERT INTO pages (id, type, linkTitle, locked, URL, position, parentPage, subPosition, visible, published, display, content1) VALUES
(124, 'page', '', 0, '', 2, 0, 0, 'on', 2, '1', 'a:7:{s:5:"title";s:10:"More stuff";s:7:"content";s:9:"<p>hi</p>";s:8:"comments";s:1:"0";s:7:"message";s:0:"";s:4:"user";s:3:"278";s:4:"time";i:1332876729;s:7:"changes";s:1:"1";}');

INSERT INTO pages (id, type, linkTitle, locked, URL, position, parentPage, subPosition, visible, published, display, content1) VALUES
(125, 'page', '', 0, '', 0, 123, 1, 'on', 2, '1', 'a:7:{s:5:"title";s:25:"We are going to the store";s:7:"content";s:19:"<p>Yes, we are.</p>";s:8:"comments";s:1:"0";s:7:"message";s:0:"";s:4:"user";s:3:"278";s:4:"time";i:1332893714;s:7:"changes";s:1:"1";}');

INSERT INTO pages (id, type, linkTitle, locked, URL, position, parentPage, subPosition, visible, published, display, content1) VALUES
(126, 'page', '', 0, '', 0, 123, 2, 'on', 2, '1', 'a:7:{s:5:"title";s:27:"It''s Wal-Mart to be percise";s:7:"content";s:18:"<p>Yes, it is.</p>";s:8:"comments";s:1:"0";s:7:"message";s:0:"";s:4:"user";s:3:"278";s:4:"time";i:1332894467;s:7:"changes";s:1:"1";}');

INSERT INTO pages (id, type, linkTitle, locked, URL, position, parentPage, subPosition, visible, published, display, content1) VALUES
(127, 'page', '', 0, '', 0, 123, 3, 'on', 2, '1', 'a:7:{s:5:"title";s:21:"Or was it Sam''s Club?";s:7:"content";s:17:"<p>Don''t know</p>";s:8:"comments";s:1:"0";s:7:"message";s:0:"";s:4:"user";s:3:"278";s:4:"time";i:1332894482;s:7:"changes";s:1:"1";}');

INSERT INTO pages (id, type, linkTitle, locked, URL, position, parentPage, subPosition, visible, published, display, content1) VALUES
(128, 'page', '', 0, '', 0, 124, 1, 'on', 2, '1', 'a:7:{s:5:"title";s:7:"Whateve";s:7:"content";s:9:"<p>*r</p>";s:8:"comments";s:1:"0";s:7:"message";s:0:"";s:4:"user";s:3:"278";s:4:"time";i:1332894605;s:7:"changes";s:1:"1";}');

INSERT INTO pages (id, type, linkTitle, locked, URL, position, parentPage, subPosition, visible, published, display, content1) VALUES
(129, 'page', '', 0, '', 0, 124, 2, 'on', 2, '1', 'a:7:{s:5:"title";s:3:"Yes";s:7:"content";s:19:"<p>So, whatever</p>";s:8:"comments";s:1:"0";s:7:"message";s:0:"";s:4:"user";s:3:"278";s:4:"time";i:1332894622;s:7:"changes";s:1:"1";}');

INSERT INTO pages (id, type, linkTitle, locked, URL, position, parentPage, subPosition, visible, published, display, content1) VALUES
(130, 'page', '', 0, '', 0, 125, 1, 'on', 2, '1', 'a:7:{s:5:"title";s:12:"Which store?";s:7:"content";s:18:"<p>HIH???* HUH</p>";s:8:"comments";s:1:"0";s:7:"message";s:0:"";s:4:"user";s:3:"278";s:4:"time";i:1332948461;s:7:"changes";s:1:"1";}');

INSERT INTO pages (id, type, linkTitle, locked, URL, position, parentPage, subPosition, visible, published, display, content1) VALUES
(131, 'page', '', 0, '', 0, 130, 1, 'on', 2, '1', 'a:7:{s:5:"title";s:5:"Title";s:7:"content";s:14:"<p>Content</p>";s:8:"comments";s:1:"0";s:7:"message";s:0:"";s:4:"user";s:3:"278";s:4:"time";i:1332948894;s:7:"changes";s:1:"1";}');

INSERT INTO pages (id, type, linkTitle, locked, URL, position, parentPage, subPosition, visible, published, display, content1) VALUES
(132, 'page', '', 0, '', 0, 131, 1, 'on', 2, '1', 'a:7:{s:5:"title";s:10:"More stuff";s:7:"content";s:11:"<p>Nice</p>";s:8:"comments";s:1:"1";s:7:"message";s:0:"";s:4:"user";s:3:"278";s:4:"time";i:1332948906;s:7:"changes";s:1:"1";}');

INSERT INTO pages (id, type, linkTitle, locked, URL, position, parentPage, subPosition, visible, published, display, content1) VALUES
(133, 'link', 'Book Exchange', 0, 'http://localhost/SGA/book-exchange/', 3, 0, 1, 'on', 1, '1', '');

INSERT INTO pages (id, type, linkTitle, locked, URL, position, parentPage, subPosition, visible, published, display, content1) VALUES
(134, 'link', 'Search Books', 0, 'http://localhost/SGA/book-exchange/search/', 0, 133, 2, 'on', 1, '1', '');

INSERT INTO pages (id, type, linkTitle, locked, URL, position, parentPage, subPosition, visible, published, display, content1) VALUES
(135, 'link', 'Book Categories', 0, 'http://localhost/SGA/book-exchange/listings/', 0, 133, 3, 'on', 1, '1', '');

INSERT INTO pages (id, type, linkTitle, locked, URL, position, parentPage, subPosition, visible, published, display, content1) VALUES
(136, 'link', 'Sell Books', 1, 'http://localhost/SGA/book-exchange/sell-books/', 0, 133, 4, 'on', 1, '1', '');

INSERT INTO pages (id, type, linkTitle, locked, URL, position, parentPage, subPosition, visible, published, display, content1) VALUES
(137, 'link', 'View my Books', 1, 'http://localhost/SGA/book-exchange/account/', 0, 133, 4, 'on', 1, '1', '');

-- --------------------------------------------------------

--
-- Table structure for table privileges
--

CREATE TABLE privileges (
  "id" int NOT NULL,
  "deleteFile" int NOT NULL,
  "uploadFile" int NOT NULL,
  "deleteForumComments" int NOT NULL,
  "sendEmail" int NOT NULL,
  "viewStaffPage" int NOT NULL,
  "createStaffPage" int NOT NULL,
  "editStaffPage" int NOT NULL,
  "deleteStaffPage" int NOT NULL,
  "publishStaffPage" int NOT NULL,
  "addStaffComments" int NOT NULL,
  "deleteStaffComments" int NOT NULL,
  "createPage" int NOT NULL,
  "editPage" int NOT NULL,
  "deletePage" int NOT NULL,
  "publishPage" int NOT NULL,
  "createSideBar" int NOT NULL,
  "editSideBar" int NOT NULL,
  "deleteSideBar" int NOT NULL,
  "publishSideBar" int NOT NULL,
  "siteSettings" int NOT NULL,
  "sideBarSettings" int NOT NULL,
  "deleteComments" int NOT NULL,
  "createExternal" int NOT NULL,
  "editExternal" int NOT NULL,
  "deleteExternal" int NOT NULL,
  "publishExternal" int NOT NULL,
  "viewStatistics" int NOT NULL,
  "autoEmail" int NOT NULL
);

--
-- Dumping data for table privileges
--


-- --------------------------------------------------------

--
-- Table structure for table purchases
--

CREATE TABLE purchases (
  "id" int NOT NULL,
  "buyerID" int NOT NULL,
  "sellerID" int NOT NULL,
  "bookID" int NOT NULL,
  "time" int NOT NULL,
  PRIMARY KEY ("id")
) ;

--
-- Dumping data for table purchases
--

INSERT INTO purchases (id, buyerID, sellerID, bookID, time) VALUES
(1, 278, 278, 44, 1340452924);

-- --------------------------------------------------------

--
-- Table structure for table question
--

CREATE TABLE question (
  "id" int NOT NULL,
  "timeStart" int NOT NULL,
  "timeEnd" int NOT NULL,
  "title" NTEXT NOT NULL,
  "question" NTEXT NOT NULL,
  "responseValue" NTEXT NOT NULL,
  "responses" NTEXT NOT NULL,
  PRIMARY KEY ("id")
) ;

--
-- Dumping data for table question
--

INSERT INTO question (id, timeStart, timeEnd, title, question, responseValue, responses) VALUES
(1, 1334440800, 1335045600, 'This is our question.', '<p>\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent quis dui a elit interdum molestie vitae a erat. In sit amet turpis a ligula fringilla dapibus. Nulla congue condimentum sem, non scelerisque elit tempor vel. Nullam metus metus, volutpat porttitor auctor in, suscipit ac quam. Vestibulum suscipit molestie malesuada. In hac habitasse platea dictumst. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Mauris auctor egestas quam, ac scelerisque velit mattis a. Nulla ac venenatis quam. Fusce at nisl in magna imperdiet scelerisque. Phasellus interdum fringilla est vel sodales. Mauris dapibus nulla nibh. Vestibulum orci sem, lobortis ut adipiscing vel, tincidunt non ante. Vivamus augue ligula, venenatis rutrum porta quis, rutrum eget urna. Donec tincidunt nibh vel nisi placerat vitae posuere metus posuere. In libero elit, adipiscing ut pretium in, porta quis ipsum.\r\n</p>\r\n<p>\r\nFusce vestibulum rutrum metus a aliquam. Sed vitae augue magna, a placerat enim. Duis in eros nisl, a suscipit lectus. Integer ac tellus quis erat lobortis feugiat eget ac urna. Duis nunc libero, vehicula vitae consequat at, tempor non ipsum. Phasellus leo urna, porta et vestibulum pellentesque, volutpat non massa. Suspendisse vel enim mauris, et gravida erat.\r\n</p>\r\n<p>\r\nAliquam tincidunt lobortis eros, at commodo eros semper ac. Curabitur dignissim, sapien sit amet hendrerit bibendum, odio lorem sollicitudin elit, id pretium arcu orci at eros. Nunc molestie, eros eu euismod dictum, risus leo imperdiet nulla, ut vestibulum libero massa sed diam. Vestibulum sit amet congue ante. Nullam ut tellus libero, a sagittis sapien. Vivamus rhoncus lacinia gravida. Vestibulum vitae est at arcu molestie ultrices vel mattis risus. Donec malesuada vehicula nisi et cursus. Cras nec imperdiet mi. Donec vitae ligula pulvinar velit tempor sodales. Integer massa lacus, sollicitudin quis pretium in, accumsan sit amet quam. Duis dolor felis, ultrices id facilisis eu, congue non erat. Nulla facilisi. Mauris imperdiet orci sit amet nisl ultricies nec pharetra ligula imperdiet. In hac habitasse platea dictumst. Morbi ut libero posuere elit tristique adipiscing a ac magna.\r\n</p>\r\n<p>\r\nPhasellus sapien velit, hendrerit at laoreet vitae, lacinia in dui. Maecenas tincidunt mauris et augue sagittis eget rutrum dolor iaculis. Integer sem velit, dapibus eu faucibus id, pulvinar sit amet velit. In et turpis lectus. In in quam id ipsum vulputate congue. Praesent facilisis metus sed urna mollis in condimentum ligula adipiscing. Curabitur tincidunt tempor mi, id adipiscing dolor porttitor eget. Etiam blandit tempus interdum. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec massa leo, hendrerit ut placerat vehicula, gravida ac risus. Aenean ornare congue felis quis hendrerit. Mauris sit amet diam augue. Duis non condimentum quam. Quisque consequat tortor odio. Etiam ornare risus sit amet nibh euismod lacinia.\r\n</p>\r\n<p>\r\nVestibulum in odio odio, nec fermentum diam. Vivamus sed erat ipsum, quis lobortis tortor. Nunc eget feugiat dui. Morbi ornare, arcu ut vulputate mattis, lectus mi ullamcorper turpis, non accumsan velit tortor at neque. Suspendisse quis mi metus. Aliquam congue imperdiet nibh, sit amet venenatis felis ornare sit amet. Nunc imperdiet mattis dui non pellentesque. Quisque sit amet elit quam, et faucibus mi. Donec in varius augue. Fusce vulputate turpis dictum arcu fringilla tristique.\r\n</p>', 'a:5:{s:5:"total";s:2:"67";i:1;s:2:"36";i:2;s:2:"12";i:3;s:1:"9";i:4;s:1:"9";}', 'a:10:{i:0;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:1;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:2;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:3;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:4;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:5;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:6;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:7;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:8;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:9;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}}');

INSERT INTO question (id, timeStart, timeEnd, title, question, responseValue, responses) VALUES
(2, 1333231200, 1333836000, 'Old Question', 'Old answer', 'a:5:{s:5:"total";s:2:"67";i:1;s:2:"36";i:2;s:2:"12";i:3;s:1:"9";i:4;s:1:"9";}', 'a:10:{i:0;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:1;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:2;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:3;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:4;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:5;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:6;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:7;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:8;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}i:9;a:4:{i:0;s:12:"Oliver Spryn";i:1;s:16:"wot200@gmail.com";i:2;s:10:"1334796073";i:3;s:34:"This is my comment. You guys rock!";}}');

INSERT INTO question (id, timeStart, timeEnd, title, question, responseValue, responses) VALUES
(3, 1335823200, 1336428000, 'New Question', 'Stuff', '0', '');

-- --------------------------------------------------------

--
-- Table structure for table saptcha
--

CREATE TABLE saptcha (
  "id" int NOT NULL,
  "question" NTEXT NOT NULL,
  "answer" NTEXT NOT NULL,
  PRIMARY KEY ("id")
) ;

--
-- Dumping data for table saptcha
--


-- --------------------------------------------------------

--
-- Table structure for table sidebar
--

CREATE TABLE sidebar (
  "id" int NOT NULL,
  "position" int NOT NULL,
  "visible" text NOT NULL,
  "published" int NOT NULL,
  "display" int NOT NULL,
  "type" text NOT NULL,
  "content1" NTEXT NOT NULL,
  "content2" NTEXT NOT NULL,
  PRIMARY KEY ("id")
) ;

--
-- Dumping data for table sidebar
--

INSERT INTO sidebar (id, position, visible, published, display, type, content1, content2) VALUES
(10, 1, 'on', 2, 1, 'Custom Content', 'a:7:{s:5:"title";s:4:"Nice";s:7:"content";s:17:"<p>Who cares?</p>";s:8:"comments";N;s:7:"message";s:0:"";s:4:"user";s:3:"278";s:4:"time";i:1332711701;s:7:"changes";s:1:"1";}', '');

INSERT INTO sidebar (id, position, visible, published, display, type, content1, content2) VALUES
(11, 2, 'on', 2, 1, 'Login', 'a:7:{s:5:"title";s:5:"Login";s:7:"content";s:30:"<p>Hi, please login below:</p>";s:8:"comments";N;s:7:"message";s:0:"";s:4:"user";s:3:"278";s:4:"time";i:1333763218;s:7:"changes";s:1:"1";}', '');

-- --------------------------------------------------------

--
-- Table structure for table siteprofiles
--

CREATE TABLE siteprofiles (
  "id" int NOT NULL,
  "siteName" varchar(200) NOT NULL,
  "paddingTop" tinyint NOT NULL,
  "paddingLeft" tinyint NOT NULL,
  "paddingRight" tinyint NOT NULL,
  "paddingBottom" tinyint NOT NULL,
  "width" int NOT NULL,
  "height" int NOT NULL,
  "sideBar" text NOT NULL,
  "auto" text NOT NULL,
  "siteFooter" text NOT NULL,
  "author" varchar(200) NOT NULL,
  "language" varchar(15) NOT NULL,
  "copyright" varchar(200) NOT NULL,
  "description" NTEXT NOT NULL,
  "meta" text NOT NULL,
  "timeZone" varchar(20) NOT NULL,
  "welcome" text NOT NULL,
  "style" varchar(200) NOT NULL,
  "iconType" text NOT NULL,
  "spellCheckerAPI" varchar(50) NOT NULL,
  "saptcha" text NOT NULL,
  "question" NTEXT NOT NULL,
  "answer" NTEXT NOT NULL,
  "failedLogins" int NOT NULL,
  PRIMARY KEY ("siteName")
);

--
-- Dumping data for table siteprofiles
--

INSERT INTO siteprofiles (id, siteName, paddingTop, paddingLeft, paddingRight, paddingBottom, width, height, sideBar, auto, siteFooter, author, language, copyright, description, meta, timeZone, welcome, style, iconType, spellCheckerAPI, saptcha, question, answer, failedLogins) VALUES
(1, 'The Bell News Magazine', 0, 0, 0, 0, 260, 180, 'Right', '', '<p>&copy; 2011 The Bell News Magazine</p>', 'The Bell News Magazine', 'en-US', '© 2011 The Bell News Magazine', 'The collaborative, innovative Bell News Magazine', 'The Bell News Magazine, The PAVCS Bell News Magazine, The Pennsylvania Virtual Charter School Bell News Magazine, Pennsylvania Virtual Charter School Bell News Magazine, Bell News Magazine, Bell News, Bell Magazine, The Bell Magazine, The Bell News', 'America/New_York', 'Ads', 'onlineUniversity.css', 'gif', 'jmyppg6c5k5ajtqcra7u4eql4l864mps48auuqliy3cccqrb6b', 'auto', 'What is the school''s principal''s last name?', 'Perney', 5);

-- --------------------------------------------------------

--
-- Table structure for table staffpages
--

CREATE TABLE staffpages (
  "id" int NOT NULL,
  "position" int NOT NULL,
  "published" int NOT NULL,
  "display" int NOT NULL,
  "content1" NTEXT NOT NULL,
  "name" NTEXT NOT NULL,
  "date" NTEXT NOT NULL,
  "comment" NTEXT NOT NULL,
  PRIMARY KEY ("id")
) ;

--
-- Dumping data for table staffpages
--


-- --------------------------------------------------------

--
-- Table structure for table users
--

CREATE TABLE users (
  "id" int NOT NULL,
  "active" varchar(20) NOT NULL,
  "activation" varchar(15) NOT NULL,
  "firstName" NTEXT NOT NULL,
  "lastName" NTEXT NOT NULL,
  "passWord" NTEXT NOT NULL,
  "changePassword" text NOT NULL,
  "emailAddress1" NTEXT NOT NULL,
  "emailAddress2" NTEXT NOT NULL,
  "emailAddress3" NTEXT NOT NULL,
  "role" NTEXT NOT NULL,
  PRIMARY KEY ("id")
) ;

--
-- Dumping data for table users
--

INSERT INTO users (id, active, activation, firstName, lastName, passWord, changePassword, emailAddress1, emailAddress2, emailAddress3, role) VALUES
(278, '1332876734', '', 'Oliver', 'Spryn', '*F8F0B5DC76103B96A83887EFC253D4643DED29AF', '', 'wot200@gmail.com', '', '', 'Administrator');

INSERT INTO users (id, active, activation, firstName, lastName, passWord, changePassword, emailAddress1, emailAddress2, emailAddress3, role) VALUES
(282, '1000000000', '', 'Oliver', 'Spryn', '*F8F0B5DC76103B96A83887EFC253D4643DED29AF', '', 'sprynoj1@gcc.edu', '', '', 'User');
