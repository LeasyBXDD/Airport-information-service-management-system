drop database if exists FlightReservation;

CREATE DATABASE FlightReservation;
USE FlightReservation;

CREATE TABLE Customer (
  CustomerID INT PRIMARY KEY,
  Name VARCHAR(50) NOT NULL,
  ContactInfo VARCHAR(100) -- specify data type
);

CREATE TABLE Aircraft (
  AircraftID INT PRIMARY KEY,
  AircraftType VARCHAR(20) NOT NULL,
  NumberOfSeats INT NOT NULL
);

CREATE TABLE Airport (
  AirportCode CHAR(3) PRIMARY KEY,
  AirportName VARCHAR(50) NOT NULL
);

CREATE TABLE Flight (
  FlightID INT PRIMARY KEY,
  FlightNumber VARCHAR(10) NOT NULL,
  DepartureTime DATETIME NOT NULL,
  ArrivalTime DATETIME NOT NULL,
  FlightStatus VARCHAR(20) NOT NULL,
  AircraftID INT NOT NULL,
  DepartureAirportCode CHAR(3) NOT NULL, -- add not null constraint
  ArrivalAirportCode CHAR(3) NOT NULL, -- add not null constraint
  FOREIGN KEY (AircraftID) REFERENCES Aircraft(AircraftID),
  FOREIGN KEY (DepartureAirportCode) REFERENCES Airport(AirportCode), -- add foreign key to airport table
  FOREIGN KEY (ArrivalAirportCode) REFERENCES Airport(AirportCode) -- add foreign key to airport table
);

CREATE TABLE Reservation (
  ReservationID INT PRIMARY KEY,
  CustomerID INT NOT NULL,
  FlightID INT NOT NULL,
  ReservationDate DATE NOT NULL DEFAULT (CURRENT_DATE), -- use parentheses around CURRENT_DATE
  FOREIGN KEY (CustomerID) REFERENCES Customer(CustomerID),
  FOREIGN KEY (FlightID) REFERENCES Flight(FlightID)
);

CREATE TABLE Seat (
  SeatID INT PRIMARY KEY,
  SeatNumber VARCHAR(5) NOT NULL,
  AircraftID INT NOT NULL, -- change the order of columns
  FOREIGN KEY (AircraftID) REFERENCES Aircraft(AircraftID)
);

CREATE TABLE ReservationSeatAssignment (
  ReservationID INT,
  SeatID INT,
  FlightID INT,
  PRIMARY KEY (ReservationID, SeatID, FlightID),
  FOREIGN KEY (ReservationID) REFERENCES Reservation(ReservationID),
  FOREIGN KEY (SeatID) REFERENCES Seat(SeatID),
  FOREIGN KEY (FlightID) REFERENCES Flight(FlightID)
);


-- 为Customer表生成十条数据
INSERT INTO Customer (CustomerID, Name, ContactInfo) VALUES
(1, 'John Smith', 'johnsmith@example.com'),
(2, 'Jane Doe', 'janedoe@example.com'),
(3, 'Bob Johnson', 'bjohnson@example.com'),
(4, 'Alice Brown', 'abrown@example.com'),
(5, 'David Lee', 'davidlee@example.com'),
(6, 'Mary Jones', 'mjones@example.com'),
(7, 'Tom Wilson', 'twilson@example.com'),
(8, 'Karen Davis', 'kdavis@example.com'),
(9, 'Steve Adams', 'sadams@example.com'),
(10, 'Lisa Taylor', 'ltaylor@example.com');

-- 为Aircraft表生成十条数据
INSERT INTO Aircraft (AircraftID, AircraftType, NumberOfSeats) VALUES
(1, 'Boeing 747', 416),
(2, 'Airbus A380', 853),
(3, 'Boeing 787', 330),
(4, 'Airbus A330', 440),
(5, 'Embraer E190', 114),
(6, 'Bombardier CRJ900', 90),
(7, 'Boeing 737', 189),
(8, 'Airbus A320', 180),
(9, 'Boeing 777', 550),
(10, 'Airbus A350', 440);

-- 为Airport表生成十条数据
INSERT INTO Airport (AirportCode, AirportName) VALUES
('JFK', 'John F. Kennedy International Airport'),
('LAX', 'Los Angeles International Airport'),
('ORD', 'OH International Airport'),
('HND', 'Tokyo Haneda International Airport'),
('LHR', 'Heathrow Airport'),
('CDG', 'Charles de Gaulle Airport'),
('PEK', 'Beijing Capital International Airport'),
('DXB', 'Dubai International Airport'),
('SYD', 'Sydney Kingsford-Smith Airport'),
('BOM', 'ChiMaharaj International Airport');

-- 为Flight表生成十条数据
INSERT INTO Flight (FlightID, FlightNumber, DepartureTime, ArrivalTime, FlightStatus, AircraftID, DepartureAirportCode, ArrivalAirportCode) VALUES
(1, 'AA100', '2023-06-01 08:00:00', '2023-06-01 10:30:00', 'On time', 1, 'JFK', 'LAX'),
(2, 'UA200', '2023-06-01 10:00:00', '2023-06-01 12:30:00', 'On time', 2, 'LAX', 'JFK'),
(3, 'DL300', '2023-06-01 12:00:00', '2023-06-01 14:30:00', 'Delayed', 3, 'ORD', 'HND'),
(4, 'JL400', '2023-06-01 14:00:00', '2023-06-02 07:00:00', 'On time', 4, 'HND', 'ORD'),
(5, 'BA500', '2023-06-01 16:00:00', '2023-06-02 07:30:00', 'On time', 5, 'LHR', 'CDG'),
(6, 'AF600', '2023-06-01 18:00:00', '2023-06-02 08:00:00', 'Delayed', 6, 'CDG', 'LHR'),
(7, 'CA700', '2023-06-02 08:00:00', '2023-06-02 20:00:00', 'On time', 7, 'PEK', 'DXB'),
(8, 'EK800', '2023-06-02 10:00:00', '2023-06-02 22:00:00', 'On time', 8, 'DXB', 'SYD'),
(9, 'QF900', '2023-06-02 12:00:00', '2023-06-03 04:00:00', 'On time', 9, 'SYD', 'BOM'),
(10, 'AI1000', '2023-06-02 14:00:00', '2023-06-03 06:00:00', 'Delayed', 10, 'BOM', 'SYD');

-- 为Reservation表生成十条数据
INSERT INTO Reservation (ReservationID, CustomerID, FlightID, ReservationDate) VALUES
(1, 1, 1, '2023-05-23'),
(2, 2, 2, '2023-05-24'),
(3, 3, 3, '2023-05-25'),
(4, 4, 4, '2023-05-26'),
(5, 5, 5, '2023-05-27'),
(6, 6, 6, '2023-05-28'),
(7, 7, 7, '2023-05-29'),
(8, 8, 8, '2023-05-30'),
(9, 9, 9, '2023-05-31'),
(10, 10, 10, '2023-06-01');

-- 为Seat表生成十条数据
INSERT INTO Seat (SeatID, SeatNumber, AircraftID) VALUES
(1, '1A', 1),
(2, '1B', 1),
(3, '2A', 1),
(4, '2B', 1),
(5, '3A', 1),
(6, '3B', 1),
(7, '4A', 1),
(8, '4B', 1),
(9, '5A', 1),
(10, '5B', 1);

-- 为ReservationSeatAssignment表生成十条数据
INSERT INTO ReservationSeatAssignment (ReservationID, SeatID, FlightID) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4),
(5, 5, 5),
(6, 6, 6),
(7, 7, 7),
(8, 8, 8),
(9, 9, 9),
(10, 10, 10);