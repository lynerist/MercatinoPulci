-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Dic 16, 2020 alle 02:07
-- Versione del server: 10.4.14-MariaDB
-- Versione PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mercatinopulci_corretto`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `acquista`
--

CREATE TABLE `acquista` (
  `dataOraPubblicazione` timestamp NOT NULL DEFAULT current_timestamp(),
  `venditore` varchar(16) NOT NULL,
  `acquirente` varchar(16) NOT NULL,
  `valutazioneSuAcquirente` tinyint(6) UNSIGNED DEFAULT NULL
) ;

--
-- Dump dei dati per la tabella `acquista`
--

INSERT INTO `acquista` (`dataOraPubblicazione`, `venditore`, `acquirente`, `valutazioneSuAcquirente`) VALUES
('2020-11-10 23:35:24', 'LBNLRD99A13F133X', 'JNTCST99L25B729P', 2),
('2020-11-11 14:24:38', 'SLNFPP98S28F205V', 'JNTCST99L25B729P', 5),
('2020-11-11 21:05:17', 'KRSHLN93S53Z347A', 'RSSCCL99D68B157L', 3),
('2020-11-11 21:20:37', 'SLNFPP98S28F205V', 'RSSCCL99D68B157L', 5);

--
-- Trigger `acquista`
--
DELIMITER $$
CREATE TRIGGER `check_acquista_annuncio_in_vendita` BEFORE INSERT ON `acquista` FOR EACH ROW BEGIN

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
DELIMITER $$
CREATE TRIGGER `imposta_statoAnnuncio_venduto` AFTER INSERT ON `acquista` FOR EACH ROW BEGIN

UPDATE annuncio SET statoAnnuncio = 'venduto' WHERE new.dataOraPubblicazione = dataOraPubblicazione AND new.venditore = venditore;

END
$$
DELIMITER ;

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
('2020-11-10 15:32:39', 'LBNLRD99A13F133X', 'inVendita', '1Kg di castagne fresche dalla Brianza.', 'castagne', 'hobby', 'altro', 15, NULL, 0, NULL, NULL, NULL, 'pubblica', 'Merate', 'Lecco'),
('2020-11-10 15:33:29', 'KRSHLN93S53Z347A', 'inVendita', 'Disco in vinile autografato di Gé Korsten fine anni 60.', 'Disco in vinile', 'hobby', 'musica', 75, 'comeNuovo', 612, NULL, NULL, NULL, 'pubblica', 'Milano', 'Milano'),
('2020-11-10 23:35:24', 'LBNLRD99A13F133X', 'venduto', 'Ciabatte usate in buone condizioni', 'Ciabatte', 'abbigliamento', 'altro', 5.99, 'buono', 15, NULL, NULL, NULL, 'pubblica', 'Piombino', 'Livorno'),
('2020-11-11 14:24:38', 'SLNFPP98S28F205V', 'venduto', 'Vendo accappatoio usato in pessime condizioni', 'Accappatoio', 'abbigliamento', 'altro', 1.99, 'usurato', 35, NULL, NULL, NULL, 'pubblica', 'Brescia', 'Brescia'),
('2020-11-11 14:45:17', 'SLNFPP98S28F205V', 'inVendita', 'Vendo \'Apologia di Socrate\'', 'Video', 'hobby', 'libriERiviste', 25, NULL, 0, NULL, NULL, NULL, 'pubblica', 'Cabiate', 'Como'),
('2020-11-11 21:05:17', 'KRSHLN93S53Z347A', 'venduto', 'Vendo un bellissimo bollitore elettrico verde', 'Bollitore', 'elettrodomestici', 'altro', 15.7, 'buono', 3, NULL, NULL, NULL, 'pubblica', 'Erba', 'Como'),
('2020-11-11 21:12:07', 'LBNLRD99A13F133X', 'inVendita', 'Vendo cavalletto multiuso di ultima generazione', 'Cavalletto', 'fotoEVideo', 'accessori', 150, NULL, 0, NULL, NULL, NULL, 'ristretta', 'Merate', 'Lecco'),
('2020-11-11 21:13:47', 'LBNLRD99A13F133X', 'inVendita', 'Vendo macchina fotografica Reflex professionale', 'Reflex', 'fotoEVideo', 'macchineFotografiche', 800, NULL, 0, '2022-05-31', NULL, NULL, 'ristretta', 'Merate', 'Lecco'),
('2020-11-11 21:17:43', 'SLNFPP98S28F205V', 'inVendita', 'Vendo tostapane usato in ottime condizioni', 'Tostapane', 'elettrodomestici', 'tostapane', 59, 'comeNuovo', 2, NULL, NULL, NULL, 'privata', 'Milano', 'Milano'),
('2020-11-11 21:20:37', 'SLNFPP98S28F205V', 'venduto', 'Vendo cassa bluetooth stereo', 'cassa', 'hobby', 'musica', 98, NULL, 0, NULL, NULL, NULL, 'pubblica', 'Milano', 'Milano'),
('2020-11-11 21:22:10', 'KRSHLN93S53Z347A', 'inVendita', 'Vendo pupazzo di spider-man', 'Pupazzo', 'hobby', 'giocattoli', 25, NULL, 0, '2021-01-01', NULL, NULL, 'pubblica', 'Brescia', 'Brescia');

-- --------------------------------------------------------

--
-- Struttura della tabella `areageografica`
--

CREATE TABLE `areageografica` (
  `comune` varchar(35) NOT NULL,
  `provincia` varchar(22) NOT NULL,
  `regione` varchar(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `areageografica`
--

INSERT INTO `areageografica` (`comune`, `provincia`, `regione`) VALUES
('Brescia', 'Brescia', 'Lombardia'),
('Cabiate', 'Como', 'Lombardia'),
('Erba', 'Como', 'Lombardia'),
('Merate', 'Lecco', 'Lombardia'),
('Milano', 'Milano', 'Lombardia'),
('Piombino', 'Livorno', 'Toscana'),
('Verano Brianza', 'Monza e della Brianza', 'Lombardia');

-- --------------------------------------------------------

--
-- Struttura della tabella `areavisibilita`
--

CREATE TABLE `areavisibilita` (
  `dataOraPubblicazione` timestamp NOT NULL DEFAULT current_timestamp(),
  `venditore` varchar(16) NOT NULL,
  `comune` varchar(35) NOT NULL,
  `provincia` varchar(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `areavisibilita`
--

INSERT INTO `areavisibilita` (`dataOraPubblicazione`, `venditore`, `comune`, `provincia`) VALUES
('2020-11-11 21:12:07', 'LBNLRD99A13F133X', 'Merate', 'Lecco'),
('2020-11-11 21:13:47', 'LBNLRD99A13F133X', 'Merate', 'Lecco'),
('2020-11-11 21:13:47', 'LBNLRD99A13F133X', 'Verano Brianza', 'Monza e della Brianza');

--
-- Trigger `areavisibilita`
--
DELIMITER $$
CREATE TRIGGER `check_visibilita` BEFORE INSERT ON `areavisibilita` FOR EACH ROW BEGIN

IF (
    SELECT visibilita 
    FROM annuncio
    WHERE dataOraPubblicazione = new.dataOraPubblicazione
    AND venditore = new.venditore
    ) != 'ristretta'
    THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "ERROR - visibilita non è ristretta";
	END IF;
END
$$
DELIMITER ;

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
('JNTCST99L25B729P', '2020-11-11 21:13:47', 'LBNLRD99A13F133X', NULL),
('RSSCCL99D68B157L', '2020-11-10 15:33:29', 'KRSHLN93S53Z347A', '1'),
('SLNFPP98S28F205V', '2020-11-10 15:33:29', 'KRSHLN93S53Z347A', '0');

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

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `codiceFiscale` varchar(16) NOT NULL,
  `tipoAccount` set('acquirente','venditore','acquirenteVenditore') NOT NULL,
  `nome` varchar(20) NOT NULL,
  `cognome` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `immagine` varchar(30) DEFAULT NULL,
  `comune` varchar(35) NOT NULL,
  `provincia` varchar(22) NOT NULL,
  `eliminato` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`codiceFiscale`, `tipoAccount`, `nome`, `cognome`, `email`, `password`, `immagine`, `comune`, `provincia`, `eliminato`) VALUES
('JNTCST99L25B729P', 'acquirente', 'Jonata', 'Casati', 'J.O.Nathan@vero.joj', 'dokidoki_plinplon', NULL, 'Verano Brianza', 'Monza e della Brianza', '0'),
('KRSHLN93S53Z347A', 'venditore', 'Helene', 'Korsten', 'helly@chenice.za', 'lavitaè#99CBFF', NULL, 'Cabiate', 'Como', '0'),
('LBNLRD99A13F133X', 'venditore', 'Leonardo', 'Albani', 'leonardo@albani.it', 'geocache_castagnose', NULL, 'Milano', 'Milano', '0'),
('RSSCCL99D68B157L', 'acquirente', 'Cecilia', 'Rossi', 'ceciglia@babao.ecco', 'password', NULL, 'Brescia', 'Brescia', '0'),
('SLNFPP98S28F205V', '', 'Filippo', 'Uslenghi', 'popi@naso.eu', 'bicicletta', NULL, 'Merate', 'Lecco', '0');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `acquista`
--
ALTER TABLE `acquista`
  ADD PRIMARY KEY (`dataOraPubblicazione`,`venditore`),
  ADD KEY `acquista_fk1` (`acquirente`);

--
-- Indici per le tabelle `annuncio`
--
ALTER TABLE `annuncio`
  ADD PRIMARY KEY (`dataOraPubblicazione`,`venditore`),
  ADD KEY `annuncio_fk1` (`venditore`),
  ADD KEY `annuncio_fk2` (`comune`,`provincia`);

--
-- Indici per le tabelle `areageografica`
--
ALTER TABLE `areageografica`
  ADD PRIMARY KEY (`comune`,`provincia`);

--
-- Indici per le tabelle `areavisibilita`
--
ALTER TABLE `areavisibilita`
  ADD PRIMARY KEY (`dataOraPubblicazione`,`venditore`,`comune`,`provincia`),
  ADD KEY `areaVisibilita_fk2` (`comune`,`provincia`);

--
-- Indici per le tabelle `osserva`
--
ALTER TABLE `osserva`
  ADD PRIMARY KEY (`acquirente`,`dataOraPubblicazione`,`venditore`),
  ADD KEY `osserva_fk2` (`dataOraPubblicazione`,`venditore`);

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
-- Limiti per la tabella `acquista`
--
ALTER TABLE `acquista`
  ADD CONSTRAINT `acquista_fk1` FOREIGN KEY (`acquirente`) REFERENCES `utente` (`codiceFiscale`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `acquista_fk2` FOREIGN KEY (`dataOraPubblicazione`,`venditore`) REFERENCES `annuncio` (`dataOraPubblicazione`, `venditore`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Limiti per la tabella `annuncio`
--
ALTER TABLE `annuncio`
  ADD CONSTRAINT `annuncio_fk1` FOREIGN KEY (`venditore`) REFERENCES `utente` (`codiceFiscale`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `annuncio_fk2` FOREIGN KEY (`comune`,`provincia`) REFERENCES `areageografica` (`comune`, `provincia`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `areavisibilita`
--
ALTER TABLE `areavisibilita`
  ADD CONSTRAINT `areaVisibilita_fk1` FOREIGN KEY (`dataOraPubblicazione`,`venditore`) REFERENCES `annuncio` (`dataOraPubblicazione`, `venditore`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `areaVisibilita_fk2` FOREIGN KEY (`comune`,`provincia`) REFERENCES `areageografica` (`comune`, `provincia`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `osserva`
--
ALTER TABLE `osserva`
  ADD CONSTRAINT `osserva_fk1` FOREIGN KEY (`acquirente`) REFERENCES `utente` (`codiceFiscale`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `osserva_fk2` FOREIGN KEY (`dataOraPubblicazione`,`venditore`) REFERENCES `annuncio` (`dataOraPubblicazione`, `venditore`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Limiti per la tabella `utente`
--
ALTER TABLE `utente`
  ADD CONSTRAINT `utente_fk1` FOREIGN KEY (`comune`,`provincia`) REFERENCES `areageografica` (`comune`, `provincia`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
