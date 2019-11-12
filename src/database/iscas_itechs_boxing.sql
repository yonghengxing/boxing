-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2018-12-06 07:41:08
-- 服务器版本： 10.1.36-MariaDB
-- PHP 版本： 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `iscas_itechs_boxing`
--

-- --------------------------------------------------------

--
-- 表的结构 `itechs_apprgroup`
--

CREATE TABLE `itechs_apprgroup` (
  `id` int(32) NOT NULL COMMENT '主键',
  `node_id` int(32) NOT NULL COMMENT '节点的id',
  `approver_id` int(32) NOT NULL COMMENT '该节点包括的审批人id',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '时间戳',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '时间戳'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `itechs_apprgroup`
--

INSERT INTO `itechs_apprgroup` (`id`, `node_id`, `approver_id`, `created_at`, `updated_at`) VALUES
(1, 2, 4, '2018-11-22 03:00:00', '2018-11-22 03:00:00'),
(2, 2, 6, '2018-11-22 03:00:00', '2018-11-22 03:00:00'),
(3, 1, 7, '2018-11-22 11:17:07', '2018-11-22 11:17:07'),
(4, 1, 8, '2018-11-22 11:17:07', '2018-11-22 11:17:07'),
(5, 1, 9, '2018-11-22 11:17:15', '2018-11-22 11:17:15'),
(6, 3, 4, '2018-11-28 09:42:14', '2018-11-28 09:42:14'),
(7, 3, 6, '2018-11-28 09:42:14', '2018-11-28 09:42:14'),
(8, 3, 7, '2018-11-28 09:42:42', '2018-11-28 09:42:42'),
(9, 4, 8, '2018-11-28 09:54:34', '2018-11-28 09:54:34'),
(10, 4, 9, '2018-11-28 09:54:34', '2018-11-28 09:54:34'),
(11, 7, 4, '2018-11-28 10:16:15', '2018-11-28 10:16:15'),
(14, 8, 8, '2018-11-30 10:27:15', '2018-11-30 10:27:15'),
(15, 2, 12, '2018-12-06 13:53:30', '2018-12-06 13:53:30');

-- --------------------------------------------------------

--
-- 表的结构 `itechs_apprnode`
--

CREATE TABLE `itechs_apprnode` (
  `id` int(32) NOT NULL COMMENT '主键',
  `comp_type` int(16) NOT NULL COMMENT '组件类型',
  `node_name` varchar(255) NOT NULL COMMENT '节点名字',
  `level` int(16) NOT NULL COMMENT '节点等级',
  `max_level` int(16) NOT NULL DEFAULT '0' COMMENT '审批最大的节点数',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `itechs_apprnode`
--

INSERT INTO `itechs_apprnode` (`id`, `comp_type`, `node_name`, `level`, `max_level`, `created_at`, `updated_at`) VALUES
(1, 100, '节点2', 2, 2, '2018-11-22 14:43:23', '2018-11-22 14:43:23'),
(2, 100, '节点1', 1, 2, '2018-11-22 14:43:23', '2018-11-22 14:43:23'),
(7, 200, 'dwwd', 1, 1, '2018-11-28 10:16:05', '2018-11-28 10:16:05'),
(8, 300, '节点1', 1, 2, '2018-11-30 10:26:30', '2018-11-30 10:26:30'),
(9, 300, '节点2', 2, 2, '2018-11-30 10:26:30', '2018-11-30 10:26:30');

-- --------------------------------------------------------

--
-- 表的结构 `itechs_apprrecord`
--

CREATE TABLE `itechs_apprrecord` (
  `id` int(32) NOT NULL COMMENT '审批记录id',
  `appr_event` int(32) NOT NULL COMMENT '对应审批事件id',
  `approver` int(32) NOT NULL COMMENT '审批人id',
  `appr_desc` varchar(255) NOT NULL COMMENT '审批意见',
  `appr_node` int(32) NOT NULL COMMENT '审批节点号',
  `has_passed` int(16) NOT NULL COMMENT '是否给予通过',
  `created_at` datetime NOT NULL COMMENT '时间戳',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '时间戳'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `itechs_apprrecord`
--

INSERT INTO `itechs_apprrecord` (`id`, `appr_event`, `approver`, `appr_desc`, `appr_node`, `has_passed`, `created_at`, `updated_at`) VALUES
(1, 4, 4, 'dddddd', 2, 1, '2018-11-23 14:57:08', '2018-11-23 15:00:00'),
(6, 4, 9, 'okokok!!!!', 1, 1, '2018-11-23 18:37:58', '2018-11-23 18:37:58'),
(7, 6, 4, '没有问题可以出库', 2, 1, '2018-11-25 19:30:40', '2018-11-25 19:30:40'),
(8, 6, 9, '我也觉得ok', 1, 1, '2018-11-25 19:32:44', '2018-11-25 19:32:44'),
(9, 7, 4, '我觉得ok', 2, 1, '2018-11-26 12:36:52', '2018-11-26 12:36:52'),
(11, 7, 9, '我也觉得ok', 1, 1, '2018-11-26 12:39:12', '2018-11-26 12:39:12'),
(12, 9, 4, 'ghuiiu', 2, 1, '2018-11-26 15:35:34', '2018-11-26 15:35:34'),
(13, 9, 9, 'guigiugiugui', 1, 1, '2018-11-26 15:35:56', '2018-11-26 15:35:56'),
(14, 11, 4, '5646546', 2, 1, '2018-11-26 15:36:55', '2018-11-26 15:36:55'),
(15, 11, 9, 'kik9i', 1, 1, '2018-11-26 15:37:34', '2018-11-26 15:37:34'),
(16, 13, 4, 'okok', 2, 1, '2018-11-26 17:36:31', '2018-11-26 17:36:31'),
(17, 13, 9, 'no ok', 1, 0, '2018-11-26 18:20:52', '2018-11-26 18:20:52'),
(18, 15, 4, 'okok!!!!', 2, 1, '2018-11-27 11:09:02', '2018-11-27 11:09:02'),
(19, 15, 9, 'oihoih', 1, 1, '2018-11-27 11:10:33', '2018-11-27 11:10:33'),
(20, 17, 4, 'wdhoidhwoihdoiwoihdw', 2, 1, '2018-11-27 11:12:02', '2018-11-27 11:12:02'),
(21, 17, 9, 'dwdwdwdw', 1, 1, '2018-11-27 11:12:17', '2018-11-27 11:12:17'),
(22, 19, 4, 'okok', 7, 1, '2018-11-28 16:16:25', '2018-11-28 16:16:25'),
(23, 21, 4, 'okok', 7, 1, '2018-11-28 17:04:26', '2018-11-28 17:04:26'),
(24, 22, 4, 'okok', 7, 1, '2018-11-28 17:05:26', '2018-11-28 17:05:26'),
(25, 24, 4, 'okok', 2, 1, '2018-11-28 19:16:29', '2018-11-28 19:16:29'),
(26, 24, 9, 'yesyes', 1, 1, '2018-11-28 19:16:52', '2018-11-28 19:16:52'),
(27, 26, 4, '不ok', 2, 0, '2018-11-28 19:20:08', '2018-11-28 19:20:08'),
(28, 27, 4, '行吧', 2, 1, '2018-11-28 19:21:19', '2018-11-28 19:21:19'),
(29, 27, 9, '彳亍口巴', 1, 1, '2018-11-28 19:21:54', '2018-11-28 19:21:54'),
(30, 28, 4, '彳亍口巴', 2, 1, '2018-11-28 19:23:36', '2018-11-28 19:23:36'),
(31, 28, 9, '彳亍口巴，没问题', 1, 1, '2018-11-28 19:24:17', '2018-11-28 19:24:17'),
(32, 30, 4, 'ok', 7, 1, '2018-11-30 10:44:49', '2018-11-30 10:44:49'),
(33, 32, 4, 'ok', 7, 1, '2018-11-30 10:48:05', '2018-11-30 10:48:05'),
(34, 33, 4, 'ok', 7, 1, '2018-11-30 10:51:13', '2018-11-30 10:51:13'),
(35, 35, 4, 'ok', 7, 1, '2018-11-30 11:13:08', '2018-11-30 11:13:08'),
(36, 37, 4, 'ok', 7, 1, '2018-11-30 11:16:54', '2018-11-30 11:16:54'),
(37, 38, 4, 'ok', 7, 1, '2018-11-30 11:19:32', '2018-11-30 11:19:32');

-- --------------------------------------------------------

--
-- 表的结构 `itechs_compauthority`
--

CREATE TABLE `itechs_compauthority` (
  `id` int(32) NOT NULL COMMENT '授权主键',
  `user_id` int(32) NOT NULL COMMENT '授权用户ID',
  `comp_id` int(32) NOT NULL COMMENT '授权组件ID',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `itechs_compauthority`
--

INSERT INTO `itechs_compauthority` (`id`, `user_id`, `comp_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2018-11-19 06:00:00', '2018-11-19 06:00:00'),
(2, 1, 3, '2018-11-19 06:00:00', '2018-11-19 06:00:00'),
(3, 1, 5, '2018-11-19 06:00:00', '2018-11-19 06:00:00'),
(4, 1, 7, '2018-11-19 06:00:00', '2018-11-19 06:00:00'),
(5, 2, 1, '2018-11-21 06:00:00', '2018-11-21 06:00:00'),
(6, 4, 1, '2018-11-21 11:00:00', '2018-11-21 11:00:00'),
(7, 6, 1, '2018-11-21 07:00:00', '2018-11-21 07:00:00'),
(8, 7, 1, '2018-11-21 06:00:00', '2018-11-21 06:00:00'),
(9, 8, 1, '2018-11-21 06:00:00', '2018-11-21 06:00:00'),
(10, 9, 1, '2018-11-21 06:00:00', '2018-11-21 06:00:00'),
(11, 9, 2, '2018-11-22 11:00:00', '2018-11-22 12:00:00'),
(12, 3, 1, '2018-11-23 04:00:00', '2018-11-23 04:00:00'),
(13, 2, 4, '2018-11-27 16:12:38', '2018-11-27 16:12:38'),
(14, 2, 7, '2018-11-27 16:12:38', '2018-11-27 16:12:38'),
(15, 2, 6, '2018-11-27 16:12:38', '2018-11-27 16:12:38'),
(16, 2, 3, '2018-11-27 16:16:05', '2018-11-27 16:16:05'),
(17, 2, 8, '2018-11-27 16:16:05', '2018-11-27 16:16:05'),
(20, 2, 10, '2018-11-28 14:19:56', '2018-11-28 14:19:56'),
(21, 3, 10, '2018-11-28 14:19:56', '2018-11-28 14:19:56'),
(22, 4, 10, '2018-11-28 14:19:56', '2018-11-28 14:19:56'),
(23, 6, 10, '2018-11-28 14:19:56', '2018-11-28 14:19:56'),
(24, 7, 10, '2018-11-28 14:19:56', '2018-11-28 14:19:56'),
(25, 8, 10, '2018-11-28 14:19:56', '2018-11-28 14:19:56'),
(26, 9, 10, '2018-11-28 14:19:56', '2018-11-28 14:19:56'),
(27, 3, 3, '2018-11-28 16:14:45', '2018-11-28 16:14:45'),
(28, 4, 3, '2018-11-28 16:14:45', '2018-11-28 16:14:45'),
(29, 10, 1, '2018-11-30 10:15:14', '2018-11-30 10:15:14'),
(30, 6, 11, '2018-11-30 10:22:00', '2018-11-30 10:22:00'),
(31, 8, 11, '2018-11-30 10:22:00', '2018-11-30 10:22:00'),
(32, 4, 4, '2018-11-30 10:42:15', '2018-11-30 10:42:15'),
(33, 3, 4, '2018-11-30 10:42:33', '2018-11-30 10:42:33'),
(34, 5, 1, '2018-11-30 10:58:19', '2018-11-30 10:58:19'),
(35, 1, 12, '2018-12-03 09:56:46', '2018-12-03 09:56:46'),
(36, 2, 12, '2018-12-03 09:56:46', '2018-12-03 09:56:46'),
(37, 3, 12, '2018-12-03 09:56:46', '2018-12-03 09:56:46'),
(38, 6, 12, '2018-12-03 09:56:46', '2018-12-03 09:56:46'),
(39, 8, 12, '2018-12-03 09:56:59', '2018-12-03 09:56:59'),
(40, 1, 13, '2018-12-03 17:43:57', '2018-12-03 17:43:57'),
(41, 3, 13, '2018-12-03 17:43:57', '2018-12-03 17:43:57'),
(42, 2, 13, '2018-12-03 17:43:57', '2018-12-03 17:43:57'),
(43, 9, 13, '2018-12-03 17:44:09', '2018-12-03 17:44:09'),
(44, 11, 1, '2018-12-06 11:02:45', '2018-12-06 11:02:45'),
(45, 11, 5, '2018-12-06 11:02:45', '2018-12-06 11:02:45'),
(46, 11, 13, '2018-12-06 11:02:45', '2018-12-06 11:02:45'),
(47, 12, 1, '2018-12-06 13:46:05', '2018-12-06 13:46:05');

-- --------------------------------------------------------

--
-- 表的结构 `itechs_component`
--

CREATE TABLE `itechs_component` (
  `id` int(32) NOT NULL COMMENT '组件id',
  `comp_name` varchar(255) NOT NULL COMMENT '组件名称',
  `comp_type` int(16) NOT NULL COMMENT '组件类型',
  `comp_desc` varchar(255) NOT NULL COMMENT '组件描述',
  `group_id` int(32) NOT NULL COMMENT '所属公司ID',
  `latest_ver` int(32) NOT NULL DEFAULT '0' COMMENT '最新版本id',
  `latest_vernum` varchar(60) NOT NULL DEFAULT '0' COMMENT '最新版本号（str）',
  `dev_import` int(16) NOT NULL DEFAULT '1001' COMMENT '允许上传入库标志',
  `test_status` int(16) NOT NULL DEFAULT '2000',
  `test_count` int(16) NOT NULL DEFAULT '0',
  `test_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `appr_status` int(16) NOT NULL DEFAULT '10000' COMMENT '该组件有无待审核事件',
  `appr_count` int(16) NOT NULL DEFAULT '0' COMMENT '待审核事件数量',
  `appr_updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '组件新审核时间点',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产品组件表';

--
-- 转存表中的数据 `itechs_component`
--

INSERT INTO `itechs_component` (`id`, `comp_name`, `comp_type`, `comp_desc`, `group_id`, `latest_ver`, `latest_vernum`, `dev_import`, `test_status`, `test_count`, `test_updated`, `appr_status`, `appr_count`, `appr_updated`, `created_at`, `updated_at`) VALUES
(1, '波形101', 100, '波形101，测试用对象', 1, 12, '2.11', 1001, 2000, 0, '2018-11-28 19:20:42', 10000, 0, '2018-11-28 19:24:20', '2018-11-19 04:00:00', '2018-11-28 19:24:20'),
(2, '波形102', 100, '波形102，测试用对象', 1, 0, '0', 1001, 2000, 0, '2018-11-19 19:36:47', 10000, 0, '2018-11-19 19:30:16', '2018-11-19 04:00:00', '2018-11-19 04:00:00'),
(3, '标准201', 200, '标准201，测试用对象', 1, 10, '1.11', 1001, 2000, 0, '2018-11-28 17:04:02', 10000, 0, '2018-11-28 17:05:29', '2018-11-19 05:00:00', '2018-11-28 17:05:29'),
(4, '标准202', 200, '标准202，测试用对象', 1, 16, '1.31', 1001, 2000, 0, '2018-11-30 11:15:19', 10000, 0, '2018-11-30 11:19:32', '2018-11-19 05:00:00', '2018-11-30 11:19:32'),
(5, '测试文档301', 300, '测试文档301，测试用对象', 1, 0, '0', 1001, 2000, 0, '2018-11-19 19:36:47', 10000, 0, '2018-11-19 19:30:16', '2018-11-19 06:00:00', '2018-11-19 06:00:00'),
(6, '测试文档302', 300, '测试文档302，测试用对象okok', 1, 0, '0', 1001, 2000, 0, '2018-11-19 19:36:47', 10000, 0, '2018-11-19 19:30:16', '2018-11-19 08:00:00', '2018-11-29 09:37:46'),
(7, '设计文档401', 400, '设计文档401，测试用对象', 1, 0, '0', 1001, 2000, 0, '2018-11-19 19:36:47', 10000, 0, '2018-11-19 19:30:16', '2018-11-19 08:00:00', '2018-11-19 08:00:00'),
(8, '设计文档402', 400, '设计文档402，测试用对象', 1, 0, '0', 1001, 2000, 0, '2018-11-19 19:36:47', 10000, 0, '2018-11-19 19:30:16', '2018-11-19 08:00:00', '2018-11-19 08:00:00'),
(10, '大力丸', 400, '吃了就会STR+1000，仅售500000G', 2, 0, '0', 1001, 2000, 0, '2018-11-28 14:19:30', 10000, 0, '2018-11-28 14:19:30', '2018-11-28 14:19:30', '2018-11-28 14:19:30'),
(11, '测试文档演示测试', 300, '演示1的测试文档', 1, 0, '0', 1001, 2000, 0, '2018-11-30 10:20:16', 10000, 0, '2018-11-30 10:20:16', '2018-11-30 10:20:16', '2018-11-30 10:20:16'),
(12, '设计文档测试101', 400, '设计文档演示测试101', 3, 0, '0', 1001, 2000, 0, '2018-12-03 09:56:08', 10000, 0, '2018-12-03 09:56:08', '2018-12-03 09:56:08', '2018-12-03 09:56:08'),
(13, '波形333', 100, '波形333测试', 2, 0, '0', 1001, 2000, 0, '2018-12-03 17:42:45', 10000, 0, '2018-12-03 17:42:45', '2018-12-03 17:42:45', '2018-12-03 17:42:45');

-- --------------------------------------------------------

--
-- 表的结构 `itechs_event`
--

CREATE TABLE `itechs_event` (
  `id` int(32) NOT NULL COMMENT '事件主键',
  `type` int(16) NOT NULL COMMENT '事件类型',
  `user_id` int(32) NOT NULL DEFAULT '0' COMMENT '发起或指派的用户ID',
  `description` varchar(255) DEFAULT NULL COMMENT '事件描述',
  `comp_id` int(32) NOT NULL COMMENT '事件所属组件id',
  `comp_ver` int(32) NOT NULL DEFAULT '0' COMMENT '事件对应组件版本id',
  `ver_num` varchar(60) DEFAULT NULL COMMENT '版本号码',
  `status` int(16) NOT NULL DEFAULT '0' COMMENT '事件状态',
  `has_assigned` int(16) NOT NULL DEFAULT '0' COMMENT '对测试、审核事件是否有分配',
  `file_path` varchar(255) DEFAULT NULL COMMENT '存放组件文件目录',
  `descdoc_path` varchar(255) DEFAULT NULL COMMENT '开发方入库的说明文件路径',
  `testdoc_path` varchar(255) DEFAULT NULL COMMENT '测试方的测试报告路径',
  `pre_event` int(32) NOT NULL DEFAULT '0' COMMENT '前置事件',
  `appr_level` int(32) NOT NULL DEFAULT '0' COMMENT '审核时节点组的层次',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '时间戳',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '时间戳'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `itechs_event`
--

INSERT INTO `itechs_event` (`id`, `type`, `user_id`, `description`, `comp_id`, `comp_ver`, `ver_num`, `status`, `has_assigned`, `file_path`, `descdoc_path`, `testdoc_path`, `pre_event`, `appr_level`, `created_at`, `updated_at`) VALUES
(3, 1000, 2, '第一次入库', 1, 5, '1.00', 1301, 1, '/app/upload/temp/component/1/1.00/', '/app/upload/temp/descdoc/1/1.00/', '/app/upload/TestDoc/1/1.00/', 0, 0, '2018-11-21 20:41:08', '2018-11-26 12:39:13'),
(4, 11000, 0, '第一次入库', 1, 0, '1.00', 11001, 1, '/app/upload/temp/component/1/1.00/', '/app/upload/temp/descdoc/1/1.00/', NULL, 3, 2, '2018-11-21 20:41:08', '2018-11-23 18:37:58'),
(5, 2000, 3, '申请测试001', 1, 5, '1.00', 2105, 1, '/app/upload/ShouKong/1/1.00/', '/app/upload/DescDoc/1/1.00/', NULL, 3, 0, '2018-11-23 18:37:58', '2018-11-26 12:39:13'),
(6, 12000, 0, '申请测试001', 1, 0, '1.00', 21001, 1, NULL, NULL, NULL, 5, 2, '2018-11-25 17:41:27', '2018-11-25 19:32:44'),
(7, 13000, 0, '测试通过ok!!!', 1, 0, '1.00', 31001, 1, NULL, NULL, '/app/upload/temp/testdoc/1/1.00/', 5, 2, '2018-11-26 12:20:51', '2018-11-26 12:39:13'),
(8, 1000, 2, 'uyfuyfuyfuyfuy', 1, 7, '1.12', 1210, 1, '/app/upload/temp/component/1/1.12/', '/app/upload/temp/descdoc/1/1.12/', NULL, 0, 0, '2018-11-26 15:34:46', '2018-11-26 21:09:39'),
(9, 11000, 0, 'uyfuyfuyfuyfuy', 1, 0, '1.12', 11001, 1, '/app/upload/temp/component/1/1.12/', '/app/upload/temp/descdoc/1/1.12/', NULL, 8, 2, '2018-11-26 15:34:46', '2018-11-26 15:35:57'),
(10, 2000, 3, 'iugiguyguy', 1, 7, '1.12', 2110, 1, '/app/upload/ShouKong/1/1.12/', '/app/upload/DescDoc/1/1.12/', NULL, 8, 0, '2018-11-26 15:35:57', '2018-11-26 21:09:39'),
(11, 12000, 0, 'iugiguyguy', 1, 0, '1.12', 21001, 1, NULL, NULL, NULL, 10, 2, '2018-11-26 15:36:37', '2018-11-26 15:37:34'),
(12, 1000, 4, 'uigugiguiwdguidwuiauiwd', 1, 0, '1.15', 1111, 1, '/app/upload/temp/component/1/1.15/', '/app/upload/temp/descdoc/1/1.15/', NULL, 0, 0, '2018-11-26 17:19:32', '2018-11-26 18:20:52'),
(13, 11000, 0, 'uigugiguiwdguidwuiauiwd', 1, 0, '1.15', 11100, 1, '/app/upload/temp/component/1/1.15/', '/app/upload/temp/descdoc/1/1.15/', NULL, 12, 2, '2018-11-26 17:19:32', '2018-11-26 18:20:52'),
(14, 1000, 2, 'hh82y892y891', 1, 8, '1.92', 1210, 1, '/app/upload/temp/component/1/1.92/', '/app/upload/temp/descdoc/1/1.92/', '/app/upload/temp/testdoc/1/1.92_1543288385/', 0, 0, '2018-11-27 11:05:22', '2018-11-27 11:13:05'),
(15, 11000, 0, 'hh82y892y891', 1, 0, '1.92', 11001, 1, '/app/upload/temp/component/1/1.92/', '/app/upload/temp/descdoc/1/1.92/', NULL, 14, 2, '2018-11-27 11:05:23', '2018-11-27 11:10:34'),
(16, 2000, 3, 'uwhouidhwudwh', 1, 8, '1.92', 2110, 1, '/app/upload/ShouKong/1/1.92/', '/app/upload/DescDoc/1/1.92/', NULL, 14, 0, '2018-11-27 11:10:34', '2018-11-27 11:13:05'),
(17, 12000, 0, 'uwhouidhwudwh', 1, 0, '1.92', 21001, 1, NULL, NULL, NULL, 16, 2, '2018-11-27 11:11:29', '2018-11-27 11:12:17'),
(18, 1000, 2, '测试git入库', 3, 9, '1.11', 1301, 1, '/app/upload/temp/component/3/1.11/', '/app/upload/temp/descdoc/3/1.11/', '/app/upload/TestDoc/3/1.11/', 0, 0, '2018-11-28 16:15:56', '2018-11-28 17:05:29'),
(19, 11000, 0, '测试git入库', 3, 0, '1.11', 11001, 1, '/app/upload/temp/component/3/1.11/', '/app/upload/temp/descdoc/3/1.11/', NULL, 18, 1, '2018-11-28 16:15:56', '2018-11-28 16:16:28'),
(20, 2000, 3, '测试git入产品库', 3, 9, '1.11', 2105, 1, '/app/upload/ShouKong/3/1.11/', '/app/upload/DescDoc/3/1.11/', NULL, 18, 0, '2018-11-28 16:16:28', '2018-11-28 17:05:29'),
(21, 12000, 0, '测试git入产品库', 3, 0, '1.11', 21001, 1, NULL, NULL, NULL, 20, 1, '2018-11-28 17:04:02', '2018-11-28 17:04:26'),
(22, 13000, 0, 'jjijiwjdoiwj', 3, 0, '1.11', 31001, 1, NULL, NULL, '/app/upload/temp/testdoc/3/1.11_1543395898/', 20, 1, '2018-11-28 17:04:58', '2018-11-28 17:05:29'),
(23, 1000, 2, '测试测试', 1, 11, '2.11', 1301, 1, '/app/upload/temp/component/1/2.11/', '/app/upload/temp/descdoc/1/2.11/', '/app/upload/TestDoc/1/2.11/', 0, 0, '2018-11-28 19:09:25', '2018-11-28 19:24:20'),
(24, 11000, 0, '测试测试', 1, 0, '2.11', 11001, 1, '/app/upload/temp/component/1/2.11/', '/app/upload/temp/descdoc/1/2.11/', NULL, 23, 2, '2018-11-28 19:09:25', '2018-11-28 19:16:55'),
(25, 2000, 3, '再来', 1, 11, '2.11', 2105, 1, '/app/upload/ShouKong/1/2.11/', '/app/upload/DescDoc/1/2.11/', NULL, 23, 0, '2018-11-28 19:16:55', '2018-11-28 19:24:20'),
(26, 12000, 0, '申请申请', 1, 0, '2.11', 21100, 1, NULL, NULL, NULL, 25, 1, '2018-11-28 19:17:50', '2018-11-28 19:20:08'),
(27, 12000, 0, '再来', 1, 0, '2.11', 21001, 1, NULL, NULL, NULL, 25, 2, '2018-11-28 19:20:42', '2018-11-28 19:21:54'),
(28, 13000, 0, '彳亍口巴，没问题', 1, 0, '2.11', 31001, 1, NULL, NULL, '/app/upload/temp/testdoc/1/2.11_1543404187/', 25, 2, '2018-11-28 19:23:07', '2018-11-28 19:24:20'),
(29, 1000, 2, '标准2测试上传', 4, 13, '1.21', 1301, 1, '/app/upload/temp/component/4/1.21/', '/app/upload/temp/descdoc/4/1.21/', '/app/upload/TestDoc/4/1.21/', 0, 0, '2018-11-30 10:36:18', '2018-11-30 10:51:15'),
(30, 11000, 0, '标准2测试上传', 4, 0, '1.21', 11001, 1, '/app/upload/temp/component/4/1.21/', '/app/upload/temp/descdoc/4/1.21/', NULL, 29, 1, '2018-11-30 10:36:18', '2018-11-30 10:44:50'),
(31, 2000, 3, '申请标准2测试', 4, 13, '1.21', 2105, 1, '/app/upload/ShouKong/4/1.21/', '/app/upload/DescDoc/4/1.21/', NULL, 29, 0, '2018-11-30 10:44:50', '2018-11-30 10:51:15'),
(32, 12000, 0, '申请标准2测试', 4, 0, '1.21', 21001, 1, NULL, NULL, NULL, 31, 1, '2018-11-30 10:46:57', '2018-11-30 10:48:05'),
(33, 13000, 0, '123456', 4, 0, '1.21', 31001, 1, NULL, NULL, '/app/upload/temp/testdoc/4/1.21_1543546199/', 31, 1, '2018-11-30 10:49:59', '2018-11-30 10:51:15'),
(34, 1000, 2, '标准202测试上传2', 4, 15, '1.31', 1301, 1, '/app/upload/temp/component/4/1.31/', '/app/upload/temp/descdoc/4/1.31/', '/app/upload/TestDoc/4/1.31/', 0, 0, '2018-11-30 11:09:38', '2018-11-30 11:19:32'),
(35, 11000, 0, '标准202测试上传2', 4, 0, '1.31', 11001, 1, '/app/upload/temp/component/4/1.31/', '/app/upload/temp/descdoc/4/1.31/', NULL, 34, 1, '2018-11-30 11:09:38', '2018-11-30 11:13:08'),
(36, 2000, 3, '标准202测试上传2', 4, 15, '1.31', 2105, 1, '/app/upload/ShouKong/4/1.31/', '/app/upload/DescDoc/4/1.31/', NULL, 34, 0, '2018-11-30 11:13:09', '2018-11-30 11:19:32'),
(37, 12000, 0, '标准202测试上传2', 4, 0, '1.31', 21001, 1, NULL, NULL, NULL, 36, 1, '2018-11-30 11:15:19', '2018-11-30 11:16:54'),
(38, 13000, 0, 'ok', 4, 0, '1.31', 31001, 1, NULL, NULL, '/app/upload/temp/testdoc/4/1.31_1543547880/', 36, 1, '2018-11-30 11:18:00', '2018-11-30 11:19:32');

-- --------------------------------------------------------

--
-- 表的结构 `itechs_group`
--

CREATE TABLE `itechs_group` (
  `id` int(32) NOT NULL COMMENT '公司主键',
  `group_name` varchar(255) NOT NULL COMMENT '公司名称',
  `group_desc` varchar(255) NOT NULL COMMENT '公司描述',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '时间戳',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '时间戳'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `itechs_group`
--

INSERT INTO `itechs_group` (`id`, `group_name`, `group_desc`, `created_at`, `updated_at`) VALUES
(1, '测试公司', '写来测试的', '2018-11-20 14:54:34', '2018-11-20 14:54:34'),
(2, '大力公司', '卖大力丸的', '2018-11-20 14:54:34', '2018-11-20 14:54:34'),
(3, '乔斯达不动产', '美国地产大亨', '2018-11-28 14:46:44', '2018-11-28 14:46:44'),
(4, 'SPW财团', '石油大亨的哈哈哈哈', '2018-11-28 14:47:07', '2018-11-28 15:13:57');

-- --------------------------------------------------------

--
-- 表的结构 `itechs_issue`
--

CREATE TABLE `itechs_issue` (
  `id` int(11) NOT NULL COMMENT '问题主键',
  `title` varchar(255) NOT NULL COMMENT '问题标题',
  `description` varchar(255) NOT NULL COMMENT '问题描述',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '问题状态',
  `tester_id` int(11) NOT NULL COMMENT '提出的测试方id',
  `dev_id` int(11) NOT NULL COMMENT '解决问题的开发方id',
  `comp_id` int(11) NOT NULL COMMENT '组件id',
  `ver_num` varchar(60) NOT NULL COMMENT '组件版本',
  `dev_event` int(32) NOT NULL COMMENT '开发方上传事件',
  `testdoc_path` varchar(255) NOT NULL COMMENT '测试文档储存路径',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '时间戳',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '时间戳'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `itechs_issue`
--

INSERT INTO `itechs_issue` (`id`, `title`, `description`, `status`, `tester_id`, `dev_id`, `comp_id`, `ver_num`, `dev_event`, `testdoc_path`, `created_at`, `updated_at`) VALUES
(2, '测试有bug', '测试有bug测试有bug测试有bug测试有bug', 1, 3, 2, 1, '1.12', 8, '/app/upload/temp/testdoc/1/1.92_1543288385/', '2018-11-26 21:09:39', '2018-11-27 10:42:56'),
(3, '大力丸不管用', 'wdidiwhoiw', 0, 3, 2, 1, '1.92', 14, '/app/upload/temp/testdoc/1/1.92_1543288385/', '2018-11-27 11:13:05', '2018-11-27 11:13:05');

-- --------------------------------------------------------

--
-- 表的结构 `itechs_product`
--

CREATE TABLE `itechs_product` (
  `id` int(11) NOT NULL,
  `proid` int(255) NOT NULL COMMENT '产品ID',
  `profile` varchar(255) NOT NULL COMMENT '产品文件名称',
  `profilepath` varchar(255) NOT NULL,
  `comp_id` int(255) NOT NULL COMMENT '产品组件ID',
  `vernum` varchar(255) NOT NULL COMMENT '组件版本',
  `filepath` varchar(255) NOT NULL COMMENT '产品文件路径',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `itechs_product`
--

INSERT INTO `itechs_product` (`id`, `proid`, `profile`, `profilepath`, `comp_id`, `vernum`, `filepath`, `created_at`, `updated_at`) VALUES
(12, 6, 'file1', '/app/proID6', 1, '1.00', '/app/upload/ShouKong/1/1.00/', '2018-11-30 16:48:49', '2018-11-30 16:48:49'),
(14, 6, 'file1', '/app/proID6', 3, '1.11', '/app/upload/ChanPing/3/1.11/', '2018-11-30 16:49:33', '2018-11-30 16:49:33'),
(19, 6, 'file1', '/app/proID6', 3, '1.11', '/app/upload/ChanPing/3/1.11/', '2018-11-30 16:56:34', '2018-11-30 16:56:34'),
(20, 13, 'test1.txt', '/app/proc/13', 1, '1.00', '/app/upload/ShouKong/1/1.00/', '2018-12-03 16:14:30', '2018-12-03 16:14:30'),
(21, 13, 'yanshi.docx', '/app/proc/13', 1, '1.00', '/app/upload/ShouKong/1/1.00/', '2018-12-03 16:23:00', '2018-12-03 16:23:00'),
(22, 14, 'yanshi.docx', '/app/proc/14', 1, '1.00', '/app/upload/ShouKong/1/1.00/', '2018-12-05 11:04:50', '2018-12-05 11:04:50'),
(23, 15, 'yanshi.docx', '/app/proc/15', 1, '1.00', '/app/upload/ShouKong/1/1.00/', '2018-12-06 10:20:57', '2018-12-06 10:20:57');

-- --------------------------------------------------------

--
-- 表的结构 `itechs_productdevices`
--

CREATE TABLE `itechs_productdevices` (
  `id` int(11) NOT NULL,
  `devicesname` varchar(255) NOT NULL COMMENT '设备名称',
  `proid` int(255) NOT NULL COMMENT '产品ID',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `itechs_productdevices`
--

INSERT INTO `itechs_productdevices` (`id`, `devicesname`, `proid`, `created_at`, `updated_at`) VALUES
(1, '设备1', 6, '2018-12-03 14:13:09', '2018-12-03 14:17:05'),
(5, '设备3', 13, '2018-12-03 16:25:47', '2018-12-03 16:25:47'),
(6, '设备2', 11, '2018-12-04 14:34:03', '2018-12-04 14:34:03'),
(7, '1204设备', 14, '2018-12-05 11:05:35', '2018-12-05 11:05:35'),
(8, '1204设备1', 14, '2018-12-05 15:30:06', '2018-12-05 15:30:06'),
(9, '设备合并1', 15, '2018-12-06 10:22:21', '2018-12-06 10:22:21');

-- --------------------------------------------------------

--
-- 表的结构 `itechs_productindex`
--

CREATE TABLE `itechs_productindex` (
  `id` int(11) NOT NULL,
  `proname` varchar(255) NOT NULL,
  `prodespt` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `itechs_productindex`
--

INSERT INTO `itechs_productindex` (`id`, `proname`, `prodespt`, `created_at`, `updated_at`) VALUES
(6, 'asdf', 'dfgs', '2018-11-28 14:00:28', '2018-11-28 14:00:28'),
(11, 'sfgsh', 'fghjfh', '2018-11-28 15:11:04', '2018-11-28 15:11:04'),
(12, '1111', '1111', '2018-11-28 17:38:04', '2018-11-28 17:38:04'),
(13, '产品1', '产品1测试', '2018-12-03 13:49:58', '2018-12-03 13:49:58'),
(14, '产品2', '产品2流程测试', '2018-12-05 11:03:45', '2018-12-05 11:03:45'),
(15, '产品3', '产品3测试，代码合并测试', '2018-12-05 16:33:47', '2018-12-05 16:33:47');

-- --------------------------------------------------------

--
-- 表的结构 `itechs_user`
--

CREATE TABLE `itechs_user` (
  `id` int(32) NOT NULL COMMENT '用户ID主键',
  `username` varchar(255) NOT NULL COMMENT '登录用用户名',
  `password` varchar(255) NOT NULL COMMENT '登陆用密码',
  `true_name` varchar(255) NOT NULL COMMENT '用户的真实姓名',
  `user_role` int(16) NOT NULL COMMENT '用户角色',
  `admin` int(8) NOT NULL DEFAULT '0' COMMENT '管理员标志位',
  `group_id` int(16) NOT NULL DEFAULT '1' COMMENT '用户所属公司',
  `remember_token` varchar(255) NOT NULL COMMENT '记住我选项验证用',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `itechs_user`
--

INSERT INTO `itechs_user` (`id`, `username`, `password`, `true_name`, `user_role`, `admin`, `group_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$vJFAOh5P9LRCJ0m6c/WjIuYQvZ8ZMya/P9pMzCUdsreJsAzNsdZ.G', '管理员账号01', 1000, 1, 2, '1Q5yckwZfbMXhFDdmuQ7MckfdOz0JjkUSjmhxrAgdoDP36X5fhB2pw65UM7p', '2018-11-19 04:00:00', '2018-11-21 20:27:32'),
(2, 'kaifa001', '$2y$10$26k4HCi.T2yFQhMeyWWgNOPrbi..EzTOY8jRtkBFC6Kc1ltwdymLa', '开发方001', 1000, 0, 1, '0vNJGr1l50biECzX5Vij9bIusgx8kYxtRtjJ2l7596khe1hS2BnTDOHYACd9', '2018-11-19 04:00:00', '2018-11-21 20:27:51'),
(3, 'ceshi001', '$2y$10$tQp89Ob8m1Gk6RZuheHqw.hlzGAn8EcBMJtHa19/X2M0yYfyJVOaS', '测试方001', 2000, 0, 1, '0qaxBV7oaAcJQ6ZgVZ7tHsu2tt1W9pub9bS38O8YEx4VMeUzBR1h1r7gAQV5', '2018-11-19 04:00:00', '2018-11-23 20:33:31'),
(4, 'jiguan001', '$2y$10$rhuKv.MNvrOXSVmAqJbij.fnduCtaKz5dm633kX/z7Io0BK5j3EMG', '机关001', 3000, 0, 1, 'rm5z9nWDny64rX2uPbLdwkftyH9i0lcckIgH1wMNktIasz6SgimVhfWONBic', '2018-11-19 04:00:00', '2018-11-22 11:17:31'),
(5, 'wangdali', '$2y$10$0afdB1iiD/.X0EFdsupTE.p9xLmMcbeGZHXu2.t/hVAAx.Hw53y/6', '王大力', 3000, 0, 2, '', '2018-11-20 07:59:14', '2018-11-20 07:59:14'),
(6, 'jiguan002', '$2y$10$bR6TS76WlvHbYhLSyxI.Ve3lCVnZ/TXpjG4b2uAqzWE4pvozkuiea', '机关002', 3000, 0, 1, 'hPb89JH1w8dzE4WHZhJbEKNvFtbNw1y4n7dYM7mAN0pYGXIPNcZdo66rUfqj', '2018-11-20 17:05:39', '2018-11-22 11:17:45'),
(7, 'jiguan003', '$2y$10$KxdyK6sOrsFiEyDr2XQiaOGWIPm.yLx8.WXWgLtoq.ZNx6z.AAOe.', '机关003', 3000, 0, 1, '', '2018-11-20 17:06:12', '2018-11-22 11:18:06'),
(8, 'jiguan004', '$2y$10$z/pOiAxb2079apu4wyYXMud1uTcd.IFlD.nOqqFF1LUyj55R.MBSm', '机关004', 3000, 0, 1, 'DMk7GnORJ9APnRYlhN85OoAZU6FQcIqF8GvomT6u5yv0BR8CYZZ3APBSDFyl', '2018-11-20 17:06:34', '2018-11-22 11:18:20'),
(9, 'jiguan005', '$2y$10$SrA3r5HwqWI99GRpYEJILOHJPeXknL/C/rHFnBnFfdwQHOPbGxzZK', '机关005', 3000, 0, 1, 'let7C2vmeZzxrwEIPUq2ByA81IEdNqlxygWv8g387hX4g9IFIeXnvolZ4V51', '2018-11-20 17:06:57', '2018-11-22 11:18:44'),
(10, 'user1', '$2y$10$D25i6BSli.huAy/155jydeJJvvUJbYeNdcduh0J7fKC47VqXZogFW', '使用方1', 5000, 0, 2, '', '2018-11-30 10:13:33', '2018-11-30 10:13:33'),
(11, 'ceshi007', '$2y$10$yvKbgmRQw1BQ5sz7POqZgultlCVaK6lciWx6dRlOJxzW0YEO6mn4K', '演示测试人员007', 2000, 0, 1, '', '2018-12-04 10:48:41', '2018-12-04 10:48:41'),
(12, 'jiguan007', '$2y$10$en4yaUcX3qlMI7nztwYTN.0MfawZemcZtnHgmqxJtidvVGDLR5N0K', '机关007', 3000, 0, 3, '', '2018-12-06 13:45:51', '2018-12-06 13:45:51');

-- --------------------------------------------------------

--
-- 表的结构 `itechs_version`
--

CREATE TABLE `itechs_version` (
  `id` int(32) NOT NULL COMMENT '版本id',
  `type` int(16) NOT NULL COMMENT '类型（受控库/产品库）',
  `comp_id` int(32) NOT NULL COMMENT '组件id',
  `ver_num` varchar(60) NOT NULL COMMENT '版本号',
  `ver_status` int(16) NOT NULL COMMENT '版本状态',
  `event_import` int(32) NOT NULL DEFAULT '0' COMMENT '入库的事件id',
  `file_path` varchar(255) DEFAULT NULL COMMENT '组件文件路径',
  `descdoc_path` varchar(255) DEFAULT NULL COMMENT '描述文档路径',
  `testdoc_path` varchar(255) DEFAULT NULL COMMENT '测试文档路径',
  `cpver_id` int(32) NOT NULL DEFAULT '0' COMMENT '产品库版本id',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `itechs_version`
--

INSERT INTO `itechs_version` (`id`, `type`, `comp_id`, `ver_num`, `ver_status`, `event_import`, `file_path`, `descdoc_path`, `testdoc_path`, `cpver_id`, `created_at`, `updated_at`) VALUES
(5, 0, 1, '1.00', 1, 3, '/app/upload/ShouKong/1/1.00/', '/app/upload/DescDoc/1/1.00/', '/app/upload/TestDoc/1/1.00/', 0, '2018-11-23 18:37:58', '2018-11-26 12:39:13'),
(6, 1, 1, '1.00', 1, 3, '/app/upload/ShouKong/1/1.00/', '/app/upload/DescDoc/1/1.00/', '/app/upload/TestDoc/1/1.00/', 0, '2018-11-26 12:39:12', '2018-11-26 12:39:12'),
(7, 0, 1, '1.12', 1, 8, '/app/upload/ShouKong/1/1.12/', '/app/upload/DescDoc/1/1.12/', NULL, 0, '2018-11-26 15:35:56', '2018-11-26 15:35:56'),
(8, 0, 1, '1.92', 1, 14, '/app/upload/ShouKong/1/1.92/', '/app/upload/DescDoc/1/1.92/', NULL, 0, '2018-11-27 11:10:34', '2018-11-27 11:10:34'),
(9, 0, 3, '1.11', 1, 18, '/app/upload/ShouKong/3/1.11/', '/app/upload/DescDoc/3/1.11/', '/app/upload/TestDoc/3/1.11/', 0, '2018-11-28 16:16:28', '2018-11-28 17:05:29'),
(10, 1, 3, '1.11', 1, 18, '/app/upload/ChanPing/3/1.11/', '/app/upload/DescDoc/3/1.11/', '/app/upload/TestDoc/3/1.11/', 0, '2018-11-28 17:05:29', '2018-11-28 17:05:29'),
(11, 0, 1, '2.11', 1, 23, '/app/upload/ShouKong/1/2.11/', '/app/upload/DescDoc/1/2.11/', '/app/upload/TestDoc/1/2.11/', 0, '2018-11-28 19:16:55', '2018-11-28 19:24:20'),
(12, 1, 1, '2.11', 1, 23, '/app/upload/ChanPing/1/2.11/', '/app/upload/DescDoc/1/2.11/', '/app/upload/TestDoc/1/2.11/', 0, '2018-11-28 19:24:20', '2018-11-28 19:24:20'),
(13, 0, 4, '1.21', 1, 29, '/app/upload/ShouKong/4/1.21/', '/app/upload/DescDoc/4/1.21/', '/app/upload/TestDoc/4/1.21/', 0, '2018-11-30 10:44:50', '2018-11-30 10:51:15'),
(14, 1, 4, '1.21', 1, 29, '/app/upload/ChanPing/4/1.21/', '/app/upload/DescDoc/4/1.21/', '/app/upload/TestDoc/4/1.21/', 0, '2018-11-30 10:51:15', '2018-11-30 10:51:15'),
(15, 0, 4, '1.31', 1, 34, '/app/upload/ShouKong/4/1.31/', '/app/upload/DescDoc/4/1.31/', '/app/upload/TestDoc/4/1.31/', 0, '2018-11-30 11:13:08', '2018-11-30 11:19:32'),
(16, 1, 4, '1.31', 1, 34, '/app/upload/ChanPing/4/1.31/', '/app/upload/DescDoc/4/1.31/', '/app/upload/TestDoc/4/1.31/', 0, '2018-11-30 11:19:32', '2018-11-30 11:19:32');

--
-- 转储表的索引
--

--
-- 表的索引 `itechs_apprgroup`
--
ALTER TABLE `itechs_apprgroup`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `itechs_apprnode`
--
ALTER TABLE `itechs_apprnode`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `itechs_apprrecord`
--
ALTER TABLE `itechs_apprrecord`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `itechs_compauthority`
--
ALTER TABLE `itechs_compauthority`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `itechs_component`
--
ALTER TABLE `itechs_component`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `itechs_event`
--
ALTER TABLE `itechs_event`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `itechs_group`
--
ALTER TABLE `itechs_group`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `itechs_issue`
--
ALTER TABLE `itechs_issue`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `itechs_product`
--
ALTER TABLE `itechs_product`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `itechs_productdevices`
--
ALTER TABLE `itechs_productdevices`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `itechs_productindex`
--
ALTER TABLE `itechs_productindex`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `itechs_user`
--
ALTER TABLE `itechs_user`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `itechs_version`
--
ALTER TABLE `itechs_version`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `itechs_apprgroup`
--
ALTER TABLE `itechs_apprgroup`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT COMMENT '主键', AUTO_INCREMENT=16;

--
-- 使用表AUTO_INCREMENT `itechs_apprnode`
--
ALTER TABLE `itechs_apprnode`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT COMMENT '主键', AUTO_INCREMENT=10;

--
-- 使用表AUTO_INCREMENT `itechs_apprrecord`
--
ALTER TABLE `itechs_apprrecord`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT COMMENT '审批记录id', AUTO_INCREMENT=38;

--
-- 使用表AUTO_INCREMENT `itechs_compauthority`
--
ALTER TABLE `itechs_compauthority`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT COMMENT '授权主键', AUTO_INCREMENT=48;

--
-- 使用表AUTO_INCREMENT `itechs_component`
--
ALTER TABLE `itechs_component`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT COMMENT '组件id', AUTO_INCREMENT=14;

--
-- 使用表AUTO_INCREMENT `itechs_event`
--
ALTER TABLE `itechs_event`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT COMMENT '事件主键', AUTO_INCREMENT=39;

--
-- 使用表AUTO_INCREMENT `itechs_group`
--
ALTER TABLE `itechs_group`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT COMMENT '公司主键', AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `itechs_issue`
--
ALTER TABLE `itechs_issue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '问题主键', AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `itechs_product`
--
ALTER TABLE `itechs_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- 使用表AUTO_INCREMENT `itechs_productdevices`
--
ALTER TABLE `itechs_productdevices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 使用表AUTO_INCREMENT `itechs_productindex`
--
ALTER TABLE `itechs_productindex`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- 使用表AUTO_INCREMENT `itechs_user`
--
ALTER TABLE `itechs_user`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT COMMENT '用户ID主键', AUTO_INCREMENT=13;

--
-- 使用表AUTO_INCREMENT `itechs_version`
--
ALTER TABLE `itechs_version`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT COMMENT '版本id', AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
