/* Author kevin */

/* Huidige auctions actief */
USE EENMAALANDERMAAL
GO

CREATE VIEW currentAuction AS
SELECT 
	voorwerp.voorwerpnummer,
	max(Bestand.filenaam) as bestand,
	voorwerp.titel,
	max(Bod.bodbedrag) as 'bodbedrag',
	max(voorwerp.looptijdeindeDag)  AS 'einddag',
	max(voorwerp.looptijdeindeTijdstip) AS 'eindtijdstip'
	FROM Voorwerp 
	LEFT JOIN Bod on Bod.voorwerp = Voorwerp.voorwerpnummer
	LEFT JOIN Bestand on Bestand.voorwerp = voorwerp.voorwerpnummer
	WHERE GETDATE() BETWEEN voorwerp.looptijdbeginDag AND voorwerp.looptijdeindeDag
	AND CURRENT_TIMESTAMP between voorwerp.looptijdbeginDag AND voorwerp.looptijdeindeDag
	GROUP BY voorwerp.voorwerpnummer, voorwerp.titel
	
/* Rubriekenboom */
CREATE PROCEDURE STUDENT_MARKS AS
BEGIN
Declare @Top  int = null;          --<<  Sets top of Hier Try 5
with ctePt as (
      Select Seq  = cast(1000+Row_Number() over (Order by rubrieknaam) as varchar(500))
            ,rubrieknummer
            ,rubriek
            ,Lvl=1
            ,rubrieknaam 
      From   Rubriek 
      Where  IsNull(@Top,0) = case when @Top is null then isnull(rubriek,0) else rubrieknummer end
      Union  All
      Select Seq  = cast(concat(p.Seq,'.',100000+Row_Number() over (Order by r.rubrieknaam)) as varchar(500))
            ,r.rubrieknummer
            ,r.rubriek,p.Lvl+1
            ,r.rubrieknaam 
      From   Rubriek r 
      Join   ctePt p  on r.rubriek = p.rubrieknummer)
     ,cteR1 as (Select Seq,rubrieknummer,R1=Row_Number() over (Order By Seq) From ctePt)
     ,cteR2 as (Select A.Seq,A.rubrieknummer,R2=Max(B.R1) From cteR1 A Join cteR1 B on (B.Seq like A.Seq+'%') Group By A.Seq,A.rubrieknummer )
Select B.R1  
      ,C.R2
      ,A.rubrieknummer
      ,A.rubriek
      ,A.Lvl
      ,rubrieknaam = Replicate('',A.Lvl-1) + A.rubrieknaam
 From ctePt A
 Join cteR1 B on A.rubrieknummer=B.rubrieknummer
 Join cteR2 C on A.rubrieknummer=C.rubrieknummer
 Order By B.R1
 END