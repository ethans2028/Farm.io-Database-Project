use bw_dbXX; #replace with own bw database name

CREATE TABLE  Farm  (
   fid   INTEGER NOT NULL,
   name  VARCHAR(30) NOT NULL,
   email  VARCHAR(30) NOT NULL,
   phone  VARCHAR(20) NOT NULL,
   address  VARCHAR(50) NOT NULL,
   city  VARCHAR(20) NOT NULL,
   state  VARCHAR(15) NOT NULL,
   zip   INTEGER NOT NULL,
   PRIMARY KEY(fid)
);


CREATE TABLE  Product  (
   pid   INTEGER NOT NULL,
   name  varchar(100) DEFAULT NULL,
   PRIMARY KEY ( pid )
);

CREATE TABLE  Store  (
  sid  INTEGER NOT NULL,
  name VARCHAR(40) NOT NULL,
  email VARCHAR(30) NOT NULL,
  phone VARCHAR(20) NOT NULL,
  address VARCHAR(50) NOT NULL,
  city VARCHAR(40) NOT NULL,
  state VARCHAR(20) NOT NULL,
  zip VARCHAR(10) NOT NULL,
  PRIMARY KEY(sid)
);

CREATE TABLE  Vehicle  (
  d_fname VARCHAR(50),
  d_lname VARCHAR(50),
  license VARCHAR(50),
  PRIMARY KEY(license)
);

CREATE TABLE  bw_dbXX.Order  (
   oid   INTEGER NOT NULL,
   day  date NOT NULL,
   PRIMARY KEY ( oid )
);

CREATE TABLE  Contains  (
   oid  	  INTEGER NOT NULL,
   pid  	  INTEGER NOT NULL,
   quantity   INTEGER NOT NULL,
   FOREIGN KEY (oid) REFERENCES bw_dbXX.Order(oid),
   FOREIGN KEY (pid) REFERENCES Product(pid),
   PRIMARY KEY(oid, pid)
);

CREATE TABLE  Delivers  (
   oid   INTEGER NOT NULL,
   license  VARCHAR(50),
   FOREIGN KEY (oid) REFERENCES bw_dbXX.Order(oid),
   FOREIGN KEY (license) REFERENCES Vehicle(license),
   PRIMARY KEY (oid, license)
);

CREATE TABLE  Owns  (
   license  VARCHAR(50) NOT NULL,
   fid   INTEGER NOT NULL,
   FOREIGN KEY (fid) REFERENCES Farm(fid),
   FOREIGN KEY (license) REFERENCES Vehicle(license),
   PRIMARY KEY(license, fid)
);

CREATE TABLE  Places  (
   oid   INTEGER NOT NULL,
   sid   INTEGER NOT NULL,
   FOREIGN KEY (oid) REFERENCES bw_dbXX.Order(oid),
   FOREIGN KEY (sid) REFERENCES Store(sid),
   PRIMARY KEY(oid, sid)
);

CREATE TABLE  Produces  (
   fid     INTEGER NOT NULL,
   pid     INTEGER NOT NULL,
   inStock INTEGER NOT NULL,
   cost  double NOT  NULL,
   FOREIGN KEY (fid) REFERENCES Farm(fid),
   FOREIGN KEY (pid) REFERENCES Product(pid),
   PRIMARY KEY(fid, pid)
);

CREATE TABLE  Fulfills  (
   oid   INTEGER NOT NULL,
   fid   INTEGER NOT NULL,
   FOREIGN KEY (oid) REFERENCES bw_dbXX.Order(oid),
   FOREIGN KEY (fid) REFERENCES Farm(fid),
   PRIMARY KEY (oid, fid)
);