CREATE DATABASE wsbrasil;

USE wsbrasil;


CREATE TABLE User(
id INT,
username VARCHAR(255),
password VARCHAR(255),
registration_date DATETIME,
last_login_date DATETIME,
PRIMARY KEY (id)
);
CREATE TABLE Category(
categoryid INT,
name VARCHAR(255),
PRIMARY KEY (categoryid));

CREATE TABLE State(
stateId INT,
name VARCHAR(255),
acronym VARCHAR(2),
PRIMARY KEY (stateId));

CREATE TABLE City(
cityId INT, 
name VARCHAR(255),
stateid INT,
PRIMARY KEY (cityId),
FOREIGN KEY (stateid) REFERENCES State(stateId));

CREATE TABLE Neighborhood(
neighborhoodId INT,
name VARCHAR(255),
cityid INT,
PRIMARY KEY (neighborhoodId),
FOREIGN KEY (cityid) REFERENCES City(cityId)
);

CREATE TABLE Realty(
realtyid INT,
address VARCHAR(255),
num_rooms INT,
offer_type BIT,
rooms_qt INT, 
toilet_qt INT,
parkingspace_qt INT,
value FLOAT,
comment TEXT,
neighborhoodId INT,
categoryid INT,

PRIMARY KEY (realtyid),
FOREIGN KEY (categoryid) REFERENCES Category(categoryid),
FOREIGN KEY (neighborhoodId) REFERENCES neighborhood(neighborhoodId)
);

CREATE TABLE AmenityRealty(
amenityId INT,
realtyid INT,
numAmenity INT,
FOREIGN KEY (amenityId) REFERENCES amenity(amenityId),
FOREIGN KEY (realtyid) REFERENCES realty(realtyid),
PRIMARY KEY (realtyid, amenityId)
);

CREATE TABLE Image(
imageId INT,
filepath TEXT,
upload_date DATETIME,
isThumbnail bit,
realtyid INT,
PRIMARY KEY (imageId),
FOREIGN KEY (realtyid) REFERENCES realty(realtyid));