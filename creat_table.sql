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
    Seat_ID INT REFERENCES Seats(ID),
    Price DECIMAL(10, 2)
);

CREATE TABLE Seats (
    ID SERIAL PRIMARY KEY,
    Hall_ID INT REFERENCES Halls(ID),
    Row_Number INT,
    Seat_Number INT,
    Status VARCHAR(20) DEFAULT 'available' -- Статусы: available, reserved, sold
);

--Эта таблица задает коэффициенты для цены в зависимости от дня недели и времени суток.


CREATE TABLE PricingRules (
    ID SERIAL PRIMARY KEY,
    Day_of_Week VARCHAR(20), -- Например, Monday, Tuesday и т. д.
    Time_of_Day VARCHAR(20), -- Утро, день, вечер, ночь
    Price_Coefficient DECIMAL(4, 2) -- Коэффициент (например, 0.8, 1.0, 1.2)
);

--Содержит информацию о популярности фильма и соответствующем коэффициенте.


CREATE TABLE MovieRating (
    ID SERIAL PRIMARY KEY,
    Movie_ID INT REFERENCES Movies(ID),
    Popularity_Rating INT, -- Рейтинг популярности, например, от 1 до 5
    Price_Coefficient DECIMAL(4, 2) -- Коэффициент на основе рейтинга популярности
);