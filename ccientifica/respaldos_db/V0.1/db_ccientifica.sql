-- phpMyAdmin SQL Dump
-- version 4.2.12deb2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 20, 2015 at 01:08 AM
-- Server version: 5.6.25-0ubuntu0.15.04.1
-- PHP Version: 5.6.4-4ubuntu6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_ccientifica`
--

-- --------------------------------------------------------

--
-- Table structure for table `fundamento`
--

CREATE TABLE IF NOT EXISTS `fundamento` (
`idfundamento` int(15) NOT NULL,
  `nombrefun` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `metodo`
--

CREATE TABLE IF NOT EXISTS `metodo` (
`idmetodo` int(11) NOT NULL,
  `nombremet` varchar(25) NOT NULL,
  `idfundamento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `resultado`
--

CREATE TABLE IF NOT EXISTS `resultado` (
  `codigo` varchar(250) NOT NULL,
  `rutaarchivo` varchar(250) NOT NULL,
  `rutaimagen` varchar(250) NOT NULL,
  `estado` int(1) NOT NULL,
  `idmetodo` int(15) NOT NULL,
  `idfundamento` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fundamento`
--
ALTER TABLE `fundamento`
 ADD PRIMARY KEY (`idfundamento`);

--
-- Indexes for table `metodo`
--
ALTER TABLE `metodo`
 ADD PRIMARY KEY (`idmetodo`), ADD KEY `idfundamento` (`idfundamento`);

--
-- Indexes for table `resultado`
--
ALTER TABLE `resultado`
 ADD PRIMARY KEY (`codigo`), ADD KEY `idfundamento` (`idfundamento`), ADD KEY `idmetodo` (`idmetodo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fundamento`
--
ALTER TABLE `fundamento`
MODIFY `idfundamento` int(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `metodo`
--
ALTER TABLE `metodo`
MODIFY `idmetodo` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `metodo`
--
ALTER TABLE `metodo`
ADD CONSTRAINT `metodo_ibfk_1` FOREIGN KEY (`idfundamento`) REFERENCES `fundamento` (`idfundamento`);

--
-- Constraints for table `resultado`
--
ALTER TABLE `resultado`
ADD CONSTRAINT `resultado_ibfk_1` FOREIGN KEY (`idfundamento`) REFERENCES `fundamento` (`idfundamento`),
ADD CONSTRAINT `resultado_ibfk_2` FOREIGN KEY (`idmetodo`) REFERENCES `metodo` (`idmetodo`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
