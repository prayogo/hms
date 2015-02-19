-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2014 at 02:26 PM
-- Server version: 5.6.11
-- PHP Version: 5.5.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hms`
--
CREATE DATABASE IF NOT EXISTS `hms` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `hms`;

-- --------------------------------------------------------

--
-- Table structure for table `ps_bank`
--

CREATE TABLE IF NOT EXISTS `ps_bank` (
  `bankid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `accountno` varchar(20) NOT NULL,
  `branch` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`bankid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `ps_bank`
--

INSERT INTO `ps_bank` (`bankid`, `name`, `accountno`, `branch`) VALUES
(1, 'Bank Negara Indonesia (BNI)', '888-888-8888', 'Selatpanjang');

-- --------------------------------------------------------

--
-- Table structure for table `ps_contactperson`
--

CREATE TABLE IF NOT EXISTS `ps_contactperson` (
  `contactpersonid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `address` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(20) NOT NULL,
  `phone2` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`contactpersonid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `ps_contactperson`
--

INSERT INTO `ps_contactperson` (`contactpersonid`, `name`, `address`, `email`, `phone`, `phone2`) VALUES
(1, 'Prayogo', 'Jl. Ibrahim no.14', 'prayogo.dong@gmail.com', '0853-6400-7133', '');

-- --------------------------------------------------------

--
-- Table structure for table `ps_customer`
--

CREATE TABLE IF NOT EXISTS `ps_customer` (
  `customerid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `address` varchar(150) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `npwp` varchar(25) DEFAULT NULL,
  `locationid` varchar(3) NOT NULL,
  `birthdate` date NOT NULL,
  `comment` varchar(250) DEFAULT NULL,
  `blacklist` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`customerid`),
  KEY `locationid` (`locationid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `ps_customer`
--

INSERT INTO `ps_customer` (`customerid`, `name`, `address`, `email`, `npwp`, `locationid`, `birthdate`, `comment`, `blacklist`) VALUES
(1, 'Prayogo', 'Jl. Ibrahim no.14', 'prayogo.dong@gmail.com', '', 'IDN', '1993-11-14', '', 'N'),
(2, 'Dyva', 'jl diponegoro', 'dyva.tan@yahoo.com', '', 'IDN', '1994-01-01', '', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `ps_customeridentification`
--

CREATE TABLE IF NOT EXISTS `ps_customeridentification` (
  `customerid` int(11) NOT NULL,
  `identificationtypeid` int(11) NOT NULL,
  `identificationno` varchar(25) NOT NULL,
  PRIMARY KEY (`customerid`,`identificationtypeid`,`identificationno`),
  KEY `identificationtypeid` (`identificationtypeid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ps_customeridentification`
--

INSERT INTO `ps_customeridentification` (`customerid`, `identificationtypeid`, `identificationno`) VALUES
(1, 1, '1234567890'),
(1, 2, 'abc88888'),
(2, 2, 'abc1234');

-- --------------------------------------------------------

--
-- Table structure for table `ps_customerphone`
--

CREATE TABLE IF NOT EXISTS `ps_customerphone` (
  `customerid` int(11) NOT NULL,
  `phone` varchar(15) NOT NULL,
  PRIMARY KEY (`customerid`,`phone`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ps_customerphone`
--

INSERT INTO `ps_customerphone` (`customerid`, `phone`) VALUES
(1, '085364007133'),
(1, '085364007134'),
(2, '8888888888888');

-- --------------------------------------------------------

--
-- Table structure for table `ps_equipment`
--

CREATE TABLE IF NOT EXISTS `ps_equipment` (
  `equipmentid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`equipmentid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `ps_equipment`
--

INSERT INTO `ps_equipment` (`equipmentid`, `name`) VALUES
(1, 'Tv'),
(2, 'Kulkas'),
(4, 'Wi-Fi');

-- --------------------------------------------------------

--
-- Table structure for table `ps_extraservice`
--

CREATE TABLE IF NOT EXISTS `ps_extraservice` (
  `extraserviceid` int(11) NOT NULL AUTO_INCREMENT,
  `serviceitemid` int(11) NOT NULL,
  `roomreservationid` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `rate` int(11) NOT NULL,
  PRIMARY KEY (`extraserviceid`),
  KEY `serviceitemid` (`serviceitemid`),
  KEY `roomreservationid` (`roomreservationid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `ps_extraservice`
--

INSERT INTO `ps_extraservice` (`extraserviceid`, `serviceitemid`, `roomreservationid`, `quantity`, `date`, `rate`) VALUES
(3, 2, 2, 2, '2014-12-15 21:45:00', 5000),
(4, 1, 2, 1, '2014-12-16 01:16:00', 12000),
(6, 3, 2, 1, '2014-12-16 20:00:00', 7500);

-- --------------------------------------------------------

--
-- Table structure for table `ps_floor`
--

CREATE TABLE IF NOT EXISTS `ps_floor` (
  `floorid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`floorid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `ps_floor`
--

INSERT INTO `ps_floor` (`floorid`, `name`) VALUES
(1, 'Lantai 1'),
(2, 'Lantai 2'),
(3, 'Lantai 3');

-- --------------------------------------------------------

--
-- Table structure for table `ps_hotel`
--

CREATE TABLE IF NOT EXISTS `ps_hotel` (
  `hotelid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `address` varchar(150) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(150) NOT NULL,
  `locationid` varchar(3) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone1` varchar(15) NOT NULL,
  `phone2` varchar(15) DEFAULT NULL,
  `fax` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`hotelid`),
  KEY `locationid` (`locationid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `ps_hotel`
--

INSERT INTO `ps_hotel` (`hotelid`, `name`, `address`, `city`, `state`, `locationid`, `email`, `phone1`, `phone2`, `fax`) VALUES
(1, 'Dyva Hotel', 'Jl. Diponegoro no.37', 'Selatpanjang', 'Kab.Kep.Meranti, Riau', 'IDN', 'reservation@dyvahotel.com', '(0763) 33381', '(0763) 33382', '(0763) 33391');

-- --------------------------------------------------------

--
-- Table structure for table `ps_identificationtype`
--

CREATE TABLE IF NOT EXISTS `ps_identificationtype` (
  `identificationtypeid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`identificationtypeid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `ps_identificationtype`
--

INSERT INTO `ps_identificationtype` (`identificationtypeid`, `name`) VALUES
(1, 'KTP'),
(2, 'Passport'),
(3, 'SIM');

-- --------------------------------------------------------

--
-- Table structure for table `ps_location`
--

CREATE TABLE IF NOT EXISTS `ps_location` (
  `locationid` varchar(3) NOT NULL,
  `iso2` varchar(2) DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`locationid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ps_location`
--

INSERT INTO `ps_location` (`locationid`, `iso2`, `name`) VALUES
('ABW', 'AW', 'Aruba'),
('AFG', 'AF', 'Afghanistan'),
('AGO', 'AO', 'Angola'),
('AIA', 'AI', 'Anguilla'),
('ALB', 'AL', 'Albania'),
('AND', 'AD', 'Andorra'),
('ANT', 'AN', 'Netherlands Antilles'),
('ARE', 'AE', 'United Arab Emirates'),
('ARG', 'AR', 'Argentina'),
('ARM', 'AM', 'Armenia'),
('ASM', 'AS', 'American Samoa'),
('ATG', 'AG', 'Antigua and Barbuda'),
('AUS', 'AU', 'Australia'),
('AUT', 'AT', 'Austria'),
('AZE', 'AZ', 'Azerbaijan'),
('BDI', 'BI', 'Burundi'),
('BEL', 'BE', 'Belgium'),
('BEN', 'BJ', 'Benin'),
('BFA', 'BF', 'Burkina Faso'),
('BGD', 'BD', 'Bangladesh'),
('BGR', 'BG', 'Bulgaria'),
('BHR', 'BH', 'Bahrain'),
('BHS', 'BS', 'Bahamas'),
('BIH', 'BA', 'Bosnia and Herzegovina'),
('BLR', 'BY', 'Belarus'),
('BLZ', 'BZ', 'Belize'),
('BMU', 'BM', 'Bermuda'),
('BOL', 'BO', 'Bolivia'),
('BRA', 'BR', 'Brazil'),
('BRB', 'BB', 'Barbados'),
('BRN', 'BN', 'Brunei Darussalam'),
('BTN', 'BT', 'Bhutan'),
('BWA', 'BW', 'Botswana'),
('CAF', 'CF', 'Central African Republic'),
('CAN', 'CA', 'Canada'),
('CHE', 'CH', 'Switzerland'),
('CHL', 'CL', 'Chile'),
('CHN', 'CN', 'China'),
('CIV', 'CI', 'Cote D''Ivoire'),
('CMR', 'CM', 'Cameroon'),
('COD', 'CD', 'Congo, the Democratic Republic of the'),
('COG', 'CG', 'Congo'),
('COK', 'CK', 'Cook Islands'),
('COL', 'CO', 'Colombia'),
('COM', 'KM', 'Comoros'),
('CPV', 'CV', 'Cape Verde'),
('CRI', 'CR', 'Costa Rica'),
('CUB', 'CU', 'Cuba'),
('CYM', 'KY', 'Cayman Islands'),
('CYP', 'CY', 'Cyprus'),
('CZE', 'CZ', 'Czech Republic'),
('DEU', 'DE', 'Germany'),
('DJI', 'DJ', 'Djibouti'),
('DMA', 'DM', 'Dominica'),
('DNK', 'DK', 'Denmark'),
('DOM', 'DO', 'Dominican Republic'),
('DZA', 'DZ', 'Algeria'),
('ECU', 'EC', 'Ecuador'),
('EGY', 'EG', 'Egypt'),
('ERI', 'ER', 'Eritrea'),
('ESH', 'EH', 'Western Sahara'),
('ESP', 'ES', 'Spain'),
('EST', 'EE', 'Estonia'),
('ETH', 'ET', 'Ethiopia'),
('FIN', 'FI', 'Finland'),
('FJI', 'FJ', 'Fiji'),
('FLK', 'FK', 'Falkland Islands (Malvinas)'),
('FRA', 'FR', 'France'),
('FRO', 'FO', 'Faroe Islands'),
('FSM', 'FM', 'Micronesia, Federated States of'),
('GAB', 'GA', 'Gabon'),
('GBR', 'GB', 'United Kingdom'),
('GEO', 'GE', 'Georgia'),
('GHA', 'GH', 'Ghana'),
('GIB', 'GI', 'Gibraltar'),
('GIN', 'GN', 'Guinea'),
('GLP', 'GP', 'Guadeloupe'),
('GMB', 'GM', 'Gambia'),
('GNB', 'GW', 'Guinea-Bissau'),
('GNQ', 'GQ', 'Equatorial Guinea'),
('GRC', 'GR', 'Greece'),
('GRD', 'GD', 'Grenada'),
('GRL', 'GL', 'Greenland'),
('GTM', 'GT', 'Guatemala'),
('GUF', 'GF', 'French Guiana'),
('GUM', 'GU', 'Guam'),
('GUY', 'GY', 'Guyana'),
('HKG', 'HK', 'Hong Kong'),
('HND', 'HN', 'Honduras'),
('HRV', 'HR', 'Croatia'),
('HTI', 'HT', 'Haiti'),
('HUN', 'HU', 'Hungary'),
('IDN', 'ID', 'Indonesia'),
('IND', 'IN', 'India'),
('IRL', 'IE', 'Ireland'),
('IRN', 'IR', 'Iran, Islamic Republic of'),
('IRQ', 'IQ', 'Iraq'),
('ISL', 'IS', 'Iceland'),
('ISR', 'IL', 'Israel'),
('ITA', 'IT', 'Italy'),
('JAM', 'JM', 'Jamaica'),
('JOR', 'JO', 'Jordan'),
('JPN', 'JP', 'Japan'),
('KAZ', 'KZ', 'Kazakhstan'),
('KEN', 'KE', 'Kenya'),
('KGZ', 'KG', 'Kyrgyzstan'),
('KHM', 'KH', 'Cambodia'),
('KIR', 'KI', 'Kiribati'),
('KNA', 'KN', 'Saint Kitts and Nevis'),
('KOR', 'KR', 'Korea, Republic of'),
('KWT', 'KW', 'Kuwait'),
('LAO', 'LA', 'Lao People''s Democratic Republic'),
('LBN', 'LB', 'Lebanon'),
('LBR', 'LR', 'Liberia'),
('LBY', 'LY', 'Libyan Arab Jamahiriya'),
('LCA', 'LC', 'Saint Lucia'),
('LIE', 'LI', 'Liechtenstein'),
('LKA', 'LK', 'Sri Lanka'),
('LSO', 'LS', 'Lesotho'),
('LTU', 'LT', 'Lithuania'),
('LUX', 'LU', 'Luxembourg'),
('LVA', 'LV', 'Latvia'),
('MAC', 'MO', 'Macao'),
('MAR', 'MA', 'Morocco'),
('MCO', 'MC', 'Monaco'),
('MDA', 'MD', 'Moldova, Republic of'),
('MDG', 'MG', 'Madagascar'),
('MDV', 'MV', 'Maldives'),
('MEX', 'MX', 'Mexico'),
('MHL', 'MH', 'Marshall Islands'),
('MKD', 'MK', 'Macedonia, the Former Yugoslav Republic of'),
('MLI', 'ML', 'Mali'),
('MLT', 'MT', 'Malta'),
('MMR', 'MM', 'Myanmar'),
('MNG', 'MN', 'Mongolia'),
('MNP', 'MP', 'Northern Mariana Islands'),
('MOZ', 'MZ', 'Mozambique'),
('MRT', 'MR', 'Mauritania'),
('MSR', 'MS', 'Montserrat'),
('MTQ', 'MQ', 'Martinique'),
('MUS', 'MU', 'Mauritius'),
('MWI', 'MW', 'Malawi'),
('MYS', 'MY', 'Malaysia'),
('NAM', 'NA', 'Namibia'),
('NCL', 'NC', 'New Caledonia'),
('NER', 'NE', 'Niger'),
('NFK', 'NF', 'Norfolk Island'),
('NGA', 'NG', 'Nigeria'),
('NIC', 'NI', 'Nicaragua'),
('NIU', 'NU', 'Niue'),
('NLD', 'NL', 'Netherlands'),
('NOR', 'NO', 'Norway'),
('NPL', 'NP', 'Nepal'),
('NRU', 'NR', 'Nauru'),
('NZL', 'NZ', 'New Zealand'),
('OMN', 'OM', 'Oman'),
('PAK', 'PK', 'Pakistan'),
('PAN', 'PA', 'Panama'),
('PCN', 'PN', 'Pitcairn'),
('PER', 'PE', 'Peru'),
('PHL', 'PH', 'Philippines'),
('PLW', 'PW', 'Palau'),
('PNG', 'PG', 'Papua New Guinea'),
('POL', 'PL', 'Poland'),
('PRI', 'PR', 'Puerto Rico'),
('PRK', 'KP', 'Korea, Democratic People''s Republic of'),
('PRT', 'PT', 'Portugal'),
('PRY', 'PY', 'Paraguay'),
('PYF', 'PF', 'French Polynesia'),
('QAT', 'QA', 'Qatar'),
('REU', 'RE', 'Reunion'),
('ROM', 'RO', 'Romania'),
('RUS', 'RU', 'Russian Federation'),
('RWA', 'RW', 'Rwanda'),
('SAU', 'SA', 'Saudi Arabia'),
('SDN', 'SD', 'Sudan'),
('SEN', 'SN', 'Senegal'),
('SGP', 'SG', 'Singapore'),
('SHN', 'SH', 'Saint Helena'),
('SJM', 'SJ', 'Svalbard and Jan Mayen'),
('SLB', 'SB', 'Solomon Islands'),
('SLE', 'SL', 'Sierra Leone'),
('SLV', 'SV', 'El Salvador'),
('SMR', 'SM', 'San Marino'),
('SOM', 'SO', 'Somalia'),
('SPM', 'PM', 'Saint Pierre and Miquelon'),
('STP', 'ST', 'Sao Tome and Principe'),
('SUR', 'SR', 'Suriname'),
('SVK', 'SK', 'Slovakia'),
('SVN', 'SI', 'Slovenia'),
('SWE', 'SE', 'Sweden'),
('SWZ', 'SZ', 'Swaziland'),
('SYC', 'SC', 'Seychelles'),
('SYR', 'SY', 'Syrian Arab Republic'),
('TCA', 'TC', 'Turks and Caicos Islands'),
('TCD', 'TD', 'Chad'),
('TGO', 'TG', 'Togo'),
('THA', 'TH', 'Thailand'),
('TJK', 'TJ', 'Tajikistan'),
('TKL', 'TK', 'Tokelau'),
('TKM', 'TM', 'Turkmenistan'),
('TON', 'TO', 'Tonga'),
('TTO', 'TT', 'Trinidad and Tobago'),
('TUN', 'TN', 'Tunisia'),
('TUR', 'TR', 'Turkey'),
('TUV', 'TV', 'Tuvalu'),
('TWN', 'TW', 'Taiwan, Province of China'),
('TZA', 'TZ', 'Tanzania, United Republic of'),
('UGA', 'UG', 'Uganda'),
('UKR', 'UA', 'Ukraine'),
('URY', 'UY', 'Uruguay'),
('USA', 'US', 'United States'),
('UZB', 'UZ', 'Uzbekistan'),
('VAT', 'VA', 'Holy See (Vatican City State)'),
('VCT', 'VC', 'Saint Vincent and the Grenadines'),
('VEN', 'VE', 'Venezuela'),
('VGB', 'VG', 'Virgin Islands, British'),
('VIR', 'VI', 'Virgin Islands, U.s.'),
('VNM', 'VN', 'Viet Nam'),
('VUT', 'VU', 'Vanuatu'),
('WLF', 'WF', 'Wallis and Futuna'),
('WSM', 'WS', 'Samoa'),
('YEM', 'YE', 'Yemen'),
('ZAF', 'ZA', 'South Africa'),
('ZMB', 'ZM', 'Zambia'),
('ZWE', 'ZW', 'Zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `ps_reservationstatus`
--

CREATE TABLE IF NOT EXISTS `ps_reservationstatus` (
  `reservationstatusid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `color` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`reservationstatusid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ps_room`
--

CREATE TABLE IF NOT EXISTS `ps_room` (
  `roomid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `lockid` varchar(50) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  `floorid` int(11) NOT NULL,
  `roomtypeid` int(11) NOT NULL,
  `roomstatusid` int(11) NOT NULL,
  PRIMARY KEY (`roomid`),
  KEY `floorid` (`floorid`),
  KEY `roomtypeid` (`roomtypeid`),
  KEY `roomstatusid` (`roomstatusid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `ps_room`
--

INSERT INTO `ps_room` (`roomid`, `name`, `lockid`, `description`, `floorid`, `roomtypeid`, `roomstatusid`) VALUES
(1, '201', '201abc', 'kamar 201', 2, 1, 1),
(2, '302', '', '', 3, 5, 1),
(3, '202', '', '', 2, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ps_roomreservation`
--

CREATE TABLE IF NOT EXISTS `ps_roomreservation` (
  `roomreservationid` int(11) NOT NULL AUTO_INCREMENT,
  `roomid` int(11) NOT NULL,
  `customerid` int(11) NOT NULL,
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  `deposit` int(11) NOT NULL DEFAULT '0',
  `cancel` char(1) NOT NULL DEFAULT 'N',
  `roomstatusid` int(11) NOT NULL,
  `out` date DEFAULT NULL,
  PRIMARY KEY (`roomreservationid`),
  KEY `roomid` (`roomid`),
  KEY `customerid` (`customerid`),
  KEY `roomstatusid` (`roomstatusid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `ps_roomreservation`
--

INSERT INTO `ps_roomreservation` (`roomreservationid`, `roomid`, `customerid`, `startdate`, `enddate`, `deposit`, `cancel`, `roomstatusid`, `out`) VALUES
(2, 1, 1, '2014-12-15', '2014-12-20', 200000, 'N', 2, NULL),
(3, 1, 2, '2014-12-15', '2014-12-16', 200000, 'Y', 6, NULL),
(4, 3, 2, '2014-12-15', '2014-12-17', 150000, 'N', 6, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ps_roomstatus`
--

CREATE TABLE IF NOT EXISTS `ps_roomstatus` (
  `roomstatusid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `color` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`roomstatusid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `ps_roomstatus`
--

INSERT INTO `ps_roomstatus` (`roomstatusid`, `name`, `color`) VALUES
(1, 'Vacant', '#037103'),
(2, 'In Use', '#ff0000'),
(3, 'Cleaning', '#1c4587'),
(5, 'Servicing', '#9900ff'),
(6, 'Reserve', '#ff9900');

-- --------------------------------------------------------

--
-- Table structure for table `ps_roomtype`
--

CREATE TABLE IF NOT EXISTS `ps_roomtype` (
  `roomtypeid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `singleb` int(11) NOT NULL DEFAULT '0',
  `doubleb` int(11) NOT NULL DEFAULT '0',
  `extrab` int(11) NOT NULL DEFAULT '0',
  `maxchild` int(11) NOT NULL DEFAULT '0',
  `maxadult` int(11) NOT NULL DEFAULT '0',
  `childcharge` int(11) NOT NULL DEFAULT '0',
  `adultcharge` int(11) NOT NULL DEFAULT '0',
  `description` varchar(250) DEFAULT NULL,
  `rate` int(11) NOT NULL DEFAULT '0',
  `weekendrate` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`roomtypeid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `ps_roomtype`
--

INSERT INTO `ps_roomtype` (`roomtypeid`, `name`, `singleb`, `doubleb`, `extrab`, `maxchild`, `maxadult`, `childcharge`, `adultcharge`, `description`, `rate`, `weekendrate`) VALUES
(1, 'Standard Room', 1, 0, 0, 1, 1, 20000, 30000, 'Standard room', 150000, 0),
(5, 'Deluxe Room', 1, 1, 0, 2, 2, 20000, 30000, '', 200000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ps_roomtypeequipment`
--

CREATE TABLE IF NOT EXISTS `ps_roomtypeequipment` (
  `roomtypeid` int(11) NOT NULL,
  `equipmentid` int(11) NOT NULL,
  PRIMARY KEY (`roomtypeid`,`equipmentid`),
  KEY `equipmentid` (`equipmentid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ps_roomtypeequipment`
--

INSERT INTO `ps_roomtypeequipment` (`roomtypeid`, `equipmentid`) VALUES
(1, 1),
(5, 1),
(5, 2),
(1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `ps_seasonalrate`
--

CREATE TABLE IF NOT EXISTS `ps_seasonalrate` (
  `seasonalrateid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(250) DEFAULT NULL,
  `startdate` datetime NOT NULL,
  `enddate` datetime NOT NULL,
  `mon` char(1) NOT NULL DEFAULT 'N',
  `tue` char(1) NOT NULL DEFAULT 'N',
  `wed` char(1) NOT NULL DEFAULT 'N',
  `thu` char(1) NOT NULL DEFAULT 'N',
  `fri` char(1) NOT NULL DEFAULT 'N',
  `sat` char(1) NOT NULL DEFAULT 'N',
  `sun` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`seasonalrateid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ps_seasonalratedetail`
--

CREATE TABLE IF NOT EXISTS `ps_seasonalratedetail` (
  `seasonalratedetailid` int(11) NOT NULL AUTO_INCREMENT,
  `seasonalrateid` int(11) NOT NULL,
  `roomid` int(11) NOT NULL,
  PRIMARY KEY (`seasonalratedetailid`),
  KEY `seasonalrateid` (`seasonalrateid`),
  KEY `roomid` (`roomid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ps_serviceitem`
--

CREATE TABLE IF NOT EXISTS `ps_serviceitem` (
  `serviceitemid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `rate` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`serviceitemid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `ps_serviceitem`
--

INSERT INTO `ps_serviceitem` (`serviceitemid`, `name`, `rate`) VALUES
(1, 'Indomie', 12000),
(2, 'Aqua', 5000),
(3, 'Kopi', 7500);

-- --------------------------------------------------------

--
-- Table structure for table `ps_tax`
--

CREATE TABLE IF NOT EXISTS `ps_tax` (
  `taxid` int(11) NOT NULL AUTO_INCREMENT,
  `room` int(11) NOT NULL DEFAULT '0',
  `meal` int(11) NOT NULL DEFAULT '0',
  `product` int(11) NOT NULL DEFAULT '0',
  `currency` varchar(5) NOT NULL,
  PRIMARY KEY (`taxid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `ps_tax`
--

INSERT INTO `ps_tax` (`taxid`, `room`, `meal`, `product`, `currency`) VALUES
(1, 10, 0, 0, 'Rp.');

-- --------------------------------------------------------

--
-- Table structure for table `ps_user`
--

CREATE TABLE IF NOT EXISTS `ps_user` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `fullname` varchar(150) NOT NULL,
  `displayname` varchar(50) NOT NULL,
  `password` varchar(150) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `active` char(1) DEFAULT '0',
  `admin` char(1) DEFAULT '0',
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `ps_user`
--

INSERT INTO `ps_user` (`userid`, `username`, `fullname`, `displayname`, `password`, `phone`, `email`, `active`, `admin`) VALUES
(1, 'prayogo', 'Prayogo', 'Prayogo', '123456', '085364007133', 'prayogo@binus.edu', 'Y', 'Y'),
(2, 'admin', 'Administrator', 'Admin', 'admin', '(0763) 33381', 'reservation@dyvahotel.com', 'Y', 'Y'),
(3, 'dyna', 'Dyna', 'Dyna', '123456', '1234567890', 'dyna@yahoo.com', 'Y', 'N');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ps_customer`
--
ALTER TABLE `ps_customer`
  ADD CONSTRAINT `ps_customer_ibfk_1` FOREIGN KEY (`locationid`) REFERENCES `ps_location` (`locationid`);

--
-- Constraints for table `ps_customeridentification`
--
ALTER TABLE `ps_customeridentification`
  ADD CONSTRAINT `ps_customeridentification_ibfk_1` FOREIGN KEY (`customerid`) REFERENCES `ps_customer` (`customerid`),
  ADD CONSTRAINT `ps_customeridentification_ibfk_2` FOREIGN KEY (`identificationtypeid`) REFERENCES `ps_identificationtype` (`identificationtypeid`);

--
-- Constraints for table `ps_customerphone`
--
ALTER TABLE `ps_customerphone`
  ADD CONSTRAINT `ps_customerphone_ibfk_1` FOREIGN KEY (`customerid`) REFERENCES `ps_customer` (`customerid`);

--
-- Constraints for table `ps_extraservice`
--
ALTER TABLE `ps_extraservice`
  ADD CONSTRAINT `ps_extraservice_ibfk_1` FOREIGN KEY (`serviceitemid`) REFERENCES `ps_serviceitem` (`serviceitemid`),
  ADD CONSTRAINT `ps_extraservice_ibfk_2` FOREIGN KEY (`roomreservationid`) REFERENCES `ps_roomreservation` (`roomreservationid`);

--
-- Constraints for table `ps_hotel`
--
ALTER TABLE `ps_hotel`
  ADD CONSTRAINT `ps_hotel_ibfk_1` FOREIGN KEY (`locationid`) REFERENCES `ps_location` (`locationid`);

--
-- Constraints for table `ps_room`
--
ALTER TABLE `ps_room`
  ADD CONSTRAINT `ps_room_ibfk_1` FOREIGN KEY (`floorid`) REFERENCES `ps_floor` (`floorid`),
  ADD CONSTRAINT `ps_room_ibfk_2` FOREIGN KEY (`roomtypeid`) REFERENCES `ps_roomtype` (`roomtypeid`),
  ADD CONSTRAINT `ps_room_ibfk_3` FOREIGN KEY (`roomstatusid`) REFERENCES `ps_roomstatus` (`roomstatusid`);

--
-- Constraints for table `ps_roomreservation`
--
ALTER TABLE `ps_roomreservation`
  ADD CONSTRAINT `ps_roomreservation_ibfk_1` FOREIGN KEY (`roomid`) REFERENCES `ps_room` (`roomid`),
  ADD CONSTRAINT `ps_roomreservation_ibfk_2` FOREIGN KEY (`customerid`) REFERENCES `ps_customer` (`customerid`),
  ADD CONSTRAINT `ps_roomreservation_ibfk_3` FOREIGN KEY (`roomstatusid`) REFERENCES `ps_roomstatus` (`roomstatusid`);

--
-- Constraints for table `ps_roomtypeequipment`
--
ALTER TABLE `ps_roomtypeequipment`
  ADD CONSTRAINT `ps_roomtypeequipment_ibfk_1` FOREIGN KEY (`roomtypeid`) REFERENCES `ps_roomtype` (`roomtypeid`),
  ADD CONSTRAINT `ps_roomtypeequipment_ibfk_2` FOREIGN KEY (`equipmentid`) REFERENCES `ps_equipment` (`equipmentid`);

--
-- Constraints for table `ps_seasonalratedetail`
--
ALTER TABLE `ps_seasonalratedetail`
  ADD CONSTRAINT `ps_seasonalratedetail_ibfk_1` FOREIGN KEY (`seasonalrateid`) REFERENCES `ps_seasonalrate` (`seasonalrateid`),
  ADD CONSTRAINT `ps_seasonalratedetail_ibfk_2` FOREIGN KEY (`roomid`) REFERENCES `ps_room` (`roomid`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
