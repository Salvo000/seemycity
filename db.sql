
create database seemycity; 
use seemycity;

show tables;


CREATE TABLE Citta (
	Nome varchar(30) NOT NULL PRIMARY KEY,
	Regione varchar(30) NOT NULL,
	Stato varchar(30) NOT NULL
) ENGINE=InnoDB;


create table Utente (
	Nickname varchar(50) primary key,
	Email varchar(200) not null,
	Password varchar(200) not null,
	dataNascita date,
	CittaResidenza varchar(30) references Citta(nome) on update cascade on delete cascade,-- deve essere  una tra le città delle attrattive
	Tipo ENUM("Premium", "Semplice", "Gestore"),
	Stato int DEFAULT 1
)Engine = INNODB;

CREATE TABLE Attrattiva (
	Nome varchar(30) NOT NULL,
	NomeCitta varchar(30) NOT NULL REFERENCES Citta(Nome),
	Indirizzo varchar(30) NOT NULL,
	Longitudine decimal(11,8) NOT NULL,
	Latitudine decimal(10,8) NOT NULL,
	NicknameUtente varchar(30) NOT NULL REFERENCES Utente(Nickname),
	foto varchar(100) NOT NULL,
	PRIMARY KEY(Nome, NomeCitta)
) ENGINE=InnoDB;

CREATE TABLE Monumento (
	NomeAttrattiva varchar(30) NOT NULL,
	NomeCitta varchar(30) NOT NULL,
	Descrizione varchar(100) NOT NULL,
	Stato ENUM("Visitabile","Non visitabile","Visitabile gratis") NOT NULL,
	FOREIGN KEY(NomeAttrattiva, NomeCitta) REFERENCES Attrattiva(Nome, NomeCitta) on update cascade on delete cascade,
	PRIMARY KEY(NomeAttrattiva, NomeCitta)
) ENGINE=InnoDB;

CREATE TABLE AttivitaRicreativa (
	NomeAttrattiva varchar(30) NOT NULL,
	NomeCitta varchar(30) NOT NULL,
	Prezzo int(5) NOT NULL,
	OrarioApertura TIME NOT NULL,
	OrarioChiusura TIME NOT NULL,
	GiornoChiusura varchar(20) NOT NULL,
	FOREIGN KEY(NomeAttrattiva, NomeCitta) REFERENCES Attrattiva(Nome, NomeCitta) on update cascade on delete cascade,
	PRIMARY KEY(NomeAttrattiva, NomeCitta)
) ENGINE=InnoDB;

insert into AttivitaCommerciale()
insert into Evento values("Pasqua2018"," Questa è una descrizione finta, serve solo a riempire il record",Today(),Hour(),100,"Aperto", "PrositBistro", Scicli,"Michele");

CREATE TABLE AttivitaCommerciale (
	NomeAttrattiva varchar(30) NOT NULL,
	NomeCitta varchar(30) NOT NULL,
	Telefono varchar(15) NOT NULL,
	SitoWeb varchar(30) NOT NULL,
	FOREIGN KEY(NomeAttrattiva, NomeCitta) REFERENCES Attrattiva(Nome, NomeCitta) on update cascade on delete cascade,
	PRIMARY KEY(NomeAttrattiva, NomeCitta)
) ENGINE=InnoDB;


CREATE TABLE Foto (
	Codice varchar(100) NOT NULL PRIMARY KEY,
	Titolo varchar(30) NOT NULL,
	NomeCitta varchar(30) NOT NULL REFERENCES Citta(Nome) on update cascade on delete cascade,
	PathFoto varchar(100) NOT NULL 
) ENGINE=InnoDB;

CREATE TABLE Percorso (
	Codice varchar(30) NOT NULL PRIMARY KEY,
	Durata TIME NOT NULL,
	Nome varchar(30) NOT NULL,
	Categoria ENUM("Arte","Storia","Natura","Gastronomico","Relax","Misto"),
	NomeCitta varchar(30) NOT NULL REFERENCES Citta(Nome) on update cascade on delete cascade,
	NicknameUtente varchar(30) NOT NULL REFERENCES Utente(Nickname) on update cascade on delete cascade,
	Next_Attrattiva_Ord int NOT NULL DEFAULT 0
) ENGINE=InnoDB;



create table Evento(
	Titolo varchar(100) primary key,
	Descrizione varchar(500) not null,
	Data date not null,
	OrarioInizio TIME not null,-- inteso come numero di ore si può usare anche TIME
	CapienzaMax int check( CapienzaMax > 0 ),  --ex field nummPartecipanti ! 
	Stato ENUM("Aperto", "Chiuso") not null, --Stato dell'iscrizione
	AttivitaCommerciale varchar(30),
	NomeCitta varchar(30),
	NicknameUtenteGestore varchar(50) references Utente(Nickname) on update cascade on delete cascade,
	FOREIGN KEY(AttivitaCommerciale, NomeCitta) REFERENCES AttivitaCommerciale(NomeAttrattiva, NomeCitta) on update cascade on delete cascade	
)Engine = INNODB;


insert into Evento values("Pasqua2018"," Questa è una descrizione finta, serve solo a riempire il record",Today(),Hour(),100,"Aperto", "PrositBistro", Scicli,"Michele");

/**
Diversa implementazione: Per avere una tabella che gestisce i propri indici (ordine) automaticamente, potremmo utilizzare il tipo di tabella MyIsam,
che permette di riferire l'indice (ovvero l'ordine dell'attrattiva) al codice del percorso, cosicchè quando inseriamo un attrattiva per un percorso,
questa avrà già l'ordine automaticamente impostatogli dalla tabella. 

Link: https://dev.mysql.com/doc/refman/5.7/en/example-auto-increment.html

Link per soluzione con InnoDb: https://www.ryadel.com/mysql-chiave-primaria-primary-key-a-due-colonne-con-auto-increment/

*/
create table Inclusione( 
	NomeAttrattiva varchar(30) NOT NULL,
	NomeCitta varchar(30) NOT NULL,
	CodicePercorso varchar(30) references Percorso(Codice) on update cascade on delete cascade,
	Ordine int NOT NULL ,
	TempoVisita Time NOT NULL, 
	FOREIGN KEY(NomeAttrattiva, NomeCitta) REFERENCES Attrattiva(Nome, NomeCitta) on update cascade on delete cascade,
	PRIMARY KEY(CodicePercorso, Ordine)
)Engine = INNODB;

create table Preferiti(
	NicknameUtente varchar(50) references Utente(Nickname) on update cascade on delete cascade,
	CodicePercorso varchar(30) references Percorso(Codice) on update cascade on delete cascade,
	NotaDescrittiva varchar(500) default null,
	primary key (NicknameUtente,CodicePercorso)	
)Engine = INNODB;

create table Follower(		
	NicknameUtente varchar(50) references Utente(Nickname) on update cascade on delete cascade,
	TitoloEvento varchar(50) references Evento(Titolo) on update cascade on delete cascade,
	primary key (NicknameUtente , TitoloEvento)
)Engine = INNODB;

create table Commento(		
	Id int auto_increment primary key,
	Recensione varchar(200) NOT NULL,
	DataInserimento date not null,
	Votazione int CHECK(Votazione >= 1 AND Votazione <= 5),
	TempoVisita Time not null,
	GiornoVisita date not null,
	NomeAttrattiva varchar(30) NOT NULL,
	NomeCitta varchar(30) NOT NULL,
	NicknameUtente varchar(50) references Utente(Nickname) on update cascade on delete cascade,
	FOREIGN KEY(NomeAttrattiva, NomeCitta) REFERENCES Attrattiva(Nome, NomeCitta) on update cascade on delete cascade
)Engine = INNODB;

create table Messaggio(
	Codice int auto_increment primary key,
	Titolo varchar(100) not null,
	Data date not null,
	Descrizione varchar(300) NOT NULL,
	NicknameMittente varchar(50) not null references Utente(Nickname) on update cascade on delete cascade,
	NicknameDestinatario varchar(50) not null references Utente(Nickname) on update cascade on delete cascade
)Engine = INNODB;




/*
--load data local infile "/Users/salvatorefiorilla/Desktop/Università/BD/utenti.txt" into table Utente;
*/



-- ************************************************* TRIGGERS *****************************************************************

--trigger da fare:
-- UTILIZZARE UN TRIGGER PER IMPLEMENTARE IL PASSAGGIO DA UTENTE SEMPLICE AD UNTENTE PREMIUM

-- TESTATO: FUNZIONA

DROP TRIGGER IF EXISTS NextUserLevel;
DELIMITER
|
CREATE TRIGGER NextUserLevel 
	AFTER INSERT ON Attrattiva
	FOR EACH ROW 
	BEGIN
		DECLARE a varchar(50);
		DECLARE tipoUtente ENUM("Premium", "Semplice", "Gestore");
		SET a = (SELECT COUNT(*) FROM Attrattiva WHERE NicknameUtente = new.NicknameUtente );
		SET tipoUtente = (SELECT Tipo FROM Utente WHERE Nickname = new.NicknameUtente);
		IF(a > 2  && tipoUtente = "Semplice") THEN
			UPDATE Utente SET Utente.Tipo = "Premium" WHERE Utente.Nickname = new.NicknameUtente;
		END IF;
	END;
|
DELIMITER ;

/**
Trigger che setta lo stato di un Evento a "Chiuso" quando il numero di partecipanti è uguale alla capienza massima dell'evento.

TESTATO: FUNZIONA
*/

DROP TRIGGER IF EXISTS CloseEvent;
DELIMITER |
CREATE TRIGGER CloseEvent 
	AFTER INSERT ON Follower
	FOR EACH ROW
	BEGIN
		DECLARE totFollower INT;
		DECLARE capMax INT;
		SET totFollower = (SELECT COUNT(*) AS Tot FROM Follower WHERE new.TitoloEvento = Follower.TitoloEvento);
		SET capMax = (SELECT CapienzaMax FROM Evento WHERE new.TitoloEvento = Evento.Titolo);
		IF(totFollower = CapMax)
			THEN UPDATE Evento SET Evento.Stato = "Chiuso" WHERE Evento.Titolo = new.TitoloEvento;
		END IF;
	END;
|
DELIMITER ;



/*
	Tutte le volte che viene inserita una nuova attrattiva all' interno di un percorso, 
	automaticamente questa viene messa in ordine, come se l'ordine fosse gestito come un intero autoincrementante
	collegato al codice del percorso.

	TESTATA: FUNZIONA
*/
DROP TRIGGER IF EXISTS BeforeInsertInPath;
DELIMITER
|
CREATE TRIGGER BeforeInsertInPath BEFORE INSERT ON Inclusione
FOR EACH ROW
BEGIN
DECLARE v_id int UNSIGNED DEFAULT 0;

  SELECT Next_Attrattiva_Ord + 1 into v_id FROM Percorso WHERE Codice = new.CodicePercorso;
  SET new.Ordine = v_id;
  UPDATE Percorso SET Next_Attrattiva_Ord = v_id WHERE Codice = new.CodicePercorso;

END;
|
DELIMITER ;

--*********************************************************************************************************************************




-- ************************************************* PROCEDURE *****************************************************************

/**
	Procedura che gestisce la richiesta di registrazione da parte di un visitatore della piattaforma.
	Possiamo mettere che crea l'utente nel db se non è presente e che magari è meglio se lo fa in atomico.
	La creazione dell'utente nella piattaforma viene effettuata tramite "Dynamic SQL".

	TESTATA: FUNZIONA
*/
--questa procedula la si esegue da webuser_not_registred e poi permette la creazione di un nuovo utente semplice o di un utente gestore
/** DA METTERE A POSTO CON LA SINTASSI DELLA PROCEDURA LOGIN*/

DROP PROCEDURE IF EXISTS SignUp;
DELIMITER
|
CREATE PROCEDURE SignUp (IN Nickname varchar(50), 
						 IN Email varchar(200), 
						 IN Password varchar(200), 
						 IN dataNascita DATE, 
						 IN CittaResidenza varchar(30), 
						 IN Tipo ENUM("Premium", "Semplice", "Gestore"), 
						 OUT result BOOLEAN)
	BEGIN	
		IF NOT EXISTS(SELECT * 
					  FROM Utente AS u 
					  WHERE u.Nickname = Nickname) THEN
			IF NOT EXISTS(SELECT *
						  FROM Citta AS c
						  WHERE c.Nome = CittaResidenza) THEN
				SET result = (FALSE);
			ELSE
				IF(Tipo = "Semplice" or tipo = "Gestore") THEN
					START TRANSACTION;
						INSERT INTO Utente VALUES(Nickname, Email, Password, dataNascita, CittaResidenza, Tipo, 1);
						SELECT "Utente inserito";
						SET result = (TRUE);
					COMMIT WORK;
				ELSE 
					SET result = (FALSE);
				END IF;
			END IF;
		ELSE
			SET result = (FALSE);
		END IF;
	END;
|
DELIMITER ;


CALL SignUp('salvo','sf@gmail.com','salvo01','1957-02-02','Milano','Semplice',@res);
SELECT @res;

/**
Procedura che gestisce il tentativo di accesso alla piattaforma da parte dell'utente.
*/
-- TESTATA: FUNZIONA
DROP PROCEDURE IF EXISTS LogIn;
DELIMITER
|
create PROCEDURE LogIn (IN Nickname varchar(50),IN Password varchar(200), OUT result BOOLEAN)
	BEGIN
		DECLARE statoUtente int;
		SET statoUtente = (SELECT u.Stato
						   FROM Utente AS u
						   WHERE u.Nickname = Nickname);
		IF(statoUtente = 1) THEN
			IF NOT EXISTS(SELECT *
						  FROM Utente AS u
						  WHERE u.Nickname = Nickname) THEN
				SET result = (FALSE);
			ELSE
				IF NOT EXISTS(SELECT *
						      FROM Utente AS u
						      WHERE u.Nickname = Nickname AND u.Password = Password) THEN
					SET result = (FALSE);
				ELSE
					SET result = (TRUE);		
				END IF;
			END IF;
		ELSE 
			SET result = (FALSE);
		END IF;
	END;
|
DELIMITER ;

CALL LogIn("salvo","salvo01",@res);
SELECT @res;

/*
	Procedura che gestisce la cancellazione di un utente.
	TESTATA: FUNZIONA
*/

DROP PROCEDURE IF EXISTS DeleteUtente;
DELIMITER
| 
CREATE PROCEDURE DeleteUtente (IN NickUser varchar(50), IN PassUser varchar(200), OUT result BOOLEAN)
	BEGIN
		IF EXISTS(SELECT *
				  FROM Utente AS u
				  WHERE u.Nickname = NickUser AND u.Password = PassUser) THEN
			START TRANSACTION;
				UPDATE Utente
				SET Utente.Stato = 0
				WHERE Utente.Nickname = NickUser;
			COMMIT WORK;
			SET result = (TRUE);
		ELSE
			SET result = (FALSE);
		END IF;
	END;
|
DELIMITER ;

CALL DeleteUtente("sudoku","pass",@res);
SELECT @res;

/*
	Procedura che permette l'inserimento di una nuova città.

	TESTATA: FUNZIONA
*/

DROP PROCEDURE IF EXISTS InsertCitta;
DELIMITER
|
CREATE PROCEDURE InsertCitta(IN Nome varchar(30), IN Regione varchar(30), IN Stato varchar(30), OUT result BOOLEAN)
	BEGIN
		IF EXISTS(SELECT *
				  FROM Citta AS c
				  WHERE c.Nome = Nome AND c.Regione = Regione ) THEN
			SET result = (FALSE);
		ELSE
			START TRANSACTION;
				INSERT INTO Citta VALUES(Nome, Regione, Stato);
			COMMIT WORK;
			SET result = (TRUE);
		END IF;
	END;
|
DELIMITER ;

CALL InsertCitta("Siviglia", "Andalusia", "Spagna",@res);
SELECT @res;

DROP PROCEDURE IF EXISTS InsertFoto;
DELIMITER
|
CREATE PROCEDURE InsertFoto(IN CodiceFoto varchar(100), 
							IN TitoloFoto varchar(30), 
							IN NomeCitta varchar(30), 
							IN PathFoto varchar(100), 
							OUT result BOOLEAN)
	BEGIN
		IF NOT EXISTS(SELECT *
				  FROM Foto AS f
				  WHERE f.Codice = CodiceFoto) THEN
			IF EXISTS(SELECT *
					  FROM Citta AS c
					  WHERE c.Nome = NomeCitta) THEN
				START TRANSACTION;
					INSERT INTO Foto VALUES(CodiceFoto, TitoloFoto, NomeCitta, PathFoto);
				COMMIT WORK;
				SET result = (TRUE);
			ELSE
				SET result = (FALSE);
			END IF;
		ELSE
			SET result = (FALSE);
		END IF;
	END;
|
DELIMITER ;

--Inserire una nuova attrattiva per la città in cui si risiede
--Da cambiare, meglio far scegliere all'utente che attrattiva inserire 
--tramite tre pulsanti "Monumento", "AtivitaCommerciale", "AttivitaRicreativa"
--Per ognuno di questi bottoni si aprirà una schermata diversa

DROP PROCEDURE IF EXISTS InsertMonumento;
DELIMITER
|
CREATE PROCEDURE InsertMonumento(IN NomeAttrattiva varchar(30), 
								 IN NomeCitta varchar(30), 
								 IN Indirizzo varchar(30), 
								 IN Longitudine decimal(11,8), 
								 IN Latitudine decimal(10,8), 
								 IN NicknameUtente varchar(30), 
								 IN Foto varchar(100), 
								 IN Descrizione varchar(100), 
								 IN Stato ENUM("Visitabile", "Non visitabile", "Visitabile gratis"),
								 OUT result BOOLEAN)
	BEGIN
		DECLARE cittaUtente varchar(30);
		DECLARE tipoUtente ENUM("Semplice", "Premium", "Gestore");
		SET tipoUtente = (SELECT u.Tipo FROM Utente AS u WHERE u.Nickname = NicknameUtente);
		SET cittaUtente = (SELECT u.CittaResidenza FROM Utente AS u WHERE u.Nickname = NicknameUtente);
		IF(tipoUtente <> "Gestore") THEN
			IF(cittaUtente = NomeCitta) THEN
				IF EXISTS(SELECT *
						  FROM Attrattiva AS a
						  WHERE a.Nome = NomeAttrattiva AND a.NomeCitta = NomeCitta) THEN
					SET result = (FALSE);
				ELSE
					START TRANSACTION;
						INSERT INTO Attrattiva VALUES(NomeAttrattiva, NomeCitta, Indirizzo, Longitudine, Latitudine, NicknameUtente, Foto);
						INSERT INTO Monumento VALUES(NomeAttrattiva, NomeCitta, Descrizione, Stato);
					COMMIT WORK;
					SET result = (TRUE);
				END IF;
			ELSE
				SET result = (FALSE);
			END IF;
		ELSE
			SET result = (FALSE);
		END IF;
	END;
|
DELIMITER ;

CALL InsertMonumento("Università Bicocca","Milano", "via scampi 49", 45.513656, 9.211307, "snorlax", "nnnn", "Università di scienza e ricerca", "Non visitabile", @res);
SELECT @res;

DROP PROCEDURE IF EXISTS InsertAttivitaRicreativa;
DELIMITER
|
CREATE PROCEDURE InsertAttivitaRicreativa(IN NomeAttrattiva varchar(30), 
								 		  IN NomeCitta varchar(30), 
								 		  IN Indirizzo varchar(30), 
								          IN Longitudine decimal(11,8), 
								          IN Latitudine decimal(10,8), 
								          IN NicknameUtente varchar(30), 
								          IN Foto varchar(100),
								          IN Prezzo int(5),
										  IN OrarioApertura TIME,
										  IN OrarioChiusura TIME,
										  IN GiornoChiusura varchar(20),
								          OUT result BOOLEAN)
	BEGIN
		DECLARE cittaUtente varchar(30);
		DECLARE tipoUtente ENUM("Semplice", "Premium", "Gestore");
		SET tipoUtente = (SELECT u.Tipo FROM Utente AS u WHERE u.Nickname = NicknameUtente);
		SET cittaUtente = (SELECT u.CittaResidenza FROM Utente AS u WHERE u.Nickname = NicknameUtente);
		IF(tipoUtente <> "Gestore") THEN
			IF(cittaUtente = NomeCitta) THEN
				IF EXISTS(SELECT *
						  FROM Attrattiva AS a
						  WHERE a.Nome = NomeAttrattiva AND a.NomeCitta = NomeCitta) THEN
					SET result = (FALSE);
				ELSE
					START TRANSACTION;
						INSERT INTO Attrattiva VALUES(NomeAttrattiva, NomeCitta, Indirizzo, Longitudine, Latitudine, NicknameUtente, Foto);
						INSERT INTO AttivitaRicreativa VALUES(NomeAttrattiva, NomeCitta, Prezzo, OrarioApertura, OrarioChiusura, GiornoChiusura);
					COMMIT WORK;
					SET result = (TRUE);
				END IF;
			ELSE
				SET result = (FALSE);
			END IF;
		ELSE
			SET result = (FALSE);
		END IF;	
	END;
|
DELIMITER ;

CALL InsertAttivitaRicreativa("PamLocal","Bologna","Via Marconi",41.922307,12.506857,"pam","",10,"09:30:00","17:00:00","Domenica",@res);
SELECT @res;



DROP PROCEDURE IF EXISTS InsertAttivitaCommerciale;
DELIMITER
|
CREATE PROCEDURE InsertAttivitaCommerciale(IN NomeAttrattiva varchar(30), 
								 		   IN NomeCitta varchar(30), 
								 		   IN Indirizzo varchar(30), 
								           IN Longitudine decimal(11,8), 
								           IN Latitudine decimal(10,8), 
								           IN NicknameUtente varchar(30), 
								           IN Foto varchar(100),
								           IN Telefono varchar(15),
								           IN SitoWeb varchar(30),
								           OUT result BOOLEAN)
	BEGIN
		DECLARE tipoUtente ENUM("Premium", "Semplice", "Gestore");
		DECLARE cittaUtente varchar(30);
		SET tipoUtente = (SELECT u.Tipo FROM Utente as u WHERE u.Nickname = NicknameUtente);
		SET cittaUtente = (SELECT u.CittaResidenza FROM Utente AS u WHERE u.Nickname = NicknameUtente);
		IF(cittaUtente = NomeCitta) THEN
			IF(tipoUtente = "Gestore") THEN
				IF EXISTS(SELECT *
					      FROM Attrattiva AS a
					      WHERE a.Nome = NomeAttrattiva AND a.NomeCitta = NomeCitta) THEN
					SET result = (FALSE);
				ELSE
					START TRANSACTION;
						INSERT INTO Attrattiva VALUES(NomeAttrattiva, NomeCitta, Indirizzo, Longitudine, Latitudine, NicknameUtente, Foto);
						INSERT INTO AttivitaCommerciale VALUES(NomeAttrattiva, NomeCitta, Telefono, SitoWeb);
					COMMIT WORK;
					SET result = (TRUE);
				END IF;
			ELSE 
				SET result = (FALSE);
			END IF;
		ELSE
			SET result = (FALSE);
		END IF;
	END;
|
DELIMITER ;

CALL InsertAttivitaCommerciale("Ludoteca Magica","Carpi","via del corso",41.922307,12.506857,"alle10","vvv","059656565", "www.ognu.it",@res);
SELECT @res;





/** Stored procedure che permette ad utente di inserire un commento per una specifica attrattiva.

	Possibile implementazione dell'interfaccia utente: 
	1) L'utente vuole inserire un commento.
	2) Va nella home (in cui avrà una TextBox di ricerca) e digita il nome dell'attrattiva.
	3) L'utente sceglie tra le attrattive mostrate con lo stesso nome, e verrà portato ad una schermata con l'attrattiva scelta.
	4) L'utente scrive un commento nell'attrattiva (cliccando sul bottone "Commenta").

	In questo caso non bisognerà effettuare un controllo che l'attrattiva e la città siano esistenti, poichè ci penserà già l'interfaccia grafica.
	Per il tempo di visita e la votazione utilizzare "Custom Checkbox" in Bootstrap e per il giorno di visita mostrare calendario.
	Successivamente passeremo queste scelte al database.
	
	***Percui non bisognerà effettuare controlli tramite database.***

	TESTATO: FUNZIONA

*/

DROP PROCEDURE IF EXISTS InsertComment;
DELIMITER
|
CREATE PROCEDURE InsertComment (IN Recensione varchar(200),
								IN Votazione int, 
								IN TempoVisita TIME, 
								IN giornoVisita DATE,
								IN NomeAttrattiva varchar(30), 
								IN NomeCitta varchar(30), 
								IN NicknameUtente varchar(50),
								OUT result BOOLEAN)
	BEGIN
		START TRANSACTION;
			INSERT INTO Commento VALUES(0, Recensione, NOW(), Votazione, TempoVisita, giornoVisita, NomeAttrattiva, NomeCitta, NicknameUtente);
			SET result = (TRUE);
		COMMIT WORK;
	END;
|
DELIMITER ;

CALL InsertComment("Molto interessante!",4,"00:50:00","2018-03-03","Colosseo","Roma","snorlax",@res);
SELECT @res;


/** Stored procedure che permette l'inserimento di un percorso tra i "Preferiti".
	1 -> Inserimento riuscito	0 -> Inserimento non riuscito
	Possibile interfaccia grafica: Di fianco al percorso vi è un bottone "Aggiungi a Preferiti" oppure "+".
	Percui non ci sarà bisogno di effettuare un controllo sull'esistenza di un percorso con quel codice,
	poichè tutto verrà gestito tramite interfaccia grafica.

	TESTATO: FUNZIONA
*/

DROP PROCEDURE IF EXISTS InsertFavoritePath;
DELIMITER
|
CREATE PROCEDURE InsertFavoritePath(IN NicknameUtente varchar(50), IN CodicePercorso varchar(30), IN NotaDescrittiva varchar(500), OUT result BOOLEAN)
	BEGIN
		DECLARE tipoUtente ENUM("Semplice", "Premium", "Gestore");
		SET tipoUtente = (SELECT u.Tipo FROM Utente AS u WHERE u.Nickname = NicknameUtente);
		IF(tipoUtente <> "Gestore") THEN
			IF NOT EXISTS(SELECT *
						  FROM Preferiti AS p
						  WHERE p.NicknameUtente = NicknameUtente AND p.CodicePercorso = CodicePercorso) THEN
				START TRANSACTION;
					INSERT INTO Preferiti VALUES(NicknameUtente, CodicePercorso, NotaDescrittiva);
					SET result = (TRUE);
				COMMIT WORK;
			ELSE
				SET result = (FALSE);
			END IF;
		ELSE
			SET result = (FALSE);
		END IF;
	END;
|
DELIMITER ;

/** Stored procedure che permette la cancellazione di un percorso tra i "Preferiti"
	1 - Cancellazione riuscita	0 -> Cancellazione non riuscita

	Possibile interfaccia grafica 1: Quando l'utente visualizza la sua lista dei "Preferiti",
	di fianco ad ognuno di essi vi sarà un bottone "-" con il quale potrà eleminiare quel percorso.

	Possibile interfaccia grafica: Di fianco al percorso vi è un bottone "-".
	In questo caso il controllo verrà effettuato da database, poichè si verificherà se il percorso sia presente
	o no nella lista dei "Preferiti" dell'utente.

	TESTATA: FUNZIONA
*/

DROP PROCEDURE IF EXISTS DeleteFavoritePath;
DELIMITER
|
CREATE PROCEDURE DeleteFavoritePath (IN NicknameUtenteIn varchar(50), IN CodicePercorsoIn varchar(30), OUT result BOOLEAN)
	BEGIN
		DECLARE tipoUtente ENUM("Semplice", "Premium", "Gestore");
		SET tipoUtente = (SELECT u.Tipo FROM Utente AS u WHERE u.Nickname = NicknameUtenteIn);
		IF(tipoUtente <> "Gestore") THEN 
			IF EXISTS(SELECT *
					  FROM Preferiti AS p
					  WHERE p.NicknameUtente = NicknameUtenteIn AND p.CodicePercorso = CodicePercorsoIn) THEN
				START TRANSACTION;
					DELETE FROM Preferiti WHERE NicknameUtente = NicknameUtenteIn AND CodicePercorso = CodicePercorsoIn;
					SET result = (TRUE);
				COMMIT WORK;
			ELSE
				SET result = (FALSE);
			END IF;
		ELSE
			SET result = (FALSE);
		END IF;
	END;
|
DELIMITER ;

/** Stored procedure che permette ad un utente di inviare un messaggio ad un altro utente della piattaforma
	1 - Messaggio inviato	0 - Messaggio non inviato

	Tipo verrà passato tramite CheckBox.

	TESTATO: FUNZIONA
*/
DROP PROCEDURE IF EXISTS SendMessage;
DELIMITER
|
CREATE PROCEDURE SendMessage (IN Titolo varchar(100),
							  IN Descrizione varchar(300), 
							  IN NicknameMittente varchar(50), 
							  IN NicknameDestinatario varchar(50),
							  OUT result BOOLEAN)
	BEGIN
		DECLARE statoUtente int;
		SET statoUtente = (SELECT u.Stato 
						   FROM Utente AS u
						   WHERE u.Nickname = NicknameDestinatario);
		IF(statoUtente = 1) THEN
			IF NOT EXISTS(SELECT *
					  FROM Utente AS u
					  WHERE u.Nickname = NicknameDestinatario) THEN
				SET result = (FALSE);
			ELSEIF (NicknameMittente = NicknameDestinatario) THEN
				SET result = (FALSE);
			ELSE
				START TRANSACTION;
					INSERT INTO Messaggio VALUES(0, Titolo, NOW(), Descrizione, NicknameMittente, NicknameDestinatario);
					SET result = (TRUE);
				COMMIT WORK;
			END IF;
		ELSE
			SET result = (FALSE);
		END IF;
	END;
|
DELIMITER ;

/*
	QUESTA STORE PROCEDURE, DATO UN CODICE DI UN MESSAGGIO LO SEGNA COME LETTO.

*/
DROP PROCEDURE IF EXISTS ackMessageReceived;
DELIMITER
|
CREATE PROCEDURE AckMessageReceived(IN Mittente varchar(50),OUT Result BOOLEAN)
	BEGIN
		START TRANSACTION;
		Update Messaggio set Letto = TRUE where Messaggio.NicknameMittente = Mittente and Letto = FALSE;
		SET Result = (TRUE);
		COMMIT;
	END;
|
DELIMITER ;


/*
	test:
	Delimiter
	|
		begin
			call SendMessage("Titolo","Descrizione", "superusercontrolaccess", "Salvo", "Privato", @Result);
			select @Result;
			DECLARE code int;
			set code = (select Codice from Messaggio where Letto = False) ;
			select code;
			call AckMessageReceived("superusercontrolaccess",@Result);
			select @Result;
		END;
	|
	Delimiter;
*/


/** Stored procedure che permette ad un utente di ogni tipo di aggiungersi come follower di un evento.

TESTATO: FUNZIONA

*/

DROP PROCEDURE IF EXISTS FollowEvent;
DELIMITER
|
CREATE PROCEDURE FollowEvent (IN NicknameUtente varchar(50), IN TitoloEvento varchar(100), OUT result BOOLEAN)
	BEGIN
		DECLARE statoEvento ENUM("Aperto","Chiuso");
		SET statoEvento = (SELECT e.Stato
						  FROM Evento AS e
						  WHERE e.Titolo = TitoloEvento);
		IF NOT EXISTS(SELECT *
				  	  FROM Evento AS e
				  	  WHERE e.Titolo = TitoloEvento) THEN
			SET result = (FALSE);
		ELSEIF EXISTS(SELECT *
				  	   FROM Follower AS f
				  	   WHERE f.TitoloEvento = TitoloEvento AND f.NicknameUtente = NicknameUtente) THEN
			SET result = (FALSE);
		ELSEIF(statoEvento = "Chiuso") THEN
			SET result = (FALSE);
		ELSE
			START TRANSACTION;
				INSERT INTO Follower VALUES(NicknameUtente, TitoloEvento);
				SET result = (TRUE);
			COMMIT WORK;
		END IF;
	END;
|
DELIMITER ;


/** ******** AZIONI PER I SOLI UTENTI PREMIUM ********** */

/** Aggiugere un percorso esistente tra i propri preferiti.
******* ERRORE NELLE SPECIFICHE: QUESTA AZIONE E' LA STESSA CHE PUO' EFFETTUARE UN UTENTE QUALSIASI. VEDI procedura "InsertFavoritePath".*******
*/

/** Inserire un nuovo percorso.*/

/** TESTATO: FUNZIONA*/

DROP PROCEDURE IF EXISTS InsertPath;
DELIMITER
|
CREATE PROCEDURE InsertPath (IN Codice varchar(30),
							 IN Durata TIME, 
							 IN Nome varchar(30), 
							 IN Categoria ENUM("Arte","Storia","Natura","Gastronomico","Relax","Misto"), 
							 IN NomeCitta varchar(30), 
							 IN NicknameUtente varchar(50),
							 OUT result BOOLEAN)
	BEGIN
		DECLARE cittaUtente varchar(30);
		DECLARE tipoUtente ENUM("Premium", "Semplice", "Gestore");
		SET cittaUtente = (SELECT u.CittaResidenza
						   FROM Utente AS u
						   WHERE u.Nickname = NicknameUtente);
		SET tipoUtente = (SELECT u.Tipo
						  FROM Utente AS u
						  WHERE u.Nickname = NicknameUtente);

		IF(tipoUtente = "Premium") THEN

			IF EXISTS(SELECT *
					  FROM Percorso AS p
					  WHERE p.Codice = Codice) THEN
				SET result = (FALSE);
			ELSEIF(cittaUtente <> NomeCitta) THEN
				SET result = (FALSE);
			ELSE
				START TRANSACTION;
					INSERT INTO Percorso() VALUES(Codice, Durata, Nome, Categoria, NomeCitta, NicknameUtente,0); 
					SET result = (TRUE);
				COMMIT WORK ;
			END IF;

		ELSE
			SET result = (FALSE);
		END IF;
	END;
|
DELIMITER ;

CALL InsertPath("a1","03:00:00","Scoprire Carpi","Storia","Carpi","ciccio",@res);
SELECT @res;

/** Inserire una nuova attrattiva in un percorso.*/

DROP PROCEDURE IF EXISTS InsertAttrattivaInPath;
DELIMITER
|
CREATE PROCEDURE InsertAttrattivaInPath (IN NomeAttrattiva varchar(30),
										 IN NomeCitta varchar(30),
									 	 IN CodicePercorso varchar(30), 
									 	 IN TempoVisita Time,
									 	 IN NicknameUtente varchar(50),
									 	 OUT result BOOLEAN)
	BEGIN

		DECLARE tipoUtente ENUM("Premium", "Semplice", "Gestore");
		DECLARE nickUser varchar(50);
		DECLARE cittaPercorso varchar(30);
		SET nickUser = (SELECT p.NicknameUtente
						FROM Percorso AS p
						WHERE p.Codice = CodicePercorso);
		SET tipoUtente = (SELECT u.Tipo
						  FROM Utente AS u
						  WHERE u.Nickname = nickUser);

		SET cittaPercorso = (SELECT p.NomeCitta
							 FROM Percorso AS p
							 WHERE p.Codice = CodicePercorso);

		IF(cittaPercorso = NomeCitta AND nickUser = NicknameUtente) THEN
			IF(tipoUtente = "Premium") THEN
				IF EXISTS(SELECT *
						  FROM Attrattiva AS a
						  WHERE a.Nome = NomeAttrattiva AND a.NomeCitta = NomeCitta) THEN

					START TRANSACTION;
						INSERT INTO Inclusione(NomeAttrattiva, NomeCitta, CodicePercorso, TempoVisita) VALUES(NomeAttrattiva, NomeCitta, CodicePercorso, TempoVisita);
						SET result = (TRUE);
					COMMIT WORK;
			
				ELSE
					SET result = (FALSE);
				END IF;
			ELSE
				SET result = (FALSE);
			END IF;
		ELSE
			SET result = (FALSE);
		END IF;

	END;
|
DELIMITER ;

CALL InsertAttrattivaInPath("Ludoteca Magica", "Carpi", "a1", 10, @res);
SELECT @res;



/** ******** AZIONI PER I SOLI UTENTI GESTORI ********** */

/** Inserire un nuovo evento

	TESTATA: FUNZIONA.
 */

DROP PROCEDURE IF EXISTS AddEvent;
DELIMITER
|
CREATE PROCEDURE AddEvent (IN Titolo varchar(100), 
						   IN Descrizione varchar(500), 
						   IN Data DATE, 
						   IN OrarioInizio TIME, 
						   IN CapienzaMax INT, 
						   IN Stato ENUM("Aperto", "Chiuso"),
						   IN AttivitaCommerciale varchar(30),
						   IN NomeCitta varchar(30),
						   IN NicknameUtenteGestore varchar(50),
						   OUT result BOOLEAN)
	BEGIN
		DECLARE tipoUtente ENUM("Premium", "Semplice", "Gestore");
		SET tipoUtente = (SELECT u.Tipo
						  FROM Utente AS u
						  WHERE u.Nickname = NicknameUtenteGestore);

		IF(tipoUtente = "Gestore") THEN

			IF NOT EXISTS(SELECT *
						  FROM Evento AS e
						  WHERE e.Titolo = Titolo) THEN

				IF EXISTS(SELECT *
						  FROM AttivitaCommerciale AS a 
						  WHERE a.NomeAttrattiva = AttivitaCommerciale AND a.NomeCitta = NomeCitta) THEN
					START TRANSACTION;
						INSERT INTO Evento VALUES(Titolo, Descrizione, Data, OrarioInizio, CapienzaMax, Stato, AttivitaCommerciale, NomeCitta, NicknameUtenteGestore);
						SET result = (TRUE);
					COMMIT WORK;
				ELSE
					SET result = (FALSE);
				END IF;

			ELSE
				SET result = (FALSE);
			END IF;

		ELSE
			SET result = (FALSE);
		END IF;

	END;
|
DELIMITER ;



/********************************************************
	TESTATA FUNZIONA 
	CALL UnfollowEvent("max","TitoloEventoUno",@Res);
	select @Res;
********************************************************/

DROP PROCEDURE IF EXISTS UnfollowEvent;
DELIMITER
|
CREATE PROCEDURE UnfollowEvent (IN NicknameUtente varchar(50), IN TitoloEvento varchar(100), OUT result BOOLEAN)
	BEGIN
		DECLARE statoEvento ENUM("Aperto","Chiuso");
		SET statoEvento = (SELECT e.Stato
						  FROM Evento AS e
						  WHERE e.Titolo = TitoloEvento);
		IF NOT EXISTS(SELECT *
				  	  FROM Evento AS e
				  	  WHERE e.Titolo = TitoloEvento) THEN
			SET result = (FALSE);
		ELSEIF NOT EXISTS(SELECT *
				  	   FROM Follower AS f
				  	   WHERE f.TitoloEvento = TitoloEvento AND f.NicknameUtente = NicknameUtente) THEN
			SET result = (FALSE);
		ELSEIF(statoEvento = "Chiuso") THEN
			SET result = (FALSE);
		ELSE
			START TRANSACTION;
				DELETE FROM Follower WHERE (Follower.TitoloEvento = TitoloEvento AND Follower.NicknameUtente = NicknameUtente);
				SET result = (TRUE);
			COMMIT WORK;
		END IF;
	END;
|
DELIMITER ;


DROP VIEW IF EXISTS tab;
create view tab(Nome,Citta,DayWeek,TempoVisita,NumVisitorsToTime) as 
 select c.NomeAttrattiva as nome, c.Nomecitta as Citta, dayofweek(c.GiornoVisita) as DayWeek, c.TempoVisita, count(*) as NumVisitorsToTime 
 from Commento as c 
 group by c.NomeAttrattiva,c.NomeCitta,DayWeek,c.TempoVisita;




--********************************************************************************************************************************************

INSERT INTO Citta VALUES("Bologna","Emilia Romagna","Italia");
INSERT INTO Citta VALUES("Roma","Lazio","Italia");
INSERT INTO Citta VALUES("Milano","Lombardia","Italia");

INSERT INTO Utente VALUES("utente1","email1","utente1","1996-04-04","Milano","Semplice",1);
INSERT INTO Utente VALUES("utente2","email2","utente2","1986-04-13","Milano","Premium",1);
INSERT INTO Utente VALUES("utente3","email3","utente3","1990-05-13","Roma","Gestore",1);

INSERT INTO Attrattiva VALUES("Stadio Meazza","Milano","Via Laveno,12",9.13821000,45.47676000,"utente1","uploads/meazza.jpg");
INSERT INTO AttivitaRicreativa VALUES("Stadio Meazza","Milano",15,"12:00:00","24:00:00","Lunedi");
INSERT INTO Attrattiva VALUES("Chiesa San Tomaso","Milano","Via S. Tomaso,5",9.18486490,45.46717490,"utente2","uploads/tomaso.jpg");
INSERT INTO Monumento VALUES("Chiesa San Tomaso","Milano","Chiesa antica","Visitabile");
INSERT INTO Attrattiva VALUES("Bella Vista Cafe","Milano","Via Broletto,18",9.18622730,45.46667530,"utente3","uploads/bellavista.jpg");
INSERT INTO AttivitaCommerciale VALUES("Bella Vista Cafe","Milano","33465265","www.bellavista.it");

INSERT INTO Percorso VALUES("P1","02:30:00","Giro per Milano","Storia","Milano","utente2",0);

INSERT INTO Inclusione VALUES("Stadio Meazza","Milano","P1",1,"00:30:00");
INSERT INTO Inclusione VALUES("Chiesa San Tomaso","Milano","P1",2,"01:30:00");
INSERT INTO Inclusione VALUES("Bella Vista Cafe","Milano","P1",3,"00:30:00");


INSERT INTO Evento VALUES("Degustazione vini","Degustazione per principianti","2018-05-15","15:00:00",4,"Aperto","Bella Vista Cafe","Milano","utente3");

INSERT INTO Preferiti VALUES("utente1","P1","Interessante");
INSERT INTO Preferiti VALUES("utente2","P1","Mia creazione");

INSERT INTO Follower VALUES("utente1","Degustazione vini");
INSERT INTO Follower VALUES("utente2","Degustazione vini");


INSERT INTO Commento VALUES(1,"Bellissimo stadio","2018-05-01",4,"15:00:00","2018-05-01","Stadio Meazza", "Milano","utente2");
INSERT INTO Commento VALUES(2,"Stadio da ristrutturare","2018-05-04",4,"18:00:00","2018-04-01","Stadio Meazza", "Milano","utente1");
INSERT INTO Commento VALUES(3,"Stadio magnifico","2018-05-04",4,"18:00:00","2018-04-01","Stadio Meazza", "Milano","utente1");
INSERT INTO Commento VALUES(4,"Stadio storico","2018-05-04",4,"18:00:00","2018-04-01","Stadio Meazza", "Milano","utente2");
INSERT INTO Commento VALUES(5,"Luci a SanSiro","2018-05-04",4,"18:00:00","2018-04-01","Stadio Meazza", "Milano","utente3");
INSERT INTO Commento VALUES(6,"di quella sera","2018-05-04",4,"19:30:00","2018-04-01","Stadio Meazza", "Milano","utente3");
INSERT INTO Commento VALUES(7,"che c'è di strano siamo stati tutti là","2018-05-04",4,"19:30:00","2018-04-01","Stadio Meazza", "Milano","utente2");


INSERT INTO Messaggio VALUES(1,"Saluto","2018-05-04","Ciao come stai?","utente1","utente2");
INSERT INTO Messaggio VALUES(2,"Risposta","2018-05-05","Tutto bene grazie","utente2","utente1");
INSERT INTO Messaggio VALUES(3,"Richiesta","2018-05-05","Ciao, vuoi fare un affare?","utente3","utente1");