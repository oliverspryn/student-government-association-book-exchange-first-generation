CREATE TABLE collaboration (
  id int NOT NULL,
  position int NOT NULL,
  visible text NOT NULL,
  "type" text NOT NULL,
  fromDate NVARCHAR(MAX) NOT NULL,
  fromTime NVARCHAR(MAX) NOT NULL,
  toDate NVARCHAR(MAX) NOT NULL,
  toTime NVARCHAR(MAX) NOT NULL,
  title NVARCHAR(MAX) NOT NULL,
  content NVARCHAR(MAX) NOT NULL,
  assignee NVARCHAR(MAX) NOT NULL,
  task NVARCHAR(MAX) NOT NULL,
  dueDate NVARCHAR(MAX) NOT NULL,
  priority NVARCHAR(MAX) NOT NULL,
  completed NVARCHAR(MAX) NOT NULL,
  directories NVARCHAR(MAX) NOT NULL,
  PRIMARY KEY (id)
);


CREATE TABLE dailyhits (
  id int NOT NULL,
  "date" varchar(255) NOT NULL,
  hits int NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE "external" (
  id int NOT NULL,
  title NVARCHAR(MAX) NOT NULL,
  position int NOT NULL,
  visible text NOT NULL,
  published int NOT NULL,
  "message" int NOT NULL,
  display int NOT NULL,
  content1 NVARCHAR(MAX) NOT NULL,
  content2 NVARCHAR(MAX) NOT NULL,
  PRIMARY KEY (id)
);


CREATE TABLE pagehits (
  id int NOT NULL,
  "page" varchar(255) NOT NULL,
  hits int NOT NULL,
  PRIMARY KEY (id)
);


CREATE TABLE pages (
  id int NOT NULL,
  title NVARCHAR(MAX) NOT NULL,
  position int NOT NULL,
  visible text NOT NULL,
  published int NOT NULL,
  "message" int NOT NULL,
  display int NOT NULL,
  content1 NVARCHAR(MAX) NOT NULL,
  content2 NVARCHAR(MAX) NOT NULL,
  comments1 int NOT NULL,
  comments2 int NOT NULL,
  "name" NVARCHAR(MAX) NOT NULL,
  "date" NVARCHAR(MAX) NOT NULL,
  "comment" NVARCHAR(MAX) NOT NULL,
  PRIMARY KEY (id)
);


CREATE TABLE privileges (
  id int NOT NULL,
  deleteFile int NOT NULL,
  uploadFile int NOT NULL,
  sendEmail int NOT NULL,
  viewStaffPage int NOT NULL,
  createStaffPage int NOT NULL,
  editStaffPage int NOT NULL,
  deleteStaffPage int NOT NULL,
  publishStaffPage int NOT NULL,
  autoPublishStaffPage int NOT NULL,
  addStaffComments int NOT NULL,
  deleteStaffComments int NOT NULL,
  createPage int NOT NULL,
  editPage int NOT NULL,
  deletePage int NOT NULL,
  publishPage int NOT NULL,
  autoPublishPage int NOT NULL,
  createSideBar int NOT NULL,
  editSideBar int NOT NULL,
  deleteSideBar int NOT NULL,
  publishSideBar int NOT NULL,
  autoPublishSideBar int NOT NULL,
  siteSettings int NOT NULL,
  sideBarSettings int NOT NULL,
  deleteComments int NOT NULL,
  createExternal int NOT NULL,
  editExternal int NOT NULL,
  deleteExternal int NOT NULL,
  publishExternal int NOT NULL,
  autoPublishExternal int NOT NULL,
  viewStatistics int NOT NULL
);

INSERT INTO privileges (id, deleteFile, uploadFile, sendEmail, viewStaffPage, createStaffPage, editStaffPage, deleteStaffPage, publishStaffPage, autoPublishStaffPage, addStaffComments, deleteStaffComments, createPage, editPage, deletePage, publishPage, autoPublishPage, createSideBar, editSideBar, deleteSideBar, publishSideBar, autoPublishSideBar, siteSettings, sideBarSettings, deleteComments, createExternal, editExternal, deleteExternal, publishExternal, autoPublishExternal, viewStatistics) VALUES(1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 1, 1, 1, 1, 1, 0, 0, 1, 1, 1, 0, 0, 1, 1, 1, 1, 1, 1, 0, 0, 1);

CREATE TABLE sidebar (
  id int NOT NULL,
  position int NOT NULL,
  visible text NOT NULL,
  published int NOT NULL,
  "message" int NOT NULL,
  display int NOT NULL,
  "type" text NOT NULL,
  title NVARCHAR(MAX) NOT NULL,
  content1 NVARCHAR(MAX) NOT NULL,
  content2 NVARCHAR(MAX) NOT NULL,
  PRIMARY KEY (id)
);


CREATE TABLE siteprofiles (
  id int NOT NULL,
  siteName varchar(200) NOT NULL,
  paddingTop tinyint NOT NULL,
  paddingLeft tinyint NOT NULL,
  paddingRight tinyint NOT NULL,
  paddingBottom tinyint NOT NULL,
  width int NOT NULL,
  height int NOT NULL,
  sideBar text NOT NULL,
  "auto" text NOT NULL,
  siteFooter text NOT NULL,
  author varchar(200) NOT NULL,
  "language" varchar(15) NOT NULL,
  copyright varchar(200) NOT NULL,
  "description" NVARCHAR(MAX) NOT NULL,
  meta text NOT NULL,
  timeZone varchar(20) NOT NULL,
  welcome text NOT NULL,
  style varchar(200) NOT NULL,
  iconType text NOT NULL,
  spellCheckerAPI varchar(50) NOT NULL,
  PRIMARY KEY (siteName)
);

INSERT INTO siteprofiles (id, siteName, paddingTop, paddingLeft, paddingRight, paddingBottom, width, height, sideBar, auto, siteFooter, author, "language", copyright, "description", meta, timeZone, welcome, style, iconType, spellCheckerAPI) VALUES(1, 'Ensigma Suite', 20, 0, 0, 0, 203, 60, 'Left', 'on', '', 'Apex Development', 'en-US', 'Apex Development, All Rights Reserved', 'An interactive, flexible content management system for individuals, organizations, or companies, which is built to suit a variety of needs', 'Apex Development, Ensigma Suite', 'America/New_York', 'Ads', 'backToSchool.css', 'jpg', 'jmyppg6c5k5ajtqcra7u4eql4l864mps48auuqliy3cccqrb6b');

CREATE TABLE staffpages (
  id int NOT NULL,
  title NVARCHAR(MAX) NOT NULL,
  position int NOT NULL,
  published int NOT NULL,
  "message" int NOT NULL,
  display int NOT NULL,
  content1 NVARCHAR(MAX) NOT NULL,
  content2 NVARCHAR(MAX) NOT NULL,
  comments1 int NOT NULL,
  comments2 int NOT NULL,
  "name" NVARCHAR(MAX) NOT NULL,
  "date" NVARCHAR(MAX) NOT NULL,
  "comment" NVARCHAR(MAX) NOT NULL,
  PRIMARY KEY (id)
);


CREATE TABLE users (
  id int NOT NULL,
  active varchar(20) NOT NULL,
  firstName NVARCHAR(MAX) NOT NULL,
  lastName NVARCHAR(MAX) NOT NULL,
  userName NVARCHAR(MAX) NOT NULL,
  "passWord" NVARCHAR(MAX) NOT NULL,
  changePassword text NOT NULL,
  emailAddress1 NVARCHAR(MAX) NOT NULL,
  emailAddress2 NVARCHAR(MAX) NOT NULL,
  emailAddress3 NVARCHAR(MAX) NOT NULL,
  "role" NVARCHAR(MAX) NOT NULL,
  PRIMARY KEY (id)
);

INSERT INTO users (id, active, firstName, lastName, userName, "passWord", changePassword, emailAddress1, emailAddress2, emailAddress3, role) VALUES(35, '1283111276', 'Oliver', 'Spryn', 'spryno724', 'Oliver99', '', 'wot200@zoominternet.net', 'oliverspryn@zoominternet.net', 'wot200@gmail.com', 'Administrator');