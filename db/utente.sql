-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Gen 10, 2021 alle 01:36
-- Versione del server: 10.4.17-MariaDB
-- Versione PHP: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mercatinopulci`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `codiceFiscale` varchar(16) NOT NULL,
  `tipoAccount` set('acquirente','venditore','venditoreAcquirente') NOT NULL,
  `nome` varchar(20) NOT NULL,
  `cognome` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(32) NOT NULL,
  `immagine` varchar(30) DEFAULT NULL,
  `comune` varchar(35) NOT NULL,
  `provincia` varchar(22) NOT NULL,
  `eliminato` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`codiceFiscale`, `tipoAccount`, `nome`, `cognome`, `email`, `password`, `immagine`, `comune`, `provincia`, `eliminato`) VALUES
('CCLPNA83E41G713I', 'venditoreAcquirente', 'Cecilia', 'Pane', 'oplascecilia@email.com', '0a14bbb183ebe2f24fb6521ed792bb66', NULL, 'Buggiano', 'Pistoia', '0'),
('CLMMTN00L51A794O', 'venditoreAcquirente', 'Martina', 'Colombo', 'potamartinacolombo@email.com', 'ba6efe28dfc9ec81c9ae38751bdef637', NULL, 'Bergamo', 'Bergamo', '0'),
('CRVLRT87R11C559Q', 'venditoreAcquirente', 'Alberto', 'Corvo', 'corvoneroalberto@email.com', '3e972d1be74160bcb7ab4dc1a19eaed3', NULL, 'Cervo', 'Imperia', '0'),
('CSTNAI91R69G113A', 'venditoreAcquirente', 'Ania', 'Costruisce', 'costruisceania@email.com', '61476dd3b4a98abc90c79023dfe380b2', NULL, 'Olbia', 'Sassari', '0'),
('CTRRSS96D57A401O', 'venditoreAcquirente', 'Caterina', 'Rossa', 'catethewitch@email.com', '22c43c7b7f00f2b5310d1e4a0762c7f5', NULL, 'Ariccia', 'Roma', '0'),
('FCUFTA90P25D560I', 'acquirente', 'Fatuo', 'Fuoco', 'fuocofatuoloso@email.com', '4befa042be9c06b84211386ce7c9da1d', NULL, 'Fiamignano', 'Rieti', '0'),
('LCUDNT63A01C803H', 'venditoreAcquirente', 'Lucio', 'Diamante', 'lucionelcielo@email.com', '7bff0a782ba0641a81fc13fd6870499c', NULL, 'Coazze', 'Torino', '0'),
('LNESFG12B69A288U', 'acquirente', 'Elena', 'Sfogo', 'elenasfogo12@email.com', 'e890f806dfd189052ca7b39ac29da142', NULL, 'Anfo', 'Brescia', '0'),
('LSSFGL77M06B396Y', 'acquirente', 'Alessandro', 'Fumagalli', 'alefumagalli@email.com', '6f0f4d469eaead0ac18da3a460f263b6', NULL, 'Abbadia Lariana', 'Lecco', '0'),
('MRGLHR99A41E801X', 'venditore', 'Margherita', 'Alighieri', 'ladivinamargherita@email.com', 'dd2d77800385e5ab955700f70ca8a1f9', NULL, 'Magenta', 'Milano', '0'),
('NDRLND85R12A652Y', 'acquirente', 'Alexander', 'Ondra', 'alexanderondra@email.com', '25baad18cb1d4598ca717b9666976b99', NULL, 'Bareggio', 'Milano', '0'),
('PNZGNR67L16C351I', 'venditore', 'Gennaro', 'Panizzi', 'gennaro.panizzi67@email.com', '8140976ba0423981a11615a8ca632c20', NULL, 'Alia', 'Palermo', '0'),
('PRCRRT83H11A014Q', 'venditoreAcquirente', 'Roberto', 'Porcino', 'boletusedulis@email.com', '0e701f335effa546f5647bb43a4728de', NULL, 'Acate', 'Ragusa', '0'),
('PRGDRD99M23F133R', 'venditoreAcquirente', 'Edoardo', 'Perego', 'edoardoperego@email.com', 'd5deab4e83b267d48299d2d1a2ab52ba', NULL, 'Merate', 'Lecco', '0'),
('RGNGNN97R13L736H', 'acquirente', 'Giovanni', 'Ragno', 'spidygiovy@email.com', '0a519b71fdd2595ff1d89b024864d9f9', NULL, 'Venezia', 'Venezia', '0'),
('SCNLLL71R18A271O', 'venditoreAcquirente', 'Ascanio', 'Lavello', 'lavelloascanio@email.com', 'f9b7caa5979bc44418e24c05a3b9e2f2', NULL, 'Barbara', 'Ancona', '0'),
('SLMBRN92B16D205T', 'venditoreAcquirente', 'Bruno', 'Salmone', 'brunosalmone@email.com', 'cd436232402079ff109da2dcfa69bffb', NULL, 'Barolo', 'Cuneo', '0'),
('VNCRSS97R06B157T', 'venditore', 'Vincenzo', 'Rossi', 'vincenzo_rossi@email.com', '7fa1adabb7e37b7726b32e44602a0ab6', NULL, 'Brescia', 'Brescia', '0');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`codiceFiscale`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `utente_fk1` (`comune`,`provincia`);

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `utente`
--
ALTER TABLE `utente`
  ADD CONSTRAINT `utente_fk1` FOREIGN KEY (`comune`,`provincia`) REFERENCES `areageografica` (`comune`, `provincia`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
