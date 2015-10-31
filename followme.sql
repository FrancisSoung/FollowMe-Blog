-- phpMyAdmin SQL Dump
-- version 3.0.0-rc1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2012 年 06 月 24 日 23:41
-- 服务器版本: 5.1.59
-- PHP 版本: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `followme`
--

-- --------------------------------------------------------

--
-- 表的结构 `fm_actions`
--

CREATE TABLE IF NOT EXISTS `fm_actions` (
  `act_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` int(1) unsigned NOT NULL DEFAULT '0',
  `u_id` int(11) unsigned NOT NULL DEFAULT '0',
  `ucon_id` int(11) unsigned NOT NULL DEFAULT '0',
  `time` varchar(40) NOT NULL DEFAULT '',
  PRIMARY KEY (`act_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=347 ;

--
-- 导出表中的数据 `fm_actions`
--

INSERT INTO `fm_actions` (`act_id`, `type`, `u_id`, `ucon_id`, `time`) VALUES
(147, 3, 3, 196, '1340018496'),
(170, 3, 1, 345, '1340103821'),
(167, 3, 1, 348, '1340094834'),
(146, 3, 2, 196, '1340018496'),
(178, 3, 1, 190, '1340137796'),
(222, 3, 1, 5, '1340267394'),
(236, 3, 1, 387, '1340290205'),
(234, 1, 1, 3, '1340289322'),
(198, 3, 1, 350, '1340169710'),
(148, 3, 4, 196, '1340018496'),
(149, 3, 5, 196, '1340018496'),
(150, 3, 6, 196, '1340018496'),
(151, 3, 7, 196, '1340018496'),
(166, 3, 1, 196, '1340068791'),
(154, 3, 3, 196, '1340018496'),
(157, 3, 3, 196, '1350023596'),
(217, 3, 2, 357, '1340251347'),
(241, 1, 2, 3, '1340251347'),
(233, 1, 1, 7, '1340289321'),
(224, 3, 0, 350, '1340273164'),
(225, 3, 1, 355, '1340274256'),
(242, 3, 1, 401, '1340306577'),
(315, 3, 20, 451, '1340411999'),
(245, 1, 1, 19, '1340314504'),
(252, 1, 21, 22, '1340353506'),
(247, 1, 20, 21, '1340315578'),
(248, 1, 21, 20, '1340315605'),
(285, 1, 21, 22, '1340381884'),
(278, 1, 22, 21, '1340381795'),
(316, 3, 20, 452, '1340412001'),
(314, 3, 20, 450, '1340411997'),
(293, 3, 20, 453, '1340411229'),
(291, 1, 1, 20, '1340411163'),
(346, 1, 1, 21, '1340461351'),
(319, 3, 20, 464, '1340412021'),
(336, 1, 20, 28, '1340414926'),
(341, 1, 20, 22, '1340417860'),
(338, 1, 20, 25, '1340414929'),
(339, 1, 20, 27, '1340414932'),
(342, 3, 20, 501, '1340417911'),
(343, 3, 20, 499, '1340417914'),
(345, 1, 1, 22, '1340461347');

-- --------------------------------------------------------

--
-- 表的结构 `fm_blacklist`
--

CREATE TABLE IF NOT EXISTS `fm_blacklist` (
  `list_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `u_id` int(11) NOT NULL DEFAULT '0',
  `su_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`list_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=151 ;

--
-- 导出表中的数据 `fm_blacklist`
--

INSERT INTO `fm_blacklist` (`list_id`, `u_id`, `su_id`) VALUES
(115, 0, 20),
(21, 5, 2),
(42, 5, 1),
(113, 0, 20),
(111, 0, 22),
(114, 0, 22),
(112, 0, 20),
(116, 0, 20),
(117, 0, 22);

-- --------------------------------------------------------

--
-- 表的结构 `fm_broadcasts`
--

CREATE TABLE IF NOT EXISTS `fm_broadcasts` (
  `bro_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` int(1) NOT NULL DEFAULT '1',
  `u_id` int(11) NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `time` varchar(40) NOT NULL DEFAULT '',
  PRIMARY KEY (`bro_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- 导出表中的数据 `fm_broadcasts`
--

INSERT INTO `fm_broadcasts` (`bro_id`, `type`, `u_id`, `content`, `time`) VALUES
(25, 1, 0, 'ennenekkwew', ''),
(26, 1, 0, 'wjwerwerw', '');

-- --------------------------------------------------------

--
-- 表的结构 `fm_broread`
--

CREATE TABLE IF NOT EXISTS `fm_broread` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `r_id` int(11) NOT NULL,
  `ru_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- 导出表中的数据 `fm_broread`
--

INSERT INTO `fm_broread` (`id`, `r_id`, `ru_id`) VALUES
(1, 23, 21),
(2, 23, 56),
(3, 24, 20),
(8, 26, 20),
(7, 25, 20),
(9, 26, 20),
(10, 25, 20),
(11, 23, 20),
(12, 26, 20),
(13, 25, 20),
(14, 23, 20),
(15, 23, 20),
(16, 23, 20),
(17, 23, 20),
(18, 25, 20),
(19, 26, 20),
(20, 25, 20),
(21, 25, 20),
(22, 25, 20),
(23, 26, 20);

-- --------------------------------------------------------

--
-- 表的结构 `fm_contents`
--

CREATE TABLE IF NOT EXISTS `fm_contents` (
  `con_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `u_id` int(11) unsigned NOT NULL DEFAULT '0',
  `systag_id` int(11) unsigned NOT NULL DEFAULT '0',
  `type` int(2) unsigned NOT NULL DEFAULT '0',
  `title` varchar(50) NOT NULL DEFAULT '',
  `image` varchar(30) NOT NULL DEFAULT '',
  `sound` varchar(50) NOT NULL,
  `link` varchar(120) NOT NULL DEFAULT '',
  `video` varchar(120) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `tags` varchar(20) NOT NULL,
  `time` varchar(40) NOT NULL DEFAULT '',
  PRIMARY KEY (`con_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=504 ;

--
-- 导出表中的数据 `fm_contents`
--

INSERT INTO `fm_contents` (`con_id`, `u_id`, `systag_id`, `type`, `title`, `image`, `sound`, `link`, `video`, `content`, `tags`, `time`) VALUES
(413, 19, 1, 30, '', '', 'http://www.xiami.com/song/4567', '', '', '', 'asdfasdf,asdf,', '1340349129'),
(466, 22, 3, 2, '', '20120622222205_455.jpg', '', '', '', '<p>\r\n	asdfasdf</p>\r\n', 'asdf,asdf,', '1340374925'),
(412, 19, 3, 4, '', '', '', '', 'asdfasdf', '<p>\r\n	asdfasdf</p>\r\n', 'asdf,adsf,', '1504195200'),
(410, 21, 2, 1, '哈哈', '', '', '', '', '<p>\r\n	<strong>越被人嘲笑的梦想就越有被实现的价值</strong></p>\r\n', '梦想,价值,', '1340349129'),
(485, 28, 2, 2, '', '20120623091600_690.jpg', '', '', '', '<p>\r\n	书籍是我们人类最好的朋友</p>\r\n', '书籍,', '1340414160'),
(452, 22, 6, 1, 'asdfasdf', '', '', '', '', '<p>\r\n	asdfasdf</p>\r\n', 'asdf,asdf,asdf,', '1340357899'),
(474, 19, 6, 1, 'qwerqwer', '', '', '', '', '<p>\r\n	qwerqwerwqer</p>\r\n', 'qwer,qwer,', '1340409286'),
(471, 21, 2, 2, '', '20120623051823_688.jpg', '', '', '', '<p>\r\n	<strong>O(&cap;_&cap;)O哈哈哈~</strong></p>\r\n', '美眉,', '1340399903'),
(463, 19, 3, 2, '', '20120622222021_206.jpg', '', '', '', '<p>\r\n	我日你先人的</p>\r\n', 'asdf,adsf,', '1340374821'),
(464, 22, 3, 2, '', '20120622222121_160.jpg', '', '', '', '<p>\r\n	asdfasd</p>\r\n<p>\r\n	asdf</p>\r\n', 'asdf,asdf,', '1340374881'),
(465, 22, 1, 2, '', '20120622222148_624.jpg', '', '', '', '<p>\r\n	asdf</p>\r\n<p>\r\n	asdf</p>\r\n<p>\r\n	sadf</p>\r\n', 'asdf,asdf,', '1340374908'),
(460, 19, 3, 2, '', '20120622212428_863.jpg', '', '', '', '<p>\r\n	adfadsf</p>\r\n', 'adf,', '1340371468'),
(404, 19, 6, 1, 'follow me请博客 哈哈', '', '', '', '', '<p>\r\n	<span style=\\color: rgb(0, 255, 0); \\><strong><em><u>follow me请博客 哈哈follow me请博客 哈哈follow me请博客 哈哈follow me请博客 哈哈</u></em></strong></span></p>\r\n<p>\r\n	<span style=\\color: rgb(0, 255, 0); \\><strong><em><u>follow me请博客 哈哈follow me请博客 哈哈follow me请博客 哈哈follow me请博客 哈哈</u></em></strong></span></p>\r\n<p>\r\n	<span style=\\color: rgb(0, 255, 0); \\><strong><em><u>follow me请博客 哈哈follow me请博客 哈哈follow me请博客 哈哈follow me请博客 哈哈follow me请博客 哈哈follow me请博客 哈哈follow me请博客 哈哈follow me请博客 哈哈follow me请博客 哈哈</u></em></strong></span></p>\r\n<p>\r\n	<span style=\\color: rgb(0, 255, 0); \\><strong><em><u>follow me请博客 哈哈follow me请博客 哈哈</u></em></strong></span></p>\r\n', 'asdfasdf,asdf,adf,', '1340349129'),
(414, 19, 6, 3, '', '', 'http://www.xiami.com/song/45675678', '', '', '', 'asdf,asdf,asdf,', '1340349129'),
(416, 19, 6, 4, '', '', '', '', 'http://v.youku.com/v_show/id_XNDE5MDMwODEy.html?f=17778620', '<p>\r\n	asdfasdfadf</p>\r\n', 'asdf,asdf,asdf,', '1340349129'),
(417, 20, 2, 1, '新闻', '', '', '', '', '<p>\r\n	新闻新闻</p>\r\n', '新闻,', '1340349129'),
(453, 20, 1, 1, '新闻', '', '', '', '', '<p>\r\n	新闻1</p>\r\n<p>\r\n	ewewerew</p>\r\n<p>\r\n	&nbsp;</p>\r\n', 'news,newsone,', '1340358136'),
(498, 20, 2, 2, '', '20120623092915_977.jpg', '', '', '', '<p>\r\n	so peaceful picture!</p>\r\n', '<so></so>,', '1340414955'),
(473, 19, 3, 2, '', '20120623065302_388.jpg', '', '', '', '<p>\r\n	asdfasdfasdf</p>\r\n', 'asdf,asdf,', '1340405582'),
(440, 21, 2, 1, '文章111', '', '', '', '', '文章', '', '1340349129'),
(438, 19, 7, 5, '百度', '', '', 'www.baidu.com', '', '', 'adsf,asd,fasdf,', '1340353122'),
(439, 21, 2, 1, '文章三', '', '', '', '', '<p>\r\n	文章三</p>\r\n', '坎坎坷坷,', '1340353195'),
(487, 27, 2, 1, '今天星期几', '', '', '', '', '<p>\r\n	忘记了哈哈，，，</p>\r\n', 'week,', '1340414247'),
(437, 19, 6, 1, 'asdfasdf', '', '', '', '', '<p>\r\n	asdfasdfasdfasdf</p>\r\n', 'adsf,asdf,sadf,', '1340353068'),
(450, 21, 7, 5, '链接我的链接', '', '', 'blog.kkk.com', '', '', 'ddddd,', '1340356409'),
(475, 19, 3, 2, '', '20120623075508_132.jpg', '', '', '', '<p>\r\n	asfasdf</p>\r\n', 'asdf,asdf,', '1340409308'),
(431, 21, 8, 1, '文章', '', '', '', '', '<p>\r\n	坎坎坷坷</p>\r\n', '的撒旦撒,', '1340352558'),
(443, 21, 2, 1, '文章23232', '', '', '', '', '文章', '大道', '1267372800'),
(446, 19, 11, 1, 'follow me请博客 哈哈', '', '', '', '', '<p>\r\n	<span style=\\\\\\color:\\><strong><em><u>follow me请博客 哈哈follow me请博客 哈哈follow me请博客 哈哈follow me请博客 哈哈</u></em></strong></span></p>\r\n<p>\r\n	<span style=\\\\\\color:\\><strong><em><u>follow me请博客 哈哈follow me请博客 哈哈follow me请博客 哈哈follow me请博客 哈哈</u></em></strong></span></p>\r\n<p>\r\n	<span style=\\\\\\color:\\><strong><em><u>follow me请博客 哈哈follow me请博客 哈哈follow me请博客 哈哈follow me请博客 哈哈follow me请博客 哈哈follow me请博客 哈哈follow me请博客 哈哈follow me请博客 哈哈follow me请博客 哈哈</u></em></strong></span></p>\r\n<p>\r\n	<span style=\\\\\\color:\\><strong><em><u>follow me请博客 哈哈follow me请博客 哈哈</u></em></strong></span></p>\r\n', 'asdf,', '1340353734'),
(501, 22, 1, 2, '', '20120623094141_664.jpg', '', '', '', '<p>\r\n	asdfasdf</p>\r\n', 'asdf,asdf,', '1340415701'),
(479, 20, 6, 1, 'asghj', '', '', '', '', '\r\n', 'adfasfd,', '1340412089'),
(458, 19, 6, 2, '', '20120622205503_298.jpg', '', '', '', '<p>\r\n	adsfadsfasdfasdfasdfasdfasdf</p>\r\n', 'adf,adf,asdf,', '1340369703'),
(448, 19, 6, 3, '', '', 'http://www.xiami.com/song/456784567', '', '', '', 'adf,adf,', '1340354787'),
(459, 19, 3, 2, '', '20120622205837_384.jpg', '', '', '', '<p>\r\n	asdfasdfasdfasdf</p>\r\n', 'asdf,', '1340369917'),
(476, 19, 6, 1, 'asdfasdf', '', '', '', '', '<p>\r\n	asdfasdfasdf</p>\r\n', 'asdf,asdf,', '1340409320'),
(477, 24, 3, 2, '', '20120623075640_451.jpg', '', '', '', '<p>\r\n	asdfasdf</p>\r\n', 'asdf,asdf,', '1340409400'),
(478, 24, 7, 1, 'asdfasdf', '', '', '', '', '<p>\r\n	asdfasdfasdf</p>\r\n', 'asdf,asdf,', '1340409412'),
(480, 26, 3, 2, '', '20120623091242_674.jpg', '', '', '', '\r\n', 'adf,asdf,', '1340413962'),
(481, 26, 3, 1, 'asdfadsfasdf', '', '', '', '', '\r\n', 'asdf,asdf,', '1340413986'),
(482, 27, 2, 2, '', '20120623091415_869.jpg', '', '', '', '<p>\r\n	小鸟小狗</p>\r\n', '撒旦撒,', '1340414055'),
(483, 25, 12, 1, '新文章.新文章!', '', '', '', '', '<p>\r\n	新文章.新文章!新文章.新文章!新文章.新文章!新文章.新文章!新文章.新文章!新文章.新文章!新文章.新文章!新文章.新文章!新文章.新文章!新文章.新文章!新文章.新文章!新文章.新文章!新文章.新文章!新文章.新文章!</p>\r\n', '新文章,好文章,', '1340414094'),
(484, 26, 3, 1, '记录来访ip 写入日志', '', '', '', '', '<p>\r\n	&lt;?php echo &#39;&lt;br&gt;&#39;; $ip=$HTTP_SERVER_VARS[&#39;REMOTE_ADDR&#39;]; echo &#39;&lt;p style=&quot;font-size:40px;font-weight:bolder:&quot;&gt;你的ip已被我记录,你想干什么:?&#39;.$ip.&#39;&lt;/p&gt;&#39;; $t=&#39;访问者IP信息：&#39;.date(&quot;Y-m-d,H-i-s&quot;).&quot;&mdash;&mdash;&mdash;&mdash;&quot;.$ip; $fp=fopen(&#39;ip.txt&#39;,&#39;a+&#39;); fwrite($fp,$t.&quot;\\\\n&quot;); fclose($fp); ?&gt;</p>\r\n', 'adf,asdf,adsf,asdf,', '1340414150'),
(488, 25, 5, 3, '', '', 'http://www.xiami.com/song/123456789 ', '', '', '<p>\r\n	虾米音乐</p>\r\n<p>\r\n	好歌</p>\r\n', 'music,摇滚,经典,', '1340414291'),
(489, 28, 8, 1, 'what is your name ？？？', '', '', '', '', '<p>\r\n	your name is 哈哈O(&cap;_&cap;)O哈哈~</p>\r\n', 'name,', '1340414339'),
(490, 25, 6, 5, '百度', '', '', 'www.baidu.com', '', '<p>\r\n	百度网站</p>\r\n', '百度,baidu,', '1340414345'),
(491, 29, 3, 4, '', '', '', '', 'http://v.youku.com/v_show/id_XNDE5MjYyNTA0.html', '<p>\r\n	视频播放地址 没有网 所以无法播放 求开网 勿屏蔽flash</p>\r\n', 'adf,asdf,asdf,', '1340414430'),
(499, 20, 11, 2, '', '20120623093209_313.jpg', '', '', '', '<p>\r\n	Ferrari formula one</p>\r\n', 'F1,', '1340415129'),
(497, 20, 12, 2, '', '20120623092618_654.jpg', '', '', '', '\r\n', 'Ferrari,', '1340414778'),
(503, 30, 12, 2, '', '20120623102316_652.jpg', '', '', '', '<p>\r\n	adsfasdf</p>\r\n', 'adsf,asdf,', '1340418196');

-- --------------------------------------------------------

--
-- 表的结构 `fm_messages`
--

CREATE TABLE IF NOT EXISTS `fm_messages` (
  `mes_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `status` int(1) NOT NULL DEFAULT '0',
  `su_id` int(11) unsigned NOT NULL DEFAULT '0',
  `gu_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `type` int(1) NOT NULL DEFAULT '3',
  `time` int(11) NOT NULL,
  PRIMARY KEY (`mes_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- 导出表中的数据 `fm_messages`
--

INSERT INTO `fm_messages` (`mes_id`, `status`, `su_id`, `gu_id`, `content`, `type`, `time`) VALUES
(19, 0, 20, 19, '恩恩恩?', 3, 1340326794),
(5, 0, 1, 4, '123', 3, 1340093334),
(6, 0, 1, 4, '测试', 3, 1340093638),
(7, 0, 1, 2, '又一个新测试', 3, 1340093658),
(9, 0, 1, 4, '111测试 ', 3, 1340094342),
(10, 0, 2, 4, '我在测试私信类型', 3, 1340227849),
(31, 0, 20, 22, 'efefe\n', 3, 1340417790);

-- --------------------------------------------------------

--
-- 表的结构 `fm_reviews`
--

CREATE TABLE IF NOT EXISTS `fm_reviews` (
  `rev_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `con_id` int(11) unsigned NOT NULL DEFAULT '0',
  `u_id` int(11) unsigned NOT NULL DEFAULT '0',
  `content` varchar(120) NOT NULL,
  `time` int(11) NOT NULL,
  `ip` char(15) NOT NULL DEFAULT '0',
  PRIMARY KEY (`rev_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=112 ;

--
-- 导出表中的数据 `fm_reviews`
--

INSERT INTO `fm_reviews` (`rev_id`, `con_id`, `u_id`, `content`, `time`, `ip`) VALUES
(91, 445, 20, '说说', 1340353726, '192.168.80.200'),
(3, 4, 3, 'dddddddddddddd', 1337791762, '255.255.255.255'),
(4, 6, 1, 'hhhhhhhh', 1337791762, '0'),
(22, 196, 2, '我也来评论  我来回应!', 1339998618, '1.1.1.1'),
(23, 345, 1, '回应  评论 测试 ', 1339998678, '255.255.234.234'),
(92, 445, 20, '43543', 1267372800, '192.168.80.200'),
(25, 196, 3, '新的测试 回应 ', 1339958878, '0'),
(93, 446, 20, '恩呢?', 1340353954, '192.168.80.200'),
(94, 445, 21, '都顶顶顶顶顶顶顶顶顶顶', 1340354033, '192.168.80.133'),
(28, 345, 4, '反反复复方法', 1340066859, ''),
(29, 198, 1, '这还是一条测试!', 1340066893, ''),
(30, 345, 3, '新回应!', 1340067018, '192.168.80.229'),
(31, 345, 1, '1234567', 1340067598, '192.168.80.229'),
(34, 198, 1, '还是一条!!!!  广告公关广告公关广告公关广告', 1340068438, '192.168.80.229'),
(35, 345, 1, '测试 Session', 1340073650, '192.168.80.1'),
(36, 345, 1, '再次 测试SESSION', 1340073988, '192.168.80.1'),
(37, 348, 1, '测试 ', 1340086546, '192.168.80.1'),
(38, 91, 1, '哈哈哈哈哈哈', 1340094015, '192.168.80.1'),
(39, 348, 1, '我来说  ', 1340094378, '192.168.80.1'),
(40, 350, 1, 'undefined', 1340169693, '192.168.80.1'),
(42, 345, 1, 'hhhhhh', 1340170206, '192.168.80.1'),
(55, 2, 21, '回应一下!', 1267372800, '192.168.80.1'),
(44, 353, 1, 'hhhhh', 1340170249, '192.168.80.1'),
(54, 350, 2, '新测试  ', 1340175285, '192.168.80.1'),
(47, 353, 1, '我我', 1340170834, '192.168.80.1'),
(48, 353, 2, '测试 ', 1340170992, '192.168.80.1'),
(50, 190, 2, '测试', 1340171352, '192.168.80.1'),
(53, 354, 2, '测试 新测试 ', 1340175269, '192.168.80.1'),
(52, 190, 2, '测试', 1340171386, '192.168.80.1'),
(58, 354, 2, '鄂尔泰', 1340193944, '192.168.80.1'),
(59, 354, 2, '我', 1340194233, '192.168.80.1'),
(57, 354, 2, 'wwerwr', 1340193085, '192.168.80.1'),
(60, 354, 2, '测试', 1340194416, '192.168.80.1'),
(61, 354, 2, '车', 1340194595, '192.168.80.1'),
(62, 353, 2, '测试', 1340194938, '192.168.80.1'),
(63, 353, 2, '我看看', 1340195241, '192.168.80.1'),
(64, 350, 2, '图片', 1340195362, '192.168.80.1'),
(65, 354, 2, '1111', 1340198256, '192.168.80.1'),
(66, 350, 2, '???', 1340198351, '192.168.80.1'),
(67, 190, 2, 'ooo??', 1340198558, '192.168.80.1'),
(68, 190, 2, '?&gt;?', 1340198600, '192.168.80.1'),
(69, 190, 2, '?&gt;??', 1340198753, '192.168.80.1'),
(70, 93, 2, 'wo lai ', 1340198771, '192.168.80.1'),
(71, 93, 2, 'zai lai', 1340198810, '192.168.80.1'),
(72, 92, 2, 'hai lai', 1340198830, '192.168.80.1'),
(73, 91, 2, '@_@ ', 1340198878, '192.168.80.1'),
(74, 5, 2, 'kkkk', 1340199253, '192.168.80.1'),
(105, 458, 20, 'I cant believe my eyes！', 1340414129, '192.168.80.6'),
(76, 92, 2, '恩恩恩?', 1340199429, '192.168.80.1'),
(88, 387, 1, '啦啦啦', 1340306653, '192.168.80.133'),
(89, 408, 20, '我了个亲!', 1340311384, '192.168.80.200'),
(90, 412, 20, '哈哈哈', 1340315712, '192.168.80.200'),
(96, 443, 21, '卡卡卡卡卡', 1340354061, '192.168.80.133'),
(99, 449, 22, 'asdf', 1340356168, '192.168.80.35'),
(106, 471, 20, 'lovely girl！', 1340414223, '192.168.80.6'),
(101, 449, 22, 'adsfasdfsadf', 1340356235, '192.168.80.35'),
(102, 452, 20, '我来回应!', 1340358031, '192.168.80.200'),
(107, 458, 20, 'if your hero in your heart nerver come to you ,what will you do?', 1340414285, '192.168.80.6'),
(108, 465, 20, 'so funning ！', 1340414335, '192.168.80.6'),
(109, 500, 20, 'where is the picture!', 1340415296, '192.168.80.6'),
(110, 501, 20, '哇塞,空中楼阁!', 1340417542, '192.168.80.6');

-- --------------------------------------------------------

--
-- 表的结构 `fm_root`
--

CREATE TABLE IF NOT EXISTS `fm_root` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理员ID',
  `name` varchar(20) NOT NULL COMMENT '管理员名称',
  `password` varchar(32) NOT NULL COMMENT '管理员密码',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='管理员表' AUTO_INCREMENT=3 ;

--
-- 导出表中的数据 `fm_root`
--

INSERT INTO `fm_root` (`id`, `name`, `password`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3'),
(2, 'root', '63a9f0ea7bb98050796b649e85481845');

-- --------------------------------------------------------

--
-- 表的结构 `fm_systags`
--

CREATE TABLE IF NOT EXISTS `fm_systags` (
  `systag_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `systag_name` varchar(20) NOT NULL,
  `seque` varchar(24) NOT NULL,
  `sort` int(2) NOT NULL,
  `time` varchar(40) NOT NULL DEFAULT '0',
  PRIMARY KEY (`systag_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- 导出表中的数据 `fm_systags`
--

INSERT INTO `fm_systags` (`systag_id`, `systag_name`, `seque`, `sort`, `time`) VALUES
(1, '新标签', '新的标签', 1, '0'),
(2, '作家', '文学作家', 5, '0'),
(3, '舞蹈家', '舞蹈家', 7, '0'),
(4, '动漫', '动漫', 6, '0'),
(5, '音乐', '音乐 music', 3, '0'),
(6, '网址', '网络链接地址', 2, '0'),
(7, '文学家', '文学作家', 8, '0'),
(8, '小说家', '小说作家', 4, '0'),
(11, '阿斯', '撒旦法', 444, '2012-06-21 06:12:00'),
(12, '杨航', '阿斯顿发斯蒂芬', 12, '2012-06-21 08:10:26');

-- --------------------------------------------------------

--
-- 表的结构 `fm_user`
--

CREATE TABLE IF NOT EXISTS `fm_user` (
  `u_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `u_name` varchar(30) NOT NULL DEFAULT '',
  `u_ico` varchar(30) NOT NULL DEFAULT 'photo.png',
  `email` varchar(30) NOT NULL DEFAULT '',
  `password` char(32) NOT NULL DEFAULT '',
  `blogname` varchar(50) NOT NULL DEFAULT '',
  `info` varchar(120) NOT NULL DEFAULT '',
  `status` int(2) NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`u_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- 导出表中的数据 `fm_user`
--

INSERT INTO `fm_user` (`u_id`, `u_name`, `u_ico`, `email`, `password`, `blogname`, `info`, `status`, `count`) VALUES
(19, 'admin', '20120622054239_630.jpg', '522138978@qq.com', 'd41d8cd98f00b204e9800998ecf8427e', 'April_2nd', 'followme', 0, 0),
(20, 'seeker', '20120622054247_611.jpg', 'seeker@ccav.com', 'e3604023669f85ade97b50403791158a', 'seeker', 'Seekers  Blog', 0, 0),
(21, 'kkkkkk', '20120623102736_675.jpg', 'bjjjjj@fdsfsdsds.fds', 'c08ac56ae1145566f2ce54cbbea35fa3', 'eeeeeee', '大苏打水', 0, 16),
(22, 'April_2nd', '20120622173526_705.jpg', '494115055@qq.com', '96e79218965eb72c92a549dd5a330112', 'April_2nd', '2b青年', 0, 0),
(25, 'googlebaidu', '20120623091304_393.jpg', 'google@baidu.com', '0ef6b2bb4fae1e5155345d1e358163cf', 'googlebaidu', 'googlebaidu', 0, 1),
(24, '4675432', 'photo.png', '4675432@qq.com', '96e79218965eb72c92a549dd5a330112', 'qsqsqsqs', '', 0, 0),
(26, 'aaaaaa', '20120623091208_180.jpg', 'aaaaaa@qq.com', '96e79218965eb72c92a549dd5a330112', 'asdfasdasdf', '', 0, 0),
(27, 'ssssss', '20120623091329_915.jpg', 'sss@sss.sss', 'af15d5fdacd5fdfea300e88a8e253e82', 'ssssss', 'ssssss', 0, 0),
(28, 'cccccc', '20120623091513_764.jpg', 'ccc@ccc.ccc', 'c1f68ec06b490b3ecb4066b1b13a9ee9', 'cccccc', 'cccccc', 0, 0),
(29, 'bbbbbb', 'photo.png', 'bbbbb@qq.com', '96e79218965eb72c92a549dd5a330112', '', '', 0, 0),
(30, 'huapeng', 'photo.png', '11233321@qq.com', '96e79218965eb72c92a549dd5a330112', '', '', 0, 4);
