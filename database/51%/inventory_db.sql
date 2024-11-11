/*
 Navicat Premium Dump SQL

 Source Server         : miste_ry
 Source Server Type    : MySQL
 Source Server Version : 100432 (10.4.32-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : inventory_db

 Target Server Type    : MySQL
 Target Server Version : 100432 (10.4.32-MariaDB)
 File Encoding         : 65001

 Date: 11/11/2024 22:32:34
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for inventory
-- ----------------------------
DROP TABLE IF EXISTS `inventory`;
CREATE TABLE `inventory`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `item_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `item_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `category` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `stock` int NULL DEFAULT NULL,
  `price` decimal(10, 2) NULL DEFAULT NULL,
  `supplier_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `qr_code_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `item_condition` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `date_registered` date NULL DEFAULT current_timestamp,
  `archive` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 25 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of inventory
-- ----------------------------
INSERT INTO `inventory` VALUES (4, '222-123', 'mouse', 'it produxts', 1111, 132.00, 'wow', NULL, NULL, NULL, NULL, '0');
INSERT INTO `inventory` VALUES (5, '222', '123', 'asd', 123, 1123.00, '', NULL, NULL, NULL, NULL, '0');
INSERT INTO `inventory` VALUES (15, '12345', 'barcode', 'Electronics', 200, 2500.00, '4', 'qrcodes/12345.png', 'Available', 'New', NULL, '0');
INSERT INTO `inventory` VALUES (22, '1724065019001', 'Laptop', 'Lab Equipment', 3, 160000.00, '7', 'qrcodes/1724065019001.png', 'Available', 'New', '2024-10-25', '0');
INSERT INTO `inventory` VALUES (23, 'HQ61280138336002991', 'Printer/ EPSON', 'Lab Equipment', 3, 90000.00, '8', 'qrcodes/HQ61280138336002991.png', '', '', '2024-10-25', '1');
INSERT INTO `inventory` VALUES (24, '4800049720121', 'Nature spring', 'Stationery', 1, 10.00, '7', 'qrcodes/4800049720121.png', 'Available', 'Used', '2024-10-25', '1');

-- ----------------------------
-- Table structure for release_log
-- ----------------------------
DROP TABLE IF EXISTS `release_log`;
CREATE TABLE `release_log`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `staff_id` int NULL DEFAULT NULL,
  `item_id` int NULL DEFAULT NULL,
  `quantity` int NOT NULL,
  `release_date` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of release_log
-- ----------------------------

-- ----------------------------
-- Table structure for request_items_table
-- ----------------------------
DROP TABLE IF EXISTS `request_items_table`;
CREATE TABLE `request_items_table`  (
  `item_id` int NOT NULL AUTO_INCREMENT,
  `request_id` int NULL DEFAULT NULL,
  `item` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `quantity` int NULL DEFAULT NULL,
  PRIMARY KEY (`item_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of request_items_table
-- ----------------------------
INSERT INTO `request_items_table` VALUES (1, 1, '4801981107971', 10);
INSERT INTO `request_items_table` VALUES (2, 2, '4801981107971', 2);
INSERT INTO `request_items_table` VALUES (3, 3, '4801981107971', 30);
INSERT INTO `request_items_table` VALUES (4, 3, '17', 30);
INSERT INTO `request_items_table` VALUES (5, 4, '4', 200);
INSERT INTO `request_items_table` VALUES (6, 4, '16', 12);
INSERT INTO `request_items_table` VALUES (7, 5, '123', 123);
INSERT INTO `request_items_table` VALUES (8, 5, '4801981107971', 1);
INSERT INTO `request_items_table` VALUES (9, 6, '222-123', 10);
INSERT INTO `request_items_table` VALUES (10, 6, '12345', 10);
INSERT INTO `request_items_table` VALUES (11, 7, '15', 1);
INSERT INTO `request_items_table` VALUES (12, 8, '22', 1);
INSERT INTO `request_items_table` VALUES (13, 9, '1724065019001', 2);
INSERT INTO `request_items_table` VALUES (14, 10, 'HQ61280138336002991', 2);
INSERT INTO `request_items_table` VALUES (15, 11, '21', 11);
INSERT INTO `request_items_table` VALUES (16, 12, '4800092113338', 11);
INSERT INTO `request_items_table` VALUES (17, 13, 'HQ61280138336002991', 2);
INSERT INTO `request_items_table` VALUES (18, 14, 'HQ61280138336002991', 2);
INSERT INTO `request_items_table` VALUES (19, 15, 'HQ61280138336002991', 2);
INSERT INTO `request_items_table` VALUES (20, 16, 'HQ61280138336002991', 2);
INSERT INTO `request_items_table` VALUES (21, 16, '4800092113338', 2);
INSERT INTO `request_items_table` VALUES (22, 17, '5', 3);

-- ----------------------------
-- Table structure for requests_table
-- ----------------------------
DROP TABLE IF EXISTS `requests_table`;
CREATE TABLE `requests_table`  (
  `request_id` int NOT NULL AUTO_INCREMENT,
  `staff_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `request_date` timestamp NOT NULL DEFAULT current_timestamp,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `request_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`request_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of requests_table
-- ----------------------------
INSERT INTO `requests_table` VALUES (6, '211', 'for multi media', '2024-10-25 07:47:19', 'Accepted', NULL);
INSERT INTO `requests_table` VALUES (7, '320209834', 'Office Supplies', '2024-10-25 10:53:51', 'Accepted', NULL);
INSERT INTO `requests_table` VALUES (8, '320209834', 'Lab EQUIPMENT', '2024-10-25 13:55:06', 'Accepted', NULL);
INSERT INTO `requests_table` VALUES (9, 'admin', 'for library', '2024-10-25 13:58:32', 'Accepted', NULL);
INSERT INTO `requests_table` VALUES (10, 'admin', 'for school', '2024-10-25 13:59:01', 'Accepted', NULL);
INSERT INTO `requests_table` VALUES (11, '143', 'kulang gamit', '2024-10-25 14:13:00', 'Pending', NULL);
INSERT INTO `requests_table` VALUES (12, 'admin', 'kulang gamit', '2024-10-25 14:15:28', 'Pending', NULL);
INSERT INTO `requests_table` VALUES (15, 'admin', 'kulang gamit', '2024-10-25 16:32:23', 'Accepted', NULL);
INSERT INTO `requests_table` VALUES (16, 'admin', 'kulang gamit', '2024-10-25 16:35:49', 'Pending', NULL);
INSERT INTO `requests_table` VALUES (17, '123', 'kulang gamit', '2024-10-25 16:51:46', 'Pending', NULL);

-- ----------------------------
-- Table structure for staff
-- ----------------------------
DROP TABLE IF EXISTS `staff`;
CREATE TABLE `staff`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `staff_firstname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `staff_middlename` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `staff_lastname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `staff_contact` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `staff_email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `staff_position` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `staff_department` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  `staff_username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `staff_password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `staff_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `staff_email`(`staff_email` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of staff
-- ----------------------------
INSERT INTO `staff` VALUES (11, 'sample', '', 'sample', 'sample', 'sample@gmail.com', 'Administrator', 'HR', '2024-09-28 13:54:58', 'admin', 'admin', 'admin');
INSERT INTO `staff` VALUES (12, 'sample1', 'sample1', 'sample1', 'sample1', 'sample1', 'sample1', 'sample1', '0000-00-00 00:00:00', 'sample1', 'sample1', 'sample1');
INSERT INTO `staff` VALUES (14, 'chin', '', 'vlle', '09876543211', 'chinvlle@gmail.com', 'Administrator', 'HR', '2024-10-25 07:42:39', 'chin10', '$2y$10$4PoN43WO/LroxzlogXHKq.pJ7MuhY9LGWVcSEiTHOY3VmW0.ExMS.', '211');
INSERT INTO `staff` VALUES (16, 'Johnmyr', '', 'Data', '09946031900', 'datajohnmyr@gmail.com', 'Supervisor', 'IT', '2024-10-25 10:53:00', 'johnmyr', '$2y$10$K7eKaqIjCNUkKZPHTFr/O.VBVSyC/l7eyVJ38TQhR6tuRY6qgBU9y', '320209834');
INSERT INTO `staff` VALUES (19, 'Johnmyr', '', 'Data', '09946031900', 'Datajohnmyr26@gmail.com', 'Administrator', 'IT', '2024-10-25 13:49:18', 'johnmyr', '$2y$10$4x04Jn3K5fVAhU0DESHvjOcp6tiuVGXsM0Trcmmty7KUSDFsyCnK6', '320209834');
INSERT INTO `staff` VALUES (20, 'richmond', '', 'suetado', '0998888888888', 'rs@gmail.com', 'Manager', 'IT', '2024-10-25 14:12:03', 'richmond', '$2y$10$/t5FrTHQzwAEJOKa0yq32u8CBRB0uviR2ZTEzn9jysOrv6llSTxBK', '143');
INSERT INTO `staff` VALUES (21, 'john', '', 'collamar', '09518325608', 'john@gmail.com', 'Supervisor', 'IT', '2024-10-25 16:31:33', 'john', '$2y$10$bNw2FhqP6Q93sJerm6DxuOKLp7gLDPYnm4PXl8rmPjGL0uSbKj8RS', '123');
INSERT INTO `staff` VALUES (22, 'zxczxc', 'zxczxc', 'zxczxc', '09946031900', 'zxcc@gmal.com', 'Administrator', 'IT', '2024-11-01 22:31:33', 'zxc', '$2y$10$CCB4OtMv9/j86e.PukA6mectiSetq.uhLk2lwwJPrE03dYo.OGZU6', '111111111111111111');

-- ----------------------------
-- Table structure for suppliers
-- ----------------------------
DROP TABLE IF EXISTS `suppliers`;
CREATE TABLE `suppliers`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `supplier_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `supplier_contact` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `supplier_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `supplier_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `archived` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of suppliers
-- ----------------------------
INSERT INTO `suppliers` VALUES (7, 'Johnmyr', '09946031900', 'datajohnmyr@gmail.com', 'Brgy Labangal GSC', '0');
INSERT INTO `suppliers` VALUES (8, 'Richmond', '121314', 'dasdadad@gmail.com', 'askasdjasdsa', '0');
INSERT INTO `suppliers` VALUES (9, 'National Bookstore', '0012010121', 'Natbookstore@gmail.com', 'Kjjdajdsadjasdadja Gennsantoscity', '1');

SET FOREIGN_KEY_CHECKS = 1;
