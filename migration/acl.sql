ALTER TABLE `Employee`  ADD `roleId` INT(2) NOT NULL DEFAULT '2' AFTER `empId`;

--
-- Table structure for table `Resource`
--

CREATE TABLE IF NOT EXISTS `Resource` (
  `resourceId` int(2) NOT NULL AUTO_INCREMENT,
  `resource` varchar(20) NOT NULL,
  PRIMARY KEY (`resourceId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------
--
-- Table structure for table `Role`
--

CREATE TABLE IF NOT EXISTS `Role` (
  `roleId` int(2) NOT NULL AUTO_INCREMENT,
  `role` varchar(10) NOT NULL,
  PRIMARY KEY (`roleId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------
--
-- Table structure for table `RoleResourcePermission`
--

CREATE TABLE IF NOT EXISTS `RoleResourcePermission` (
  `rrpId` int(2) NOT NULL AUTO_INCREMENT,
  `roleId` int(2) NOT NULL,
  `resourceId` int(2) NOT NULL,
  `edit` int(2) NOT NULL,
  `remove` int(2) NOT NULL,
  `addNew` int(2) NOT NULL,
  `view` int(2) NOT NULL,
  `allowAll` int(2) NOT NULL,
  PRIMARY KEY (`rrpId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

