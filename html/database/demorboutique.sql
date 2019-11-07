-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2016 at 07:10 PM
-- Server version: 5.6.25
-- PHP Version: 5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `demorboutique`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_menu`
--

CREATE TABLE IF NOT EXISTS `account_menu` (
  `roleid` int(11) NOT NULL,
  `menuid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_menu`
--

INSERT INTO `account_menu` (`roleid`, `menuid`) VALUES
(1, 0),
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 15),
(1, 16),
(1, 17),
(1, 18),
(1, 19),
(1, 20),
(1, 21),
(1, 22),
(1, 23),
(2, 1),
(2, 2),
(2, 3),
(2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `account_role`
--

CREATE TABLE IF NOT EXISTS `account_role` (
  `roleid` int(11) NOT NULL,
  `rolename` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_role`
--

INSERT INTO `account_role` (`roleid`, `rolename`) VALUES
(1, 'Owner'),
(2, 'Admin'),
(3, 'Finance');

-- --------------------------------------------------------

--
-- Table structure for table `account_user`
--

CREATE TABLE IF NOT EXISTS `account_user` (
  `email` varchar(100) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `password` varchar(40) NOT NULL,
  `roleid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_user`
--

INSERT INTO `account_user` (`email`, `fullname`, `password`, `roleid`) VALUES
('franky@demorboutique.com', 'Franky', '0192023a7bbd73250516f069df18b500', 1),
('frankykwek@yahoo.com', 'Franky Kwek', '0192023a7bbd73250516f069df18b500', 2);

-- --------------------------------------------------------

--
-- Table structure for table `blog_category`
--

CREATE TABLE IF NOT EXISTS `blog_category` (
  `categoryid` int(11) NOT NULL,
  `categoryname` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog_category`
--

INSERT INTO `blog_category` (`categoryid`, `categoryname`) VALUES
(1, 'News'),
(2, 'Event'),
(3, 'Style'),
(4, 'aaa');

-- --------------------------------------------------------

--
-- Table structure for table `blog_list`
--

CREATE TABLE IF NOT EXISTS `blog_list` (
  `blogid` int(11) NOT NULL,
  `categoryid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `method` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `createddate` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog_list`
--

INSERT INTO `blog_list` (`blogid`, `categoryid`, `name`, `method`, `description`, `createddate`) VALUES
(1, 2, 'test', 'select-video', '<p>testa sdfsdfsd</p>', '2016-12-10'),
(2, 1, 'static', 'select-image', '<p>sadsadsad</p>', '2016-12-10'),
(3, 3, 'slider', 'select-slider', '', '2016-12-10'),
(4, 1, 'video', 'select-video', '<p>hahahahaha</p>', '2016-12-10');

-- --------------------------------------------------------

--
-- Table structure for table `blog_list_image`
--

CREATE TABLE IF NOT EXISTS `blog_list_image` (
  `listid` int(11) NOT NULL,
  `filepath` varchar(100) NOT NULL,
  `urlpath` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog_list_image`
--

INSERT INTO `blog_list_image` (`listid`, `filepath`, `urlpath`) VALUES
(1, 'blogimage/slider73681.mp4', 'http://localhost:8088/demorboutique/public/product/detail/2'),
(2, 'blogimage/95046.jpg', 'http://localhost:8088/demorboutique/public/'),
(3, 'blogimage/slider63018.jpg', 'aaa'),
(3, 'blogimage/slider48296.jpg', 'bbb'),
(3, 'blogimage/slider36688.png', 'ccc'),
(4, 'blogimage/video63774.mp4', '');

-- --------------------------------------------------------

--
-- Table structure for table `lookup_orderinfo`
--

CREATE TABLE IF NOT EXISTS `lookup_orderinfo` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lookup_orderinfo`
--

INSERT INTO `lookup_orderinfo` (`id`, `name`) VALUES
(1, 'Shipping'),
(2, 'Billing');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE IF NOT EXISTS `member` (
  `userid` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `emailaddress` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `dateofbirth` date NOT NULL,
  `gender` varchar(10) NOT NULL,
  `country` varchar(5) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `postcode` varchar(20) DEFAULT NULL,
  `address` text,
  `telphonenumber` varchar(20) DEFAULT NULL,
  `mobilenumber` varchar(20) DEFAULT NULL,
  `issubscribe` smallint(6) NOT NULL,
  `active` smallint(6) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`userid`, `firstname`, `lastname`, `emailaddress`, `password`, `dateofbirth`, `gender`, `country`, `state`, `city`, `postcode`, `address`, `telphonenumber`, `mobilenumber`, `issubscribe`, `active`) VALUES
(3, 'franky', 'kwek', 'frankykwek@yahoo.com', 'cc03e747a6afbbcbf8be7668acfebee5', '2006-01-01', 'Male', '1', '3', '2', '4', 'test 123', '12345', '1234567', 0, 1),
(2, 'jennifer', 'pauling', 'jenniferpauling11@gmail.com', 'admin123', '1998-08-03', 'Female', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `orderdetail`
--

CREATE TABLE IF NOT EXISTS `orderdetail` (
  `orderno` varchar(10) NOT NULL,
  `productid` int(11) NOT NULL,
  `productname` varchar(100) NOT NULL,
  `productimage` varchar(200) NOT NULL,
  `productcolor` varchar(100) NOT NULL,
  `productprice` int(11) NOT NULL,
  `productsize` varchar(5) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orderdetail`
--

INSERT INTO `orderdetail` (`orderno`, `productid`, `productname`, `productimage`, `productcolor`, `productprice`, `productsize`, `quantity`) VALUES
('241116001', 16, 'da', 'http://localhost:8088/demorboutique/public/assets/images/uploads/product02.jpg', 'productimage/color/92694.jpg', 320000, 'S', 1),
('271116001', 16, 'da', 'http://localhost:8088/demorboutique/public/assets/images/uploads/product02.jpg', 'productimage/color/92694.jpg', 320000, 'S', 1),
('291116001', 19, 'Laptop lenovo', 'http://localhost:8088/demorboutique/public/productimage/main63745117.jpeg', 'productimage/color/92694.jpg', 9000000, 'S', 1),
('291116001', 16, 'da', 'http://localhost:8088/demorboutique/public/assets/images/uploads/product02.jpg', 'productimage/color/92694.jpg', 320000, 'S', 2),
('131216001', 16, 'Test edit', 'http://localhost:8088/demorboutique/public/productimage/main74452039.jpg', 'productimage/color/92694.jpg', 320000, 'S', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orderheader`
--

CREATE TABLE IF NOT EXISTS `orderheader` (
  `orderno` varchar(10) NOT NULL,
  `memberid` int(11) NOT NULL,
  `membername` varchar(200) NOT NULL,
  `memberemail` varchar(100) NOT NULL,
  `paymenttype` varchar(50) NOT NULL,
  `paymentto` int(11) DEFAULT NULL,
  `accountno` varchar(50) DEFAULT NULL,
  `accountname` varchar(50) DEFAULT NULL,
  `totalamount` int(11) DEFAULT NULL,
  `evidence` varchar(100) DEFAULT NULL,
  `voucher` varchar(100) DEFAULT NULL,
  `note` text NOT NULL,
  `trackingno` varchar(50) DEFAULT NULL,
  `subtotal` int(11) NOT NULL,
  `conveniencefee` int(11) NOT NULL,
  `vouchernominal` int(11) NOT NULL,
  `shippingfee` int(11) NOT NULL,
  `tax` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `insertdate` date NOT NULL,
  `updatedate` date NOT NULL,
  `exchangedate` date DEFAULT NULL,
  `isdeleted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orderheader`
--

INSERT INTO `orderheader` (`orderno`, `memberid`, `membername`, `memberemail`, `paymenttype`, `paymentto`, `accountno`, `accountname`, `totalamount`, `evidence`, `voucher`, `note`, `trackingno`, `subtotal`, `conveniencefee`, `vouchernominal`, `shippingfee`, `tax`, `status`, `insertdate`, `updatedate`, `exchangedate`, `isdeleted`) VALUES
('131216001', 3, 'franky kwek', 'frankykwek@yahoo.com', 'Transfer Bank', NULL, NULL, NULL, NULL, NULL, '', '', NULL, 320000, 0, 0, 0, 16000, 'Pending', '2016-12-13', '2016-12-13', NULL, 0),
('241116001', 3, 'franky kwek', 'frankykwek@yahoo.com', '', 1, '123456789', 'qwertyui', 6000000, 'productimage/transfer68288845.jpg', 'DEMORLOGIN', 'test', '123213131', 0, 0, 0, 0, 0, 'Ship', '2016-11-24', '2016-11-25', NULL, 0),
('271116001', 3, 'franky kwek', 'frankykwek@yahoo.com', 'Transfer Bank', 2, '2312312311', 'sdfsdfsdfsd', 50000, 'productimage/transfer17594400.png', 'DEMORLOGIN', 'hahahaha', NULL, 320000, 0, 50000, 0, 16000, 'Paid', '2016-11-27', '2016-12-07', NULL, 0),
('291116001', 3, 'franky kwek', 'frankykwek@yahoo.com', 'Transfer Bank', 1, 'sdf', 'sdfa', 31231231, 'productimage/transfer59906683.jpg', '', 'asdasdasd', '134567', 9640000, 0, 0, 0, 482000, 'Ship', '2016-11-29', '2016-12-07', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `orderhistory`
--

CREATE TABLE IF NOT EXISTS `orderhistory` (
  `orderno` varchar(10) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(20) NOT NULL,
  `remark` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orderhistory`
--

INSERT INTO `orderhistory` (`orderno`, `date`, `status`, `remark`) VALUES
('241116001', '2016-11-24', 'Pending', NULL),
('241116001', '2016-11-24', 'Waiting', NULL),
('241116001', '2016-11-24', 'Paid', NULL),
('241116001', '2016-11-24', 'Ship', '123213131'),
('271116001', '2016-11-27', 'Pending', NULL),
('291116001', '2016-11-29', 'Pending', NULL),
('271116001', '2016-12-05', 'Waiting', NULL),
('291116001', '2016-12-06', 'Waiting', NULL),
('291116001', '2016-12-07', 'Ship', NULL),
('131216001', '2016-12-13', 'Pending', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orderinfo`
--

CREATE TABLE IF NOT EXISTS `orderinfo` (
  `orderno` varchar(10) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `country` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `zipcode` varchar(20) NOT NULL,
  `telphonenumber` varchar(20) NOT NULL,
  `mobilenumber` varchar(20) NOT NULL,
  `info` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orderinfo`
--

INSERT INTO `orderinfo` (`orderno`, `firstname`, `lastname`, `email`, `address`, `country`, `state`, `city`, `zipcode`, `telphonenumber`, `mobilenumber`, `info`) VALUES
('241116001', 'franky', 'kwek', 'frankykwek@yahoo.com', 'test 123', '1', '1', '1', '4', '12345', '1234567', 1),
('241116001', 'franky', 'kwek', 'frankykwek@yahoo.com', 'test 123', '1', '1', '1', '4', '12345', '1234567', 2),
('271116001', 'franky', 'kwek', 'frankykwek@yahoo.com', 'test 123', '1', '1', '1', '4', '12345', '1234567', 1),
('271116001', 'franky', 'kwek', 'frankykwek@yahoo.com', 'test 123', '1', '1', '1', '4', '12345', '1234567', 2),
('291116001', 'franky', 'kwek', 'frankykwek@yahoo.com', 'test 123', '1', '1', '1', '4', '12345', '1234567', 1),
('291116001', 'franky', 'kwek', 'frankykwek@yahoo.com', 'test 123', '1', '1', '1', '4', '12345', '1234567', 2),
('131216001', 'franky', 'kwek', 'frankykwek@yahoo.com', 'test 123', '1', '1', '1', '4', '12345', '1234567', 1),
('131216001', 'franky', 'kwek', 'frankykwek@yahoo.com', 'test 123', '1', '1', '1', '4', '12345', '1234567', 2);

-- --------------------------------------------------------

--
-- Table structure for table `order_notpermit`
--

CREATE TABLE IF NOT EXISTS `order_notpermit` (
  `orderno` varchar(10) NOT NULL,
  `productname` varchar(50) NOT NULL,
  `size` varchar(5) NOT NULL,
  `colour` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `shippingcost` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_notpermit`
--

INSERT INTO `order_notpermit` (`orderno`, `productname`, `size`, `colour`, `quantity`, `shippingcost`) VALUES
('241116001', 'test', 'S', 'merah', 3, 20000),
('241116001', 'a', 'a', 'a', 4, 20000);

-- --------------------------------------------------------

--
-- Table structure for table `order_permit`
--

CREATE TABLE IF NOT EXISTS `order_permit` (
  `orderno` varchar(10) NOT NULL,
  `voucher` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_permit`
--

INSERT INTO `order_permit` (`orderno`, `voucher`) VALUES
('291116001', 2),
('241116001', 2);

-- --------------------------------------------------------

--
-- Table structure for table `order_permit_detail`
--

CREATE TABLE IF NOT EXISTS `order_permit_detail` (
  `orderno` varchar(10) NOT NULL,
  `productid` int(11) NOT NULL,
  `productname` varchar(100) NOT NULL,
  `productimage` varchar(200) NOT NULL,
  `productcolor` varchar(100) NOT NULL,
  `productprice` int(11) NOT NULL,
  `productsize` varchar(5) NOT NULL,
  `quanitity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_permit_detail`
--

INSERT INTO `order_permit_detail` (`orderno`, `productid`, `productname`, `productimage`, `productcolor`, `productprice`, `productsize`, `quanitity`) VALUES
('291116001', 19, 'Laptop lenovo', 'http://localhost:8088/demorboutique/public/productimage/main63745117.jpeg', 'productimage/color/92694.jpg', 9000000, 'S', 1),
('291116001', 16, 'da', 'http://localhost:8088/demorboutique/public/assets/images/uploads/product02.jpg', 'productimage/color/92694.jpg', 320000, 'S', 2),
('241116001', 16, 'da', 'http://localhost:8088/demorboutique/public/assets/images/uploads/product02.jpg', 'productimage/color/92694.jpg', 320000, 'S', 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_refund`
--

CREATE TABLE IF NOT EXISTS `order_refund` (
  `orderno` varchar(10) NOT NULL,
  `productid` int(11) NOT NULL,
  `productname` varchar(100) NOT NULL,
  `productimage` varchar(100) NOT NULL,
  `productcolor` varchar(100) NOT NULL,
  `productprice` int(11) NOT NULL,
  `productsize` varchar(5) NOT NULL,
  `quanitity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_refund`
--

INSERT INTO `order_refund` (`orderno`, `productid`, `productname`, `productimage`, `productcolor`, `productprice`, `productsize`, `quanitity`) VALUES
('291116001', 16, 'da', 'http://localhost:8088/demorboutique/public/assets/images/uploads/product02.jpg', 'productimage/color/92694.jpg', 320000, 'S', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `pagesid` int(11) NOT NULL,
  `pagesname` varchar(50) NOT NULL,
  `pagestext` text NOT NULL,
  `pagesimage` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`pagesid`, `pagesname`, `pagestext`, `pagesimage`) VALUES
(1, 'About De''mor', '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>\r\n<p>Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>\r\n<p>It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n<p>test</p>\r\n<p>asdasdasdsadasd</p>', 'sliderimage/banner_about.jpg'),
(2, 'Exchanges', '<ul>\r\n<li>We do not REFUND AND RETURN your money if the product doesn&rsquo;t meet your expectation but you can do exchange the product by filling in the Exchange Form in the &lsquo;&rsquo;shipping and exchange&rsquo;&rsquo; page.</li>\r\n<li>Unfortunately, we cannot refund your original domestic and international shipping charges. Additionally, we cannot refund customs, duties, taxes, VAT or tariffs. In special cases, if you are returning a purchase, you may be eligible for a refund of a portion or all of the duties and taxes from your local customs office.</li>\r\n<li>\r\n<div>If the color or the size of the article does not meet your expectation then you may exchange your order, or certain products within the order. Within 14 days of receiving your order, you must fill the form in the website Shipping &amp; Exchange Product Form or send an email to cs@demorboutique.com that contains:</div>\r\n<div>a. Invoice Number</div>\r\n<div>b. Product Name</div>\r\n<div>c. Reason why you want to exchange</div>\r\n<div>At this time, you can also inform us of the article that you wish to receive in exchange.</div>\r\n</li>\r\n<li>If you choose to exchange an item for any reason and the item is presented in good condition with the tag on it, no perfume, no wash and never worn before.</li>\r\n<li>You can then post the envelope, or the package with the article you wish to exchange, back to DE&rsquo;MOR. You are responsible for the postage costs of the returned article. We hold the right not to accept returned packages and envelopes where the postage costs have not been completely paid for.</li>\r\n</ul>', ''),
(3, 'Shipping', '<div style="font-weight: bold; margin-bottom: 10px;">Domestic and International</div>\n				<ul>\n					<li>Orders that are received on a certain day will be processed on the next business day. We do not ship on Saturdays, Sundays or on Indonesian Public holidays.</li>\n					<li>Orders are usually packed and ready to ship in 1 to 3 business days.</li>\n					<li>Our preferred service is provided via FedEx service. Delivery can be expected within 5 to 7 business days depend on the destination of the country, Monday through Friday. Orders placed on Friday after 12 p.m. ET and over the weekend will be shipped on Monday. Saturday and Sunday delivery is not available. Preferred Service is not available to P.O. Boxes.</li>\n					<li>Shipments are subject to customs clearance procedures, which can cause delays beyond original delivery estimates.</li>\n					<li>A business day is considered to be Monday through Friday, excluding certain holidays.</li>\n					<li>Duties and taxes are set by the destination country. The amount of applicable duties and taxes will vary by country. This cost will be borne by the customer.</li>\n					<li>Domestic and International shipments will not ship until all item(s) ordered become available.</li>\n					<li>At this time, gift packaging is unavailable for domestic and international shipments.</li>\n					<li>Domestic and International customers may ship to multiple addresses by placing a separate order for each shipping address. We cannot ship single domestic and international orders to multiple addresses at this time.</li>\n					<li>\n						<div>The fuel surcharge for each shipment is assessed on the net freight charge and the following transportation-related surcharges:</div>\n						<div>a. Broker Routing Fee (Broker Select);</div>\n						<div>b.	Out of Delivery Area (ODA);</div>\n						<div>c. Out of Pickup Area (OPA);</div>\n						<div>d.	Residential Delivery Surcharge (RESI)</div>\n						<div>e.	Saturday Delivery (SDL); and,</div>\n						<div>f.	Saturday Pickup (SPU).</div>\n						<div>Please refer to <a href="#">http://www.fedex.com/id/rates/dfs</a></div>\n					</li>\n					<li>Please note that shipping windows are estimates and delivery dates cannot be guaranteed. You will be given estimated delivery days in shipping page, based on your selected destination country and the shipping methods available for the items in your shopping cart.</li>\n					<li>The following is an <a href="#">estimated delivery</a> for our international orders. You will be quoted a specific estimated delivery at the time of checkout that is based on your selected destination country and the shipping methods available for the items in your shopping cart.</li>\n				</ul><br/>\n				<div>\n					<table>\n						<tr>\n							<th width="350">Destinations</th>\n							<th width="200">Delivery Time Estimate</th>\n						</tr>\n						<tr>\n							<td>Singapore</td>\n							<td>1-8 business days</td>\n						</tr>\n						<tr>\n							<td>China(South), Hong Kong and Malaysia</td>\n							<td>1-5 business days</td>\n						</tr>\n						<tr>\n							<td>USA and Mexico</td>\n							<td>1-7 business days</td>\n						</tr>\n						<tr>\n							<td>Canada, Japan and Australia</td>\n							<td>1-6 business days</td>\n						</tr>\n						<tr>\n							<td>Germany, France and United Kingdom</td>\n							<td>1-7 business days</td>\n						</tr>\n						<tr>\n							<td>United Emirate Arab, Turkey and India</td>\n							<td>1-7 business days</td>\n						</tr>\n						<tr>\n							<td>Brazil, Argentina and South Africa</td>\n							<td>1-14 business days</td>\n						</tr>\n					</table>\n				</div>', ''),
(4, 'Privacy Policy', '<p>WHAT TYPE OF INFORMATION DOES DEMORBOUTIQUE.COM COLLECT ONLINE?</p>\r\n<p>Collection of Personal Information:</p>\r\n<p>Demorboutique.com may ask you to provide personal information when you establish or update an Account on this site, sign up to receive emails or texts from DE&rsquo;MOR or other marketing materials, make a purchase, create or update your Wish List, send items to a friend, view your order history, participate in contests and surveys, submit a career profile or contact us. Categories of personal information collected online include name, billing and shipping address information, email address, telephone number, mobile number, payment card information, recipient''s name, address and email address, items purchased combined with your other personal information, r&eacute;sum&eacute; information and any other information you choose to provide us.</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>Information collected through technology</p>\r\n<p>Information gathered through technology is used by us to determine such things as which parts of our website are most visited or used, what products are browsed and/or purchased, the effectiveness of our websites and advertisements, and difficulties visitors may experience in accessing our websites. Cookies and pixel tags may be used to tell us whether demorboutique.com has been previously visited by you or someone using your computer, what products or portions of the website you may have viewed or products added to your Shopping Bag. The information collected through technology may be associated with other information such as your IP address, name, purchases made, your contact information, and your actions in response to our communications with you. This is then used to enhance and personalize your online browsing and shopping experience, to market and promote our products, events, and services, and those of third parties, to you and to assist in the administration of your use of features and programs on our site, and to determine the display of content and advertising based on your interests on third party sites where you may visit.</p>\r\n<p><br /><br /></p>\r\n<p>Information collected by us on Social Media Pages</p>\r\n<p>De''mor uses the information collected on its Social Media Pages to send communications regarding our products, services, and promotions; to respond to your inquiries; to conduct surveys, sweepstakes or contests; to analyze your activity on our Social Media Pages; and to develop our products and services.</p>\r\n<p><br /><br /></p>\r\n<p>WHAT INFORMATION DOES DEMORBOUTIQUE.COM SHARE WITH THIRD PARTIES?</p>\r\n<p>We may use third-party vendors to help us provide services to you, such as monitoring site activity; hosting the website; assisting us with our Social Media Pages; providing promotional strategy; processing orders; running promotions, events and surveys; maintaining our database; providing store locator services; processing employment applications; administering and monitoring emails and text messages; or to market to you. We may make names, addresses and/or email addresses collected online available to other companies as provided herein.</p>\r\n<p>&nbsp;</p>\r\n<p>The mandatory personal information we collect from you will be used and or shared within our corporate group and to third parties for one or the following purposes:</p>\r\n<ul>\r\n<li>To deliver products that you purchase from our website. For example, we may pass your name and address on to a third party such as our courier service company or supplier of choice in order to make delivery of the product to you;</li>\r\n<li>To inform and update you on the delivery of the product and for customer support purposes;</li>\r\n<li>To provide you with relevant product information such as SKUs;</li>\r\n<li>To process your orders and to provide you with the services and information offered through our website and which you may request;</li>\r\n<li>To allow us to administer your registered account with us;</li>\r\n<li>To verify and carry out financial transactions in relation to payments you may make online. For example, payments that you make through our website will be processed by our appointed agent. Disclosure to these data processing agents such as that of our appointed agent in this context is necessary for the purpose of conducting the sales transaction that you have opted for.</li>\r\n<li>The non-mandatory personal information such as date of birth and gender are used to carry out research/es on our users&rsquo; demographics and for us to send you suggestion or information in the form of promotional emails which we think you may find useful, thereby, enhancing your experience when you visit our website. By providing us these non-mandatory personal information, you are deemed to have consented to be part of our research/es and to receiving suggestions or information as outlined above.</li>\r\n</ul>\r\n<p><br /><br /></p>\r\n<p>If you provide us your email address after January 1, 2017 (including updating your email information), provided you have not opted out of receiving marketing emails from us, your email address may also be shared with other companies, so that those businesses may send you information about their products.</p>\r\n<p><br /><br /></p>\r\n<p>When you send an email from demorboutique.com to a friend, we will send your selected recipient your email address, message, and your selected outfit or item(s). We may include an opportunity for the recipient to sign up to receive promotional materials from demorboutique.com.</p>\r\n<p><br /><br /></p>\r\n<p>You should be aware that we may disclose specific information about you if necessary to do so by law or based on our good faith belief that it is necessary to conform or comply with the law or is necessary to protect the users of our website, the website or the public.</p>\r\n<p><br /><br /></p>\r\n<p>We may use advertisers, third party ad networks, and other advertising companies to serve advertisements on the Website. Please be advised that such advertising companies may gather information about your visit to the Website or other sites (such as through cookies, web beacons and other technologies) to enable such advertising companies to market products or services to you, to monitor which ads have been served to your browser and which webpages you were viewing when such ads were delivered.</p>\r\n<p><br /><br /></p>\r\n<ul>\r\n<li>Subscription to our marketing and promotional materials</li>\r\n</ul>\r\n<p>In addition to the personal information outlined above, when you register a De&rsquo;mor account with us, you shall be asked if you would like to subscribe to our marketing and or promotional materials from time to time. These marketing and or promotional materials may come from within our corporate group wholly or through affiliation with third parties. If you choose to so subscribe, you are deemed to have consented to us processing within our corporate group and or third parties your personal information for this purpose. You can always choose to unsubscribe from marketing information at any time by opting for the unsubscribe function within the electronic marketing material.</p>\r\n<p><br /><br /></p>\r\n<ul>\r\n<li>Accessing Actual Orders</li>\r\n</ul>\r\n<p>Your actual order details may be stored with us but for security reasons, cannot be retrieved directly by us. However, you may access this information by logging into your account on the website. Here, you can view the details of your orders that have been completed, those which are open and those which are to be dispatched as well as administer your address details, bank details and any newsletter to which you may have subscribed. You undertake to treat the personal access data confidentially and not make it available to unauthorized third parties. We cannot assume any liability for any misuse of passwords unless this misuse is through our own fault.</p>\r\n<p style="font-size: 18px; margin-bottom: 10px;">&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p><br /><br /></p>\r\n<p>UPDATING YOUR PERSONAL INFORMATION</p>\r\n<p>We prefer to keep your personal information accurate and up-to-date. To do this, we provide you with the opportunity to update or modify your demorboutique.com Account when you Log In.</p>\r\n<p><br /><br /></p>\r\n<p>PRIVACY OF CHILDREN ON OUR WEBSITE</p>\r\n<p>To ensure compliance with federal law, demorboutique.com does not knowingly collect or maintain information provided by children under the age of 13.</p>\r\n<p><br /><br /></p>\r\n<p>LINKS TO OTHER WEBSITES AND SERVICES</p>\r\n<p>For your convenience, our website may contain links to other websites. Demorboutique.com is not responsible for the privacy practices, advertising, products or the content of such websites. Links that appear on Demorboutique.com should not necessarily be deemed to imply that Demorboutique.com endorses or has any affiliation with the linked websites. We encourage you to review the separate privacy policies of each site you visit.</p>\r\n<p><br /><br /></p>\r\n<p>UPDATES TO PRIVACY POLICY</p>\r\n<p>As Demorboutique.com continues to offer visitors new and different types of content and services, Demorboutique.com may modify its information collection, use or disclosure practices. Should there be a material change to our information collection, use or disclosure practices, it will be applied only to information collected on a going-forward basis, and we will update this Privacy Policy.</p>\r\n<p><br /><br /></p>\r\n<p>SECURITY STATEMENT</p>\r\n<p>Demorboutique.com has imposed confidentiality obligations on its service providers who will have access to the personal information collected on this site. In addition, we have implemented administrative, technical and physical measures to address the confidentiality of personal information collected on this website.<br />While we implement the above security measures for this website, you should be aware that 100% security is not always possible.</p>\r\n<p><br /><br /></p>\r\n<p>Security of Your Personal Information</p>\r\n<p>De''mor ensures that all information collected will be safely and securely stored. We protect your personal information by:</p>\r\n<p>&nbsp;</p>\r\n<ul>\r\n<li>Allowing access to personal information only via passwords;</li>\r\n<li>Maintaining technology products to prevent unauthorized computer access; and</li>\r\n<li>Securely destroying your personal information when it is no longer needed for our record retention purposes.</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p>De''mor uses 128-bit SSL (Secure Sockets Layer) encryption technology when processing your financial details. 128-bit SSL encryption is approximated to take at least one trillion years to break, and is the industry standard.</p>\r\n<p><br /><br /></p>\r\n<p>Disclosure of Personal Information</p>\r\n<p>We will not share your information with any other organizations other than our corporate group and those third parties directly related to and necessary for the purchase of products, delivery of the same and purpose for which you have authorized. In exceptional circumstances, De&rsquo;mor may be required to disclose personal information, such as when there are grounds to believe that the disclosure is necessary to prevent a threat to life or health, or required by the law. De&rsquo;mor is committed to complying with the Personal Data Protection Act 2010,in particular, its policies as well as corresponding guidelines and orders.<br />If you believe that your privacy has been breached by de&rsquo;mor please contact cs@demorboutiwue.com and we will resolve the issue.</p>\r\n<p>&nbsp;</p>', ''),
(5, 'Terms & Conditions', '<p>Welcome to www.demorboutique.com (the "Website"), operated by DE&rsquo;MOR (private company). ("DE&rsquo;MOR", "we", "our", or "us"). The Website enables anonymous visitors to the Website ("Visitors") to browse the Website, and Visitors who are at least eighteen (17) year of age and not a minor in their state or residence, and who affirmatively indicate their agreement to abide by these Terms of Use (this "Agreement") by means of a click-through consent where this option is made available by DE&rsquo;MOR ("Registrants"), to purchase our products through the Website.</p>\r\n<p><br /><br /></p>\r\n<p>The terms "you", "your" and "yours" when used herein refer to either Registrants or Visitors, or to both Registrants and Visitors collectively, as applicable; provided that such terms will refer collectively to both Registrants and Visitors unless the context of this Agreement indicates otherwise. This Agreement sets forth the terms and conditions which govern your use of the Website.</p>\r\n<p><br /><br /></p>\r\n<p>By accessing the Site, you confirm your understanding of the Terms and Conditions. If you do not agree to these Terms and Conditions of use, you shall not use this website. The Site reserves the right, to change, modify, add, or remove portions of these Terms and Conditions of use at any time. Changes will be effective when posted on the Site with no other notice provided. Please check these Terms and Conditions of use regularly for updates. Your continued use of the Site following the posting of changes to these Terms and Conditions of use constitutes your acceptance of those changes.</p>\r\n<p><br /><br /></p>\r\n<p>1. Copyright Notice and Use of Website.</p>\r\n<p>&nbsp;</p>\r\n<p>The design of this Website and all text, graphics, information, content, and other material displayed on or that can be downloaded from this Website are protected by copyright, trademark and other laws and may not be used except as permitted in these Terms and Conditions or with prior written permission of the owner of such material. The software and other technological components of this Website and the Website as a compilation are &copy; 2016, Dilenium Company. or its affiliates and suppliers. The contents (including without limitation, the look and feel, all text, photographs, images, video and audio) of this Website are &copy; 2016, DE&rsquo;MOR or their respective affiliates and suppliers. All rights reserved. You may not modify the information or materials displayed on or that can be downloaded from this Website in any way or reproduce or publicly display, perform, distribute or otherwise use any such information or materials for any public or commercial purpose. You may not copy, reproduce, publish, transmit, distribute, perform, display, post, modify, create derivative works from, sell, license or otherwise exploit this Website. Any unauthorized use of any such information or materials may violate copyright laws, trademark laws, laws of privacy and publicity, and other laws and regulations and is prohibited. In the event of a violation of these laws and regulations, DE&rsquo;MOR reserves the right to seek all remedies available by law and in equity. DE&rsquo;MOR reserves the right to block or deny access to the Website to anyone at any time for any reason.</p>\r\n<p><br /><br /></p>\r\n<p>2. Registration.</p>\r\n<p>&nbsp;</p>\r\n<ul>\r\n<li>Profile; Password. You will only be able to use certain functionality of the Website if you register with us. If you decide to register with us, you will receive a user ID and password ("Profile") to access your Registrant account ("Account"). You shall not allow any third party to use your Profile or Account to access the Website and you shall strictly safeguard all information that would enable any individual or entity to access the Website by using your Profile. You are fully responsible for your failure to safeguard information and/or to permit any other person to access or use the Website using your Profile and/or Account, and for all activities that occur under your Profile and/or Account. You may not sell or otherwise transfer your Profile or Account or any portion thereof. You shall notify DE&rsquo;MOR immediately of any unauthorized use of their Profile, Account or otherwise of the Website.</li>\r\n<li>Accurate Information. You shall provide us with accurate, complete and current information about yourself during registration and at all other times, and you shall update all information provided to us or requested by us if and as soon as such information changes.</li>\r\n<li>Disabling or Revocation of Account. We have the right to cancel your registration for any reason or for no reason at any time, as determined in our sole discretion, including without limitation if we believe you have violated this Agreement. If we disable access to your Account, you may be prevented from accessing the Website, your Account details and/or any files or other various Website materials, including without limitation all text, comments, icons, images, messages, tags, links, photographs, audio, video and other content (collectively, "Content") which are contained in or accessible through your Account, all of which may be deleted by us. Such disabling or cancelling of your Account will mean that you may lose access to all Content submitted by you.</li>\r\n<li>Cessation of Services. The form and nature of the products or services offered through the Website may change from time to time without prior notice to you. As part of our continuing innovation, DE&rsquo;MOR may stop (permanently or temporarily) providing certain Website features to you in our sole discretion, without prior notice to you.</li>\r\n</ul>\r\n<p><br /><br /></p>\r\n<p>3. User Submissions.</p>\r\n<p>&nbsp;</p>\r\n<p>The Website permits the submission of user-submitted ratings and reviews in addition to the submission of other user-submitted text, artwork, photographs, product ideas, video, audio, and images ("User Submissions"). You understand that such User Submissions may be accessed and viewed by others, including by the general public, and, whether or not such User Submissions are published, DE&rsquo;MOR does not guarantee any confidentiality with respect to any User Submissions. You are solely responsible for your own User Submissions and the consequences of publishing them on the Website.</p>\r\n<p>&nbsp;</p>\r\n<p>By submitting User Submissions, you hereby grant to DE&rsquo;MOR an unrestricted, nonexclusive, perpetual, royalty-free, worldwide, transferable and irrevocable license and right, but not the obligation, to use, edit, alter, copy, reproduce, disclose, display, publish, remove, prepare derivative works from, perform, distribute, exhibit, broadcast, or otherwise exploit the User Submissions. In whole or in part, in any form, media or technology, now known or hereafter developed including, without limitation, broadcast and cable television, radio, mobile transmission, and the internet, for any purpose whatsoever including, without limitation, advertising, promotion, entertainment or commercial purposes, without any payment to or further authorization by you. Under the license granted herein, DE&rsquo;MOR shall be free to use any ideas or concepts contained in the User Submissions without further attribution, compensation or notice to you. DE&rsquo;MOR does not endorse any User Submissions or any opinion, recommendation, or advice expressed therein. DE&rsquo;MOR reserves the right to determine in its sole discretion whether User Submissions are appropriate and comply with these Terms of conditions, including without limitation, the Prohibited Uses of Website and Services, Review Guidelines and other applicable rules and restrictions, and whether or not to allow the uploading and/or removal of any User Submissions.</p>\r\n<p><br /><br /></p>\r\n<p>4. Transactions.</p>\r\n<p>&nbsp;</p>\r\n<ul>\r\n<li>\r\n<div>Products</div>\r\n<p>Several of our products are offered for sale through the Website. In the event you wish to purchase any of these products, you will be asked by DE&rsquo;MOR or an authorized third party DE&rsquo;MOR&rsquo;s behalf to supply certain information to us or to an agent, including without limitation, your full name, address and credit card information. Please note, however, that DE&rsquo;MOR is not responsible for processing any payments made via the Website and that DE&rsquo;MOR does not have access to your credit card information. A third party maintains this information. You shall provide DE&rsquo;MOR or any third party acting as our agent with accurate, complete and current information at all times, and to comply with the terms and conditions of any ancillary agreement that you may enter into which governs your purchase of any product.</p>\r\n</li>\r\n<li>\r\n<div>Payments</div>\r\n<p>The prices of products are indicated in Indonesia Rupiah (IDR). Your right to any product that is available for purchase through the Website is conditional on our receipt of the appropriate full payment and related costs for such product. If such payment and costs cannot be charged to your credit card or if a charge is refunded for any reason, including chargeback, we reserve the right to cancel your order and/or suspend or terminate your Account. You are responsible for all charges made under your Account.</p>\r\n</li>\r\n<li>\r\n<div>Taxes</div>\r\n<p>You are responsible for paying all applicable taxes arising out of any purchase made under your Account or otherwise made by you.</p>\r\n</li>\r\n<li>\r\n<div>Shipping</div>\r\n<p>You are responsible for paying all such applicable rates.</p>\r\n</li>\r\n<li>\r\n<div>Product Descriptions</div>\r\n<p>We attempt to be as accurate as possible in describing products (including pricing) offered for purchase through the Website; however, we do not warrant or represent that all such descriptions are complete, current or error-free. If you purchase one of our products and such product was not accurately described or depicted on the Website, your sole remedy shall be to return such unused product to us within (14) days of your receipt. We do exchange of the product that you bought by fill the Exchange Form. We change our product descriptions and pricing from time to time, so you must check these details before ordering from us. We also cannot guarantee product availability. From time to time, DE&rsquo;MOR may have to cancel or refuse an order placed by you. We may, in our sole discretion, limit or cancel quantities purchased per person, per household or per order. These restrictions may include orders placed by or under the same customer account, the same credit card, and/or orders that use the same billing and/or shipping address. In such an instance, if practical, we will notify you of our reasons for cancelling or refusing the order. We will do so via the e-mail and/or billing address/phone number provided at the time the order was made. We reserve the right to limit or prohibit orders that, in our sole judgment, appear to be placed by dealers, resellers or distributors.</p>\r\n</li>\r\n<li>\r\n<div>Exchange</div>\r\n<p>If you have purchased a product offered through the Website that you wish to exchange to us, you must adhere to our exchange Policy. Your sole remedy for any and all failures, delays or interruptions with respect to the ordering and delivery of our products ordered by you through the Website is limited to a exchange for such products, if we determine in our sole discretion that you have complied with our Exchange Policy.</p>\r\n</li>\r\n</ul>\r\n<p><br /><br /></p>\r\n<p>5. Third Party Links.</p>\r\n<p>&nbsp;</p>\r\n<p>The Website provides links to third party websites that we believe may be of possible interest to you. Because we do not endorse or otherwise have control over such websites, we are not responsible or liable, directly or indirectly, for (i) the availability of such websites, (ii) any content, data, text, software, music, sound, photographs, video, messages, tags, links, advertising, services, products, or other materials on or available from such websites, (iii) your participation, correspondence or business dealings with any third party found on or through the Website regarding payment and delivery of specific goods and services, and any other terms, conditions, representations or warranties associated with such dealings, which are solely between you and any such third party, or (iv) any damage or loss caused or alleged to be caused by or in connection with your interaction with any such third party. Your use of any website linked to from the Website is subject to the policies and procedures of the owner of such website, and your use of all such websites is subject to such policies and procedures and not to the terms and conditions of this Agreement. You understand that by using any third party website linked to from the Website, you may be exposed to content or other materials that are offensive, indecent, defamatory or otherwise objectionable.</p>\r\n<p><br /><br /></p>\r\n<p>6. Prohibit Use.</p>\r\n<p>&nbsp;</p>\r\n<p>YOU SHALL NOT USE THE WEBSITE IN ANY MANNER THAT:</p>\r\n<p>&nbsp;</p>\r\n<ul>\r\n<li>Is designed to interrupt, destroys or limit the functionality of, any computer software or hardware or telecommunications equipment (including without limitation by means of software viruses or any other computer code, files or programs);</li>\r\n<li>Interferes with or disrupts the Website, services connected to the Website, or otherwise interferes with operations or services of the Website in any way;</li>\r\n<li>infringes any copyright, trademark, trade secret, patent or other right of any party, or defames or invades the publicity rights or the privacy of any person, living or deceased (or impersonates any such person);</li>\r\n<li>consists of any unsolicited or unauthorized advertising, promotional materials, "junk mail," "spam," "chain letters," "pyramid schemes," or any other form of solicitation; causes us to lose (in whole or part) the services of our internet service providers or other suppliers;</li>\r\n<li>links to materials or other content, directly or indirectly, to which you do not have a right to link;</li>\r\n<li>is false, misleading, harmful, threatening, abusive, harassing, tortious, defamatory, vulgar, obscene, libelous, invasive of another''s privacy, hateful, or racially, ethnically or otherwise objectionable, as determined by DE&rsquo;MOR in its sole discretion;</li>\r\n<li>copies, modifies, creates a derivative work of, reverse engineers, decompiles or otherwise attempts to extract the source code of the software underlying the Website or any portion thereof;</li>\r\n<li>violates, or encourages anyone to violate this Agreement, and ancillary terms and conditions listed on the Website, or the Privacy Policy; or</li>\r\n<li>violates, or encourages anyone to violate, any applicable local, state, national, or international law, regulation or order.</li>\r\n</ul>\r\n<p><br /><br /></p>\r\n<p>7. Limitation of Liability.</p>\r\n<p>&nbsp;</p>\r\n<p>IN NO EVENT SHALL ANY OF THE DE&rsquo;MOR PARTIES BE LIABLE FOR LOST PROFITS OR FOR ANY SPECIAL, INCIDENTAL, INDIRECT, CONSEQUENTIAL OR PUNITIVE DAMAGES ARISING OUT OF OR IN CONNECTION WITH, DIRECTLY OR INDIRECTLY, YOUR USE OF (I) THE WEBSITE (INCLUDING WITHOUT LIMITATION YOUR USE OF ANY CONTENT APPEARING THEREON), OR (II) ANY PRODUCT PURCHASED THROUGH THE WEBSITE, WHETHER OR NOT DE&rsquo;MOR HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES. THE AGGREGATE LIABILITY OF THE DE&rsquo;MOR PARTIES TO YOU OR ANY THIRD PARTY IN ANY CIRCUMSTANCE IS LIMITED TO THE LESSER OF (A) ALL PRODUCTS PURCHASED IN THE SIX (6) MONTH PERIOD IMMEDIATELY PRIOR TO THE ARISING OF SUCH LIABILITY, OR (B) TEN MILION RUPIAH (IDR10.000.000).</p>\r\n<p>&nbsp;</p>\r\n<p>SOME JURISDICTIONS DO NOT ALLOW THE EXCLUSION OF CERTAIN WARRANTIES OR THE LIMITATION OR EXCLUSION OF LIABILITY FOR SPECIAL, INCIDENTAL, INDIRECT, CONSEQUENTIAL OR PUNITIVE DAMAGES. ACCORDINGLY, SOME OF THE ABOVE LIMITATIONS HEREOF MAY NOT APPLY TO YOU.</p>\r\n<p><br /><br /></p>\r\n<p>8. General.</p>\r\n<p>&nbsp;</p>\r\n<p>If any provision of this Agreement is held to be invalid by a court having competent jurisdiction, the invalidity of such provision shall not affect the validity of the remaining provisions of this Agreement, which shall remain in full force and effect. Section headings are for reference purposes only and in no way define, limit, construe or describe the scope or extent of such section. This Agreement and any ancillary terms and conditions referenced herein sets forth the entire understanding and agreement between us with respect to the subject matter hereof. The provisions of this Agreement shall survive termination or expiration to the extent necessary to carry out the obligations of you and DE&rsquo;MOR hereunder.</p>\r\n<p><br /><br /></p>\r\n<p>9. Disclaimers.</p>\r\n<p>&nbsp;</p>\r\n<p>Your use of this site is at your risk. The information, materials and services provided on or through this Website are provided "as is" without any warranties of any kind including warranties of merchantability, fitness for a particular purpose, title, or non-infringement of intellectual property. TO THE FULLEST EXTENT PERMISSIBLE BY APPLICABLE LAW, NEITHER DE&rsquo;MOR, THEIR SUPPLIERS, NOR ANY OF THEIR RESPECTIVE AFFILIATES WARRANT THE ACCURACY OR COMPLETENESS OF THE INFORMATION, MATERIALS OR SERVICES PROVIDED ON OR THROUGH THIS WEBSITE. The information, materials and services provided on or through this Website may be out of date, and neither DE&rsquo;MOR, its suppliers, nor any of their respective affiliates makes any commitment or assumes any duty to update such information, materials or services.</p>\r\n<p><br /><br /></p>\r\n<p>10. Contact Us.</p>\r\n<p>&nbsp;</p>\r\n<p>If you have any questions or concerns regarding the Website, please contact us by e-mail at <a href="http://&lt;?php echo $_SERVER[''HTTP_HOST''] ?&gt;/demorboutique/contact.php">cs@demorboutique.com</a> or write to us at DE&rsquo;MOR Boutique, Komplex Pondok Bambu Kuning Blok B4 No. 11, Bojonggede, Bogor, 16320, Indonesia.</p>', '');

-- --------------------------------------------------------

--
-- Table structure for table `pages_career`
--

CREATE TABLE IF NOT EXISTS `pages_career` (
  `email` varchar(100) NOT NULL,
  `careercontent` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pages_career`
--

INSERT INTO `pages_career` (`email`, `careercontent`) VALUES
('franky@yahoo.com', '<p>ahaha test</p>\r\n<p>asdasdsaas</p>\r\n<p>dadasdasdasdsad</p>');

-- --------------------------------------------------------

--
-- Table structure for table `pages_career_detail`
--

CREATE TABLE IF NOT EXISTS `pages_career_detail` (
  `careerid` int(11) NOT NULL,
  `careertitle` varchar(50) NOT NULL,
  `careerdate` date NOT NULL,
  `careercontent` text NOT NULL,
  `ispublish` tinyint(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pages_career_detail`
--

INSERT INTO `pages_career_detail` (`careerid`, `careertitle`, `careerdate`, `careercontent`, `ispublish`) VALUES
(1, 'web developer', '2016-09-01', '<div class="faq20">\r\n<div>PERSYARATAN:</div>\r\n<ul class="list-dot">\r\n<li>Lulusan S1 Teknik Informatika/Sistem Informasi (Tidak diutamakan, yang penting berpengalaman)</li>\r\n<li>Menguasai bahasa pemrograman PHP</li>\r\n<li>Menguasai database engine MySQL</li>\r\n<li>Memaksimalkan web security</li>\r\n<li>Menguasai SEO (Bonus)</li>\r\n<li>Menguasai back-end website selama 1 tahun</li>\r\n</ul>\r\n</div>\r\n<div class="faq20">\r\n<div>TANGGUNG JAWAB PEKERJAAN:</div>\r\n<ul class="list-dot">\r\n<li>Membuat projek based web menggunakan PHP, MySQL bersama AJAX dan Javascript</li>\r\n<li>Melakukan testing dan debugging</li>\r\n<li>Bekerja dengan pasukan luar/dalaman</li>\r\n<li>Ketua projek apabila berpengalaman dan cukup mahir</li>\r\n</ul>\r\n</div>\r\n<div>\r\n<div>KRITERIA:</div>\r\n<ul class="list-dot">\r\n<li>Usia 20 - 30 tahun</li>\r\n<li>Bertanggung jawab dan pekerja keras</li>\r\n<li>Mampu bekerja sesuai dengan deadline</li>\r\n<li>Siap bekerja secara team maupun individu</li>\r\n</ul>\r\n</div>', 1),
(2, 'web designer', '2016-09-14', '<p>syarat wjadi web designer</p>', 1),
(3, 'Senior web expert', '2016-08-19', '<p>hahahahhahahahahahaaaa</p>\r\n<p>sdfsdfdsfdsf</p>\r\n<p>sdfdsfdsf</p>\r\n<p>&nbsp;</p>\r\n<p>testing</p>\r\n<p>hahaaaa</p>', 1),
(4, 'web expert', '2016-08-19', 'hahahahhahahahahahaaaa', 1),
(6, 'testsf', '2016-09-25', '<p>dsfdsfsdfsdfsdfdsfs</p>', 0),
(7, 'adasdsa', '2016-11-22', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pages_contact`
--

CREATE TABLE IF NOT EXISTS `pages_contact` (
  `operation` varchar(500) NOT NULL,
  `phonenumber` varchar(50) NOT NULL,
  `mobilenumber` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `maps` text NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pages_contact`
--

INSERT INTO `pages_contact` (`operation`, `phonenumber`, `mobilenumber`, `email`, `maps`, `address`) VALUES
('9:00-17:00', '021-4529889111', '021-4529889', 'cs@demorboutique.com', 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15866.752855506122!2d106.78747754999999!3d-6.17248325!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xc67ef3c54c15e885!2sDayTrans+-+Grogol!5e0!3m2!1sen!2sid!4v1475412408207', '<p>Jl. Kemanggisan Hilir III</p>\r\n<p>Blok AB no 89</p>\r\n<p>20245</p>');

-- --------------------------------------------------------

--
-- Table structure for table `pages_footer`
--

CREATE TABLE IF NOT EXISTS `pages_footer` (
  `payment` text NOT NULL,
  `copyright` varchar(100) NOT NULL,
  `socialfacebook` varchar(400) NOT NULL,
  `socialinstagram` varchar(400) NOT NULL,
  `socialpinterest` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pages_footer`
--

INSERT INTO `pages_footer` (`payment`, `copyright`, `socialfacebook`, `socialinstagram`, `socialpinterest`) VALUES
('<ul class="list-payment">\r\n<li><img class="img-responsive" src="http://localhost:8088/demorboutique/public/assets/images/icons/master.png" alt="" data-mce-src="http://localhost:8088/demorboutique/public/assets/images/icons/master.png"></li>\r\n<li><img class="img-responsive" src="http://localhost:8088/demorboutique/public/assets/images/icons/visa.png" alt="" data-mce-src="http://localhost:8088/demorboutique/public/assets/images/icons/visa.png"></li>\r\n<li><img class="img-responsive" src="http://localhost:8088/demorboutique/public/assets/images/icons/bca.png" alt="" data-mce-src="http://localhost:8088/demorboutique/public/assets/images/icons/bca.png"></li>\r\n<li><img class="img-responsive" src="http://localhost:8088/demorboutique/public/assets/images/icons/mandiri.svg" alt="" data-mce-src="http://localhost:8088/demorboutique/public/assets/images/icons/mandiri.svg"></li></ul>', 'COPYRIGHT ©2016 DE''MOR BOUTIQUE.', 'https://www.facebook.com/Demor-Boutique-346443122143490/?fref=ts', 'https://www.instagram.com/demor_boutique/', 'https://www.pinterest.com/');

-- --------------------------------------------------------

--
-- Table structure for table `pages_header`
--

CREATE TABLE IF NOT EXISTS `pages_header` (
  `title` varchar(255) NOT NULL,
  `metakeyword` varchar(255) NOT NULL,
  `metadescription` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `favicon` varchar(255) NOT NULL,
  `googlewebmaster` varchar(255) NOT NULL,
  `googleanalytic` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pages_header`
--

INSERT INTO `pages_header` (`title`, `metakeyword`, `metadescription`, `logo`, `favicon`, `googlewebmaster`, `googleanalytic`) VALUES
('demorboutique', 'demorboutique product', 'demorboutique product tops', 'sliderimage/logo.svg', 'sliderimage/favicon.ico', 'test', 'test\r\naa');

-- --------------------------------------------------------

--
-- Table structure for table `pages_message`
--

CREATE TABLE IF NOT EXISTS `pages_message` (
  `messageid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pages_message`
--

INSERT INTO `pages_message` (`messageid`, `name`, `email`, `subject`, `message`) VALUES
(1, 'franky', 'frankykwek@yahoo.com', 'test', 'sdfsdfdsfkldsjlfksdjflksdjfldsfs'),
(2, 'test', 'test@yahoo.com', 'test', 'halo ini test'),
(4, 'franky', 'frankykwek@yahoo.com', 'Request Product', 'test ini test\r\nsdfdsfdslfksdjfsdfsdf'),
(5, 'sdfsdf', 'franky@test.com', 'Others', 'dskfjksfjskljfsdfs');

-- --------------------------------------------------------

--
-- Table structure for table `pages_slider`
--

CREATE TABLE IF NOT EXISTS `pages_slider` (
  `sliderid` int(11) NOT NULL,
  `sliderpath` varchar(400) NOT NULL,
  `imagetype` varchar(50) NOT NULL,
  `uploaddate` date NOT NULL,
  `ispublish` tinyint(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pages_slider`
--

INSERT INTO `pages_slider` (`sliderid`, `sliderpath`, `imagetype`, `uploaddate`, `ispublish`) VALUES
(1, 'sliderimage/36219.jpg', 'jpg', '2016-10-02', 1),
(2, 'sliderimage/59204.jpg', 'jpg', '2016-10-02', 1),
(3, 'sliderimage/62543.png', 'png', '2016-12-14', 1);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE IF NOT EXISTS `payment` (
  `paymentid` int(11) NOT NULL,
  `paymentname` varchar(100) NOT NULL,
  `paymentview` varchar(100) NOT NULL,
  `ispublish` tinyint(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`paymentid`, `paymentname`, `paymentview`, `ispublish`) VALUES
(1, 'Credit Card', 'viewcredit', 1),
(2, 'Bank Transfer', 'viewtransfer', 1);

-- --------------------------------------------------------

--
-- Table structure for table `payment_transfer`
--

CREATE TABLE IF NOT EXISTS `payment_transfer` (
  `transferid` int(11) NOT NULL,
  `bankname` varchar(30) NOT NULL,
  `accountnumber` varchar(15) NOT NULL,
  `accountname` varchar(100) NOT NULL,
  `ispublish` tinyint(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment_transfer`
--

INSERT INTO `payment_transfer` (`transferid`, `bankname`, `accountnumber`, `accountname`, `ispublish`) VALUES
(1, 'BCA', '1950992885', 'Demour', 1),
(2, 'Mandiri', '1950992885', 'Demour', 1),
(3, 'Test', '12321312312', 'dsfsdfdsf', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `productid` bigint(20) NOT NULL,
  `categoryid` int(11) NOT NULL,
  `productcode` varchar(100) NOT NULL,
  `productname` varchar(255) NOT NULL,
  `brandname` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `discount` smallint(6) NOT NULL,
  `insertdate` date NOT NULL,
  `updatedate` date NOT NULL,
  `productdescription` text NOT NULL,
  `sizechart` text NOT NULL,
  `isdeleted` tinyint(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`productid`, `categoryid`, `productcode`, `productname`, `brandname`, `price`, `discount`, `insertdate`, `updatedate`, `productdescription`, `sizechart`, `isdeleted`) VALUES
(1, 1, 'XB5711', 'Sweater Dress', 'Test', 50000, 0, '2016-10-01', '0000-00-00', 'Testasdasdasdasd', 'asdfksdjflksdjfklsdjfls', 0),
(2, 2, 'XB5712', 'Sweater Dress', 'Test', 50000, 10, '2016-10-01', '0000-00-00', 'Testasdasdasdasd', 'asdfksdjflksdjfklsdjfls', 1),
(3, 1, 'XB5713', 'Sweater Dress', 'Test', 50000, 10, '2016-10-04', '0000-00-00', 'Testasdasdasdasd', 'asdfksdjflksdjfklsdjfls', 1),
(4, 3, 'XB5714', 'Sweater Dress', 'Test', 50000, 10, '2016-10-16', '0000-00-00', 'Testasdasdasdasd', 'asdfksdjflksdjfklsdjfls', 1),
(5, 2, 'XB5715', 'Sweater Dress', 'Test', 50000, 0, '2016-10-16', '0000-00-00', 'Testasdasdasdasd', 'asdfksdjflksdjfklsdjfls', 1),
(6, 1, 'XB5716', 'Sweater Dress', 'Test', 50000, 10, '2016-10-16', '0000-00-00', 'Testasdasdasdasd', 'asdfksdjflksdjfklsdjfls', 1),
(7, 2, 'XB5717', 'Sweater Dress', 'Test', 50000, 10, '2016-10-16', '0000-00-00', 'Testasdasdasdasd', 'asdfksdjflksdjfklsdjfls', 1),
(8, 1, 'XB5718', 'Sweater Dress', 'Test', 50000, 0, '2016-10-16', '0000-00-00', 'Testasdasdasdasd', 'asdfksdjflksdjfklsdjfls', 1),
(9, 3, 'XB5719', 'Sweater Dress', 'Test', 50000, 10, '2016-10-16', '0000-00-00', 'Testasdasdasdasd', 'asdfksdjflksdjfklsdjfls', 1),
(10, 1, 'XB5720', 'Sweater Dress', 'Test', 50000, 10, '2016-10-16', '0000-00-00', 'Testasdasdasdasd', 'asdfksdjflksdjfklsdjfls', 1),
(11, 2, 'XB5721', 'Sweater Dress', 'Test', 50000, 10, '2016-10-16', '0000-00-00', 'Testasdasdasdasd', 'asdfksdjflksdjfklsdjfls', 0),
(12, 3, 'XB5722', 'Sweater Dress', 'Test', 50000, 10, '2016-10-16', '0000-00-00', 'Testasdasdasdasd', 'asdfksdjflksdjfklsdjfls', 1),
(13, 3, 'XB5723', 'Sweater Dress', 'Test', 50000, 10, '2016-10-16', '0000-00-00', 'Testasdasdasdasd', 'asdfksdjflksdjfklsdjfls', 1),
(14, 3, 'XB5724', 'Sweater Dress', 'Test', 50000, 10, '2016-10-16', '0000-00-00', 'Testasdasdasdasd', 'asdfksdjflksdjfklsdjfls', 1),
(16, 1, 'TEST0001', 'Test edit', 'asdasd', 400000, 20, '2016-10-20', '2016-12-10', '<div>Soft sweater with DIRECTØR print.</div>\r\n<div>Model wears size S.</div>\r\n<div>Composition: 95% Cotton, 5% Elastane</div>\r\n<div>Made in Portugal</div>', '<div class="clearfix table-size">\r\n<div class="pull-left s100">\r\n<div class="mb10"> </div>\r\n<div class="mb10">EU</div>\r\n<div class="mb10">UK</div>\r\n<div>USA</div>\r\n</div>\r\n<div class="pull-left s70">\r\n<div class="mb10">XS</div>\r\n<div class="mb10">34</div>\r\n<div class="mb10">8</div>\r\n<div>4</div>\r\n</div>\r\n<div class="pull-left s70">\r\n<div class="mb10">S</div>\r\n<div class="mb10">36</div>\r\n<div class="mb10">10</div>\r\n<div>6</div>\r\n</div>\r\n<div class="pull-left s70">\r\n<div class="mb10">M</div>\r\n<div class="mb10">38</div>\r\n<div class="mb10">12</div>\r\n<div>8</div>\r\n</div>\r\n<div class="pull-left s70">\r\n<div class="mb10">L</div>\r\n<div class="mb10">40</div>\r\n<div class="mb10">14</div>\r\n<div>10</div>\r\n</div>\r\n<div class="pull-left s70">\r\n<div class="mb10">XL</div>\r\n<div class="mb10">42</div>\r\n<div class="mb10">16</div>\r\n<div>12</div>\r\n</div>\r\n</div>', 1),
(19, 1, 'LPTP0001', 'Laptop lenovo', 'Lenovo', 10000000, 10, '2016-11-27', '2016-11-27', '<p>dsfsdfsdfsd</p>', '<p>sdfdfsdfsfsdfs</p>', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE IF NOT EXISTS `product_category` (
  `categoryid` int(11) NOT NULL,
  `categoryname` varchar(100) NOT NULL,
  `isdeleted` tinyint(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`categoryid`, `categoryname`, `isdeleted`) VALUES
(1, 'Tops', 1),
(2, 'Dresses', 1),
(3, 'Bottoms', 1),
(5, 'aaaa', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_color`
--

CREATE TABLE IF NOT EXISTS `product_color` (
  `colorid` int(11) NOT NULL,
  `colorpath` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_color`
--

INSERT INTO `product_color` (`colorid`, `colorpath`) VALUES
(3, 'productimage/color/57033.jpg'),
(4, 'productimage/color/92694.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `product_detail`
--

CREATE TABLE IF NOT EXISTS `product_detail` (
  `productid` bigint(20) NOT NULL,
  `colorid` int(11) NOT NULL,
  `mainimage` varchar(255) DEFAULT NULL,
  `subimage` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_detail`
--

INSERT INTO `product_detail` (`productid`, `colorid`, `mainimage`, `subimage`) VALUES
(1, 3, 'assets/images/uploads/product01.jpg', 'assets/images/uploads/product02.jpg\r\n'),
(1, 4, 'assets/images/uploads/product01.jpg', 'assets/images/uploads/product02.jpg\r\n'),
(2, 3, 'assets/images/uploads/product01.jpg', 'assets/images/uploads/product02.jpg\r\n'),
(2, 4, 'assets/images/uploads/product01.jpg', 'assets/images/uploads/product02.jpg\r\n'),
(3, 3, 'assets/images/uploads/product01.jpg', 'assets/images/uploads/product02.jpg\r\n'),
(3, 4, 'assets/images/uploads/product01.jpg', 'assets/images/uploads/product02.jpg\r\n'),
(4, 3, 'assets/images/uploads/product01.jpg', 'assets/images/uploads/product02.jpg\r\n'),
(4, 4, 'assets/images/uploads/product01.jpg', 'assets/images/uploads/product02.jpg\r\n'),
(5, 3, 'assets/images/uploads/product01.jpg', 'assets/images/uploads/product02.jpg\r\n'),
(5, 4, 'assets/images/uploads/product01.jpg', 'assets/images/uploads/product02.jpg\r\n'),
(6, 3, 'assets/images/uploads/product01.jpg', 'assets/images/uploads/product02.jpg\r\n'),
(6, 4, 'assets/images/uploads/product01.jpg', 'assets/images/uploads/product02.jpg\r\n'),
(7, 3, 'assets/images/uploads/product01.jpg', 'assets/images/uploads/product02.jpg\r\n'),
(7, 4, 'assets/images/uploads/product01.jpg', 'assets/images/uploads/product02.jpg\r\n'),
(8, 3, 'assets/images/uploads/product01.jpg', 'assets/images/uploads/product02.jpg\r\n'),
(8, 4, 'assets/images/uploads/product01.jpg', 'assets/images/uploads/product02.jpg\r\n'),
(9, 3, 'assets/images/uploads/product01.jpg', 'assets/images/uploads/product02.jpg\r\n'),
(9, 4, 'assets/images/uploads/product01.jpg', 'assets/images/uploads/product02.jpg\r\n'),
(10, 3, 'assets/images/uploads/product01.jpg', 'assets/images/uploads/product02.jpg\r\n'),
(10, 4, 'assets/images/uploads/product01.jpg', 'assets/images/uploads/product02.jpg\r\n'),
(11, 3, 'assets/images/uploads/product01.jpg', 'assets/images/uploads/product02.jpg\r\n'),
(11, 4, 'assets/images/uploads/product01.jpg', 'assets/images/uploads/product02.jpg\r\n'),
(12, 3, 'assets/images/uploads/product01.jpg', 'assets/images/uploads/product02.jpg\r\n'),
(12, 4, 'assets/images/uploads/product01.jpg', 'assets/images/uploads/product02.jpg\r\n'),
(13, 3, 'assets/images/uploads/product01.jpg', 'assets/images/uploads/product02.jpg\r\n'),
(13, 4, 'assets/images/uploads/product01.jpg', 'assets/images/uploads/product02.jpg\r\n'),
(14, 3, 'assets/images/uploads/product01.jpg', 'assets/images/uploads/product02.jpg\r\n'),
(14, 4, 'assets/images/uploads/product01.jpg', 'assets/images/uploads/product02.jpg\r\n'),
(19, 4, 'productimage/main63745117.jpeg', 'productimage/back66427951.jpeg'),
(16, 4, 'productimage/main74452039.jpg', 'productimage/back95982530.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `product_detail_image`
--

CREATE TABLE IF NOT EXISTS `product_detail_image` (
  `productid` bigint(20) NOT NULL,
  `colorid` int(11) NOT NULL,
  `subimage` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_detail_image`
--

INSERT INTO `product_detail_image` (`productid`, `colorid`, `subimage`) VALUES
(19, 4, 'productimage/sub63023545.jpeg'),
(19, 4, 'productimage/sub68332248.jpeg'),
(2, 3, 'productimage/sub63023545.jpeg'),
(2, 4, 'productimage/sub68332248.jpeg'),
(16, 4, 'productimage/sub96972656.jpg'),
(16, 4, 'productimage/sub64618598.png'),
(16, 4, 'productimage/sub92192925.png');

-- --------------------------------------------------------

--
-- Table structure for table `product_detail_size`
--

CREATE TABLE IF NOT EXISTS `product_detail_size` (
  `productid` bigint(20) NOT NULL,
  `colorid` int(11) NOT NULL,
  `size` varchar(5) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_detail_size`
--

INSERT INTO `product_detail_size` (`productid`, `colorid`, `size`, `stock`) VALUES
(1, 3, 'S', 5),
(1, 3, 'M', 2),
(1, 4, 'S', 1),
(1, 4, 'M', 7),
(2, 3, 'S', 5),
(2, 3, 'M', 2),
(2, 4, 'S', 1),
(2, 4, 'M', 7),
(3, 3, 'S', 5),
(3, 3, 'M', 2),
(3, 4, 'S', 1),
(3, 4, 'M', 7),
(5, 3, 'S', 5),
(5, 3, 'M', 2),
(5, 4, 'S', 1),
(5, 4, 'M', 7),
(6, 3, 'S', 5),
(6, 3, 'M', 2),
(6, 4, 'S', 1),
(6, 4, 'M', 7),
(7, 3, 'S', 5),
(7, 3, 'M', 2),
(7, 4, 'S', 1),
(7, 4, 'M', 7),
(8, 3, 'S', 5),
(8, 3, 'M', 2),
(8, 4, 'S', 1),
(8, 4, 'M', 7),
(9, 3, 'S', 5),
(9, 3, 'M', 2),
(9, 4, 'S', 1),
(9, 4, 'M', 7),
(10, 3, 'S', 5),
(10, 3, 'M', 2),
(10, 4, 'S', 1),
(10, 4, 'M', 7),
(11, 3, 'S', 5),
(11, 3, 'M', 2),
(11, 4, 'S', 1),
(11, 4, 'M', 7),
(12, 3, 'S', 5),
(12, 3, 'M', 2),
(12, 4, 'S', 1),
(12, 4, 'M', 7),
(13, 3, 'S', 5),
(13, 3, 'M', 2),
(13, 4, 'S', 1),
(13, 4, 'M', 7),
(14, 3, 'S', 0),
(14, 3, 'M', 0),
(14, 4, 'S', 0),
(14, 4, 'M', 0),
(19, 4, 'S', 1),
(19, 4, 'M', 2),
(19, 4, 'L', 3),
(16, 4, 'S', 1),
(16, 4, 'M', 2),
(16, 4, 'L', 3);

-- --------------------------------------------------------

--
-- Table structure for table `product_exchange`
--

CREATE TABLE IF NOT EXISTS `product_exchange` (
  `exchangeid` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `ordernumber` varchar(15) NOT NULL,
  `productname` varchar(100) NOT NULL,
  `detailproduct` varchar(100) NOT NULL,
  `exchangedate` datetime NOT NULL,
  `reason` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_exchange`
--

INSERT INTO `product_exchange` (`exchangeid`, `fullname`, `ordernumber`, `productname`, `detailproduct`, `exchangedate`, `reason`) VALUES
(1, 'Jane Doe', '1234567890', 'Sweater Dress', 'Sweater Dress', '2016-10-13 00:00:00', 'test\r\ntestsdfsdlkfjsdkfljsdklfjsdkfdsjlkfsdfdsfsdf'),
(2, 'test', 'test1', 'test2', 'test3', '2016-10-22 11:07:49', 'test4');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `tax` int(11) NOT NULL,
  `arrival` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`tax`, `arrival`) VALUES
(5, 14);

-- --------------------------------------------------------

--
-- Table structure for table `shipping`
--

CREATE TABLE IF NOT EXISTS `shipping` (
  `shippingid` int(11) NOT NULL,
  `shippingname` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shipping`
--

INSERT INTO `shipping` (`shippingid`, `shippingname`) VALUES
(1, 'Fedex');

-- --------------------------------------------------------

--
-- Table structure for table `subscribe`
--

CREATE TABLE IF NOT EXISTS `subscribe` (
  `email` varchar(100) NOT NULL,
  `type` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subscribe`
--

INSERT INTO `subscribe` (`email`, `type`) VALUES
('frankykwek@yahoo.com', 1),
('frankykwek@rocketmail.com', 1);

-- --------------------------------------------------------

--
-- Table structure for table `subscribe_type`
--

CREATE TABLE IF NOT EXISTS `subscribe_type` (
  `typeid` int(11) NOT NULL,
  `typename` varchar(200) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subscribe_type`
--

INSERT INTO `subscribe_type` (`typeid`, `typename`) VALUES
(1, 'All Newsletters'),
(2, 'All Buyers');

-- --------------------------------------------------------

--
-- Table structure for table `terminate_product_image`
--

CREATE TABLE IF NOT EXISTS `terminate_product_image` (
  `imageid` int(11) NOT NULL,
  `main` varchar(255) NOT NULL,
  `back` varchar(255) NOT NULL,
  `productid` int(11) NOT NULL,
  `isactive` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `terminate_product_image`
--

INSERT INTO `terminate_product_image` (`imageid`, `main`, `back`, `productid`, `isactive`) VALUES
(1, 'productimage/main63745117.jpeg', 'productimage/back66427951.jpeg', 0, 1),
(3, 'productimage/main74452039.jpg', 'productimage/back95982530.jpg', 16, 1);

-- --------------------------------------------------------

--
-- Table structure for table `terminate_product_subimage`
--

CREATE TABLE IF NOT EXISTS `terminate_product_subimage` (
  `imageid` int(11) NOT NULL,
  `subimage` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `terminate_product_subimage`
--

INSERT INTO `terminate_product_subimage` (`imageid`, `subimage`) VALUES
(1, 'productimage/sub63023545.jpeg'),
(1, 'productimage/sub68332248.jpeg'),
(3, 'productimage/sub96972656.jpg'),
(3, 'productimage/sub64618598.png'),
(3, 'productimage/sub92192925.png');

-- --------------------------------------------------------

--
-- Table structure for table `voucher`
--

CREATE TABLE IF NOT EXISTS `voucher` (
  `voucherid` int(11) NOT NULL,
  `vouchername` varchar(100) NOT NULL,
  `discount` int(11) NOT NULL,
  `discountfor` int(11) NOT NULL,
  `timescanused` int(11) NOT NULL,
  `islimit` tinyint(4) NOT NULL,
  `discountbegin` date NOT NULL,
  `discountend` date NOT NULL,
  `isexpired` tinyint(4) NOT NULL,
  `insertdate` date NOT NULL,
  `isdeleted` tinyint(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `voucher`
--

INSERT INTO `voucher` (`voucherid`, `vouchername`, `discount`, `discountfor`, `timescanused`, `islimit`, `discountbegin`, `discountend`, `isexpired`, `insertdate`, `isdeleted`) VALUES
(1, 'Test masuk', 100000, 0, 1, 1, '2016-09-01', '2016-10-16', 0, '2016-09-01', 1),
(2, 'DEMORLOGIN', 50000, 0, 1, 0, '2016-11-01', '2016-12-31', 1, '2016-11-01', 0),
(3, 'DEMORDRESS', 150000, 2, 0, 1, '2016-11-30', '2016-11-30', 0, '2016-11-30', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_menu`
--
ALTER TABLE `account_menu`
  ADD PRIMARY KEY (`roleid`,`menuid`);

--
-- Indexes for table `account_role`
--
ALTER TABLE `account_role`
  ADD PRIMARY KEY (`roleid`);

--
-- Indexes for table `blog_category`
--
ALTER TABLE `blog_category`
  ADD PRIMARY KEY (`categoryid`);

--
-- Indexes for table `blog_list`
--
ALTER TABLE `blog_list`
  ADD PRIMARY KEY (`blogid`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`emailaddress`),
  ADD UNIQUE KEY `userid` (`userid`);

--
-- Indexes for table `orderheader`
--
ALTER TABLE `orderheader`
  ADD PRIMARY KEY (`orderno`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`pagesid`);

--
-- Indexes for table `pages_career_detail`
--
ALTER TABLE `pages_career_detail`
  ADD PRIMARY KEY (`careerid`);

--
-- Indexes for table `pages_message`
--
ALTER TABLE `pages_message`
  ADD PRIMARY KEY (`messageid`);

--
-- Indexes for table `pages_slider`
--
ALTER TABLE `pages_slider`
  ADD PRIMARY KEY (`sliderid`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`paymentid`);

--
-- Indexes for table `payment_transfer`
--
ALTER TABLE `payment_transfer`
  ADD PRIMARY KEY (`transferid`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`productid`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`categoryid`);

--
-- Indexes for table `product_color`
--
ALTER TABLE `product_color`
  ADD PRIMARY KEY (`colorid`);

--
-- Indexes for table `product_exchange`
--
ALTER TABLE `product_exchange`
  ADD PRIMARY KEY (`exchangeid`);

--
-- Indexes for table `shipping`
--
ALTER TABLE `shipping`
  ADD PRIMARY KEY (`shippingid`);

--
-- Indexes for table `subscribe_type`
--
ALTER TABLE `subscribe_type`
  ADD PRIMARY KEY (`typeid`);

--
-- Indexes for table `terminate_product_image`
--
ALTER TABLE `terminate_product_image`
  ADD PRIMARY KEY (`imageid`);

--
-- Indexes for table `voucher`
--
ALTER TABLE `voucher`
  ADD PRIMARY KEY (`voucherid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_role`
--
ALTER TABLE `account_role`
  MODIFY `roleid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `blog_category`
--
ALTER TABLE `blog_category`
  MODIFY `categoryid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `blog_list`
--
ALTER TABLE `blog_list`
  MODIFY `blogid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `pagesid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `pages_career_detail`
--
ALTER TABLE `pages_career_detail`
  MODIFY `careerid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `pages_message`
--
ALTER TABLE `pages_message`
  MODIFY `messageid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `pages_slider`
--
ALTER TABLE `pages_slider`
  MODIFY `sliderid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `paymentid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `payment_transfer`
--
ALTER TABLE `payment_transfer`
  MODIFY `transferid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `productid` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `categoryid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `product_color`
--
ALTER TABLE `product_color`
  MODIFY `colorid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `product_exchange`
--
ALTER TABLE `product_exchange`
  MODIFY `exchangeid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `shipping`
--
ALTER TABLE `shipping`
  MODIFY `shippingid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `subscribe_type`
--
ALTER TABLE `subscribe_type`
  MODIFY `typeid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `terminate_product_image`
--
ALTER TABLE `terminate_product_image`
  MODIFY `imageid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `voucher`
--
ALTER TABLE `voucher`
  MODIFY `voucherid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
