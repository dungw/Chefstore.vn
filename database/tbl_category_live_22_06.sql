-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 22, 2015 at 11:10 PM
-- Server version: 5.5.42-cll
-- PHP Version: 5.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `chefstor_vi`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE IF NOT EXISTS `tbl_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Khóa chính',
  `parent_id` int(11) DEFAULT '0' COMMENT 'Id của danh mục cha',
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Tên danh mục',
  `img` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `column` tinyint(4) NOT NULL DEFAULT '1',
  `home` tinyint(4) NOT NULL DEFAULT '0',
  `status` tinyint(4) DEFAULT '1' COMMENT 'Trạng thái',
  `ordering` int(11) NOT NULL COMMENT 'Thứ tự, từ nhỏ tới lớn',
  `description` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Comment',
  `meta_title` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `meta_keyword` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_description` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Bảng chứa danh mục' AUTO_INCREMENT=187 ;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`id`, `parent_id`, `name`, `img`, `column`, `home`, `status`, `ordering`, `description`, `meta_title`, `meta_keyword`, `meta_description`) VALUES
(1, 0, 'Vật dụng nhà bếp', '', 1, 0, 1, 1000, '', '', '', ''),
(2, 0, 'Thiết bị bếp', '', 1, 0, 1, 900, NULL, '', NULL, NULL),
(3, 3, 'Vật Dụng Phòng Ăn', '', 1, 0, 0, 800, '', '', '', ''),
(4, 0, 'Phòng ăn', '', 1, 0, 1, 700, '', '', '', ''),
(5, 0, 'Quầy bar', '', 1, 0, 1, 600, '', '', '', ''),
(8, 1, 'Xoong, Nồi, Chảo', '', 1, 0, 1, 0, '', '', '', ''),
(9, 1, 'Dụng cụ làm bánh', '', 1, 0, 1, 0, '', '', '', ''),
(10, 2, 'Bếp các loại', '', 1, 0, 1, 0, '', '', '', ''),
(21, 5, 'Dụng cụ quầy bar', '', 1, 0, 1, 0, '', '', '', ''),
(22, 5, 'Ly, cốc nhựa', '', 1, 0, 1, 0, '', '', '', ''),
(26, 4, 'Các thiết bị', '', 1, 0, 1, 0, '', '', '', ''),
(33, 3, 'Đồ Điện', '', 1, 0, 0, 0, '', '', '', ''),
(37, 4, 'Các vật dụng phục vụ', '', 1, 0, 1, 0, '', '', '', ''),
(40, 4, 'Nội, ngoại thất, trang trí', '', 1, 0, 1, 0, '', '', '', ''),
(59, 1, 'Dụng cụ bếp', '', 1, 0, 1, 0, '', '', '', ''),
(60, 1, 'Áo bếp', '', 1, 0, 1, 0, '', '', '', ''),
(61, 2, 'Lò nướng, Lò vi sóng', '', 1, 0, 1, 0, '', '', '', ''),
(63, 117, 'Ly rượu vang', '', 1, 0, 1, 0, '', '', '', ''),
(70, 2, 'Máy làm bánh Waffle', '', 1, 0, 1, 0, '', '', '', ''),
(93, 2, 'Thiết bị chế biến thực phẩm', '', 1, 0, 1, 0, '', '', '', ''),
(96, 5, 'Các thiết bị', '', 1, 0, 1, 0, '', '', '', ''),
(98, 1, 'Xe chở đồ', '', 1, 0, 1, 0, '', '', '', ''),
(112, 0, 'Đồ sứ', '', 1, 0, 1, 0, '', '', '', ''),
(113, 117, 'Vật dụng tiện ích', '', 1, 0, 1, 0, '', '', '', ''),
(118, 2, 'Máy rửa bát', '', 0, 0, 1, 0, '', '', '', ''),
(115, 2, 'Tủ bảo quản thực phẩm', '', 0, 0, 1, 0, '', '', '', ''),
(117, 0, 'Đồ thủy tinh', '', 0, 0, 1, 0, '', '', '', ''),
(120, 117, 'Cốc bia, cốc rượu mạnh', '', 0, 0, 1, 0, '', '', '', ''),
(124, 112, 'Nhà hàng  Âu, Á', '', 0, 0, 1, 0, '', '', '', ''),
(125, 112, 'Nhà hàng Nhật', '', 0, 0, 1, 0, '', '', '', ''),
(127, 125, 'Đĩa, Bát các loại', '', 0, 0, 1, 0, '', '', '', ''),
(137, 3, 'Vật Dụng Nhà Bếp', '', 0, 0, 0, 0, '', '', '', ''),
(147, 1, 'Hộp đựng gia vị, thực phẩm', '', 0, 0, 1, 0, '', '', '', ''),
(148, 3, 'Vật Dụng Làm Bánh', '', 0, 0, 0, 0, '', '', '', ''),
(154, 117, 'Cốc nước, Sinh tố', '', 0, 0, 1, 0, '', '', '', ''),
(155, 120, 'Ly, cốc thủy tinh', '', 0, 0, 0, 0, 'Ly, cốc thủy tinh Bormioli Rocco - Italy', 'ly-coc-thuy-tinh', '', ''),
(156, 117, 'Ly cốc màu', '', 0, 0, 1, 0, 'Bát, đĩa thủy tinh, gốm thủy tinh Bormioli Rocco - Italy', '', '', ''),
(157, 120, 'Vật dụng thủy tinh khác', '', 0, 0, 0, 0, 'Khay, hộp, xô đá, bình pha và phục vụ rượu vang, chai lọ,... thủy tinh Bormioli Rocco - Italy', '', '', ''),
(158, 117, 'Ly Cocktail, Tráng miệng', '', 0, 0, 1, 0, '', '', '', ''),
(161, 124, 'Đồ phíp cao cấp', '', 0, 0, 1, 0, '', '', '', ''),
(162, 124, 'Tô, Đĩa phục vụ', '', 0, 0, 1, 0, '', '', '', ''),
(163, 124, 'Cốc trà, Cà phê', '', 0, 0, 1, 0, '', '', '', ''),
(175, 0, 'Đồ Gia Dụng', '', 0, 0, 1, 0, '', '', '', ''),
(176, 175, 'Đồ Điện', '', 0, 0, 1, 0, '', '', '', ''),
(177, 175, 'Vật Dụng Nhà Bếp', '', 0, 0, 1, 0, '', '', '', ''),
(178, 175, 'Vật Dụng Phòng Ăn', '', 0, 0, 1, 0, '', '', '', ''),
(179, 175, 'Dụng Cụ Làm Bánh', '', 0, 0, 1, 0, '', '', '', ''),
(180, 177, 'Dao, Kéo & Dụng Cụ Bếp', '', 0, 0, 1, 0, '', '', '', ''),
(181, 177, 'Vật Dụng Tiện Ích', '', 0, 0, 1, 0, '', '', '', ''),
(182, 177, 'Dụng Cụ Vệ Sinh', '', 0, 0, 1, 0, '', '', '', ''),
(183, 178, 'Bát, Đĩa', '', 0, 0, 1, 0, '', '', '', ''),
(184, 178, 'Ly, Cốc', '', 0, 0, 1, 0, '', '', '', ''),
(185, 178, 'Vật Dụng Phục Vụ', '', 0, 0, 1, 0, '', '', '', ''),
(186, 177, 'Xoong, Chảo', '', 0, 0, 1, 0, '', '', '', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
