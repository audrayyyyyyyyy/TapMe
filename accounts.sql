CREATE DATABASE TapMe;

CREATE TABLE account (
    AccountID INT AUTO_INCREMENT PRIMARY KEY,
    Firstname VARCHAR(100) NOT NULL,
    Lastname VARCHAR(100) NOT NULL,
    Email VARCHAR(100) NOT NULL,
    Password VARCHAR(100) NOT NULL
);

INSERT INTO account (Firstname, Lastname, Email, Password) 
VALUES 
('Jansen'           ,'Baloaloa' , 'jansen.baloaloa@yahoo.com'   , '1234'),
('Audray Mae'       ,'Valdez'   , 'audray.valdez@yahoo.com'     , '1234'),
('Seah'             ,'Ubado'    , 'seah_ubado@gmail.com'        , '1234'),
('Eunice Lyka'      ,'Dorilag'  , 'eunice_dorilag@gmail.com'    , '1234'),
('123'              ,'456'      , '1234@1234.com'               , '1234'),
('Michael Angelo'   ,'Burac'    , 'michaelburac@yahoo.com'      , '1234');


CREATE TABLE Conversation (
    ConversationID INT AUTO_INCREMENT PRIMARY KEY,
    Account1 INT NOT NULL,
    Account2 INT NOT NULL,
    
    LastMessage INT,
    LastSender INT,

    FOREIGN KEY (Account2) REFERENCES account(AccountID),
    FOREIGN KEY (Account1) REFERENCES account(AccountID),
    FOREIGN KEY (LastSender) REFERENCES account(AccountID),
    FOREIGN KEY (LastMessage) REFERENCES Message(MessageID)
);

CREATE TABLE Message (
    MessageID INT AUTO_INCREMENT PRIMARY KEY,
    ConversationID INT NOT NULL,
    Content VARCHAR(256) NOT NULL,
    DateTime DATETIME NOT NULL,
    Sender INT NOT NULL,
    FOREIGN KEY (ConversationID)    REFERENCES Conversation(ConversationID),
    FOREIGN KEY (Sender)            REFERENCES account(AccountID)
);