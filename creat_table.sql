CREATE TABLE Cinema (
    ID SERIAL PRIMARY KEY,
    name VARCHAR(255),
    Address VARCHAR(255)
);

CREATE TABLE Halls (
    ID SERIAL PRIMARY KEY,
    name VARCHAR(255),
    Cinema_ID INT REFERENCES Cinema(ID),
    Number_of_seats
 INT
);

CREATE TABLE Movies (
    ID SERIAL PRIMARY KEY,
    name VARCHAR(255),
    Duration INT,
    Genre VARCHAR(50),
    Price DECIMAL(10, 2)
);

CREATE TABLE Sessions (
    ID SERIAL PRIMARY KEY,
    Дата_и_время TIMESTAMP,
    Hall_ID INT REFERENCES Halls(ID),
    Movie_ID INT REFERENCES Movies(ID)
);

CREATE TABLE Customers (
    ID SERIAL PRIMARY KEY,
    name VARCHAR(255),
    Email VARCHAR(255),
    phone VARCHAR(20)
);

CREATE TABLE Tickets (
    ID SERIAL PRIMARY KEY,
    Session_ID INT REFERENCES Sessions(ID),
    Customer_ID INT REFERENCES Customers(ID),
    place INT,
    Price DECIMAL(10, 2)
);
