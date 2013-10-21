-- phpMyAdmin SQL Dump
-- version 3.1.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 24, 2010 at 12:44 AM
-- Server version: 5.0.51
-- PHP Version: 5.2.6-1+lenny6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `h04329_sikopis`
--

-- --------------------------------------------------------

--
-- Table structure for table `INV_MGT_CUSTOMER`
--

CREATE TABLE IF NOT EXISTS `INV_MGT_CUSTOMER` (
  `ID` int(11) NOT NULL auto_increment,
  `CUSTOMER_TYPE` varchar(50) NOT NULL,
  `CUSTOMER_DESC` varchar(50) default NULL,
  `CATEGORY` varchar(10) default NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `INV_MGT_CUSTOMER`
--

INSERT INTO `INV_MGT_CUSTOMER` (`ID`, `CUSTOMER_TYPE`, `CUSTOMER_DESC`, `CATEGORY`) VALUES
(1, 'PLG', 'Pelanggan', 'SALES'),
(2, 'OWN', 'Own Use', 'OWN_USE');

-- --------------------------------------------------------

--
-- Table structure for table `INV_MGT_DELIVERY_PLAN`
--

CREATE TABLE IF NOT EXISTS `INV_MGT_DELIVERY_PLAN` (
  `ID` int(11) NOT NULL auto_increment,
  `INV_TYPE` varchar(10) NOT NULL,
  `QUANTITY` decimal(50,2) NOT NULL,
  `DELIVERY_DATE` date NOT NULL,
  `DELIVERY_SHIFT_NUMBER` varchar(10) NOT NULL,
  `SALES_ORDER_NUMBER` varchar(50) NOT NULL,
  `STATION_ID` varchar(50) NOT NULL,
  `DELIVERY_MESSAGE` varchar(255) default NULL,
  `PLAN_STATUS` varchar(10) default NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=88 ;

--
-- Dumping data for table `INV_MGT_DELIVERY_PLAN`
--

INSERT INTO `INV_MGT_DELIVERY_PLAN` (`ID`, `INV_TYPE`, `QUANTITY`, `DELIVERY_DATE`, `DELIVERY_SHIFT_NUMBER`, `SALES_ORDER_NUMBER`, `STATION_ID`, `DELIVERY_MESSAGE`, `PLAN_STATUS`) VALUES
(10, 'PRX', 20000.00, '2010-02-20', '4', '6572777 so', '34.402.54', 'ok barang diproses', 'CFM'),
(9, 'SLR', 16000.00, '2010-02-20', '1', '8000778 so', '31.406.01', 'siap dikirim', 'CFM'),
(8, 'PRM', 16000.00, '2010-02-20', '1', '8000777 so', '31.406.01', 'akan dikiri tepat waktu', 'CFM'),
(4, 'PRM', 16000.00, '2010-02-20', '2', '888999007', '34.402.56', 'ok akan segera dikirim on time jam 3 sore', 'CFM'),
(5, 'SLR', 16000.00, '2010-02-20', '1', '9876543 SO', '34.402.56', 'ok akan segera dikirim on time', 'CFM'),
(6, 'PPL', 12000.00, '2010-02-20', '3', '14789 SO', '34.402.56', 'iya siap dikirim...', 'CFM'),
(7, 'PPL', 8000.00, '2010-02-20', '2', '88887777999', '34.402.56', 'akan dikirm tepat waktu', 'CFM'),
(11, 'SLR', 30000.00, '2010-02-20', '1', '7362728 so', '34.402.54', 'iyah, sabar bntr', 'PLN'),
(12, 'PRM', 16000.00, '2010-02-20', '1', '8000779 SO', '31.406.01', 'siap komandan', 'CFM'),
(13, 'PRM', 16000.00, '2010-02-20', '2', '778899 so', '34.402.56', 'bentar lagi zaaaa', 'CFM'),
(14, 'PRX', 16000.00, '2010-02-20', '1', '8000780 SO', '31.406.01', 'ditunggu pak ', 'CFM'),
(15, 'PRM', 16000.00, '2010-02-20', '2', '123654 SO', '34.402.36', 'ok lg proses ya...', 'CFM'),
(16, 'SLR', 12000.00, '2010-02-20', '1', '4563212 SO', '34.402.36', 'siap boz...', 'CFM'),
(17, 'PPL', 16000.00, '2010-02-22', '2', '8000781 SO', '31.406.01', 'siap dikirim', 'CFM'),
(18, 'PPL', 5000.00, '2010-02-20', '1', '23242424 SO', '34.402.36', 'ok segera dikirim', 'CFM'),
(19, 'PRM', 8000.00, '2010-02-20', '1', '125589 SO', '34.401.21', 'iya neng crewet amat sech', 'CFM'),
(20, 'PRX', 12000.00, '2010-02-20', '1', '323232 SO', '34.402.36', 'ok saya kirim on time', 'CFM'),
(21, 'PRM', 32000.00, '2010-02-20', '1', '45866 SO', '34.401.21', 'iya siap bu...', 'CFM'),
(22, 'SLR', 12000.00, '2010-02-20', '1', '222222 SO', '34.402.36', 'ok tunggu sayakirim on time', 'CFM'),
(23, 'PRX', 8000.00, '2010-02-20', '1', '58944 SO', '34.401.21', 'iya siap bosss..', 'CFM'),
(24, 'PPL', 8000.00, '2010-02-20', '1', '2526266 SO', '34.402.54', 'xxxxxxx', 'CFM'),
(25, 'SLR', 8000.00, '2010-02-20', '2', '45899 SO', '34.401.21', 'ok tunggu ya...', 'CFM'),
(26, 'PRM', 18000.00, '2010-02-20', '3', '2222 SO', '34.402.36', 'ok saya kirim nanti on time', 'CFM'),
(27, 'PPL', 18000.00, '2010-02-20', '3', '3232323 SO', '34.402.36', 'ok saya kirim nanti', 'CFM'),
(28, 'PRX', 8000.00, '2010-02-20', '1', '676767', '31.406.01', 'untuk layanan jual', 'CFM'),
(29, 'PRX', 8000.00, '2010-02-20', '1', '12589 SO', '34.402.56', 'ok siap bosss', 'CFM'),
(30, 'PPL', 8000.00, '2010-02-20', '1', '12548 SO', '34.402.56', 'ok ditunggu...', 'CFM'),
(31, 'PPL', 8000.00, '2010-02-20', '1', '9888888 SO', '34.402.36', 'okkkkkk nya', 'CFM'),
(32, 'PRM', 12000.00, '2010-02-20', '1', '2323323 SO', '34.402.36', 'ok nanti saya kirim', 'CFM'),
(33, 'PPL', 5000.00, '2010-02-20', '1', '98123 SO', '34.402.56', 'oke siap', 'CFM'),
(34, 'PPL', 8000.00, '2010-02-20', '1', '2899999 SO', '34.401.21', 'layanan jual tolong buat ', 'CFM'),
(35, 'SLR', 16000.00, '2010-02-20', '1', '13131 So', '34.402.56', 'hai layanan jual, ad order nih', 'CFM'),
(36, 'PRM', 20000.00, '2010-02-20', '2', '1245555 SO', '34.406.06', 'oke tunggu', 'CFM'),
(37, 'PPL', 10000.00, '2010-02-20', '1', '156666', '34.406.06', 'oke diantos :)', 'CFM'),
(38, 'SLR', 24000.00, '2010-02-21', '3', '782828 SO', '34.406.06', 'persiapkan ya, ada yg pesen nih', 'CFM'),
(39, 'PPL', 8000.00, '2010-02-21', '1', '4444444SO', '34.402.56', 'layanan jual prepare buat bsok untuk pengiriman', 'CFM'),
(40, 'PRX', 24000.00, '2010-02-21', '1', '999888 SO', '34.406.06', 'tolong segera ditangani', 'CFM'),
(41, 'SLR', 8000.00, '2010-02-21', '1', '232323232SO', '34.402.56', 'layanan jual tolong prepare buat besok\r\n', 'CFM'),
(42, 'PPL', 20000.00, '2010-02-21', '1', '12345 SO', '34.402.56', 'Ok on time PAK', 'CFM'),
(43, 'PPL', 15000.00, '2010-02-21', '1', '000999 SO', '34.402.56', 'ok antosan PAK', 'CFM'),
(44, 'PRM', 25000.00, '2010-02-21', '1', '444444 SO', '34.402.56', 'Siap PAK', 'CFM'),
(45, 'PPL', 8000.00, '2010-02-21', '1', '212SO', '34.402.56', 'layanan jual tolong prepare', 'CFM'),
(46, 'SLR', 10000.00, '2010-02-21', '1', '32323232SO', '34.402.36', 'pak siapkan mobil tangki untuk pengiriman  32323232SO', 'CFM'),
(47, 'PPL', 16000.00, '2010-02-21', '1', '124566 SO', '34.401.21', 'Tolong dipersiapkan DO untuk good issue sip I besok', 'CFM'),
(48, 'PPL', 16000.00, '2010-02-21', '1', '798822 SO', '34.401.21', 'Tolong Disiapkan DO buat besok kirim sip I', 'PLN'),
(49, 'SLR', 15000.00, '2010-02-21', '1', '147852 SO', '34.402.56', 'siapkan pak\r\n', 'CFM'),
(50, 'PPL', 19000.00, '2010-02-21', '2', '212333 SO', '34.406.06', 'mohon untuk segera ditangani...', 'CFM'),
(51, 'PPL', 8000.00, '2010-02-21', '1', '555 A SO', '34.401.21', 'layanan jual tolong dipersiapkan DO nya kirim ship 1', 'CFM'),
(52, 'PPL', 8000.00, '2010-02-21', '1', '555 B SO', '34.401.21', 'Tolong disiapkan DO BUat besok pagi Sip I', 'CFM'),
(53, 'PPL', 6000.00, '2010-02-21', '2', '123456SO', '34.402.56', 'tolong prepare buat pengiriman', 'CFM'),
(54, 'PRM', 10000.00, '2010-02-21', '1', '222222 SO', '34.401.21', 'ok barang sdh diterima makasih', 'PLN'),
(55, 'PRM', 10000.00, '2010-02-21', '1', '222222 SO', '34.401.21', 'layanan jual tolong prepare untuk spbu...', 'PLN'),
(56, 'PRM', 8000.00, '2010-02-21', '2', '222222 A SO', '34.406.06', 'laynan jual tolong prepare ship II', 'CFM'),
(57, 'PPL', 8000.00, '2010-02-21', '1', '75554444SO', '34.402.56', 'bagian layanan jual tolong untuk prepare ke 34.402.56 jam 9 pagi', 'CFM'),
(58, 'PRM', 8000.00, '2010-02-21', '2', '222222 B SO', '34.406.06', 'layanan jual tolong prepare', 'CFM'),
(59, 'PPL', 8000.00, '2010-02-21', '1', '236900SO', '34.402.56', 'tolong prepare bwat pngriman spbu jl peta', 'CFM'),
(60, 'PPL', 8000.00, '2010-02-21', '3', '456698 SO', '34.401.21', 'tolong prepare', 'CFM'),
(61, 'PRM', 8000.00, '2010-02-21', '1', '5555 A SO', '34.406.06', 'tolong prepare pengriman', 'CFM'),
(62, 'PPL', 8000.00, '2010-02-21', '1', '98666 SO', '34.401.21', 'tolong prepare', 'CFM'),
(63, 'PRM', 8000.00, '2010-02-21', '1', '99999 SO', '34.406.06', 'tolong prepare', 'CFM'),
(64, 'PRM', 8000.00, '2010-02-21', '1', '888888', '34.406.06', 'tolong prepare', 'CFM'),
(65, 'SLR', 8000.00, '2010-02-21', '1', '33333 SO', '34.406.06', 'segera prepare', 'CFM'),
(66, 'PRX', 8000.00, '2010-02-21', '1', '333033 SO', '34.406.06', 'tolong prepare', 'CFM'),
(67, 'PRX', 8000.00, '2010-02-21', '1', '444444 A SO', '34.406.06', 'tolong prepare pengeriman besok', 'CFM'),
(68, 'PRX', 8000.00, '2010-02-21', '1', '123600 A SO', '34.406.06', 'tolong prepare buat pengiriman', 'CFM'),
(69, 'PPL', 8000.00, '2010-02-21', '1', '12133 A SO', '34.402.54', 'Pak Tolong di siapkan SO buat besok', 'CFM'),
(70, 'PPL', 8000.00, '2010-02-21', '1', '454545 A SO', '34.402.54', 'Tlng Disiapkan SO nya PAK', 'CFM'),
(71, 'PRX', 8000.00, '2010-02-23', '1', '333333 A SO', '34.402.54', 'Pak tolong di siapkan SO nya', 'CFM'),
(72, 'PRX', 8000.00, '2010-02-23', '1', '333333 B SO', '34.402.54', 'Pak Tolong disiapkan SO nya buat besok', 'CFM'),
(73, 'PRX', 8000.00, '2010-02-23', '1', '333333 C SO', '34.402.54', 'Pak tolong dipersiapkan SO nya buat besok juga', 'CFM'),
(74, 'PPL', 8000.00, '2010-02-23', '1', '34550 A SO', '34.401.21', 'Pak Tolong disiapkan SO nya buat besok', 'CFM'),
(75, 'PPL', 8000.00, '2010-02-23', '1', '34550 B SO', '34.401.21', 'Pak Tolong disiapkan SO nya buat besok ya', 'CFM'),
(76, 'PRX', 8000.00, '2010-02-23', '1', '123456 A SO', '34.401.21', 'tolong prepare buat pengiriman', 'CFM'),
(77, 'PRX', 8000.00, '2010-02-23', '1', '123456 B SO', '34.401.21', 'tolong persiapkan buat pengiriman', 'CFM'),
(78, 'PRM', 8000.00, '2010-02-23', '1', '654321 A SO', '34.401.21', 'layanan jual tolong prepare buat pengiriman', 'CFM'),
(79, 'PRM', 8000.00, '2010-02-23', '1', '654321 B SO', '34.401.21', 'layanan jual tolong prepare buat pengiriman\r\n', 'CFM'),
(80, 'PRM', 8000.00, '2010-02-23', '1', '654321 C SO', '34.401.21', 'layanan jual tolong prepare buat pengiriman', 'CFM'),
(81, 'PPL', 8000.00, '2010-02-23', '1', '123400 B SO', '34.401.21', 'Pak Tolong Siapkan SO nya buat besokk', 'CFM'),
(82, 'PPL', 8000.00, '2010-02-23', '1', '123400 A SO', '34.401.21', 'Tolong Pak disiapkan SO nya buat besok', 'CFM'),
(83, 'PPL', 8000.00, '2010-02-23', '1', '12345', '34.401.21', 'Pak Tolong disiapkan SO nya ya buat besok', 'CFM'),
(84, 'PRX', 8000.00, '2010-02-23', '1', '098876 SO', '34.402.56', 'pak tolong disiapkan SO nya', 'CFM'),
(85, 'SLR', 8000.00, '2010-02-23', '1', '288900 SO', '34.402.56', 'Pak tolong disiapkan SO nya buat besok', 'PLN'),
(86, 'PPL', 8000.00, '2010-02-23', '1', '45009 SO', '34.401.21', 'Pak Tolong disiapkan SO nya buat besok', 'CFM'),
(87, 'PPL', 8000.00, '2010-02-24', '2', '09090 SO', '34.402.56', 'Pak Tolong disiapkan SO nya ya Pak', 'CFM');

-- --------------------------------------------------------

--
-- Table structure for table `INV_MGT_DELIVERY_REALISATION`
--

CREATE TABLE IF NOT EXISTS `INV_MGT_DELIVERY_REALISATION` (
  `ID` int(11) NOT NULL auto_increment,
  `SALES_ORDER_NUMBER` varchar(50) NOT NULL,
  `STATION_ID` varchar(50) NOT NULL,
  `INV_TYPE` varchar(10) NOT NULL,
  `QUANTITY` decimal(50,2) NOT NULL,
  `PLATE_NUMBER` varchar(20) NOT NULL,
  `DRIVER_NAME` varchar(50) NOT NULL,
  `DELIVERY_DATE` date NOT NULL,
  `DELIVERY_TIME` varchar(20) NOT NULL,
  `DELIVERY_SHIFT_NUMBER` varchar(10) NOT NULL,
  `DELIVERY_MESSAGE` varchar(255) default NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=82 ;

--
-- Dumping data for table `INV_MGT_DELIVERY_REALISATION`
--

INSERT INTO `INV_MGT_DELIVERY_REALISATION` (`ID`, `SALES_ORDER_NUMBER`, `STATION_ID`, `INV_TYPE`, `QUANTITY`, `PLATE_NUMBER`, `DRIVER_NAME`, `DELIVERY_DATE`, `DELIVERY_TIME`, `DELIVERY_SHIFT_NUMBER`, `DELIVERY_MESSAGE`) VALUES
(8, '8000778 so', '31.406.01', 'SLR', 16000.00, 'D 1234 ', 'Bejo', '2010-02-20', '21:05', '1', 'abang antrin'),
(7, '8000777 so', '31.406.01', 'PRM', 16000.00, 'D 3456 DD', 'Kusnadi', '2010-02-20', '20:57', '1', 'iya neng abang kirim'),
(3, '888999007', '34.402.56', 'PRM', 16000.00, 'D 4567', 'basuki', '2010-02-20', '19:13', '2', 'good isue on time'),
(4, '9876543 SO', '34.402.56', 'SLR', 16000.00, 'D 9995', 'Ludi', '2010-02-20', '19:30', '1', 'sabar neng dikirim nie'),
(5, '14789 SO', '34.402.56', 'PPL', 12000.00, 'D 1478', 'Jonny', '2010-02-20', '19:56', '3', 'Good issue on time'),
(6, '88887777999', '34.402.56', 'PPL', 8000.00, 'D 3456 DD', 'jony', '2010-02-20', '20:09', '2', 'ok segera berangkat'),
(9, '6572777 so', '34.402.54', 'PRX', 20000.00, 'D 2222 ZZ', 'ujang', '2010-02-20', '21:13', '4', 'ni bro, barang dah diangkut sama bro ujang, tunggu yaa'),
(10, '778899 so', '34.402.56', 'PRM', 16000.00, 'D 1111 RR', 'Ririn', '2010-02-20', '21:28', '2', 'iya nih spesial sopir si neng'),
(11, '8000779 SO', '31.406.01', 'PRM', 16000.00, 'D 999', 'Wahyu', '2010-02-20', '21:29', '1', 'sudah dikirim'),
(12, '8000780 SO', '31.406.01', 'PRX', 16000.00, 'D 2323', 'eko', '2010-02-20', '21:36', '1', 'sudah berangkat'),
(13, '123654 SO', '34.402.36', 'PRM', 16000.00, 'D 9995', 'jimbpong', '2010-02-20', '21:42', '2', 'ok bro mobil ke tkp'),
(14, '4563212 SO', '34.402.36', 'SLR', 12000.00, 'D 4567', 'grandong', '2010-02-20', '21:51', '1', 'tank meluncur ke tkp'),
(15, '8000781 SO', '31.406.01', 'PPL', 16000.00, 'D 1111 SE', 'iwan', '2010-02-22', '21:54', '2', 'siap berangkat'),
(16, '125589 SO', '34.401.21', 'PRM', 8000.00, 'D 2258 MM', 'jony', '2010-02-20', '22:01', '1', 'iya udah dikirim neng...\r\n'),
(17, '23242424 SO', '34.402.36', 'PPL', 5000.00, 'D 434343', 'dukun', '2010-02-20', '22:01', '1', 'mobil meluncur ke tkp brow'),
(18, '45866 SO', '34.401.21', 'PRM', 32000.00, 'D 5486 AA', 'AA jon', '2010-02-20', '22:07', '1', 'udah dikirim neng...'),
(19, '323232 SO', '34.402.36', 'PRX', 12000.00, 'D 4444', 'pepi', '2010-02-20', '03:00', '1', 'mobil sudah pergi dari depot'),
(20, '222222 SO', '34.402.36', 'SLR', 12000.00, 'D55555', 'kuswara', '2010-02-20', '07:15', '1', 'mobil sudah on the way'),
(21, '58944 SO', '34.401.21', 'PRX', 8000.00, 'D 4589 NN', 'Ririn', '2010-02-20', '22:16', '1', 'udah dikirim boss'),
(22, '45899 SO', '34.401.21', 'SLR', 8000.00, 'D 4588 JJ', 'agus', '2010-02-20', '22:22', '2', 'udah dikirim..'),
(23, '2222 SO', '34.402.36', 'PRM', 18000.00, 'D34444', 'ssss', '2010-02-20', '03:00', '3', 'mobil on the way'),
(24, '3232323 SO', '34.402.36', 'PPL', 18000.00, 'D3434', 'juno', '2010-02-20', '03:28', '3', 'on the way'),
(25, '676767', '31.406.01', 'PRX', 8000.00, '5656', 'dita', '2010-02-20', '22:31', '1', 'sebentar dikirim'),
(26, '12589 SO', '34.402.56', 'PRX', 8000.00, 'D 2258 MM', 'romi', '2010-02-20', '22:31', '1', 'ok barang udah dikirim'),
(27, '12548 SO', '34.402.56', 'PPL', 8000.00, 'D 4589 NN', 'ahmad', '2010-02-20', '22:35', '1', 'ok barang sudah dikirim...'),
(28, '9888888 SO', '34.402.36', 'PPL', 8000.00, 'D 3949', 'Agus', '2010-02-01', '02:42', '1', 'otw'),
(29, '2323323 SO', '34.402.36', 'PRM', 12000.00, 'D2345', 'jaja', '2010-02-20', '22:44', '1', 'mobil on the way'),
(30, '98123 SO', '34.402.56', 'PPL', 5000.00, 'D 12343', 'kkkk', '2010-02-20', '07:48', '1', 'otw'),
(31, '2899999 SO', '34.401.21', 'PPL', 8000.00, 'D3333', 'jajang', '2010-02-20', '23:01', '1', 'on the way'),
(32, '13131 So', '34.402.56', 'SLR', 16000.00, 'B 1223 AK', 'popong', '2010-02-20', '23:21', '1', 'terkirim'),
(33, '1245555 SO', '34.406.06', 'PRM', 20000.00, 'D 9995', 'ssssss', '2010-02-20', '09:22', '2', 'otw'),
(34, '156666', '34.406.06', 'PPL', 10000.00, 'D 4567', 'hhhh', '2010-02-20', '09:27', '1', 'otw'),
(35, '782828 SO', '34.406.06', 'SLR', 24000.00, 'G 1167 YU', 'BASUKI', '2010-02-21', '16:28', '3', 'udah dikirim, tunggu ajah'),
(36, '4444444SO', '34.402.56', 'PPL', 8000.00, 'D33333', 'jaja', '2010-02-21', '16:33', '1', 'mobil on the way\r\n'),
(37, '999888 SO', '34.406.06', 'PRX', 24000.00, 'D 1234 SS', 'PAIJO', '2010-02-21', '16:38', '1', 'mobil OTW, mohon ditunggu...'),
(38, '232323232SO', '34.402.56', 'SLR', 8000.00, 'D44444', 'kusno', '2010-02-21', '16:40', '1', 'mobil on the way'),
(39, '12345 SO', '34.402.56', 'PPL', 20000.00, 'B 7878 DG', 'Aul', '2010-02-21', '08:45', '1', 'sudah berangkat'),
(40, '000999 SO', '34.402.56', 'PPL', 15000.00, 'B 9999 PE', 'Cucu', '2010-02-21', '10:53', '1', 'sudah nie '),
(41, '444444 SO', '34.402.56', 'PRM', 25000.00, 'D 8888 FE', 'Juju', '2010-02-22', '10:00', '1', 'otw PAK'),
(42, '212SO', '34.402.56', 'PPL', 8000.00, 'D21112', 'koswara', '2010-02-21', '17:14', '1', 'mobil on the way'),
(43, '32323232SO', '34.402.36', 'SLR', 10000.00, 'D 2121 ED', 'ARif', '2010-02-21', '13:24', '1', 'ok, sudah dikirim'),
(44, '124566 SO', '34.401.21', 'PPL', 16000.00, 'D 0000', 'Ajum', '2010-02-21', '17:33', '1', 'Neng Sudah dianter nie'),
(45, '147852 SO', '34.402.56', 'SLR', 15000.00, 'D 2333 GF', 'mr black', '2010-02-21', '17:51', '1', 'dijalan ni'),
(46, '212333 SO', '34.406.06', 'PPL', 19000.00, 'D 2121  WR', 'Bejo', '2010-02-21', '14:56', '2', 'mobil sudah meluncur ke SPBU 34.406.06'),
(47, '555 A SO', '34.401.21', 'PPL', 8000.00, 'D 5589 AA', 'bedul', '2010-02-21', '18:01', '1', 'neng abang anteri ya...'),
(48, '555 B SO', '34.401.21', 'PPL', 8000.00, 'D 5555', 'Joni', '2010-02-21', '09:08', '1', 'sudah dikirim neng geulis'),
(49, '123456SO', '34.402.56', 'PPL', 6000.00, 'D 2121  WR', 'Bejo', '2010-02-21', '15:22', '2', 'mobil OTW'),
(50, '222222 A SO', '34.406.06', 'PRM', 8000.00, 'D 689 MM', 'abdul', '2010-02-21', '18:39', '2', 'sip barang sudah dikirim'),
(51, '222222 B SO', '34.406.06', 'PRM', 8000.00, 'D 6589 WW', 'ujang', '2010-02-21', '18:42', '2', 'barang udah dikirim'),
(52, '75554444SO', '34.402.56', 'PPL', 8000.00, 'D 2121  WR', 'bejo', '2010-02-21', '18:42', '1', 'mobil sedang dijalan'),
(53, '236900SO', '34.402.56', 'PPL', 8000.00, 'D3333', 'jajang', '2010-02-21', '18:53', '1', 'mobil otw'),
(54, '456698 SO', '34.401.21', 'PPL', 8000.00, 'D3333', 'jajang', '2010-02-21', '19:00', '3', 'mobil otw'),
(55, '5555 A SO', '34.406.06', 'PRM', 8000.00, 'D444', 'jajang', '2010-02-21', '19:02', '1', 'mobil otw'),
(56, '98666 SO', '34.401.21', 'PPL', 8000.00, 'D333', 'jajang', '2010-02-21', '19:04', '1', 'mobil otw'),
(57, '99999 SO', '34.406.06', 'PRM', 8000.00, 'DEEE', 'jajang', '2010-02-21', '19:07', '1', 'mobil otw'),
(58, '888888', '34.406.06', 'PRM', 8000.00, 'D3333', 'jajang', '2010-02-21', '19:08', '1', 'mobil otw'),
(59, '33333 SO', '34.406.06', 'SLR', 8000.00, 'D 6589 WW', 'PAIMAN', '2010-02-21', '09:08', '1', 'OTW'),
(60, '333033 SO', '34.406.06', 'PRX', 8000.00, 'D4444', 'jajanga', '2010-02-21', '19:10', '1', 'mobil otw'),
(61, '444444 A SO', '34.406.06', 'PRX', 8000.00, 'D3333', 'jajang', '2010-02-21', '19:16', '1', 'mobil otw'),
(62, '123600 A SO', '34.406.06', 'PRX', 8000.00, 'D3333', 'jajang', '2010-02-21', '19:18', '1', 'mobil otw\r\n'),
(63, '12133 A SO', '34.402.54', 'PPL', 8000.00, 'D 3333', 'Abah ', '2010-02-20', '08:26', '1', 'sudah dikirim PAK'),
(64, '2526266 SO', '34.402.54', 'PPL', 8000.00, 'D 9995', 'sobar', '2010-02-21', '19:52', '1', 'sudah berangkat PAK'),
(65, '454545 A SO', '34.402.54', 'PPL', 8000.00, 'D 8884', 'koko', '2010-02-21', '19:57', '1', 'sudah berangkat'),
(66, '333333 A SO', '34.402.54', 'PRX', 8000.00, 'D 9090 JI', 'Jagur', '2010-02-23', '08:30', '1', 'Pak Barang sudah dikirim'),
(67, '333333 B SO', '34.402.54', 'PRX', 8000.00, 'D 3000 KL', 'Komar', '2010-02-23', '08:30', '1', 'Pak barang sudah dikirim'),
(68, '333333 C SO', '34.402.54', 'PRX', 8000.00, 'D 4090 MM', 'Tora', '2010-02-23', '08:30', '1', 'Pak barang sudah dikirim'),
(69, '34550 A SO', '34.401.21', 'PPL', 8000.00, 'D 5656 TI', 'Bagus', '2010-02-23', '08:00', '1', 'Pak Barang sudah saya kirim'),
(70, '34550 B SO', '34.401.21', 'PPL', 8000.00, 'D 8765 KL', 'Yoyo', '2010-02-23', '08:00', '1', 'Pak barang sudah dikirim ya'),
(71, '123456 A SO', '34.401.21', 'PRX', 8000.00, 'D1234', 'jajang', '2010-02-23', '20:56', '1', 'mobil on the way'),
(72, '123456 B SO', '34.401.21', 'PRX', 8000.00, 'D 3000 KL', 'jajang', '2010-02-23', '20:59', '1', 'mobil on the way'),
(73, '654321 A SO', '34.401.21', 'PRM', 8000.00, 'D2325', 'jajang', '2010-02-23', '21:10', '1', 'mobil on the way'),
(74, '654321 B SO', '34.401.21', 'PRM', 8000.00, 'D333', 'jajang', '2010-02-23', '21:12', '1', 'mobil on the way'),
(75, '654321 C SO', '34.401.21', 'PRM', 8000.00, 'D3333', 'jajang', '2010-02-23', '21:14', '1', 'mobil on the way'),
(76, '123400 B SO', '34.401.21', 'PPL', 8000.00, 'D 6565 FE', 'RIRIN', '2010-02-23', '08:15', '1', 'Pak barang sudah dikirim'),
(77, '123400 A SO', '34.401.21', 'PPL', 8000.00, 'D 4090 MM', 'Kusnadi', '2010-02-23', '09:40', '1', 'Pak barang sudah dikirim'),
(78, '12345', '34.401.21', 'PPL', 8000.00, 'D 1212 MM', 'Bagio', '2010-02-23', '21:50', '1', 'Bu barang sudah dikirim'),
(79, '098876 SO', '34.402.56', 'PRX', 8000.00, 'D 5656 KL', 'Basuki', '2010-02-23', '10:12', '1', 'barang sudah dikirim pak'),
(80, '45009 SO', '34.401.21', 'PPL', 8000.00, 'D 1111 HG', 'ujang', '2010-02-23', '22:20', '1', 'Pak barang sudah dikirim'),
(81, '09090 SO', '34.402.56', 'PPL', 8000.00, 'D 3434 FE', 'Aa Basuki', '2010-02-24', '14:34', '2', 'Siap  Pak, barang sudah dikirim');

-- --------------------------------------------------------

--
-- Table structure for table `INV_MGT_DIST_LOCATION`
--

CREATE TABLE IF NOT EXISTS `INV_MGT_DIST_LOCATION` (
  `ID` int(11) NOT NULL auto_increment,
  `LOCATION_CODE` varchar(50) NOT NULL,
  `LOCATION_NAME` varchar(50) default NULL,
  `SUPPLY_POINT` varchar(50) NOT NULL,
  `SALES_AREA_MANAGER` varchar(50) NOT NULL,
  PRIMARY KEY  (`ID`),
  UNIQUE KEY `UQ_INV_MGT_DIST_LOCATION_1` (`LOCATION_CODE`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `INV_MGT_DIST_LOCATION`
--

INSERT INTO `INV_MGT_DIST_LOCATION` (`ID`, `LOCATION_CODE`, `LOCATION_NAME`, `SUPPLY_POINT`, `SALES_AREA_MANAGER`) VALUES
(1, 'BDG', 'BANDUNG', 'UJUNG BERUNG', 'TATA PANDAYA'),
(2, 'BDG.KAB', 'KABUPATEN BANDUNG', 'PADALARANG', 'TATA PANDAYA');

-- --------------------------------------------------------

--
-- Table structure for table `INV_MGT_MARGIN`
--

CREATE TABLE IF NOT EXISTS `INV_MGT_MARGIN` (
  `ID` int(11) NOT NULL auto_increment,
  `INV_TYPE` varchar(50) NOT NULL,
  `MARGIN_VALUE` decimal(10,2) NOT NULL,
  `STATION_ID` varchar(50) default NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `INV_MGT_MARGIN`
--

INSERT INTO `INV_MGT_MARGIN` (`ID`, `INV_TYPE`, `MARGIN_VALUE`, `STATION_ID`) VALUES
(8, 'SLR', 0.05, '31.406.01'),
(7, 'PRM', 0.05, '31.406.01'),
(3, 'PRM', 4.20, '34.402.56'),
(4, 'SLR', 4.40, '34.402.56'),
(5, 'PRX', 6.00, '34.402.56'),
(6, 'PPL', 6.50, '34.402.56'),
(9, 'PRX', 0.05, '31.406.01'),
(10, 'PPL', 0.05, '31.406.01'),
(11, 'PRM', 5.00, '34.401.21'),
(12, 'SLR', 5.00, '34.401.21'),
(13, 'PRX', 5.00, '34.401.21'),
(14, 'PPL', 5.00, '34.401.21'),
(15, 'PRM', 5.00, '34.406.06'),
(16, 'SLR', 5.00, '34.406.06'),
(17, 'PRX', 5.00, '34.406.06'),
(18, 'PRM', 0.06, '34.402.40'),
(19, 'SLR', 0.06, '34.402.40'),
(20, 'PRX', 0.03, '34.402.40'),
(21, 'PPL', 5.00, '34.402.54'),
(22, 'PRX', 5.00, '34.402.54'),
(23, 'SLR', 5.00, '34.402.54'),
(24, 'PRM', 5.00, '34.402.54'),
(25, 'PPL', 5.00, '34.406.06');

-- --------------------------------------------------------

--
-- Table structure for table `INV_MGT_OUTPUT`
--

CREATE TABLE IF NOT EXISTS `INV_MGT_OUTPUT` (
  `ID` int(11) NOT NULL auto_increment,
  `INV_TYPE` varchar(50) NOT NULL,
  `CUSTOMER_TYPE` varchar(50) NOT NULL,
  `OUTPUT_VALUE` decimal(50,2) NOT NULL,
  `OUTPUT_DATE` date NOT NULL,
  `UNIT_PRICE` decimal(50,2) NOT NULL,
  `BEGIN_STAND_METER` decimal(50,2) default '0.00',
  `END_STAND_METER` decimal(50,2) default '0.00',
  `VEHICLE_TYPE` varchar(50) default NULL,
  `TERA_VALUE` decimal(10,2) default NULL,
  `PUMP_ID` varchar(10) default NULL,
  `NOSEL_ID` varchar(10) default NULL,
  `OUTPUT_TIME` varchar(20) default NULL,
  `CATEGORY` varchar(10) default NULL,
  `STATION_ID` varchar(50) default NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=64 ;

--
-- Dumping data for table `INV_MGT_OUTPUT`
--

INSERT INTO `INV_MGT_OUTPUT` (`ID`, `INV_TYPE`, `CUSTOMER_TYPE`, `OUTPUT_VALUE`, `OUTPUT_DATE`, `UNIT_PRICE`, `BEGIN_STAND_METER`, `END_STAND_METER`, `VEHICLE_TYPE`, `TERA_VALUE`, `PUMP_ID`, `NOSEL_ID`, `OUTPUT_TIME`, `CATEGORY`, `STATION_ID`) VALUES
(1, 'PRM', 'PLG', 1480.00, '2010-02-20', 4500.00, 1020.00, 2500.00, 'MBL', 20.00, 'A', 'A1', '19:01', 'SALES', '34.402.56'),
(21, 'SLR', 'PLG', 2990.00, '2010-02-20', 4500.00, 2010.00, 5000.00, 'MBL', 10.00, 'B', 'B1', '23:17', 'SALES', '34.402.56'),
(3, 'PRM', 'PLG', 5490.00, '2010-02-20', 4500.00, 2510.00, 8000.00, 'MBL', 10.00, 'A', 'A2', '19:18', 'SALES', '34.402.56'),
(7, 'PRM', 'PLG', 2490.00, '2010-02-20', 4500.00, 2510.00, 5000.00, 'MBL', 10.00, 'A', 'A1', '20:46', 'SALES', '31.406.01'),
(5, 'PRX', 'PLG', 6000.00, '2010-02-20', 6300.00, 3000.00, 9000.00, 'MBL', 10.00, 'C', 'C1', '19:20', 'SALES', '34.402.56'),
(6, 'PPL', 'PLG', 7000.00, '2010-02-20', 7000.00, 3000.00, 10000.00, 'MBL', 10.00, 'D', 'D1', '19:21', 'SALES', '34.402.56'),
(8, 'SLR', 'PLG', 3490.00, '2010-02-20', 4500.00, 2510.00, 6000.00, 'MBL', 0.00, 'B', 'B1', '20:48', 'SALES', '31.406.01'),
(9, 'SLR', 'PLG', 2490.00, '2010-02-20', 4500.00, 3510.00, 6000.00, 'MBL', 0.00, 'C', 'C1', '20:48', 'SALES', '31.406.01'),
(10, 'SLR', 'PLG', 1490.00, '2010-02-20', 4500.00, 4510.00, 6000.00, 'MBL', 0.00, 'D', 'D1', '20:49', 'SALES', '31.406.01'),
(11, 'PRX', 'PLG', 267.00, '2010-02-20', 6450.00, 2410.00, 2677.00, 'MBL', 10.00, 'A', 'A2', '21:45', 'SALES', '31.406.01'),
(12, 'PRM', 'PLG', 2490.00, '2010-02-20', 4500.00, 2010.00, 4500.00, 'MBL', 10.00, 'A', 'A1', '21:49', 'SALES', '34.401.21'),
(13, 'SLR', 'PLG', 2480.00, '2010-02-20', 4500.00, 2040.00, 4520.00, 'MBL', 20.00, 'B', 'B1', '21:50', 'SALES', '34.401.21'),
(14, 'PRX', 'PLG', 3470.00, '2010-02-20', 6450.00, 2530.00, 6000.00, 'MBL', 30.00, 'C', 'C1', '21:51', 'SALES', '34.401.21'),
(15, 'PPL', 'PLG', 3960.00, '2010-02-20', 7000.00, 3040.00, 7000.00, 'MBL', 40.00, 'D', 'D1', '21:51', 'SALES', '34.401.21'),
(16, 'PPL', 'PLG', 1499.00, '2010-02-20', 7000.00, 3501.00, 5000.00, 'MBL', 1.00, 'A', 'A3', '21:58', 'SALES', '31.406.01'),
(17, 'PRX', 'PLG', 7980.00, '2010-02-20', 6450.00, 1020.00, 9000.00, 'MBL', 20.00, 'C', 'C1', '22:11', 'SALES', '34.401.21'),
(18, 'PPL', 'PLG', 5990.00, '2010-02-20', 7000.00, 3010.00, 9000.00, 'MBL', 10.00, 'D', 'D2', '22:55', 'SALES', '34.401.21'),
(22, 'SLR', 'PLG', 12990.00, '2010-02-20', 4500.00, 15010.00, 28000.00, 'MBL', 10.00, 'B', 'B1', '23:16', 'SALES', '34.406.06'),
(20, 'PRM', 'PLG', 9990.00, '2010-02-20', 4500.00, 20010.00, 30000.00, 'MBL', 10.00, 'A', 'A1', '23:15', 'SALES', '34.406.06'),
(23, 'PRX', 'PLG', 4980.00, '2010-02-20', 6300.00, 10020.00, 15000.00, 'MBL', 20.00, 'C', 'C1', '23:17', 'SALES', '34.406.06'),
(24, 'PRM', 'PLG', 14985.00, '2010-02-20', 4500.00, 20015.00, 35000.00, 'MBL', 15.00, 'A', 'A1', '16:34', 'SALES', '34.402.56'),
(25, 'PPL', 'PLG', 4990.00, '2010-02-21', 7000.00, 2010.00, 7000.00, 'MBL', 10.00, 'D', 'D1', '16:35', 'SALES', '34.402.56'),
(26, 'SLR', 'PLG', 25000.00, '2010-02-20', 4500.00, 15000.00, 40000.00, 'MBL', 15.00, 'A', 'A2', '16:35', 'SALES', '34.402.56'),
(27, 'PPL', 'PLG', 3490.00, '2010-02-21', 7000.00, 2010.00, 5500.00, 'MBL', 10.00, 'D', 'D3', '16:40', 'SALES', '34.401.21'),
(28, 'PPL', 'OWN', 50.00, '2010-02-21', 6675.00, 5500.00, 5550.00, 'MBL', 0.00, 'D', 'D3', '16:51', 'OWN_USE', '34.401.21'),
(29, 'PPL', 'PLG', 4990.00, '2010-02-21', 7000.00, 3010.00, 8000.00, 'MBL', 10.00, 'D', 'D3', '17:25', 'SALES', '34.401.21'),
(30, 'PPL', 'PLG', 6990.00, '2010-02-21', 7000.00, 2010.00, 9000.00, 'MBL', 10.00, 'D', 'D4', '18:05', 'SALES', '34.401.21'),
(31, 'PRM', 'PLG', 9980.00, '2010-02-21', 4500.00, 10020.00, 20000.00, 'MBL', 20.00, 'A', 'A1', '18:24', 'SALES', '34.406.06'),
(32, 'PPL', 'PLG', 6980.00, '2010-02-21', 7000.00, 2020.00, 9000.00, 'MBL', 20.00, 'D', 'D1', '18:25', 'SALES', '34.402.56'),
(33, 'PPL', 'PLG', 4990.00, '2010-02-21', 7000.00, 2010.00, 7000.00, 'MBL', 10.00, 'D', 'D1', '18:26', 'SALES', '34.402.56'),
(34, 'PRM', 'PLG', 20.00, '2010-02-21', 4500.00, 30.00, 50.00, 'MBL', 1.00, 'A', 'A1', '18:29', 'SALES', '34.406.06'),
(35, 'PPL', 'PLG', 3980.00, '2010-02-21', 7000.00, 2020.00, 6000.00, 'MTR', 20.00, 'D', 'D2', '18:47', 'SALES', '34.402.56'),
(36, 'PPL', 'PLG', 2990.00, '2010-02-21', 7000.00, 2010.00, 5000.00, 'MBL', 10.00, 'D', 'D1', '18:53', 'SALES', '34.401.21'),
(37, 'PPL', 'PLG', 9990.00, '2010-02-21', 7000.00, 2010.00, 12000.00, 'MBL', 10.00, 'D', 'D1', '18:56', 'SALES', '34.401.21'),
(38, 'PRM', 'PLG', 13985.00, '2010-02-21', 4500.00, 26015.00, 40000.00, 'MBL', 15.00, 'A', 'A1', '18:58', 'SALES', '34.406.06'),
(39, 'SLR', 'PLG', 16980.00, '2010-02-21', 4500.00, 28020.00, 45000.00, 'MBL', 20.00, 'B', 'B1', '19:01', 'SALES', '34.406.06'),
(40, 'PRX', 'PLG', 26000.00, '2010-02-21', 6300.00, 34000.00, 60000.00, 'MBL', 20.00, 'C', 'C1', '19:01', 'SALES', '34.406.06'),
(45, 'PRM', 'PLG', 2990.00, '2010-02-23', 4500.00, 2010.00, 5000.00, 'MBL', 10.00, 'A', 'A1', '19:46', 'SALES', '34.401.21'),
(42, 'PRX', 'PLG', 4495.00, '2010-02-21', 6500.00, 1505.00, 6000.00, 'MBL', 5.00, 'A', 'A2', '06:00', 'SALES', '34.402.54'),
(43, 'PRM', 'PLG', 4980.00, '2010-02-23', 4500.00, 1020.00, 6000.00, 'MBL', 20.00, 'A', 'A1', '18:24', 'SALES', '34.401.21'),
(44, 'PRX', 'PLG', 90.00, '2010-02-23', 6500.00, 2010.00, 2100.00, 'MBL', 10.00, 'C', 'C1', '19:22', 'SALES', '34.402.54'),
(46, 'SLR', 'PLG', 3990.00, '2010-02-23', 4500.00, 2010.00, 6000.00, 'MBL', 10.00, 'B', 'B1', '20:11', 'SALES', '34.402.56'),
(47, 'PRX', 'PLG', 7980.00, '2010-02-23', 6450.00, 2020.00, 10000.00, 'MBL', 20.00, 'C', 'C1', '20:50', 'SALES', '34.401.21'),
(48, 'PRX', 'PLG', 3980.00, '2010-02-23', 6450.00, 1020.00, 5000.00, 'MBL', 20.00, 'C', 'C1', '20:51', 'SALES', '34.401.21'),
(49, 'PRM', 'PLG', 8980.00, '2010-02-23', 4500.00, 2020.00, 11000.00, 'MBL', 20.00, 'A', 'A1', '21:02', 'SALES', '34.401.21'),
(50, 'PRM', 'PLG', 9980.00, '2010-02-23', 4500.00, 2020.00, 12000.00, 'MBL', 20.00, 'A', 'A2', '21:03', 'SALES', '34.401.21'),
(51, 'PRM', 'PLG', 7980.00, '2010-02-23', 4500.00, 2020.00, 10000.00, 'MBL', 20.00, 'A', 'A3', '21:04', 'SALES', '34.401.21'),
(52, 'PRM', 'PLG', 7980.00, '2010-02-23', 4500.00, 2020.00, 10000.00, 'MBL', 20.00, 'A', 'A4', '21:05', 'SALES', '34.401.21'),
(53, 'PPL', 'PLG', 9980.00, '2010-02-23', 7000.00, 2020.00, 12000.00, 'MBL', 20.00, 'D', 'D1', '21:17', 'SALES', '34.401.21'),
(54, 'PPL', 'PLG', 5990.00, '2010-02-23', 7000.00, 1010.00, 7000.00, 'MBL', 10.00, 'D', 'D1', '21:17', 'SALES', '34.401.21'),
(55, 'PRM', 'PLG', 3990.00, '2010-02-23', 4500.00, 8010.00, 12000.00, 'MBL', 10.00, 'A', 'A1', '21:52', 'SALES', '34.401.21'),
(56, 'SLR', 'PLG', 3990.00, '2010-02-23', 4500.00, 5010.00, 9000.00, 'MBL', 10.00, 'B', 'B1', '21:56', 'SALES', '34.402.56'),
(57, 'PRX', 'PLG', 7990.00, '2010-02-23', 6300.00, 2010.00, 10000.00, 'MBL', 10.00, 'C', 'C1', '21:58', 'SALES', '34.402.56'),
(58, 'SLR', 'PLG', 11990.00, '2010-02-23', 4500.00, 2010.00, 14000.00, 'MBL', 10.00, 'B', 'B1', '22:01', 'SALES', '34.402.56'),
(59, 'PPL', 'PLG', 10990.00, '2010-02-23', 7000.00, 3010.00, 14000.00, 'MBL', 10.00, 'D', 'D1', '22:11', 'SALES', '34.401.21'),
(60, 'PRM', 'PLG', 12980.00, '2010-02-24', 4500.00, 27020.00, 40000.00, 'MBL', 20.00, 'A', 'A1', '00:03', 'SALES', '34.402.56'),
(61, 'PRX', 'PLG', 7980.00, '2010-02-24', 6300.00, 10020.00, 18000.00, 'MBL', 20.00, 'C', 'C1', '00:10', 'SALES', '34.402.56'),
(62, 'SLR', 'PLG', 19980.00, '2010-02-24', 4500.00, 40020.00, 60000.00, 'MBL', 20.00, 'B', 'B1', '00:13', 'SALES', '34.402.56'),
(63, 'PPL', 'PLG', 13980.00, '2010-02-24', 7000.00, 29020.00, 43000.00, 'MBL', 20.00, 'D', 'D1', '00:27', 'SALES', '34.402.56');

-- --------------------------------------------------------

--
-- Table structure for table `INV_MGT_PRICE`
--

CREATE TABLE IF NOT EXISTS `INV_MGT_PRICE` (
  `ID` int(11) NOT NULL auto_increment,
  `INV_TYPE` varchar(50) NOT NULL,
  `UNIT_PRICE` decimal(10,2) NOT NULL,
  `CATEGORY` varchar(10) default NULL,
  `STATION_ID` varchar(50) default NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=49 ;

--
-- Dumping data for table `INV_MGT_PRICE`
--

INSERT INTO `INV_MGT_PRICE` (`ID`, `INV_TYPE`, `UNIT_PRICE`, `CATEGORY`, `STATION_ID`) VALUES
(12, 'PRM', 4295.00, 'OWN_USE', '31.406.01'),
(11, 'PRM', 4500.00, 'SALES', '31.406.01'),
(3, 'PRM', 4500.00, 'SALES', '34.402.56'),
(4, 'SLR', 4500.00, 'SALES', '34.402.56'),
(5, 'PRX', 6300.00, 'SALES', '34.402.56'),
(6, 'PPL', 7000.00, 'SALES', '34.402.56'),
(7, 'PRM', 4300.00, 'OWN_USE', '34.402.56'),
(8, 'SLR', 4250.00, 'OWN_USE', '34.402.56'),
(9, 'PRX', 5975.00, 'OWN_USE', '34.402.56'),
(10, 'PPL', 6675.00, 'OWN_USE', '34.402.56'),
(13, 'SLR', 4500.00, 'SALES', '31.406.01'),
(14, 'SLR', 4295.00, 'OWN_USE', '31.406.01'),
(15, 'PRX', 6450.00, 'SALES', '31.406.01'),
(16, 'PRX', 6125.00, 'OWN_USE', '31.406.01'),
(17, 'PPL', 7000.00, 'SALES', '31.406.01'),
(18, 'PPL', 6650.00, 'OWN_USE', '31.406.01'),
(19, 'PRM', 4500.00, 'SALES', '34.401.21'),
(20, 'PRM', 4295.00, 'OWN_USE', '34.401.21'),
(21, 'SLR', 4500.00, 'SALES', '34.401.21'),
(22, 'SLR', 4295.00, 'OWN_USE', '34.401.21'),
(23, 'PRX', 6450.00, 'SALES', '34.401.21'),
(24, 'PRX', 6125.00, 'OWN_USE', '34.401.21'),
(25, 'PPL', 7000.00, 'SALES', '34.401.21'),
(26, 'PPL', 6675.00, 'OWN_USE', '34.401.21'),
(27, 'PRM', 4500.00, 'SALES', '34.406.06'),
(28, 'PRM', 4350.00, 'OWN_USE', '34.406.06'),
(29, 'SLR', 4500.00, 'SALES', '34.406.06'),
(30, 'SLR', 4350.00, 'OWN_USE', '34.406.06'),
(31, 'PRX', 6300.00, 'SALES', '34.406.06'),
(32, 'PRX', 6100.00, 'OWN_USE', '34.406.06'),
(33, 'PRM', 4500.00, 'SALES', '34.402.40'),
(34, 'PRM', 4250.00, 'OWN_USE', '34.402.40'),
(35, 'SLR', 4500.00, 'SALES', '34.402.40'),
(36, 'SLR', 4250.00, 'OWN_USE', '34.402.40'),
(37, 'PRX', 6300.00, 'SALES', '34.402.40'),
(38, 'PRX', 6100.00, 'OWN_USE', '34.402.40'),
(39, 'PPL', 7000.00, 'SALES', '34.402.54'),
(40, 'PPL', 6375.00, 'OWN_USE', '34.402.54'),
(41, 'PRX', 6500.00, 'SALES', '34.402.54'),
(42, 'PRX', 6250.00, 'OWN_USE', '34.402.54'),
(43, 'SLR', 4500.00, 'SALES', '34.402.54'),
(44, 'SLR', 4300.00, 'OWN_USE', '34.402.54'),
(45, 'PRM', 4500.00, 'SALES', '34.402.54'),
(46, 'PRM', 4200.00, 'OWN_USE', '34.402.54'),
(47, 'PPL', 7000.00, 'SALES', '34.406.06'),
(48, 'PPL', 6650.00, 'OWN_USE', '34.406.06');

-- --------------------------------------------------------

--
-- Table structure for table `INV_MGT_REAL_STOCK`
--

CREATE TABLE IF NOT EXISTS `INV_MGT_REAL_STOCK` (
  `ID` int(11) NOT NULL auto_increment,
  `INV_TYPE` varchar(50) NOT NULL,
  `START_DATE` datetime NOT NULL,
  `END_DATE` datetime NOT NULL,
  `QUANTITY` decimal(50,2) NOT NULL,
  `STATION_ID` varchar(50) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `INV_MGT_REAL_STOCK`
--

INSERT INTO `INV_MGT_REAL_STOCK` (`ID`, `INV_TYPE`, `START_DATE`, `END_DATE`, `QUANTITY`, `STATION_ID`) VALUES
(2, 'PRM', '2010-02-23 00:00:00', '2010-02-23 00:00:00', 50000.00, '34.401.21'),
(3, 'SLR', '2010-02-23 00:00:00', '2010-02-23 00:00:00', 21000.00, '34.401.21'),
(4, 'PRX', '2010-02-23 00:00:00', '2010-02-23 00:00:00', 12000.00, '34.401.21'),
(5, 'PPL', '2010-02-23 00:00:00', '2010-02-23 00:00:00', 17000.00, '34.401.21'),
(6, 'PPL', '2010-02-23 00:00:00', '2010-02-23 00:00:00', 5000.00, '34.406.06'),
(7, 'PPL', '2010-02-24 00:00:00', '2010-02-24 00:00:00', 14000.00, '34.402.56');

-- --------------------------------------------------------

--
-- Table structure for table `INV_MGT_SALES_ORDER`
--

CREATE TABLE IF NOT EXISTS `INV_MGT_SALES_ORDER` (
  `ID` int(11) NOT NULL auto_increment,
  `INV_TYPE` varchar(10) NOT NULL,
  `QUANTITY` decimal(50,0) NOT NULL,
  `BANK_TRANSFER_DATE` datetime NOT NULL,
  `DELIVERY_DATE` date NOT NULL,
  `DELIVERY_SHIFT_NUMBER` varchar(10) NOT NULL,
  `BANK_NAME` varchar(50) NOT NULL,
  `BANK_ACCOUNT_NUMBER` varchar(50) NOT NULL,
  `SALES_ORDER_NUMBER` varchar(50) NOT NULL,
  `STATION_ID` varchar(50) NOT NULL,
  `ORDER_MESSAGE` varchar(255) default NULL,
  `ORDER_STATUS` varchar(10) default NULL,
  `ORDER_DATE` datetime default NULL,
  `RECEIVE_DATE` datetime default NULL,
  PRIMARY KEY  (`ID`),
  UNIQUE KEY `UQ_INV_MGT_SALES_ORDER_1` (`SALES_ORDER_NUMBER`,`STATION_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=98 ;

--
-- Dumping data for table `INV_MGT_SALES_ORDER`
--

INSERT INTO `INV_MGT_SALES_ORDER` (`ID`, `INV_TYPE`, `QUANTITY`, `BANK_TRANSFER_DATE`, `DELIVERY_DATE`, `DELIVERY_SHIFT_NUMBER`, `BANK_NAME`, `BANK_ACCOUNT_NUMBER`, `SALES_ORDER_NUMBER`, `STATION_ID`, `ORDER_MESSAGE`, `ORDER_STATUS`, `ORDER_DATE`, `RECEIVE_DATE`) VALUES
(11, 'PRX', 20000, '2010-02-19 18:09:00', '2010-02-20', '4', 'BCA', '721828828', '6572777 so', '34.402.54', 'pesan pertamax bro, tolong kirim ya', 'CFM', '2010-02-20 21:10:53', '2010-02-20 21:16:13'),
(10, 'SLR', 16000, '2010-02-19 21:02:00', '2010-02-20', '1', 'mandiri', '88888', '8000778 so', '31.406.01', 'tolong kirim jam 8 pagi', 'CFM', '2010-02-20 21:03:30', '2010-02-20 21:07:32'),
(9, 'PRM', 16000, '2010-02-19 20:53:00', '2010-02-20', '1', 'mandiri', '88888', '8000777 so', '31.406.01', 'tolong dikirim jam 7 pagi', 'CFM', '2010-02-20 20:55:00', '2010-02-20 21:00:15'),
(4, 'PRM', 16000, '2010-02-19 19:07:00', '2010-02-20', '2', '234567', '6789999', '888999007', '34.402.56', 'tlg kirim setelah jam 3 sore', 'CFM', '2010-02-20 19:08:58', NULL),
(5, 'SLR', 16000, '2010-02-19 19:25:00', '2010-02-20', '1', 'Mandiri', '123456', '9876543 SO', '34.402.56', 'tlg segera kirim stok kosong', 'CFM', '2010-02-20 19:26:27', '2010-02-23 22:21:42'),
(6, 'PPL', 12000, '2010-02-19 19:52:00', '2010-02-20', '3', 'Mandiri', '123456', '14789 SO', '34.402.56', 'tolong kirim dong...', 'CFM', '2010-02-20 19:53:58', NULL),
(7, 'PRM', 16000, '2010-02-19 19:58:00', '2010-02-20', '2', 'mandiri', '45678', '778899 so', '34.402.56', 'ttlg kirom setelah jam 4 sore', 'CFM', '2010-02-20 20:01:05', NULL),
(8, 'PPL', 8000, '2010-02-19 20:03:00', '2010-02-20', '2', 'mandiri', '34567', '88887777999', '34.402.56', 'tolong kirim hari ini shift 2', 'CFM', '2010-02-20 20:04:54', NULL),
(12, 'SLR', 30000, '2010-02-19 21:21:00', '2010-02-20', '1', 'BNI', '928299', '7362728 so', '34.402.54', 'kirim cepet oeee.. depot!! solar abiss', 'PLN', '2010-02-20 21:23:04', NULL),
(13, 'PRM', 16000, '2010-02-20 21:22:00', '2010-02-21', '1', 'mandiri', '9999', '8000779 SO', '31.406.01', 'tolong dikirim', 'CFM', '2010-02-20 21:24:06', '2010-02-20 21:31:58'),
(14, 'PRX', 16000, '2010-02-21 21:33:00', '2010-02-22', '1', 'mandiri', '88888', '8000780 SO', '31.406.01', 'mohon dikirim', 'CFM', '2010-02-20 21:34:25', NULL),
(15, 'PRM', 16000, '2010-02-19 10:00:00', '2010-02-20', '2', 'Mandiri', '321456', '123654 SO', '34.402.36', 'wey kirim cepet', 'CFM', '2010-02-20 21:40:36', '2010-02-20 21:44:21'),
(16, 'SLR', 12000, '2010-02-19 09:46:00', '2010-02-20', '1', 'BCA', '789456123', '4563212 SO', '34.402.36', 'dikirim jam 3 donk...', 'CFM', '2010-02-20 21:48:09', '2010-02-20 21:53:35'),
(17, 'PPL', 16000, '2010-02-21 21:50:00', '2010-02-22', '2', 'mandiri', '88888', '8000781 SO', '31.406.01', 'minta dikirim jam 11 siang', 'CFM', '2010-02-20 21:52:27', NULL),
(18, 'PPL', 5000, '2010-02-19 21:55:00', '2010-02-20', '1', 'BNI', '12345678', '23242424 SO', '34.402.36', 'kirimdonk secepatnya', 'CFM', '2010-02-20 21:56:08', '2010-02-20 22:02:42'),
(19, 'PRM', 8000, '2010-02-19 21:55:00', '2010-02-20', '1', 'Mandiri', '4586622', '125589 SO', '34.401.21', 'bang tolong kirim dong pagi2 ya...', 'CFM', '2010-02-20 21:57:08', '2010-02-20 22:03:03'),
(20, 'PRX', 12000, '2010-02-19 22:03:00', '2010-02-20', '1', 'niaga', '32323232', '323232 SO', '34.402.36', 'tolong kirim jam 3 ', 'CFM', '2010-02-20 22:04:20', '2010-02-20 22:08:12'),
(21, 'PRM', 32000, '2010-02-19 22:04:00', '2010-02-20', '1', 'Mandiri', '4586220', '45866 SO', '34.401.21', 'minta tambah dong bang...', 'CFM', '2010-02-20 22:05:26', '2010-02-20 22:08:33'),
(22, 'SLR', 12000, '2010-02-19 22:11:00', '2010-02-20', '1', 'mandiri', '222222', '222222 SO', '34.402.36', 'kirim donk jam 08.00', 'CFM', '2010-02-20 22:12:24', '2010-02-20 22:16:33'),
(23, 'PRX', 8000, '2010-02-19 22:13:00', '2010-02-20', '1', 'BNI', '789959', '58944 SO', '34.401.21', 'segera kirim ea....', 'CFM', '2010-02-20 22:14:55', '2010-02-20 22:17:07'),
(24, 'PPL', 8000, '2010-02-18 22:17:00', '2010-02-20', '1', 'bankbankan', '7161616', '2526266 SO', '34.402.54', 'kirim ya pak', 'CFM', '2010-02-20 22:18:55', '2010-02-21 19:53:01'),
(25, 'SLR', 8000, '2010-02-19 22:19:00', '2010-02-20', '2', 'BCA', '559986', '45899 SO', '34.401.21', 'bang cepet kirim ya dah mu abis nech...', 'CFM', '2010-02-20 22:20:25', '2010-02-20 22:23:13'),
(26, 'PRM', 18000, '2010-02-19 22:19:00', '2010-02-20', '3', 'niaga', '22222', '2222 SO', '34.402.36', 'tolong kirim jam 03.00', 'CFM', '2010-02-20 22:21:01', '2010-02-20 22:24:32'),
(27, 'PPL', 18000, '2010-02-19 22:27:00', '2010-02-20', '3', 'NIAGA', '22222222', '3232323 SO', '34.402.36', 'tolong kirim jam 3 ', 'CFM', '2010-02-20 22:27:53', NULL),
(28, 'PRX', 8000, '2010-02-22 22:28:00', '2010-02-23', '1', 'mandiri', '5555', '676767', '31.406.01', 'stok kritis segera', 'CFM', '2010-02-20 22:29:15', '2010-02-20 22:33:07'),
(29, 'PRX', 8000, '2010-02-19 22:30:00', '2010-02-20', '1', 'BNI', '458996', '12589 SO', '34.402.56', 'bang cepet kirim ya...', 'CFM', '2010-02-20 22:30:37', '2010-02-20 22:33:17'),
(30, 'PPL', 8000, '2010-02-19 22:34:00', '2010-02-20', '1', 'Mandiri', '4599812', '12548 SO', '34.402.56', 'minta dikirim secepatnya', 'CFM', '2010-02-20 22:35:01', '2010-02-20 22:36:54'),
(31, 'PPL', 8000, '2010-02-01 22:38:00', '2010-02-02', '1', 'Danamon', '99999999999', '9888888 SO', '34.402.36', 'tlng...........krim.', 'CFM', '2010-02-20 22:40:10', '2010-02-20 22:43:51'),
(32, 'PRM', 12000, '2010-02-19 22:42:00', '2010-02-20', '1', 'mandiri', '23456', '2323323 SO', '34.402.36', 'tolong kirim jam 3', 'CFM', '2010-02-20 22:43:21', '2010-02-20 22:45:51'),
(33, 'PPL', 5000, '2010-02-19 09:46:00', '2010-02-20', '1', 'Mandiri', '123456', '98123 SO', '34.402.56', 'cepet dunk...', 'CFM', '2010-02-20 22:47:00', '2010-02-20 22:49:32'),
(34, 'PRM', 10000, '2010-02-19 22:52:00', '2010-02-20', '1', 'mandiri', '23457', '222222 SO', '34.401.21', 'tolong kirim jam 3', 'PLN', '2010-02-20 22:53:22', NULL),
(35, 'PPL', 8000, '2010-02-19 22:58:00', '2010-02-20', '1', 'mandiri', '122222', '2899999 SO', '34.401.21', 'tolong kirim jam 4', 'CFM', '2010-02-20 22:58:54', '2010-02-20 23:02:46'),
(36, 'PRM', 1000, '2010-02-19 23:08:00', '2010-02-20', '1', 'NIAGA', '007212', '24242323SO', '34.401.31', 'tolong kirim jam 5', 'REQ', '2010-02-20 23:09:35', NULL),
(37, 'PRM', 1000, '2010-02-19 23:11:00', '2010-02-20', '1', 'niaga', '92992929', '920200220SO', '34.402.36', 'tolong kirim jam 4', 'REQ', '2010-02-20 23:11:41', NULL),
(38, 'SLR', 8000, '2010-02-19 23:13:00', '2010-02-20', '1', 'NIAGA', '080880808', '0090909 SO', '34.402.36', 'tolong kirim jam 5', 'REQ', '2010-02-20 23:14:33', NULL),
(39, 'PPL', 5000, '2010-02-19 23:17:00', '2010-02-20', '1', 'NIAGA', '455555', '466666 SO', '34.402.36', 'tolong kirim jam 3\r\n', 'REQ', '2010-02-20 23:17:41', NULL),
(40, 'SLR', 16000, '2010-02-20 23:19:00', '2010-02-21', '1', 'bank-ku', '726226', '13131 So', '34.402.56', 'cepet yeee', 'CFM', '2010-02-20 23:20:22', '2010-02-20 23:23:28'),
(41, 'PRM', 20000, '2010-02-19 09:19:00', '2010-02-20', '2', 'Mandiri', '789456123', '1245555 SO', '34.406.06', 'order dongk...', 'CFM', '2010-02-20 23:21:08', NULL),
(42, 'SLR', 1000, '2010-02-19 23:24:00', '2010-02-20', '1', 'NIAGA', '323232', '424242SO', '34.402.36', 'tolong kirim jam 3', 'REQ', '2010-02-20 23:25:11', NULL),
(43, 'PPL', 10000, '2010-02-20 23:26:00', '2010-02-20', '1', 'Mandiri', '789456123', '156666', '34.406.06', 'pesen donk...', 'CFM', '2010-02-20 23:25:44', NULL),
(44, 'SLR', 1000, '2010-02-19 23:26:00', '2010-02-20', '1', 'NIAGA', '2999002', '8999997SO', '34.402.36', 'tolong kirim jam 3', 'REQ', '2010-02-20 23:27:21', NULL),
(45, 'SLR', 10000, '2010-02-19 23:28:00', '2010-02-20', '1', 'Mandiri', '989898989', '32323232SO', '34.402.36', 'tolongkirim jam 3', 'CFM', '2010-02-20 23:29:27', NULL),
(46, 'SLR', 24000, '2010-02-20 16:25:00', '2010-02-21', '3', 'mandiri syariah', '661717', '782828 SO', '34.406.06', 'tolong kirim yaa... cepetan...', 'CFM', '2010-02-21 16:26:39', '2010-02-21 16:30:40'),
(47, 'PRX', 8000, '2010-02-20 16:27:00', '2010-02-21', '1', '3232323', '32323322', '3232332SO', '34.402.36', 'tolong kirim jam 4', 'REQ', '2010-02-21 16:28:09', NULL),
(48, 'PPL', 8000, '2010-02-20 16:30:00', '2010-02-21', '1', '3333333', '3333333', '4444444SO', '34.402.56', 'tolong kirim ', 'CFM', '2010-02-21 16:30:37', NULL),
(49, 'PRX', 24000, '2010-02-20 16:34:00', '2010-02-21', '1', 'BCA', '12399999', '999888 SO', '34.406.06', 'dikirimmcepatm donk, lg kritis nih...', 'CFM', '2010-02-21 16:36:23', '2010-02-21 16:39:47'),
(50, 'SLR', 8000, '2010-02-20 16:37:00', '2010-02-21', '1', 'NIAGA', '9898989898', '232323232SO', '34.402.56', 'tolong kirim jam 3\r\n', 'CFM', '2010-02-21 16:38:11', '2010-02-21 16:41:32'),
(51, 'PPL', 20000, '2010-02-20 16:41:00', '2010-02-21', '1', 'Mandiri', '111111111', '12345 SO', '34.402.56', 'Tolong Di kirim', 'CFM', '2010-02-21 16:42:15', NULL),
(52, 'SLR', 15000, '2010-02-20 09:47:00', '2010-02-21', '1', 'Mandiri', '121212', '147852 SO', '34.402.56', 'Hbis Nie ', 'CFM', '2010-02-21 16:48:28', '2010-02-21 17:53:33'),
(53, 'PPL', 15000, '2010-02-21 16:51:00', '2010-02-21', '1', 'Mandiri', '1222333', '000999 SO', '34.402.56', 'help me seep yeuh', 'CFM', '2010-02-21 16:52:22', NULL),
(54, 'PRM', 25000, '2010-02-21 16:56:00', '2010-02-22', '1', 'Mandiri', '11111100', '444444 SO', '34.402.56', '', 'CFM', '2010-02-21 16:57:46', '2010-02-21 17:01:26'),
(55, 'PPL', 8000, '2010-02-20 17:09:00', '2010-02-21', '1', 'niaga', '007', '212SO', '34.402.56', 'tolong kirim jam 3', 'CFM', '2010-02-21 17:11:12', NULL),
(56, 'PPL', 16000, '2010-02-20 17:24:00', '2010-02-21', '1', 'Mandiri', '459866', '124566 SO', '34.401.21', 'bang kirim cepet ya....', 'CFM', '2010-02-21 17:25:25', NULL),
(57, 'PPL', 16000, '2010-02-20 17:40:00', '2010-02-21', '1', 'BNI', '459998', '798822 SO', '34.401.21', 'tolong kirim ya bang...', 'PLN', '2010-02-21 17:41:32', NULL),
(58, 'PPL', 19000, '2010-02-20 10:52:00', '2010-02-21', '2', 'BCA', '3333333', '212333 SO', '34.406.06', 'order cepet donk...', 'CFM', '2010-02-21 17:53:43', NULL),
(59, 'PPL', 8000, '2010-02-20 17:54:00', '2010-02-21', '1', 'BCA', '4599989', '555 A SO', '34.401.21', 'bang tolong kirim sesuai kp tangki', 'CFM', '2010-02-21 17:56:07', '2010-02-21 18:03:38'),
(60, 'PPL', 8000, '2010-02-20 17:56:00', '2010-02-21', '1', 'BCA', '4599989', '555 B SO', '34.401.21', 'bang tolong kirim sesuai kp tangkiku ya', 'CFM', '2010-02-21 17:57:05', '2010-02-21 18:10:50'),
(61, 'PRM', 18000, '2010-02-20 09:01:00', '2010-02-21', '1', 'BCA', '1236999', '21222254  SO', '34.406.06', 'order', 'REQ', '2010-02-21 18:03:19', NULL),
(62, 'PPL', 6000, '2010-02-20 09:18:00', '2010-02-21', '2', 'BCA', '11122345', '123456SO', '34.402.56', 'tolong kirim', 'CFM', '2010-02-21 18:19:28', '2010-02-21 18:23:45'),
(63, 'PRM', 8000, '2010-02-20 13:31:00', '2010-02-21', '2', 'Mandiri', '000000', '222222 A SO', '34.406.06', 'Tolong dikirim langsung ya ret II', 'CFM', '2010-02-21 18:32:51', '2010-02-21 18:41:01'),
(64, 'PRM', 8000, '2010-02-20 18:34:00', '2010-02-21', '2', 'Mandiri', '000000', '222222 B SO', '34.406.06', 'Tolong dikirim sekarang ya ret II Ok', 'CFM', '2010-02-21 18:35:10', '2010-02-21 18:43:29'),
(65, 'PPL', 8000, '2010-02-20 18:39:00', '2010-02-21', '1', 'BCA', '11122345', '75554444SO', '34.402.56', 'tolong kirim jam 9 pagi', 'CFM', '2010-02-21 18:40:04', '2010-02-21 18:46:00'),
(66, 'PRM', 8000, '2010-02-21 18:47:00', '2010-02-21', '1', 'Mandiri', '4444', '5555 A SO', '34.406.06', 'Tolong Kirim ya CANTIK', 'CFM', '2010-02-21 18:47:57', '2010-02-21 19:09:41'),
(67, 'PPL', 8000, '2010-02-20 09:51:00', '2010-02-21', '1', 'Mandiri', '124333', '236900SO', '34.402.56', 'Tolong segera dikirm jam 9 pagi', 'CFM', '2010-02-21 18:51:59', '2010-02-21 18:54:28'),
(68, 'PPL', 8000, '2010-02-20 18:54:00', '2010-02-21', '3', 'Miun', '985564', '456698 SO', '34.401.21', 'kang nyungken dikirim nya anu enggal', 'CFM', '2010-02-21 18:54:57', '2010-02-21 19:01:37'),
(69, 'PRM', 8000, '2010-02-20 18:54:00', '2010-02-21', '1', 'Mandiri', '23232', '99999 SO', '34.406.06', 'Tolong Dikirim PAK', 'CFM', '2010-02-21 18:55:09', '2010-02-21 19:10:39'),
(70, 'PPL', 8000, '2010-02-20 19:02:00', '2010-02-21', '1', 'BNI', '459996', '98666 SO', '34.401.21', 'akang cepetan ya kirim tong lami-lami teuing ach>>>', 'CFM', '2010-02-21 19:03:01', '2010-02-21 19:05:01'),
(71, 'PRM', 8000, '2010-02-20 19:04:00', '2010-02-21', '1', 'Mandiri', '33333', '888888', '34.406.06', 'Pak Tolong dikirim', 'CFM', '2010-02-21 19:04:54', '2010-02-21 19:10:23'),
(72, 'SLR', 8000, '2010-02-20 19:04:00', '2010-02-21', '1', 'Mandiri', '8888', '33333 SO', '34.406.06', 'Pak Tolong dikirim PAK', 'CFM', '2010-02-21 19:05:25', '2010-02-21 19:10:04'),
(73, 'PRX', 8000, '2010-02-20 19:05:00', '2010-02-21', '1', 'm', '8888', '333033 SO', '34.406.06', 'Pak Tolong dikirim PAK', 'CFM', '2010-02-21 19:06:07', '2010-02-21 19:11:02'),
(74, 'PRX', 8000, '2010-02-21 19:14:00', '2010-02-21', '1', 'Mandiri', '89898', '444444 A SO', '34.406.06', 'kirim lagi dong PAK', 'CFM', '2010-02-21 19:15:06', '2010-02-21 19:17:04'),
(75, 'PRX', 8000, '2010-02-20 09:14:00', '2010-02-21', '1', 'BNI', '12300066', '123600 A SO', '34.406.06', 'tolong kirim cepet', 'CFM', '2010-02-21 19:16:45', '2010-02-21 19:21:09'),
(76, 'PPL', 8000, '2010-02-20 19:21:00', '2010-02-21', '1', 'BNI', '983838', '12133 A SO', '34.402.54', 'tolong kirimmmm', 'CFM', '2010-02-21 19:22:34', '2010-02-21 19:28:38'),
(77, 'PPL', 8000, '2010-02-20 19:54:00', '2010-02-21', '1', 'BNI', '9117171', '454545 A SO', '34.402.54', 'tolong kirim segera', 'CFM', '2010-02-21 19:55:13', '2010-02-23 19:50:15'),
(78, 'PRX', 8000, '2010-02-22 19:16:00', '2010-02-23', '1', 'mandiri', '12121212', '333333 A SO', '34.402.54', 'Tolong dikirim Jam 8 pagi', 'CFM', '2010-02-23 19:17:34', '2010-02-23 19:49:48'),
(79, 'PRX', 8000, '2010-02-22 19:17:00', '2010-02-23', '1', 'mandiri', '12121212', '333333 B SO', '34.402.54', 'Tolong dikirim Jam 8 pagi ya', 'CFM', '2010-02-23 19:18:34', '2010-02-23 19:50:51'),
(80, 'PRX', 8000, '2010-02-22 19:18:00', '2010-02-23', '1', 'mandiri', '12121212', '333333 C SO', '34.402.54', 'Tolong dikirim Jam 8 pagi ya Pak', 'CFM', '2010-02-23 19:19:04', '2010-02-23 19:50:35'),
(81, 'PPL', 8000, '2010-02-22 19:52:00', '2010-02-23', '1', 'BNI', '4889787', '34550 A SO', '34.401.21', 'tolong segera kirim ya...', 'CFM', '2010-02-23 19:53:34', NULL),
(82, 'PPL', 8000, '2010-02-23 19:53:00', '2010-02-23', '1', 'BNI', '68999', '34550 B SO', '34.401.21', 'tolong segera dikirim...', 'CFM', '2010-02-23 19:54:40', NULL),
(83, 'PRX', 8000, '2010-02-23 20:55:00', '2010-02-23', '1', 'BCA', '4889787', '123456 A SO', '34.401.21', 'tolong segera dikirim udah kehabisan stok nih...', 'CFM', '2010-02-23 20:54:22', '2010-02-23 20:58:04'),
(84, 'PRX', 8000, '2010-02-22 08:55:00', '2010-02-23', '1', 'BCA', '4889787', '123456 B SO', '34.401.21', 'tolong segera dikirim udah kehabisan stok nih pak...', 'CFM', '2010-02-23 20:57:00', '2010-02-23 21:00:35'),
(85, 'PRM', 8000, '2010-02-22 09:07:00', '2010-02-23', '1', 'BNI', '12345123', '654321 A SO', '34.401.21', 'kirim cepet jam 8 pagi...', 'CFM', '2010-02-23 21:09:05', '2010-02-23 21:11:54'),
(86, 'PRM', 8000, '2010-02-22 09:09:00', '2010-02-23', '1', 'BNI', '12345123', '654321 B SO', '34.401.21', 'kirim cepet jam 8 pagi ya...', 'CFM', '2010-02-23 21:09:50', '2010-02-23 21:12:53'),
(87, 'PRM', 8000, '2010-02-22 09:09:00', '2010-02-23', '1', 'BNI', '12345123', '654321 C SO', '34.401.21', 'kirim cepet jam 8 pagi ya pak...', 'CFM', '2010-02-23 21:10:15', '2010-02-23 21:15:03'),
(88, 'PPL', 8000, '2010-02-22 09:18:00', '2010-02-23', '1', 'BCA', '12345123', '123400 A SO', '34.401.21', 'tolong segera dikirim jam 8', 'CFM', '2010-02-23 21:19:25', NULL),
(89, 'PPL', 8000, '2010-02-22 09:19:00', '2010-02-23', '1', 'BCA', '12345123', '123400 B SO', '34.401.21', 'tolong segera dikirim jam 8 ya ', 'CFM', '2010-02-23 21:20:38', '2010-02-23 21:24:59'),
(90, 'PPL', 8000, '2010-02-22 21:44:00', '2010-02-23', '1', 'BNI', '123456', '12345', '34.401.21', 'tolong segera kirim ya...', 'CFM', '2010-02-23 21:45:09', '2010-02-23 21:51:56'),
(91, 'PRX', 8000, '2010-02-22 22:05:00', '2010-02-23', '1', 'BNI', '556889', '098876 SO', '34.402.56', 'tolong segera dikirim,,,', 'CFM', '2010-02-23 22:05:52', '2010-02-23 22:16:22'),
(92, 'SLR', 8000, '2010-02-22 22:06:00', '2010-02-23', '1', 'BNI', '445666', '288900 SO', '34.402.56', 'tolong segera dikirim...', 'PLN', '2010-02-23 22:06:52', NULL),
(93, 'SLR', 8000, '2010-02-22 22:08:00', '2010-02-23', '1', 'Mandiri', '667599', '467785 SO', '34.402.56', 'tolong segera dikirim..', 'REQ', '2010-02-23 22:09:28', NULL),
(94, 'PPL', 8000, '2010-02-22 22:13:00', '2010-02-23', '1', 'BRI', '588896', '45009 SO', '34.401.21', 'tolong segera dikirim...', 'CFM', '2010-02-23 22:14:22', '2010-02-23 22:24:14'),
(95, 'PRM', 8000, '2010-02-23 00:07:00', '2010-02-24', '1', 'mandiri', '123333', '666666 SO', '34.402.56', 'Pak tolong dikirim ya', 'REQ', '2010-02-24 00:08:31', NULL),
(96, 'SLR', 8000, '2010-02-23 00:09:00', '2010-02-24', '1', 'mandiri', '111111', '777777', '34.402.56', 'Tolong dikirm sudah habis nie', 'REQ', '2010-02-24 00:10:04', NULL),
(97, 'PPL', 8000, '2010-02-23 00:28:00', '2010-02-24', '2', 'mandiri', '99999', '09090 SO', '34.402.56', 'Pak Tolong dikirim ya', 'CFM', '2010-02-24 00:29:27', '2010-02-24 00:37:35');

-- --------------------------------------------------------

--
-- Table structure for table `INV_MGT_STATION`
--

CREATE TABLE IF NOT EXISTS `INV_MGT_STATION` (
  `ID` int(11) NOT NULL auto_increment,
  `STATION_ID` varchar(50) NOT NULL,
  `STATION_ADDRESS` varchar(50) default NULL,
  `LOCATION_CODE` varchar(50) NOT NULL,
  `SUPPLY_POINT_DISTANCE` decimal(50,2) default NULL,
  `MAX_TOLERANCE` decimal(50,2) default NULL,
  `STATION_STATUS` varchar(50) default NULL,
  PRIMARY KEY  (`ID`),
  UNIQUE KEY `UQ_INV_MGT_STATION_1` (`STATION_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `INV_MGT_STATION`
--

INSERT INTO `INV_MGT_STATION` (`ID`, `STATION_ID`, `STATION_ADDRESS`, `LOCATION_CODE`, `SUPPLY_POINT_DISTANCE`, `MAX_TOLERANCE`, `STATION_STATUS`) VALUES
(4, '34.402.56', 'Jl. Peta No. 142-144 Bandung', 'BDG', 18.00, 80.00, 'REGISTERED'),
(5, '34.403.25', 'Jl. Raya Kopo Kec. Ciparay', 'BDG', 23.00, 75.00, 'REGISTERED'),
(6, '34.401.02', 'jl.Wastu Kencana No. 36 Bandung', 'BDG', 18.00, 80.00, 'REGISTERED'),
(7, '34.403.31', 'Jl. Raya Cicalengka Nagrek Kab. Bandung', 'BDG.KAB', 26.00, 90.00, 'REGISTERED'),
(8, '34.401.10', 'jl.jend. Ahmad Yani No. 277 Bandung', 'BDG', 15.00, 70.00, 'REGISTERED'),
(9, '34.406.06', 'Jl. Rumah Sakit Bandung', 'BDG', 5.00, 45.00, 'REGISTERED'),
(10, '34.401.19', 'jl. Brigjen Katamso', 'BDG', 21.00, 110.00, 'REGISTERED'),
(11, '34.401.21', 'jl. Cihamplas No. 175', 'BDG', 22.00, 120.00, 'REGISTERED'),
(12, '34.409.04', 'Jl. Raya Soreang Km. 16', 'BDG', 26.00, 90.00, 'REGISTERED'),
(13, '34.401.27', 'jl. Tamblong No. 3 Bdg', 'BDG', 16.00, 60.00, 'REGISTERED'),
(14, '34.401.28', 'jl. Surapati No. 119 Bdg', 'BDG', 17.00, 70.00, 'REGISTERED'),
(15, '34.401.31', 'jl. Garuda No. 92 Bandung', 'BDG', 20.00, 100.00, 'REGISTERED'),
(16, '34.401.32', 'jl. Setiabudhi No. 128 Bdg', 'BDG', 27.00, 170.00, 'REGISTERED'),
(17, '34.401.33', 'jl. Martadinata No. 79 Bandung', 'BDG', 14.00, 40.00, 'REGISTERED'),
(18, '34.402.12', 'jl. Terusan Buah Batu Cipagalo Bandung', 'BDG', 10.00, 12.00, 'REGISTERED'),
(19, '34.402.17', 'jl. Raya BKR No. 78A', 'BDG', 16.00, 60.00, 'REGISTERED'),
(20, '34.402.20', 'jl. Purwakarta No. 1 Antapani Bandung', 'BDG', 13.00, 30.00, 'REGISTERED'),
(21, '34.402.21', 'jl.Raya Cibaduyut ', 'BDG', 14.00, 40.00, 'REGISTERED'),
(22, '34.402.23', 'jl.Kopo Sayati ', 'BDG', 17.00, 70.00, 'REGISTERED'),
(23, '34.402.25', 'jl. Soekarno Hatta  556', 'BDG', 7.00, 25.00, 'REGISTERED'),
(24, '34.402.26', 'jl. Cipamokolan No. 9', 'BDG', 4.00, 25.00, 'REGISTERED'),
(25, '34.402.30', 'jl. Laswi No. 61 Bandung', 'BDG', 12.00, 40.00, 'REGISTERED'),
(26, '34.402.34', 'jl. Terusan Jakarta Bandung', 'BDG', 13.00, 50.00, 'REGISTERED'),
(27, '34.402.35', 'jl. Ciwastra No. 263 Bandung', 'BDG', 7.00, 25.00, 'REGISTERED'),
(28, '34.402.36', 'jl. Laswi No. 136-140 Bandung', 'BDG', 14.00, 40.00, 'REGISTERED'),
(29, '34.402.38', 'jl. Terusan Buah Batu No. 55-57 Bdg', 'BDG', 10.00, 25.00, 'REGISTERED'),
(30, '34.402.40', 'jl. Raya Dayeuhkolot 18-20 Bandung', 'BDG', 13.00, 35.00, 'REGISTERED'),
(31, '34.402.44', 'jl. AH Nasution No. 940-944 Bdg', 'BDG', 13.00, 35.00, 'REGISTERED'),
(32, '34.402.47', 'jl. Ibrahim Adjie No. 135 Bandung', 'BDG', 13.00, 35.00, 'REGISTERED'),
(33, '34.402.49', 'jl. Jend. Ahmad Yani Bandung', 'BDG', 15.00, 45.00, 'REGISTERED'),
(34, '34.402.52', 'jl. Kopo Bihbul No. 88', 'BDG', 15.00, 45.00, 'REGISTERED'),
(35, '34.402.54', 'jl. Moch. Ramdan No. 92 Bandung', 'BDG', 17.00, 60.00, 'REGISTERED'),
(36, '31.406.01', 'Jl. Soekarno Hatta no.728', 'BDG', 1.00, 10.00, 'REGISTERED');

-- --------------------------------------------------------

--
-- Table structure for table `INV_MGT_SUPPLY`
--

CREATE TABLE IF NOT EXISTS `INV_MGT_SUPPLY` (
  `ID` int(11) NOT NULL auto_increment,
  `INV_TYPE` varchar(50) NOT NULL,
  `SUPPLY_VALUE` decimal(50,2) NOT NULL,
  `SUPPLY_DATE` date NOT NULL,
  `DELIVERY_ORDER_NUMBER` varchar(20) NOT NULL,
  `PLATE_NUMBER` varchar(20) default NULL,
  `NIAP_NUMBER` varchar(20) default NULL,
  `STATION_ID` varchar(50) default NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=81 ;

--
-- Dumping data for table `INV_MGT_SUPPLY`
--

INSERT INTO `INV_MGT_SUPPLY` (`ID`, `INV_TYPE`, `SUPPLY_VALUE`, `SUPPLY_DATE`, `DELIVERY_ORDER_NUMBER`, `PLATE_NUMBER`, `NIAP_NUMBER`, `STATION_ID`) VALUES
(1, 'PRM', 24000.00, '2010-02-19', '12345 SO', 'D 4567', '012345689', '34.402.56'),
(2, 'SLR', 16000.00, '2010-02-19', '54321 SO', 'D 4567', '012345689', '34.402.56'),
(3, 'PRX', 8000.00, '2010-02-19', '6789 SO', 'D 4567', '012345689', '34.402.56'),
(4, 'PPL', 7500.00, '2010-02-19', '12365 SO', 'D 4567', '012345689', '34.402.56'),
(5, 'PRM', 18331.00, '2010-01-01', 'STOK AWL', 'STOCK AWL', 'BY PIPE', '31.406.01'),
(6, 'SLR', 22307.70, '2010-01-01', 'STOK AWL', 'STOCK AWL', 'BY PIPE', '31.406.01'),
(7, 'PRX', 6681.70, '2010-01-01', 'STOK AWL', 'STOCK AWL', 'BY PIPE', '31.406.01'),
(8, 'PPL', 14049.80, '2010-01-01', 'STOK AWL', 'STOCK AWL', 'BY PIPE', '31.406.01'),
(9, 'PRM', 16000.00, '2010-02-20', '8000777 so', 'D 3456 DD', '2345', '31.406.01'),
(10, 'SLR', 16000.00, '2010-02-20', '8000778 so', 'D 1234 ', '4444', '31.406.01'),
(64, 'PRX', 5000.00, '2010-02-21', 'per tgl 21 ', 'STOK AWL', 'stok awal', '34.402.54'),
(12, 'PRM', 16000.00, '2010-02-20', '8000779 SO', 'D 999', '7676', '31.406.01'),
(13, 'PRM', 16000.00, '2010-02-20', '123654 SO', 'D 9995', '012345689', '34.402.36'),
(14, 'PRM', 16000.00, '2010-02-19', '45665', 'D 2258 MM', '12345', '34.401.21'),
(15, 'SLR', 16000.00, '2010-02-19', '5589', 'D 2258 MM', '12356', '34.401.21'),
(16, 'PRX', 16000.00, '2010-02-19', '5588', 'D 2258 MM', '12354', '34.401.21'),
(17, 'PPL', 16000.00, '2010-02-19', '5583', 'D 2258 MM', '12357', '34.401.21'),
(18, 'SLR', 12000.00, '2010-02-20', '4563212 SO', 'D 4567', '1112234', '34.402.36'),
(19, 'PPL', 5000.00, '2010-02-20', '23242424 SO', 'D 434343', 'ssss', '34.402.36'),
(20, 'PRM', 8000.00, '2010-02-20', '125589 SO', 'D 2258 MM', '45888', '34.401.21'),
(21, 'PRX', 12000.00, '2010-02-20', '323232 SO', 'D 4444', '322332', '34.402.36'),
(22, 'PRM', 32000.00, '2010-02-20', '45866 SO', 'D 5486 AA', '12358', '34.401.21'),
(23, 'SLR', 12000.00, '2010-02-20', '222222 SO', 'D55555', '3232', '34.402.36'),
(24, 'PRX', 8000.00, '2010-02-20', '58944 SO', 'D 4589 NN', '65899', '34.401.21'),
(25, 'SLR', 8000.00, '2010-02-20', '45899 SO', 'D 4588 JJ', '459986', '34.401.21'),
(26, 'PRM', 18000.00, '2010-02-20', '2222 SO', 'D34444', '3333', '34.402.36'),
(27, 'PRX', 8000.00, '2010-02-20', '676767', '5656', '34343', '31.406.01'),
(28, 'PRX', 8000.00, '2010-02-20', '12589 SO', 'D 2258 MM', '58966', '34.402.56'),
(29, 'PPL', 8000.00, '2010-02-20', '12548 SO', 'D 4589 NN', '65981', '34.402.56'),
(30, 'PPL', 8000.00, '2010-02-20', '9888888 SO', 'D 3949', '111111111', '34.402.36'),
(31, 'PRM', 12000.00, '2010-02-20', '2323323 SO', 'D2345', '343432', '34.402.36'),
(32, 'PPL', 5000.00, '2010-02-20', '98123 SO', 'D 12343', '121222', '34.402.56'),
(33, 'PPL', 8000.00, '2010-02-20', '2899999 SO', 'D3333', '43343', '34.401.21'),
(34, 'PRM', 20000.00, '2010-02-18', 'Stok Awal', 'D 4567', 'Stok Awal', '34.406.06'),
(35, 'SLR', 15000.00, '2010-02-18', 'Stok Awal', 'D 4567', 'Stok Awal', '34.406.06'),
(36, 'PRX', 10000.00, '2010-02-18', 'Stok Awal', 'D 4567', 'Stok Awal', '34.406.06'),
(37, 'SLR', 16000.00, '2010-02-20', '13131 So', 'B 1223 AK', '5655', '34.402.56'),
(38, 'SLR', 24000.00, '2010-02-21', '782828 SO', 'G 1167 YU', '2121', '34.406.06'),
(39, 'PRX', 24000.00, '2010-02-21', '999888 SO', 'D 1234 SS', '12225', '34.406.06'),
(40, 'PRM', 3000.00, '2010-02-21', 'per tgl 21 feb', 'STOK AWL', 'stok awl', '34.401.21'),
(41, 'SLR', 8000.00, '2010-02-21', '232323232SO  	', 'D44444', '77777', '34.402.56'),
(42, 'PRM', 25000.00, '2010-02-21', '444444 SO', 'D 8888 FE', '676767', '34.402.56'),
(43, 'SLR', 15000.00, '2010-02-21', '147852 SO', 'D 2333 GF', '42343', '34.402.56'),
(44, 'PPL', 8000.00, '2010-02-21', '555 A SO', 'D 5589 AA', '465999', '34.401.21'),
(45, 'PPL', 8000.00, '2010-02-21', '98662 DO', 'D 5555', '98556', '34.401.21'),
(46, 'PPL', 6000.00, '2010-02-21', '123456SO', 'D 2121  WR', '1234', '34.402.56'),
(47, 'PRM', 8000.00, '2010-02-21', '222222 A SO', 'D 689 MM', '09090', '34.406.06'),
(48, 'PRM', 8000.00, '2010-02-21', '222222 B SO', 'D 6589 WW', '3333', '34.406.06'),
(49, 'PPL', 8000.00, '2010-02-21', '75554444SO', 'D 2121  WR', '1323', '34.402.56'),
(50, 'PPL', 8000.00, '2010-02-21', '236900SO', 'D3333', '124000', '34.402.56'),
(51, 'PPL', 8000.00, '2010-02-21', '456698 SO', 'D3333', '35646', '34.401.21'),
(52, 'PPL', 8000.00, '2010-02-21', '98666 SO', 'D333', '12345', '34.401.21'),
(53, 'PRM', 8000.00, '2010-02-21', '5555 A SO', 'D444', '6666', '34.406.06'),
(54, 'SLR', 8000.00, '2010-02-21', '33333 SO', 'D 6589 WW', '333333', '34.406.06'),
(55, 'PRM', 8000.00, '2010-02-21', '888888', 'D3333', '5656', '34.406.06'),
(56, 'PRM', 8000.00, '2010-02-21', '99999 SO', 'DEEE', '787878', '34.406.06'),
(57, 'PRX', 8000.00, '2010-02-21', '333033 SO', 'D4444', '565656', '34.406.06'),
(58, 'PRX', 8000.00, '2010-02-21', '444444 A SO', 'D3333', '66666', '34.406.06'),
(59, 'PRX', 8000.00, '2010-02-21', '123600 A SO', 'D3333', '12356', '34.406.06'),
(63, 'PPL', 8000.00, '2010-02-21', 'per tgl 21 ', 'STOK AWL', 'stok awal', '34.402.54'),
(61, 'PRM', 21000.00, '2010-02-21', 'per tgl 21 ', 'STOK AWL', 'stok awal', '34.402.54'),
(62, 'SLR', 15000.00, '2010-02-21', 'per tgl 21 ', 'STOK AWL', 'stok awal', '34.402.54'),
(65, 'PPL', 8000.00, '2010-02-21', '2526266 SO', 'D 9995', '1111', '34.402.54'),
(66, 'PRX', 8000.00, '2010-02-23', '333333 A SO', 'D 9090 JI', '6500048', '34.402.54'),
(67, 'PPL', 8000.00, '2010-02-23', '454545 A SO', 'D 8884', '200998', '34.402.54'),
(68, 'PRX', 8000.00, '2010-02-23', '333333 C SO', 'D 4090 MM', '565400', '34.402.54'),
(69, 'PRX', 8000.00, '2010-02-23', '333333 B SO', 'D 3000 KL', '36994', '34.402.54'),
(70, 'PRX', 8000.00, '2010-02-23', '123456 A', 'D1234', '12345612', '34.401.21'),
(71, 'PRX', 8000.00, '2010-02-23', '123456 B SO', 'D 3000 KL', '12345611', '34.401.21'),
(72, 'PRM', 8000.00, '2010-02-23', '654321 A SO', 'D2325', '12345613', '34.401.21'),
(73, 'PRM', 8000.00, '2010-02-23', '654321 B SO', 'D333', '12345614', '34.401.21'),
(74, 'PRM', 8000.00, '2010-02-23', '654321 C SO', 'D3333', '12345615', '34.401.21'),
(75, 'PPL', 8000.00, '2010-02-23', '123400 B SO', 'D 6565 FE', '12345617', '34.401.21'),
(76, 'PPL', 8000.00, '2010-02-23', '12345', 'D 1212 MM', '49905', '34.401.21'),
(77, 'PRX', 8000.00, '2010-02-23', '098876 SO', 'D 5656 KL', '456660', '34.402.56'),
(78, 'SLR', 16000.00, '2010-02-23', '9876543 SO', 'D 9995', '568889', '34.402.56'),
(79, 'PPL', 8000.00, '2010-02-23', '45009 SO', 'D 1111 HG', '23778', '34.401.21'),
(80, 'PPL', 8000.00, '2010-02-24', '09090 SO', 'D 3434 FE', '5555', '34.402.56');

-- --------------------------------------------------------

--
-- Table structure for table `INV_MGT_TANK_CAPACITY`
--

CREATE TABLE IF NOT EXISTS `INV_MGT_TANK_CAPACITY` (
  `ID` int(11) NOT NULL auto_increment,
  `INV_TYPE` varchar(50) NOT NULL,
  `TANK_CAPACITY` decimal(50,2) NOT NULL,
  `STATION_ID` varchar(50) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=94 ;

--
-- Dumping data for table `INV_MGT_TANK_CAPACITY`
--

INSERT INTO `INV_MGT_TANK_CAPACITY` (`ID`, `INV_TYPE`, `TANK_CAPACITY`, `STATION_ID`) VALUES
(13, 'PRX', 30000.00, '34.406.06'),
(12, 'SLR', 30000.00, '34.406.06'),
(11, 'PRM', 30000.00, '34.406.06'),
(10, 'SLR', 20000.00, '34.409.04'),
(9, 'PRM', 60000.00, '34.409.04'),
(14, 'PRM', 30000.00, '34.402.56'),
(15, 'SLR', 30000.00, '34.402.56'),
(16, 'PRX', 15000.00, '34.402.56'),
(17, 'PPL', 15000.00, '34.402.56'),
(18, 'PRM', 60000.00, '34.401.02'),
(19, 'SLR', 30000.00, '34.401.02'),
(20, 'PRX', 20000.00, '34.401.02'),
(21, 'PPL', 20000.00, '34.401.02'),
(22, 'PRM', 45000.00, '34.401.10'),
(23, 'SLR', 45000.00, '34.401.10'),
(24, 'PRX', 30000.00, '34.401.10'),
(25, 'PPL', 30000.00, '34.401.10'),
(26, 'PRM', 60000.00, '34.401.21'),
(27, 'SLR', 30000.00, '34.401.21'),
(28, 'PRX', 20000.00, '34.401.21'),
(29, 'PPL', 20000.00, '34.401.21'),
(30, 'PRM', 45000.00, '34.401.27'),
(31, 'SLR', 45000.00, '34.401.27'),
(32, 'PRX', 30000.00, '34.401.27'),
(33, 'PPL', 30000.00, '34.401.27'),
(34, 'PRM', 30000.00, '34.401.28'),
(35, 'SLR', 20000.00, '34.401.28'),
(36, 'PRX', 20000.00, '34.401.28'),
(37, 'PPL', 20000.00, '34.401.28'),
(38, 'PRM', 60000.00, '34.401.31'),
(39, 'SLR', 30000.00, '34.401.31'),
(40, 'PRX', 20000.00, '34.401.31'),
(41, 'PRM', 60000.00, '34.401.32'),
(42, 'SLR', 30000.00, '34.401.32'),
(43, 'PRX', 30000.00, '34.401.32'),
(44, 'PPL', 30000.00, '34.401.32'),
(45, 'PRM', 30000.00, '34.402.12'),
(46, 'SLR', 30000.00, '34.402.12'),
(47, 'PRX', 15000.00, '34.402.12'),
(48, 'PRM', 80000.00, '34.402.20'),
(49, 'SLR', 30000.00, '34.402.20'),
(50, 'PRX', 20000.00, '34.402.20'),
(51, 'PRM', 48000.00, '34.402.21'),
(52, 'SLR', 32000.00, '34.402.21'),
(53, 'PRM', 50000.00, '34.402.23'),
(54, 'SLR', 30000.00, '34.402.23'),
(55, 'PRX', 15000.00, '34.402.23'),
(56, 'PPL', 15000.00, '34.402.23'),
(57, 'PRM', 45000.00, '34.402.30'),
(58, 'SLR', 20000.00, '34.402.30'),
(59, 'PRX', 20000.00, '34.402.30'),
(60, 'PRM', 52000.00, '34.402.34'),
(61, 'PRX', 20000.00, '34.402.34'),
(62, 'PRM', 75000.00, '34.402.36'),
(63, 'SLR', 45000.00, '34.402.36'),
(64, 'PRX', 30000.00, '34.402.36'),
(65, 'PPL', 20000.00, '34.402.36'),
(66, 'PRM', 32000.00, '34.402.38'),
(67, 'SLR', 32000.00, '34.402.38'),
(68, 'PRX', 20000.00, '34.402.38'),
(69, 'PRM', 77000.00, '34.402.44'),
(70, 'SLR', 45000.00, '34.402.44'),
(71, 'PRX', 32000.00, '34.402.44'),
(72, 'PRM', 62000.00, '34.402.47'),
(73, 'SLR', 31000.00, '34.402.47'),
(74, 'PRX', 21000.00, '34.402.47'),
(75, 'PRM', 64000.00, '34.402.49'),
(76, 'SLR', 30000.00, '34.402.49'),
(77, 'PRX', 30000.00, '34.402.49'),
(78, 'PPL', 30000.00, '34.402.49'),
(79, 'PRM', 45000.00, '34.402.52'),
(80, 'SLR', 45000.00, '34.402.52'),
(81, 'PRX', 21000.00, '34.402.52'),
(82, 'PRM', 46000.00, '34.402.54'),
(83, 'SLR', 30000.00, '34.402.54'),
(84, 'PRX', 25000.00, '34.402.54'),
(85, 'PPL', 25000.00, '34.402.54'),
(93, 'SLR', 60000.00, '31.406.01'),
(92, 'PRM', 60000.00, '31.406.01'),
(91, 'PRX', 20000.00, '31.406.01'),
(90, 'PPL', 20000.00, '31.406.01');

-- --------------------------------------------------------

--
-- Table structure for table `INV_MGT_TYPE`
--

CREATE TABLE IF NOT EXISTS `INV_MGT_TYPE` (
  `ID` int(11) NOT NULL auto_increment,
  `INV_TYPE` varchar(50) NOT NULL,
  `INV_DESC` varchar(50) default NULL,
  `PRODUCT_TYPE` varchar(10) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `INV_MGT_TYPE`
--

INSERT INTO `INV_MGT_TYPE` (`ID`, `INV_TYPE`, `INV_DESC`, `PRODUCT_TYPE`) VALUES
(1, 'PRM', 'Premium', 'BBM'),
(2, 'SLR', 'Solar', 'BBM'),
(3, 'PRX', 'Pertamax', 'BBM'),
(4, 'PPL', 'Pertamax Plus', 'BBM');

-- --------------------------------------------------------

--
-- Table structure for table `INV_MGT_USER_ROLE`
--

CREATE TABLE IF NOT EXISTS `INV_MGT_USER_ROLE` (
  `ID` int(11) NOT NULL auto_increment,
  `USER_NAME` varchar(50) NOT NULL,
  `USER_PASSWORD` varchar(255) NOT NULL,
  `USER_ROLE` varchar(20) NOT NULL,
  `FIRST_NAME` varchar(50) NOT NULL,
  `LAST_NAME` varchar(50) NOT NULL,
  `STATION_ID` varchar(50) default NULL,
  `EMAIL_ADDRESS` varchar(50) default NULL,
  `ACCOUNT_ACTIVATED` varchar(3) default NULL,
  PRIMARY KEY  (`ID`),
  UNIQUE KEY `UQ_INV_MGT_USER_ROLE_1` (`USER_NAME`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=52 ;

--
-- Dumping data for table `INV_MGT_USER_ROLE`
--

INSERT INTO `INV_MGT_USER_ROLE` (`ID`, `USER_NAME`, `USER_PASSWORD`, `USER_ROLE`, `FIRST_NAME`, `LAST_NAME`, `STATION_ID`, `EMAIL_ADDRESS`, `ACCOUNT_ACTIVATED`) VALUES
(1, 'pertamina', '47b8cadecf3574684124d04dade07a8130ede686f62f84f8d645e7a9a6371a9e', 'PTM', 'Pertamina', 'UPMS III', '', 'pertamina@pertamina.com', 'Y'),
(2, 'bphmigas', '6ecef92bd83190ca6a3b67a2784d4e15694377a4e1cecea03a739f6b6b2ff33f', 'BPH', 'BPH', 'Migas', '', 'bphmigas@bphmigas.go.id', 'Y'),
(3, 'depotub', '4107bd9a243fb9e21fabfeb6795755276c1aaaed09e02fccf2f368010812272c', 'DEP', 'Depot', 'Ujung Berung', '', 'depotub@pertamina.com', 'Y'),
(4, 'superuser', '327908dbeccf385bf1ef9de012aecf29ffa03116861b44cdf661edeb517bdebf', 'SUP', 'Super', 'User', '', 'vigong@free.fr', 'Y'),
(5, 'nathani', '91d28db306d158c2e05679de714766446bca6e4961c17076a7f142f43c91892e', 'PUS', 'Nathani', 'Prima Sejahtera', '', 'nathani.primasejahtera@gmail.com', 'Y'),
(45, 'deni', '7a7f04c0aa384e6ed4890273c07683c942e373f23e78e39e9418f9792e9a798d', 'OWN', 'Pertamina', 'Retail', '31.406.01', 'spbu_coco_bdg', 'Y'),
(12, 'Agus ', 'de674ee0d9f0b5997fb2e585be2a3d726ab78ab8564fd8be9bb2532c5183d1cc', 'OWN', 'Agus Diki', 'Arisandi', '34.402.56', 'agus@yahoo.com', 'Y'),
(13, 'H. Dase', 'f4d159902fbbed19029baac5434e5f982252de01043499cbf949fa7eee64e3aa', 'OWN', 'H. Dase', 'Asep D', '34.403.25', 'dase@yahoo.com', 'Y'),
(14, 'abdulmanan', 'de4768e58097003a8ea88bae3d17429e6527bfa500f602eae8ad1345345d654c', 'OWN', 'Abdul', 'manan', '34.401.02', 'abdulmanan@yahoo.com', 'Y'),
(15, 'PT. Djuwita', '50619c652baa9ce0cd01268f09bf244a35aea6fd06ec97e805ff2f41e404377d', 'OWN', 'PT. Djuwita', 'Agung', '34.403.31', 'juwita@yahoo.com', 'Y'),
(16, 'Elsiana', '766879148afd379d58861a762b36fba9031004dec774e7c3f1bea09280485fc4', 'OWN', 'Elsiana', 'Setiati', '34.401.10', 'Elsiana@yahoo.com', 'Y'),
(17, 'Ny. Ely', '2429b74d38ccac35841e9915f88bdd3deccc679be1312f78171598e97ae9a65f', 'OWN', 'Ny. Ely', 'Eliyah', '34.406.06', 'eliyah@yahoo.com', 'Y'),
(18, 'primkopad', 'cc3d4f90fcc81b2a8b3c602a0f1a9c01e9a9f7d6ebcd3bf029771373ca2750c2', 'OWN', 'Primkopad', 'Pussenif', '34.401.19', 'primkopad@yahoo.com', 'Y'),
(19, 'robby', 'b890afb96b2e306108dfa223fed0ff739fd93a80e238e6522c52b54578e5518e', 'OWN', 'Robby', 'Djojodirejo', '34.401.21', 'robby@yahoo.com', 'Y'),
(20, 'PT. Puta', '52f789dbc0ed2acfca5c00eac4910694725676ff6b870596eb6bf34d8cf6afe4', 'OWN', 'PT. Puta', 'Petro Patria', '34.409.04', 'petro@yahoo.com', 'Y'),
(21, 'Djojodirejo', 'b890afb96b2e306108dfa223fed0ff739fd93a80e238e6522c52b54578e5518e', 'OWN', 'Robby', 'Djojodirejo', '34.401.27', 'robby@yahoo.com', 'Y'),
(22, 'griya', 'f203f4a650d7950c8e4e630307deff6c5e83c887cb6d2739ead0447f65b7eb09', 'OWN', 'Griya, PT', 'Mas Utama, PT', '34.401.28', 'griya@yahoo.com', 'Y'),
(23, 'sukron', '5b3aadda2cfeab4a71c9c1e6467f67cef0335eda027698fc45b4542a915b08a4', 'OWN', 'Sukron', 'Roshadi', '34.401.31', 'sukron@yahoo.com', 'Y'),
(24, 'sadikin', '12a94ab45e3cd90c1f510116d5bf97d2efa89daab5d1934ed893404646721f3f', 'OWN', 'Agus ', 'Sadikin', '34.401.32', 'agus@yahoo.com', 'Y'),
(25, 'irwan', '0fc36256f22ada849317ebff29e0f022af95026fd0da8895234e26b8afe7848f', 'OWN', 'Irwan', 'Hadikusuma', '34.401.33', 'irwan@yahoo.com', 'Y'),
(26, 'chaerani', 'ec0b086077f81d42ee5331f161c89e4fb7475801231afe487e687d496f1f078a', 'OWN', 'Chaerani ', 'Lubis', '34.402.12', 'Chaerani@yahoo.com', 'Y'),
(27, 'sadli', '8c3beca7bfac2790d58cad049e339db15ab03a659061af36a1e27f474ea8c789', 'OWN', 'Dali', 'Sadli', '34.402.17', 'dali@yahoo.com', 'Y'),
(28, 'febi', '1dbb0febce9a43faf6f706bc88c4571e320768719fadf0fccd5ee0c3e2b4498f', 'OWN', 'Febi', 'Budianto', '34.402.20', 'febi@yahoo.com', 'Y'),
(29, 'endang', '7c9d57c6d0c6980449c4398ceb9a62913a211706a480fc328aed71af6bdc80e8', 'OWN', 'Endang', 'Sunarya', '34.402.21', 'endang@yahoo.com', 'Y'),
(30, 'adeng', '38aceef15e3a67bf68f268e8d4a3390b357ece450d1c3c9cc6b4d00649e6b003', 'OWN', 'Adeng', 'Zaenal', '34.402.23', 'adeng@yahoo.com', 'Y'),
(31, 'helmi', 'a158e23bcb60febf918e8ea7ef3d038faf817be043185ea0ea1bf13b55123e0c', 'OWN', 'Helmi ', 'Nadzir', '34.402.25', 'helmi@yahoo.com', 'Y'),
(32, 'nany', 'bb95daa8ef08f569cc62c2959940955fb7ac2a3d4e5a43d2374abbe41f1e5735', 'OWN', 'Nany', 'Suhaeni', '34.402.26', 'nany@yahoo.com', 'Y'),
(33, 'giga', '332cb6c79b0b91adfb57e6c989cfbb1a776442c3a5499412b9399b4c8076a5b6', 'OWN', 'Giga, PT', 'Intrax, PT', '34.402.30', 'giga@yahoo.com', 'Y'),
(34, 'budianto', '1dbb0febce9a43faf6f706bc88c4571e320768719fadf0fccd5ee0c3e2b4498f', 'OWN', 'Febi', 'Budianto', '34.402.34', 'febi@yahoo.com', 'Y'),
(35, 'kuraesin', 'efac01f5d2c4773e70fc8818f1ba933ab946a7d4b8b38e6207218e760df71ed1', 'OWN', 'H. A. Kuraesin', 'Kuraesin', '34.402.35', 'kuraesin@yahoo.com', 'Y'),
(36, 'yansen', 'c7b61a8aef2994ad0ff9583414242a0d2cb70d507f0456f9890a6a867846a425', 'OWN', 'Ir. Yansen', 'Wiyono', '34.402.36', 'yansen@yahoo.com', 'Y'),
(37, 'rukun', '166c4d6d4f4763265dedfb6f5a6f0a80a8b8b81ce8a68e9892149f288b3e87cd', 'OWN', 'Rukun Citra, PT', 'UN, PT', '34.402.38', 'rukuncitra@yahoo.com', 'Y'),
(38, 'Agusdiki', 'de674ee0d9f0b5997fb2e585be2a3d726ab78ab8564fd8be9bb2532c5183d1cc', 'ADM', 'Agus Diki', 'Arisandi', '34.402.56', 'agus@yahoo.com', 'Y'),
(39, 'dedi', 'cb35ae614325c32c78beec827449be88ccbbf4e807f6820448aaaa92a135697d', 'OWN', 'Dedi', 'Supriyatna', '34.402.40', 'dedi@yahoo.com', 'Y'),
(40, 'nagamas', 'cfda0f9ef8bc2a21051ce5f42ba585d5d04dfa5cf938c09d332de20b0594d797', 'OWN', 'Nagamas Putra, PT', 'Jaya, PT', '34.402.44', 'nagamas@yahoo.com', 'Y'),
(41, 'kuswandi', '6bed2f50fe8e2742f13ea90e7c45fd768d3896d15447baf94f74807a3aaef359', 'OWN', 'Kus', 'wandi', '34.402.47', 'kuswandi@yahoo.com', 'Y'),
(42, 'liephitjen', '8d05669a99f2a42ff9c5bcad8331b13dc86dc0964ae884b5050be12f82b87a2c', 'OWN', 'Lie Phi', 'Tjen', '34.402.49', 'liephitjen@yahoo.com', 'Y'),
(43, 'muchlis', '1869a1d789b611464ef3adf7442de5e71924d8943324b4094de6c4f161668dba', 'OWN', 'H. Muchlis', 'Muchlis', '34.402.52', 'muchlis@yahoo.com', 'Y'),
(44, 'erward', 'c0cabb61e51ec8fadb792a0153932cdddde5f99ea28342faa2f513494d6d2b46', 'OWN', 'Ir. Erward', 'Hermanto', '34.402.54', 'erward@yahoo.com', 'Y'),
(46, 'elieliyah', '2429b74d38ccac35841e9915f88bdd3deccc679be1312f78171598e97ae9a65f', 'ADM', 'Ny. Ely', 'Eliyah', '34.406.06', 'eliyah@yahoo.com', 'Y'),
(47, 'operator', '30f859b2d1f794678cd70f3e328ffb69efc94e13f1ef7935be3b896ef415d8af', 'OPE', 'paijo', 'bin ahmad', '34.402.56', 'paijo@yahoo.com', 'Y'),
(48, 'pelanggan', '67c202dcaef3f58c98f7d12b888a7c97972c0cd266c373d8993dac498be3f85a', 'USE', 'pelang', 'gannn', '34.406.06', 'pelanggan@yahoo.com', 'Y'),
(49, 'adminspbu', 'bf76b3861d22d64d9d96c5fe8a1fe11508ea10ecb9ed3eb65015fd451cae855c', 'ADM', 'admin', 'spbu', '34.406.06', 'adminspbu@yahoo.com', 'Y'),
(50, 'operator1', '06e55b633481f7bb072957eabcf110c972e86691c3cfedabe088024bffe42f23', 'OPE', 'oper', 'rator', '34.406.06', 'operator@yahoo.com', 'Y'),
(51, 'Dadang', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'OPE', 'Dadang', 'Usman', '34.401.21', 'dadang@yahoo.com', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `OVERHEAD_COST`
--

CREATE TABLE IF NOT EXISTS `OVERHEAD_COST` (
  `ID` int(11) NOT NULL auto_increment,
  `OVH_CODE` varchar(20) NOT NULL,
  `OVH_DESC` varchar(50) NOT NULL,
  `OVH_VALUE` decimal(50,2) NOT NULL,
  `OVH_DATE` date NOT NULL,
  `STATION_ID` varchar(50) default NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `OVERHEAD_COST`
--

INSERT INTO `OVERHEAD_COST` (`ID`, `OVH_CODE`, `OVH_DESC`, `OVH_VALUE`, `OVH_DATE`, `STATION_ID`) VALUES
(1, 'ATK 21', 'kertas 1 rim', 50000.00, '2010-02-21', '34.401.21'),
(2, 'OB 21', 'alat-alat pembersih', 100000.00, '2010-02-21', '34.401.21'),
(3, 'CS 21', 'alat-alat pembersih', 20000.00, '2010-02-21', '34.406.06'),
(4, 'ATK 21', 'beli kertas 1 rim', 100000.00, '2010-02-21', '34.402.54'),
(5, 'JAJAN 21', 'baso 5 mangkok', 20000.00, '2010-02-21', '34.402.54'),
(6, 'GAJI 22', 'gaji karyawan bulan februari ', 150000.00, '2010-02-23', '34.401.21'),
(7, 'PAKET 23', 'biaya pengiriman paket ', 50000.00, '2010-02-23', '34.401.21');

-- --------------------------------------------------------

--
-- Table structure for table `WORK_IN_CAPITAL`
--

CREATE TABLE IF NOT EXISTS `WORK_IN_CAPITAL` (
  `ID` int(11) NOT NULL auto_increment,
  `C_VALUE` decimal(50,2) NOT NULL,
  `C_DESC` varchar(10) default NULL,
  `C_CODE` varchar(10) NOT NULL,
  `STATION_ID` varchar(50) default NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `WORK_IN_CAPITAL`
--

INSERT INTO `WORK_IN_CAPITAL` (`ID`, `C_VALUE`, `C_DESC`, `C_CODE`, `STATION_ID`) VALUES
(3, 1000000000.00, 'MODAL KERJ', 'C_INIT', '31.406.01'),
(2, 2000000000.00, 'modal kerj', 'C_INIT', '34.402.56'),
(4, 2000000000.00, 'Modal kerj', 'C_INIT', '34.401.21'),
(5, 1000000000.00, 'Modal Kerj', 'C_INIT', '34.406.06'),
(6, 2000000000.00, 'Modal Awal', 'C_INIT', '34.402.40'),
(7, 2000000000.00, 'modal kerj', 'C_INIT', '34.402.54');
