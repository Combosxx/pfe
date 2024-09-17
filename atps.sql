-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 17 sep. 2024 à 07:13
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `atps`
--

-- --------------------------------------------------------

--
-- Structure de la table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `AdminId` int NOT NULL AUTO_INCREMENT,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(100) NOT NULL,
  PRIMARY KEY (`AdminId`),
  UNIQUE KEY `Username` (`Username`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `admins`
--

INSERT INTO `admins` (`AdminId`, `Username`, `Password`, `Email`) VALUES
(1, 'admin1', 'password123', 'admin1@example.com'),
(2, 'admin2', 'password456', 'admin2@example.com');

-- --------------------------------------------------------

--
-- Structure de la table `companies`
--

DROP TABLE IF EXISTS `companies`;
CREATE TABLE IF NOT EXISTS `companies` (
  `CompanyId` int NOT NULL AUTO_INCREMENT,
  `CompanyName` varchar(100) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `PhoneNumber` varchar(20) NOT NULL,
  `NumVehicles` int NOT NULL DEFAULT '0',
  `NumDrivers` int NOT NULL DEFAULT '0',
  `BankName` varchar(100) NOT NULL,
  `RIB` varchar(100) NOT NULL,
  PRIMARY KEY (`CompanyId`),
  UNIQUE KEY `CompanyName` (`CompanyName`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `companies`
--

INSERT INTO `companies` (`CompanyId`, `CompanyName`, `Address`, `Email`, `PhoneNumber`, `NumVehicles`, `NumDrivers`, `BankName`, `RIB`) VALUES
(1, 'Company A', '123 Street, City, Country', 'contact@companya.com', '1234567890', 10, 5, 'Bank A', 'RIB123456'),
(2, 'Company B', '456 Avenue, City, Country', 'contact@companyb.com', '0987654321', 8, 4, 'Bank B', 'RIB654321');

-- --------------------------------------------------------

--
-- Structure de la table `countries`
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE IF NOT EXISTS `countries` (
  `CountryId` int NOT NULL AUTO_INCREMENT,
  `CountryName` varchar(100) NOT NULL,
  PRIMARY KEY (`CountryId`),
  UNIQUE KEY `CountryName` (`CountryName`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `countries`
--

INSERT INTO `countries` (`CountryId`, `CountryName`) VALUES
(1, 'Country A'),
(2, 'Country B'),
(3, 'Country C');

-- --------------------------------------------------------

--
-- Structure de la table `countrydistances`
--

DROP TABLE IF EXISTS `countrydistances`;
CREATE TABLE IF NOT EXISTS `countrydistances` (
  `DistanceId` int NOT NULL AUTO_INCREMENT,
  `StartCountryId` int DEFAULT NULL,
  `EndCountryId` int DEFAULT NULL,
  `DistanceKm` decimal(10,2) NOT NULL,
  PRIMARY KEY (`DistanceId`),
  KEY `StartCountryId` (`StartCountryId`),
  KEY `EndCountryId` (`EndCountryId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `countrydistances`
--

INSERT INTO `countrydistances` (`DistanceId`, `StartCountryId`, `EndCountryId`, `DistanceKm`) VALUES
(1, 1, 2, 1000.00),
(2, 2, 3, 1500.00);

-- --------------------------------------------------------

--
-- Structure de la table `creditcards`
--

DROP TABLE IF EXISTS `creditcards`;
CREATE TABLE IF NOT EXISTS `creditcards` (
  `CreditCardId` int NOT NULL AUTO_INCREMENT,
  `CustomerId` int NOT NULL,
  `CardNumber` varchar(20) NOT NULL,
  `ExpirationDate` date NOT NULL,
  `CVV` varchar(4) NOT NULL,
  `CardType` varchar(50) NOT NULL,
  PRIMARY KEY (`CreditCardId`),
  KEY `CustomerId` (`CustomerId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `CustomerId` int NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `PhoneNumber` varchar(20) NOT NULL,
  PRIMARY KEY (`CustomerId`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `freightcosts`
--

DROP TABLE IF EXISTS `freightcosts`;
CREATE TABLE IF NOT EXISTS `freightcosts` (
  `FreightCostId` int NOT NULL AUTO_INCREMENT,
  `FreightType` enum('air_freight','sea_freight','road_freight') NOT NULL,
  `CostPerKg` decimal(10,2) NOT NULL,
  `CostPerKm` decimal(10,2) NOT NULL,
  PRIMARY KEY (`FreightCostId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `independent_driver`
--

DROP TABLE IF EXISTS `independent_driver`;
CREATE TABLE IF NOT EXISTS `independent_driver` (
  `DriverId` int NOT NULL AUTO_INCREMENT,
  `VehicleId` int NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `PhoneNumber` varchar(20) NOT NULL,
  `BankName` varchar(100) NOT NULL,
  `RIB` varchar(100) NOT NULL,
  PRIMARY KEY (`DriverId`),
  UNIQUE KEY `Email` (`Email`),
  KEY `VehicleId` (`VehicleId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `passwordresettokens`
--

DROP TABLE IF EXISTS `passwordresettokens`;
CREATE TABLE IF NOT EXISTS `passwordresettokens` (
  `TokenId` int NOT NULL AUTO_INCREMENT,
  `UserId` int NOT NULL,
  `Token` varchar(128) NOT NULL,
  `TokenExpiry` datetime NOT NULL,
  PRIMARY KEY (`TokenId`),
  UNIQUE KEY `Token` (`Token`),
  KEY `UserId` (`UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `queries`
--

DROP TABLE IF EXISTS `queries`;
CREATE TABLE IF NOT EXISTS `queries` (
  `QueryId` int NOT NULL AUTO_INCREMENT,
  `CustomerId` int NOT NULL,
  `Subject` varchar(150) NOT NULL,
  `Description` text NOT NULL,
  `QueryDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`QueryId`),
  KEY `CustomerId` (`CustomerId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `quotes`
--

DROP TABLE IF EXISTS `quotes`;
CREATE TABLE IF NOT EXISTS `quotes` (
  `QuoteId` int NOT NULL AUTO_INCREMENT,
  `CustomerId` int NOT NULL,
  `Description` text NOT NULL,
  `EstimatedCost` decimal(10,2) NOT NULL,
  `QuoteDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`QuoteId`),
  KEY `CustomerId` (`CustomerId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `routes`
--

DROP TABLE IF EXISTS `routes`;
CREATE TABLE IF NOT EXISTS `routes` (
  `RouteId` int NOT NULL AUTO_INCREMENT,
  `StartLocation` varchar(100) NOT NULL,
  `EndLocation` varchar(100) NOT NULL,
  `Distance` int NOT NULL,
  `EstimatedTravelTime` int NOT NULL,
  PRIMARY KEY (`RouteId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `services`
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE IF NOT EXISTS `services` (
  `ServiceId` int NOT NULL AUTO_INCREMENT,
  `ServiceName` varchar(100) NOT NULL,
  `Description` text,
  PRIMARY KEY (`ServiceId`),
  UNIQUE KEY `ServiceName` (`ServiceName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `shipments`
--

DROP TABLE IF EXISTS `shipments`;
CREATE TABLE IF NOT EXISTS `shipments` (
  `ShipmentId` int NOT NULL AUTO_INCREMENT,
  `CustomerId` int NOT NULL,
  `VehicleId` int NOT NULL,
  `DriverId` int NOT NULL,
  `CompanyId` int NOT NULL,
  `ServiceId` int NOT NULL,
  `Status` varchar(50) NOT NULL,
  `EstimatedDeliveryDate` datetime NOT NULL,
  `ActualDeliveryDate` datetime DEFAULT NULL,
  `RouteId` int NOT NULL,
  `Cost` decimal(10,2) NOT NULL,
  PRIMARY KEY (`ShipmentId`),
  KEY `CustomerId` (`CustomerId`),
  KEY `VehicleId` (`VehicleId`),
  KEY `DriverId` (`DriverId`),
  KEY `CompanyId` (`CompanyId`),
  KEY `ServiceId` (`ServiceId`),
  KEY `RouteId` (`RouteId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `testimonials`
--

DROP TABLE IF EXISTS `testimonials`;
CREATE TABLE IF NOT EXISTS `testimonials` (
  `TestimonialId` int NOT NULL AUTO_INCREMENT,
  `CustomerId` int NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Content` text NOT NULL,
  `TestimonialDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`TestimonialId`),
  KEY `CustomerId` (`CustomerId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `UserId` int NOT NULL AUTO_INCREMENT,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(100) NOT NULL,
  PRIMARY KEY (`UserId`),
  UNIQUE KEY `Username` (`Username`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `vehicles`
--

DROP TABLE IF EXISTS `vehicles`;
CREATE TABLE IF NOT EXISTS `vehicles` (
  `VehicleId` int NOT NULL AUTO_INCREMENT,
  `VehicleType` varchar(50) NOT NULL,
  `LicensePlate` varchar(20) NOT NULL,
  `Capacity` int NOT NULL,
  `VehicleImage` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`VehicleId`),
  UNIQUE KEY `LicensePlate` (`LicensePlate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `countrydistances`
--
ALTER TABLE `countrydistances`
  ADD CONSTRAINT `countrydistances_ibfk_1` FOREIGN KEY (`StartCountryId`) REFERENCES `countries` (`CountryId`),
  ADD CONSTRAINT `countrydistances_ibfk_2` FOREIGN KEY (`EndCountryId`) REFERENCES `countries` (`CountryId`);

--
-- Contraintes pour la table `creditcards`
--
ALTER TABLE `creditcards`
  ADD CONSTRAINT `creditcards_ibfk_1` FOREIGN KEY (`CustomerId`) REFERENCES `customers` (`CustomerId`);

--
-- Contraintes pour la table `independent_driver`
--
ALTER TABLE `independent_driver`
  ADD CONSTRAINT `independent_driver_ibfk_1` FOREIGN KEY (`VehicleId`) REFERENCES `vehicles` (`VehicleId`);

--
-- Contraintes pour la table `passwordresettokens`
--
ALTER TABLE `passwordresettokens`
  ADD CONSTRAINT `passwordresettokens_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `users` (`UserId`);

--
-- Contraintes pour la table `queries`
--
ALTER TABLE `queries`
  ADD CONSTRAINT `queries_ibfk_1` FOREIGN KEY (`CustomerId`) REFERENCES `customers` (`CustomerId`);

--
-- Contraintes pour la table `quotes`
--
ALTER TABLE `quotes`
  ADD CONSTRAINT `quotes_ibfk_1` FOREIGN KEY (`CustomerId`) REFERENCES `customers` (`CustomerId`);

--
-- Contraintes pour la table `shipments`
--
ALTER TABLE `shipments`
  ADD CONSTRAINT `shipments_ibfk_1` FOREIGN KEY (`CustomerId`) REFERENCES `customers` (`CustomerId`),
  ADD CONSTRAINT `shipments_ibfk_2` FOREIGN KEY (`VehicleId`) REFERENCES `vehicles` (`VehicleId`),
  ADD CONSTRAINT `shipments_ibfk_3` FOREIGN KEY (`DriverId`) REFERENCES `independent_driver` (`DriverId`),
  ADD CONSTRAINT `shipments_ibfk_4` FOREIGN KEY (`CompanyId`) REFERENCES `companies` (`CompanyId`),
  ADD CONSTRAINT `shipments_ibfk_5` FOREIGN KEY (`ServiceId`) REFERENCES `services` (`ServiceId`),
  ADD CONSTRAINT `shipments_ibfk_6` FOREIGN KEY (`RouteId`) REFERENCES `routes` (`RouteId`);

--
-- Contraintes pour la table `testimonials`
--
ALTER TABLE `testimonials`
  ADD CONSTRAINT `testimonials_ibfk_1` FOREIGN KEY (`CustomerId`) REFERENCES `customers` (`CustomerId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
