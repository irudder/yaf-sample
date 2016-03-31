-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2016 年 03 月 31 日 13:53
-- 服务器版本: 5.5.40
-- PHP 版本: 5.4.33

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `yuser`
--

-- --------------------------------------------------------

--
-- 表的结构 `bank`
--

CREATE TABLE IF NOT EXISTS `bank` (
  `bid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `bname` varchar(50) NOT NULL,
  `bmark` varchar(100) NOT NULL COMMENT '标志',
  `binfo` text NOT NULL COMMENT '信息',
  `is_show` int(1) NOT NULL DEFAULT '1' COMMENT '是否显示0不显示1显示',
  PRIMARY KEY (`bid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `bank`
--

INSERT INTO `bank` (`bid`, `bname`, `bmark`, `binfo`, `is_show`) VALUES
(1, '中国工商银行', 'ICBC', 'ICBC', 1),
(2, '中国农业银行', 'abc', 'qqqq', 1),
(8, '中国邮政银行', 'youzheng', 'test', 1),
(7, '中国建设银行', 'jianshe', 'qwe', 1),
(6, '中国银行', 'boc', 'qqqqqq', 1),
(9, '华夏银行', 'hxb', '4', 1);

-- --------------------------------------------------------

--
-- 表的结构 `order`
--

CREATE TABLE IF NOT EXISTS `order` (
  `oid` int(11) NOT NULL AUTO_INCREMENT,
  `otime` varchar(11) NOT NULL,
  `onum` varchar(100) NOT NULL,
  `omoney` float(7,2) NOT NULL,
  `otype` varchar(100) NOT NULL,
  `ouser` varchar(100) NOT NULL,
  `opaybank` varchar(100) NOT NULL,
  `opayprovider` varchar(100) NOT NULL,
  `opoundage` float(7,2) NOT NULL,
  PRIMARY KEY (`oid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=48 ;

--
-- 转存表中的数据 `order`
--

INSERT INTO `order` (`oid`, `otime`, `onum`, `omoney`, `otype`, `ouser`, `opaybank`, `opayprovider`, `opoundage`) VALUES
(36, '1459387736', 'e78667c333542b415c50b714e1051711', 555.00, '-1', 'test', 'c', 'caifutong', 0.12),
(35, '1459387732', 'fd29ecd8f2535454fb0f90319ea330e7', 555.00, '-1', 'test', 'a', 'caifutong', 0.28),
(34, '1459387718', '98c8f7ccb6aa95ff911236452091a63d', 555.00, '储值订单', 'test', 'd', 'kuaiqian', 55.50),
(33, '1459387702', '18118cc58366365eaac79af9ded8d582', 555.00, '手机充值话费订单', 'test', 'd', 'kuaiqian', 55.50),
(32, '1459387694', '364631be3744c35e59b7e45a6149ddb1', 555.00, '卡密订单', 'test', 'c', 'caifutong', 0.12),
(31, '1459387670', '6033890b4df549f9f126ef6a0a162637', 555.00, '卡密订单', 'test', 'b', 'caifutong', 68.43),
(14, '1459239882', '01cb7b774352ad5972f996f6d24d6b80', 326.00, '卡密订单', 'eeee', 'a', 'caifutong', 39.12),
(30, '1459387627', '44aacdee010189a703dbd8dcd3a6ad0a', 555.00, '卡密订单', 'test', 'a', 'yibao', 68.43),
(16, '1459242356', '883f65db8152fe297b68794cb3e177f3', 10000.00, '0', 'eeee', 'd', 'alipay', 450.00),
(17, '1459242397', '1d7e5a829fa1f3266ac0afbe31cfc8db', 10000.00, '0', 'eeee', 'd', 'alipay', 450.00),
(18, '1459242420', 'f94b5d645a36f54b8680ba40bb6984db', 3500.00, '0', 'eeee', 'd', 'kuaiqian', 350.00),
(19, '1459242432', '98d06af0f3eb53f9e03d2426f85b4968', 3200.00, '0', 'eeee', 'd', 'kuaiqian', 320.00),
(20, '1459242872', '78baad6c72251b13c446b64f6a1d2f32', 666.00, '0', 'eeee', 'b', 'caifutong', 0.34),
(21, '1459243116', '3aabe50d9cd335004727a2dbc1410140', 3333.00, '0', 'eeee', 'd', 'kuaiqian', 333.30),
(22, '1459243141', 'b76866f0b39ec3f3c7075b43f208f407', 4444.00, '0', 'eeee', 'd', 'kuaiqian', 444.40),
(29, '1459387620', '224ef38f39b7c3d5aabac1d0b796d6f1', 555.00, '0', 'test', 'c', 'caifutong', 28.86),
(28, '1459387590', '78252d652b83a1c68d5c2da257e245e3', 345.00, '手机充值话费订单', 'test', 'd', 'kuaiqian', 42.54),
(26, '1459316402', '0e8d462ca5cf3da60956328f5dd8e328', 3333.00, '0', 'test', 'a', 'yibao', 410.96),
(27, '1459328836', 'f70221f436a69d1a537700a42ab2d262', 360.00, '0', 'test', 'hxb', 'caifutong', 28.86),
(37, '1459387740', '3460118ef2145f32aa54bb2788dd4dd3', 555.00, '-1', 'test', 'ICBC', 'caifutong', 0.12),
(38, '1459387957', '404e95b89ccaa0dd92cbdb791facb7da', 666.00, '0', 'test', 'b', 'caifutong', 0.34),
(39, '1459387963', 'f2abb9c875f5adcca13dd7f9ff775af9', 666.00, '0', 'test', 'c', 'caifutong', 0.12),
(40, '1459388017', '9170a69747b606eb617e60b47db36963', 333.00, '0', 'test', 'ICBC', 'caifutong', 0.12),
(41, '1459388021', '56df851a2db6e9ee8088e96bec7a3673', 333.00, '0', 'test', 'c', 'caifutong', 0.12),
(42, '1459388091', '4adcd4a9697349d765044820419fabcf', 333.00, '手机充值话费订单', 'test', 'd', 'kuaiqian', 33.30),
(43, '1459388207', 'b16e79487cc140ba3d02f01421dacabf', 666.00, '手机充值话费订单', 'test', 'd', 'kuaiqian', 66.60),
(44, '1459388220', '47d767d1b8d583aae348d9478941688d', 666.00, '储值订单', 'test', 'd', 'kuaiqian', 66.60),
(45, '1459391327', '6ea4e0c31f75e71144e24d661c190dee', 362.00, '手机充值话费订单', '123123', 'd', 'kuaiqian', 36.20),
(46, '1459391744', '80e9df6d93f9018d4e2f1f7cc6b1d3f4', 362.00, '0', '123123', 'jianshe', 'caifutong', 0.12),
(47, '1459394359', 'a16282a43bf3b6b2241df44587e58805', 10.00, '储值订单', 'wangdc', 'boc', 'kuaiqian', 1.00);

-- --------------------------------------------------------

--
-- 表的结构 `ordertype`
--

CREATE TABLE IF NOT EXISTS `ordertype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `ordertype`
--

INSERT INTO `ordertype` (`id`, `type`) VALUES
(1, '卡密订单'),
(2, '手机充值话费订单'),
(3, '储值订单');

-- --------------------------------------------------------

--
-- 表的结构 `paycontact`
--

CREATE TABLE IF NOT EXISTS `paycontact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pmark` varchar(100) NOT NULL COMMENT '支付商标识',
  `bmark` varchar(100) NOT NULL COMMENT '银行标识',
  `pname` varchar(100) NOT NULL COMMENT '支付商名',
  `bname` varchar(100) NOT NULL COMMENT '银行名',
  `ordertype` varchar(100) NOT NULL,
  `quota` float(7,2) NOT NULL,
  `poundage` float(7,3) NOT NULL,
  `is_show` int(1) NOT NULL DEFAULT '1' COMMENT '是否显示',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- 转存表中的数据 `paycontact`
--

INSERT INTO `paycontact` (`id`, `pmark`, `bmark`, `pname`, `bname`, `ordertype`, `quota`, `poundage`, `is_show`) VALUES
(5, 'alipay', 'ICBC', '支付宝', '中国工商银行', '', 0.00, 11.000, 1),
(6, 'yibao', 'ICBC', '易宝', '中国工商银行', '卡密订单', 0.00, 3.000, 0),
(7, 'alipay', 'ICBC', '支付宝', '中国工商银行', '卡密订单', 0.00, 11.000, 1),
(28, 'yibao', 'jianshe', '易宝', '中国建设银行', '', 6.40, 3.000, 1),
(10, 'yibao', 'abc', '易宝', '中国农业银行', '卡密订单', 0.00, 3.000, 1),
(11, 'caifutong', 'abc', '财付通', '中国农业银行', '卡密订单', 0.00, 0.051, 1),
(14, 'caifutong', 'youzheng', '财付通', '中国邮政银行', '卡密订单', 0.00, 0.051, 1),
(27, 'caifutong', 'hxb', '财付通', '华夏银行', '', 234.05, 0.051, 1),
(18, 'kuaiqian', 'boc', '快钱', '中国银行', '储值订单', 0.00, 10.000, 1),
(26, 'alipay', 'boc', '支付宝', '中国银行', '手机充值话费订单', 3000.00, 11.000, 1),
(25, 'caifutong', 'ICBC', '财付通', '中国工商银行', '', 234.05, 0.051, 1),
(24, 'caifutong', 'jianshe', '财付通', '中国建设银行', '卡密订单', 234.05, 0.051, 1);

-- --------------------------------------------------------

--
-- 表的结构 `payprovider`
--

CREATE TABLE IF NOT EXISTS `payprovider` (
  `pid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `pname` varchar(100) NOT NULL,
  `pmark` varchar(100) NOT NULL COMMENT '支付商标志',
  `isquota` int(1) NOT NULL COMMENT '是否限额',
  `quota` float(7,2) NOT NULL COMMENT '额度',
  `poundage` float(7,3) NOT NULL COMMENT '手续费',
  `is_show` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- 转存表中的数据 `payprovider`
--

INSERT INTO `payprovider` (`pid`, `pname`, `pmark`, `isquota`, `quota`, `poundage`, `is_show`) VALUES
(1, '支付宝', 'alipay', 1, 3000.00, 11.000, 1),
(7, '财付通', 'caifutong', 0, 234.05, 0.051, 1),
(21, '易宝', 'yibao', 0, 6.40, 3.000, 1),
(20, '快钱', 'kuaiqian', 0, 0.00, 10.000, 1);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uname` varchar(50) NOT NULL,
  `pwd` varchar(50) NOT NULL,
  `relname` varchar(50) NOT NULL,
  `IDcard` varchar(20) NOT NULL,
  `regtime` varchar(20) NOT NULL,
  `regip` varchar(20) NOT NULL,
  `lastip` varchar(20) NOT NULL,
  `lasttime` varchar(20) NOT NULL,
  `poundage` float(7,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `uname`, `pwd`, `relname`, `IDcard`, `regtime`, `regip`, `lastip`, `lasttime`, `poundage`) VALUES
(11, 'ffff', 'ffff', 'aaaa', '111111111111111111', '1458719650', '127.0.0.1', '127.0.0.1', '0', 23.00),
(12, 'test1', '4297f44b13955235245b2497399d7a93', 'test1', '123123123123123123', '1458724856', '172.16.67.45', '172.16.67.45', '1458724856', 0.00),
(20, 'test', '098f6bcd4621d373cade4e832627b4f6', 'test', '111111111111111111', '1459298050', '127.0.0.1', '127.0.0.1', '1459384472', 0.00),
(21, 'nihaoma', '4297f44b13955235245b2497399d7a93', '123123', '111111111111111111', '1459391299', '172.16.67.122', '172.16.67.122', '1459391299', 0.00),
(22, 'wangdc', '4297f44b13955235245b2497399d7a93', 'a', '123123123123123123', '1459394344', '172.16.67.45', '172.16.67.45', '1459394344', 0.00);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
