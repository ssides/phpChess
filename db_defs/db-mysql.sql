use Chess;

drop table if exists `Player`;
create table `Player` (
  `ID` varchar(38) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Token` varchar(255) NOT NULL,
  `IsActive` enum('0','1') NOT NULL,
  `InsertDate` datetime NOT NULL
);

create unique index ix_PlayerID on `Player`(`ID`);
create unique index ix_PlayerName on `Player`(`Name`);

drop table if exists `UserProfile`;
create table `UserProfile`
(
  `ID` varchar(38) not null primary key, 
  `PlayerID` varchar(38) not null,
  `OriginalName` varchar(256) not null,
  `OriginalSavedPath` varchar(256) not null,
  `OriginalContentType` varchar(256) not null,
  `OriginalFileSize` int(10) not null,
  `InsertDate` datetime not null,
  `OriginalScale` decimal(15,13) null,
  `DisplayScale` decimal(15,13) null,
  `ThumbnailPath` varchar(256) null, 
  `HOffset` int null,
  `VOffset` int null,
  constraint `FK_UserProfile_Player` foreign key (`PlayerID`) references `Player`(`ID`)
);

drop table if exists `Game`;
create table `Game`
(
  `ID` varchar(38) not null primary key, 
  `Organizer` varchar(38) not null, 
  `Opponent` varchar(38) null, 
  `GameStartDate` datetime null, 
  `GameFinishDate` datetime null,
  `OpponentInviteDate` datetime null, 
  `OpponentJoinDate` datetime null, 
  `OpponentColor` char(1) null, -- 'W' or 'B'
  `OrganizerClock` int null,
  `OpponentClock` int null,
  `IsTimed` enum('0','1') null default '0',
  `Turn` char(1) null,  -- O(R)ganizer or O(P)ponent
  `InsertDate` datetime not null,
  `UpdateDate` datetime null,
  constraint `FK_GameOrganizer_Player` foreign key (`Organizer`) references `Player`(`ID`),
  constraint `FK_GameOpponent_Player` foreign key (`Opponent`) references `Player`(`ID`)
 );

drop table if exists `Piece`;
create table `Piece`
(
  `ID` varchar(38) not null primary key, 
  `GameID` varchar(38) not null,
  `SquareID` char(2) not null, 
  `PieceID` char(2) not null, 
  `IsMoving` char(1) not null, -- (M)oving or move(D)
  `IsInPlay` enum('0','1') not null default '1',
  `InsertDate` datetime not null,
  `UpdateDate` datetime null,
  constraint `FK_Piece_Game` foreign key (`GameID`) references `Game`(`ID`)
 );

-- make sure there are never two pieces on the same square in the same game.
create unique index ix_Piece on `Piece`(`GameID`,`SquareID`);
