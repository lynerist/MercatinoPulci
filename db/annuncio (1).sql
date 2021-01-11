-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Gen 12, 2021 alle 00:56
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
-- Struttura della tabella `annuncio`
--

CREATE TABLE `annuncio` (
  `dataOraPubblicazione` timestamp NOT NULL DEFAULT current_timestamp(),
  `venditore` varchar(16) NOT NULL,
  `statoAnnuncio` set('inVendita','venduto','eliminato') NOT NULL DEFAULT 'inVendita',
  `titolo` varchar(150) NOT NULL,
  `prodotto` varchar(30) NOT NULL,
  `categoria` set('elettrodomestici','fotoEVideo','abbigliamento','hobby') NOT NULL,
  `sottoCategoria` set('aspirapolveri','caffettiere','tostapane','frullatori','macchineFotografiche','accessori','telecamere','microfoni','vestiti','borse','scarpe','accessori','giocattoli','filmEDVD','musica','libriERiviste','altro') NOT NULL,
  `prezzo` float UNSIGNED NOT NULL,
  `statoUsura` set('comeNuovo','buono','medio','usurato') DEFAULT NULL,
  `tempoUsura` smallint(5) UNSIGNED NOT NULL,
  `scadenzaGaranzia` date DEFAULT NULL,
  `foto` varchar(30) DEFAULT NULL,
  `valutazioneSuVenditore` tinyint(6) UNSIGNED DEFAULT NULL,
  `visibilita` set('privata','pubblica','ristretta') NOT NULL,
  `comune` varchar(35) NOT NULL,
  `provincia` varchar(22) NOT NULL
) ;

--
-- Dump dei dati per la tabella `annuncio`
--

INSERT INTO `annuncio` (`dataOraPubblicazione`, `venditore`, `statoAnnuncio`, `titolo`, `prodotto`, `categoria`, `sottoCategoria`, `prezzo`, `statoUsura`, `tempoUsura`, `scadenzaGaranzia`, `foto`, `valutazioneSuVenditore`, `visibilita`, `comune`, `provincia`) VALUES
('2021-01-11 00:12:53', 'PRGDRD99M23F133R', 'inVendita', 'Ramponi da montagna', 'ramponi', 'hobby', 'altro', 50, 'buono', 7, NULL, NULL, NULL, 'pubblica', 'Merate', 'Lecco'),
('2021-01-11 01:00:23', 'PNZGNR67L16C351I', 'inVendita', 'La caffettiera della nonna', 'caffettiera', 'elettrodomestici', 'caffettiere', 37, 'medio', 40, NULL, NULL, NULL, 'pubblica', 'Palermo', 'Palermo'),
('2021-01-11 19:29:20', 'LCUDNT63A01C803H', 'inVendita', 'Apple Pencil ancora nella scatola mai aperta', 'Apple Pencil', 'hobby', 'altro', 70, NULL, 0, NULL, NULL, NULL, 'pubblica', 'Alpette', 'Torino'),
('2021-01-11 19:34:10', 'SCNLLL71R18A271O', 'inVendita', 'paperetta di gomma nuova, c\'era il 2x1', 'papera di gomma', 'hobby', 'giocattoli', 3.5, NULL, 0, NULL, NULL, NULL, 'pubblica', 'Camerano', 'Ancona'),
('2021-01-11 21:58:27', 'CCLPNA83E41G713I', 'venduto', 'Vaso con fiori rossi in ceramica', 'vaso', 'hobby', 'altro', 24, 'comeNuovo', 8, NULL, NULL, 4, 'pubblica', 'Pistoia', 'Pistoia'),
('2021-01-11 22:03:23', 'CCLPNA83E41G713I', 'inVendita', 'Reflex appena presa', 'Reflex', 'fotoEVideo', 'macchineFotografiche', 350, 'comeNuovo', 1, NULL, NULL, NULL, 'pubblica', 'Pistoia', 'Pistoia'),
('2021-01-11 22:22:54', 'CLMMTN00L51A794O', 'inVendita', 'borsa rossa alla moda', 'borsa ', 'abbigliamento', 'borse', 39, 'comeNuovo', 3, NULL, NULL, NULL, 'pubblica', 'Bergamo', 'Bergamo'),
('2021-01-11 22:32:28', 'CRVLRT87R11C559Q', 'inVendita', 'Quadro su papiro', 'quadro', 'hobby', 'altro', 25, 'usurato', 83, NULL, NULL, NULL, 'pubblica', 'Imperia', 'Imperia'),
('2021-01-11 22:44:33', 'CSTNAI91R69G113A', 'inVendita', 'DVD le crociate', 'DVD', 'hobby', 'filmEDVD', 10, 'comeNuovo', 18, NULL, NULL, NULL, 'pubblica', 'Sassari', 'Sassari'),
('2021-01-11 23:14:21', 'CTRRSS96D57A401O', 'inVendita', 'carte per tarocchi', 'tarocchi', 'hobby', 'altro', 210, 'buono', 70, NULL, NULL, NULL, 'pubblica', 'Roma', 'Roma');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `annuncio`
--
ALTER TABLE `annuncio`
  ADD PRIMARY KEY (`dataOraPubblicazione`,`venditore`),
  ADD KEY `annuncio_fk1` (`venditore`),
  ADD KEY `annuncio_fk2` (`comune`,`provincia`);

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `annuncio`
--
ALTER TABLE `annuncio`
  ADD CONSTRAINT `annuncio_fk1` FOREIGN KEY (`venditore`) REFERENCES `utente` (`codiceFiscale`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `annuncio_fk2` FOREIGN KEY (`comune`,`provincia`) REFERENCES `areageografica` (`comune`, `provincia`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
