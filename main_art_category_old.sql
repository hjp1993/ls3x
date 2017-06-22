/*
Navicat MySQL Data Transfer

Source Server         : 本地3308端口
Source Server Version : 50617
Source Host           : localhost:3308
Source Database       : ls3x

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2017-05-25 09:45:31
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for main_art_category_old
-- ----------------------------
DROP TABLE IF EXISTS `main_art_category_old`;
CREATE TABLE `main_art_category_old` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `pid` int(11) DEFAULT '0' COMMENT '父id',
  `visible` tinyint(4) DEFAULT NULL,
  `odx` int(11) DEFAULT NULL,
  `timestamp` int(11) DEFAULT NULL,
  `childnums` int(11) DEFAULT NULL,
  `nums` int(11) DEFAULT NULL,
  `lastid` int(11) DEFAULT NULL,
  `odb` varchar(32) DEFAULT 'CreateTime',
  `scend` varchar(32) DEFAULT 'desc',
  `isatc` tinyint(4) DEFAULT '1' COMMENT '排序是否应用到子栏目',
  `type` varchar(20) DEFAULT 'arts' COMMENT '栏目类型',
  `iscst` tinyint(4) DEFAULT '1' COMMENT '栏目模板是否应用到子栏目',
  `cstyle` varchar(100) DEFAULT NULL COMMENT '栏目页模板',
  `isast` tinyint(4) DEFAULT '1' COMMENT '内容模板是否应用到子栏目',
  `astyle` varchar(100) DEFAULT NULL COMMENT '内容页模板',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of main_art_category_old
-- ----------------------------
INSERT INTO `main_art_category_old` VALUES ('1', '学校概况', '0', '1', '0', '1487648914', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('2', '新闻中心', '0', '1', '1', '1487648914', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('3', '教育科研', '0', '1', '2', '1487648914', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('4', '教师频道', '0', '1', '3', '1487648914', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('5', '德育天地', '0', '1', '4', '1487648914', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('6', '校务公开', '0', '1', '5', '1487648914', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('7', '家校指导', '0', '1', '6', '1487648914', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('8', '年级动态', '0', '1', '7', '1487648914', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('9', '学校简介', '1', '1', '0', '1487656303', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('10', '现任校领导', '1', '1', '1', '1487656303', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('11', '历史沿革', '1', '1', '2', '1487656303', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('12', '学校荣誉', '1', '1', '3', '1487656303', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('13', '校园风景', '1', '1', '4', '1487656303', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('14', '课程建设', '0', '1', '8', '1487656303', '3', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('15', '校园足球', '14', '1', '0', '1487656303', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('16', '市容小卫士', '14', '1', '1', '1487656303', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('17', '小交警中队', '14', '1', '2', '1487656303', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('18', '校内新闻', '2', '1', '0', '1487656461', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('19', '校园公告', '2', '1', '1', '1487656461', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('20', '团队活动', '2', '1', '2', '1487656461', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('21', '大事记', '2', '1', '3', '1487656461', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('22', '校本课程', '3', '1', '0', '1487656576', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('23', '教育科研活动', '3', '1', '1', '1487656576', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('24', '课题研究', '3', '1', '2', '1487656576', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('25', '论文报告', '3', '1', '3', '1487656576', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('26', '学科教研', '3', '1', '4', '1487656576', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('27', '校本培训', '3', '1', '5', '1487656576', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('28', '综合实践活动', '22', '1', '0', '1487656782', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('29', '书香校园', '22', '1', '1', '1487656782', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('30', '影视教育', '22', '1', '2', '1487656782', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('31', '艺术教育', '22', '1', '3', '1487656782', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('32', '环境与健康教育', '22', '1', '4', '1487656782', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('33', '体育传统教育', '22', '1', '5', '1487656782', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('34', '备课之窗', '23', '1', '0', '1487656825', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('35', '教工活动', '4', '1', '0', '1487657335', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('36', '三小魅力', '4', '1', '1', '1487657335', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('37', '教研组主页', '4', '1', '2', '1487657335', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('38', '善行义举榜', '4', '1', '3', '1487657335', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('39', '名师风采', '36', '1', '0', '1487657531', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('40', '教师荣誉', '36', '1', '1', '1487657531', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('41', '助人为乐', '38', '1', '0', '1487657531', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('42', '见义勇为', '38', '1', '1', '1487657531', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('43', '诚实守信', '38', '1', '2', '1487657531', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('44', '爱岗敬业', '38', '1', '3', '1487657531', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('45', '孝老爱亲', '38', '1', '4', '1487657531', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('46', '精彩校园', '5', '1', '0', '1487657710', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('47', '大队光荣簿', '5', '1', '1', '1487657710', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('48', '少年科学院', '5', '1', '2', '1487657710', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('49', '小喇叭之声', '5', '1', '3', '1487657710', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('50', '学校小交警', '5', '1', '4', '1487657710', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('51', '思想品德教育专栏', '5', '1', '5', '1487657710', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('52', '班级主页', '5', '1', '6', '1487657710', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('53', '本周升旗手', '47', '1', '0', '1487657736', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('54', '学校管理', '6', '1', '0', '1487660397', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('55', '职称评定', '6', '1', '1', '1487660397', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('56', '评优评先', '6', '1', '2', '1487660397', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('57', '招生通告', '6', '1', '3', '1487660397', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('58', '教育收费', '6', '1', '4', '1487660397', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('59', '监督投诉', '6', '1', '5', '1487660397', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('60', '依法治校', '6', '1', '6', '1487660397', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('61', '创建专栏', '6', '1', '7', '1487660397', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('62', '月工作安排', '54', '1', '0', '1487662023', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('63', '周工作安排', '54', '1', '1', '1487662023', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('64', '国家法规', '60', '1', '0', '1487662023', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('65', '地方法规', '60', '1', '1', '1487662023', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('66', '上级文件', '60', '1', '2', '1487662023', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('67', '校内规章', '60', '1', '3', '1487662023', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('68', '法制教育', '60', '1', '4', '1487662023', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('69', '自有链接', '60', '1', '5', '1487662023', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('70', '创建无烟学校', '61', '1', '0', '1487662023', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('71', '创建\"省平安校园\"专栏', '61', '1', '1', '1487662023', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('72', '\"2014年省优秀网站评比\"专栏', '61', '1', '2', '1487662023', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('73', '数字化校园创建专栏', '61', '1', '3', '1487662023', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('74', '足球特色学校创建', '61', '1', '4', '1487662023', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('75', '家长学校', '7', '1', '0', '1487662478', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('76', '家长学校', '7', '1', '1', '1487662478', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('77', '家教艺术', '7', '1', '2', '1487662478', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('78', '家长茶座', '7', '1', '3', '1487662478', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('79', '互联网', '7', '1', '4', '1487662478', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('80', '家长心声', '7', '1', '5', '1487662478', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('81', '心灵小屋', '8', '1', '0', '1487662478', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('82', '教师心理', '8', '1', '1', '1487662478', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('83', '心理测验', '8', '1', '2', '1487662478', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
INSERT INTO `main_art_category_old` VALUES ('84', '轻松驿站', '8', '1', '3', '1487662478', '0', '0', '0', 'CreateTime', 'desc', '1', 'arts', '1', '', '1', '');
