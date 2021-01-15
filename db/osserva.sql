-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Gen 15, 2021 alle 21:19
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
-- Struttura della tabella `osserva`
--

CREATE TABLE `osserva` (
  `acquirente` varchar(16) NOT NULL,
  `dataOraPubblicazione` timestamp NOT NULL DEFAULT current_timestamp(),
  `venditore` varchar(16) NOT NULL,
  `richiestaDiAcquisto` enum('0','1') DEFAULT NULL
) ;

--
-- Dump dei dati per la tabella `osserva`
--

INSERT INTO `osserva` (`acquirente`, `dataOraPubblicazione`, `venditore`, `richiestaDiAcquisto`) VALUES
('BCCGRT89R52E617T', '2021-01-14 21:21:14', 'LLLSCN71R18A271O', '1'),
('BCCGRT89R52E617T', '2021-01-15 15:58:27', 'PRCRRT83H11A014Q', '0'),
('DNTLCU63A01C803H', '2021-01-12 20:39:44', 'PNZGNR67L16C351I', NULL),
('FCUFTA90P25D560I', '2021-01-11 22:32:28', 'CRVLRT87R11C559Q', NULL),
('FGLLSS77M06B396Y', '2021-01-13 13:19:09', 'RSSCTR96D57A401O', '1'),
('FGLLSS77M06B396Y', '2021-01-14 21:21:14', 'LLLSCN71R18A271O', '1'),
('LLLSCN71R18A271O', '2021-01-11 22:22:54', 'CLMMTN00L51A794O', NULL),
('LLLSCN71R18A271O', '2021-01-11 22:32:28', 'CRVLRT87R11C559Q', NULL),
('PRCRRT83H11A014Q', '2021-01-14 21:01:33', 'DNTLCU63A01C803H', '1'),
('PRGDRD99M23F133R', '2021-01-11 22:22:54', 'CLMMTN00L51A794O', '0'),
('PRGDRD99M23F133R', '2021-01-12 20:35:57', 'SLMBRN92B16D205T', NULL),
('PRGDRD99M23F133R', '2021-01-13 18:43:28', 'LHRMRG99A41E801X', '0'),
('RGNGNN97R13L736H', '2021-01-11 19:29:20', 'DNTLCU63A01C803H', '1'),
('RGNGNN97R13L736H', '2021-01-11 22:22:54', 'CLMMTN00L51A794O', NULL),
('RGNGNN97R13L736H', '2021-01-12 20:39:44', 'PNZGNR67L16C351I', NULL),
('RGNGNN97R13L736H', '2021-01-13 13:23:28', 'CRVLRT87R11C559Q', '0'),
('RSNLND85R12A652Y', '2021-01-11 01:00:23', 'PNZGNR67L16C351I', NULL),
('RSNLND85R12A652Y', '2021-01-14 21:18:03', 'CSTNAI91R69G113A', '0'),
('SFGLNE12B69A288U', '2021-01-11 22:22:54', 'CLMMTN00L51A794O', NULL);

--
-- Trigger `osserva`
--
DELIMITER $$
CREATE TRIGGER `check_osserva_annuncio_in_vendita` BEFORE INSERT ON `osserva` FOR EACH ROW BEGIN

IF (
    SELECT statoAnnuncio 
    FROM annuncio
    WHERE dataOraPubblicazione = new.dataOraPubblicazione
    AND venditore = new.venditore
    ) != 'inVendita'
    THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "ERROR - L'annuncio non è più in vendita";
	END IF;
END
$$
DELIMITER ;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `osserva`
--
ALTER TABLE `osserva`
  ADD PRIMARY KEY (`acquirente`,`dataOraPubblicazione`,`venditore`),
  ADD KEY `osserva_fk2` (`dataOraPubblicazione`,`venditore`);

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `osserva`
--
ALTER TABLE `osserva`
  ADD CONSTRAINT `osserva_fk1` FOREIGN KEY (`acquirente`) REFERENCES `utente` (`codiceFiscale`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `osserva_fk2` FOREIGN KEY (`dataOraPubblicazione`,`venditore`) REFERENCES `annuncio` (`dataOraPubblicazione`, `venditore`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
