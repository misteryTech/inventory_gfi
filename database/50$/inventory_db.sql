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

 Date: 25/10/2024 09:48:53
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
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of inventory
-- ----------------------------
INSERT INTO `inventory` VALUES (4, '222-123', 'mouse', 'it produxts', 1111, 132.00, 'wow', NULL, NULL, NULL, NULL);
INSERT INTO `inventory` VALUES (5, '222', '123', 'asd', 123, 1123.00, '', NULL, NULL, NULL, NULL);
INSERT INTO `inventory` VALUES (15, '12345', 'barcode', 'Electronics', 200, 2500.00, '4', 'qrcodes/12345.png', 'Available', 'New', NULL);

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
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

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
  PRIMARY KEY (`request_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of requests_table
-- ----------------------------
INSERT INTO `requests_table` VALUES (1, '234', 'gi uhaw', '2024-10-23 21:24:43', 'Accepted');
INSERT INTO `requests_table` VALUES (2, 'sample1', 'for multi media', '2024-10-23 21:25:48', 'Accepted');
INSERT INTO `requests_table` VALUES (3, 'sample1', 'for library', '2024-10-23 21:26:17', 'Pending');
INSERT INTO `requests_table` VALUES (4, 'sample1', 'for it department', '2024-10-24 11:55:38', 'Pending');
INSERT INTO `requests_table` VALUES (5, 'sample1', 'asd', '2024-10-24 11:59:03', 'Pending');
INSERT INTO `requests_table` VALUES (6, '211', 'for multi media', '2024-10-25 07:47:19', 'Accepted');

-- ----------------------------
-- Table structure for staff
-- ----------------------------
DROP TABLE IF EXISTS `staff`;
CREATE TABLE `staff`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `staff_firstname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
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
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of staff
-- ----------------------------
INSERT INTO `staff` VALUES (9, 'reymark', 'escalante', '09852003016', 'reymarkescalante12@gmail.com', 'Administrator', 'IT', '2024-09-28 13:29:40', 'admin', '$2y$10$JV4ihVFbSs6eHP/GPnQ5ueDCz/TVIIE2/1XByjrAD1UAmGyByfNYa', '234');
INSERT INTO `staff` VALUES (10, 'asd', 'asd', 'asd', 'asdasdasd@gmail.com', 'Administrator', 'IT', '2024-09-28 13:32:21', 'admin', '$2y$10$wMnIbe6Lv/XbT3dNKdWQneKx7yDvDh8TnJ6BDWNsD3ZhCBGGbgyFi', '123');
INSERT INTO `staff` VALUES (11, 'sample', 'sample', 'sample', 'sample@gmail.com', 'Administrator', 'HR', '2024-09-28 13:54:58', 'sample', '$2y$10$yRxxgYvHnr6HCVsypDA5kuZHVlpGNzvE4fU4Gpfa0PN1039mPojtK', 'admin');
INSERT INTO `staff` VALUES (12, 'sample1', 'sample1', 'sample1', 'sample1@gmail.com', 'Technician', 'HR', '2024-09-28 13:56:29', 'sample1', '$2y$10$L3AhSSoRx9rBc.Mz0JV.NO5LXlbbACPwRC5MmqPN9WePCV8ro1LtW', 'sample1');
INSERT INTO `staff` VALUES (14, 'chin', 'vlle', '09876543211', 'chinvlle@gmail.com', 'Administrator', 'HR', '2024-10-25 07:42:39', 'chin10', '$2y$10$4PoN43WO/LroxzlogXHKq.pJ7MuhY9LGWVcSEiTHOY3VmW0.ExMS.', '211');

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
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of suppliers
-- ----------------------------

SET FOREIGN_KEY_CHECKS = 1;
