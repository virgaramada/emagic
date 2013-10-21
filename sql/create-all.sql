DROP TABLE IF EXISTS INV_MGT_CUSTOMER;
DROP TABLE IF EXISTS INV_MGT_DEPOT;
DROP TABLE IF EXISTS INV_MGT_REAL_STOCK;
DROP TABLE IF EXISTS INV_MGT_DELIVERY_REALISATION;
DROP TABLE IF EXISTS INV_MGT_TANK_CAPACITY;
DROP TABLE IF EXISTS INV_MGT_DELIVERY_PLAN;
DROP TABLE IF EXISTS INV_MGT_DIST_LOCATION;
DROP TABLE IF EXISTS INV_MGT_SALES_ORDER;
DROP TABLE IF EXISTS INV_MGT_STATION;
DROP TABLE IF EXISTS WORK_IN_CAPITAL;
DROP TABLE IF EXISTS OVERHEAD_COST;
DROP TABLE IF EXISTS INV_MGT_USER_ROLE;
DROP TABLE IF EXISTS INV_MGT_TYPE;
DROP TABLE IF EXISTS INV_MGT_SUPPLY;
DROP TABLE IF EXISTS INV_MGT_PRICE;
DROP TABLE IF EXISTS INV_MGT_OUTPUT;
DROP TABLE IF EXISTS INV_MGT_MARGIN;

CREATE TABLE INV_MGT_MARGIN (
       ID INT(11) NOT NULL AUTO_INCREMENT
     , INV_TYPE VARCHAR(50) NOT NULL
     , MARGIN_VALUE DECIMAL(10, 2) NOT NULL
     , STATION_ID VARCHAR(50)
     , START_DATE DATETIME
     , END_DATE DATETIME
     , PRIMARY KEY (ID)
);

CREATE TABLE INV_MGT_OUTPUT (
       ID INT(11) NOT NULL AUTO_INCREMENT
     , INV_TYPE VARCHAR(50) NOT NULL
     , CUSTOMER_TYPE VARCHAR(50) NOT NULL
     , OUTPUT_VALUE DECIMAL(50, 2) NOT NULL
     , OUTPUT_DATE DATE NOT NULL
     , UNIT_PRICE DECIMAL(50, 2) NOT NULL
     , BEGIN_STAND_METER DECIMAL(50, 2) DEFAULT 0.00
     , END_STAND_METER DECIMAL(50, 2) DEFAULT 0.00
     , VEHICLE_TYPE VARCHAR(50)
     , TERA_VALUE DECIMAL(10, 2)
     , PUMP_ID VARCHAR(10)
     , NOSEL_ID VARCHAR(10)
     , OUTPUT_TIME VARCHAR(20)
     , CATEGORY VARCHAR(10)
     , STATION_ID VARCHAR(50)
     , PRIMARY KEY (ID)
);

CREATE TABLE INV_MGT_PRICE (
       ID INT(11) NOT NULL AUTO_INCREMENT
     , INV_TYPE VARCHAR(50) NOT NULL
     , UNIT_PRICE DECIMAL(10, 2) NOT NULL
     , CATEGORY VARCHAR(10)
     , STATION_ID VARCHAR(50)
     , START_DATE DATETIME
     , END_DATE DATETIME
     , PRIMARY KEY (ID)
);

CREATE TABLE INV_MGT_SUPPLY (
       ID INT(11) NOT NULL AUTO_INCREMENT
     , INV_TYPE VARCHAR(50) NOT NULL
     , SUPPLY_VALUE DECIMAL(50, 2) NOT NULL
     , SUPPLY_DATE DATE NOT NULL
     , DELIVERY_ORDER_NUMBER VARCHAR(20) NOT NULL
     , PLATE_NUMBER VARCHAR(20)
     , NIAP_NUMBER VARCHAR(20)
     , STATION_ID VARCHAR(50)
     , PRIMARY KEY (ID)
);

CREATE TABLE INV_MGT_TYPE (
       ID INT(11) NOT NULL AUTO_INCREMENT
     , INV_TYPE VARCHAR(50) NOT NULL
     , INV_DESC VARCHAR(50)
     , PRODUCT_TYPE VARCHAR(10) NOT NULL
     , UNIQUE UQ_INV_MGT_TYPE_1 (INV_TYPE)
     , PRIMARY KEY (ID)
);

CREATE TABLE INV_MGT_USER_ROLE (
       ID INT(11) NOT NULL AUTO_INCREMENT
     , USER_NAME VARCHAR(50) NOT NULL
     , USER_PASSWORD VARCHAR(255) NOT NULL
     , USER_ROLE VARCHAR(20) NOT NULL
     , FIRST_NAME VARCHAR(50) NOT NULL
     , LAST_NAME VARCHAR(50) NOT NULL
     , STATION_ID VARCHAR(50)
     , EMAIL_ADDRESS VARCHAR(50)
     , ACCOUNT_ACTIVATED VARCHAR(3)
     , UNIQUE UQ_INV_MGT_USER_ROLE_1 (USER_NAME)
     , PRIMARY KEY (ID)
);

CREATE TABLE OVERHEAD_COST (
       ID INT(11) NOT NULL AUTO_INCREMENT
     , OVH_CODE VARCHAR(20) NOT NULL
     , OVH_DESC VARCHAR(50) NOT NULL
     , OVH_VALUE DECIMAL(50, 2) NOT NULL
     , OVH_DATE DATE NOT NULL
     , STATION_ID VARCHAR(50)
     , PRIMARY KEY (ID)
);

CREATE TABLE WORK_IN_CAPITAL (
       ID INT(11) NOT NULL AUTO_INCREMENT
     , C_VALUE DECIMAL(50, 2) NOT NULL
     , C_DESC VARCHAR(10)
     , C_CODE VARCHAR(10) NOT NULL
     , STATION_ID VARCHAR(50)
     , PRIMARY KEY (ID)
);

CREATE TABLE INV_MGT_STATION (
       ID INT(11) NOT NULL AUTO_INCREMENT
     , STATION_ID VARCHAR(50) NOT NULL
     , STATION_ADDRESS VARCHAR(50)
     , LOCATION_CODE VARCHAR(50) NOT NULL
     , SUPPLY_POINT_DISTANCE DECIMAL(50, 2)
     , MAX_TOLERANCE DECIMAL(50, 2)
     , STATION_STATUS VARCHAR(50)
     , UNIQUE UQ_INV_MGT_STATION_1 (STATION_ID)
     , PRIMARY KEY (ID)
);

CREATE TABLE INV_MGT_SALES_ORDER (
       ID INT(11) NOT NULL AUTO_INCREMENT
     , INV_TYPE VARCHAR(50) NOT NULL
     , QUANTITY DECIMAL(50) NOT NULL
     , BANK_TRANSFER_DATE DATETIME NOT NULL
     , DELIVERY_DATE DATE NOT NULL
     , DELIVERY_SHIFT_NUMBER VARCHAR(10) NOT NULL
     , BANK_NAME VARCHAR(50) NOT NULL
     , BANK_ACCOUNT_NUMBER VARCHAR(50) NOT NULL
     , SALES_ORDER_NUMBER VARCHAR(50) NOT NULL
     , STATION_ID VARCHAR(50) NOT NULL
     , ORDER_MESSAGE VARCHAR(255)
     , ORDER_STATUS VARCHAR(10)
     , ORDER_DATE DATETIME
     , RECEIVE_DATE DATETIME
     , UNIQUE UQ_INV_MGT_SALES_ORDER_1 (SALES_ORDER_NUMBER, STATION_ID)
     , PRIMARY KEY (ID)
);

CREATE TABLE INV_MGT_DIST_LOCATION (
       ID INT(11) NOT NULL AUTO_INCREMENT
     , LOCATION_CODE VARCHAR(50) NOT NULL
     , LOCATION_NAME VARCHAR(50)
     , SUPPLY_POINT VARCHAR(50) NOT NULL
     , SALES_AREA_MANAGER VARCHAR(50) NOT NULL
     , DEPOT_CODE VARCHAR(50)
     , UNIQUE UQ_INV_MGT_DIST_LOCATION_1 (LOCATION_CODE)
     , PRIMARY KEY (ID)
);

CREATE TABLE INV_MGT_DELIVERY_PLAN (
       ID INT(11) NOT NULL AUTO_INCREMENT
     , INV_TYPE VARCHAR(50) NOT NULL
     , QUANTITY DECIMAL(50, 2) NOT NULL
     , DELIVERY_DATE DATE NOT NULL
     , DELIVERY_SHIFT_NUMBER VARCHAR(10) NOT NULL
     , SALES_ORDER_NUMBER VARCHAR(50) NOT NULL
     , STATION_ID VARCHAR(50) NOT NULL
     , DELIVERY_MESSAGE VARCHAR(255)
     , PLAN_STATUS VARCHAR(10)
     , PRIMARY KEY (ID)
);

CREATE TABLE INV_MGT_TANK_CAPACITY (
       ID INT(11) AUTO_INCREMENT
     , INV_TYPE VARCHAR(50) NOT NULL
     , TANK_CAPACITY DECIMAL(50, 2) NOT NULL
     , STATION_ID VARCHAR(50) NOT NULL
     , PRIMARY KEY (ID)
);

CREATE TABLE INV_MGT_DELIVERY_REALISATION (
       ID INT(11) NOT NULL AUTO_INCREMENT
     , SALES_ORDER_NUMBER VARCHAR(50) NOT NULL
     , STATION_ID VARCHAR(50) NOT NULL
     , INV_TYPE VARCHAR(50) NOT NULL
     , QUANTITY DECIMAL(50, 2) NOT NULL
     , PLATE_NUMBER VARCHAR(20) NOT NULL
     , DRIVER_NAME VARCHAR(50) NOT NULL
     , DELIVERY_DATE DATE NOT NULL
     , DELIVERY_TIME VARCHAR(20) NOT NULL
     , DELIVERY_SHIFT_NUMBER VARCHAR(10) NOT NULL
     , DELIVERY_MESSAGE VARCHAR(255)
     , PRIMARY KEY (ID)
);

CREATE TABLE INV_MGT_REAL_STOCK (
       ID INT(11) NOT NULL AUTO_INCREMENT
     , INV_TYPE VARCHAR(50) NOT NULL
     , START_DATE DATETIME NOT NULL
     , END_DATE DATETIME NOT NULL
     , QUANTITY DECIMAL(50, 2) NOT NULL
     , STATION_ID VARCHAR(50) NOT NULL
     , PRIMARY KEY (ID)
);

CREATE TABLE INV_MGT_DEPOT (
       ID INT(11) NOT NULL AUTO_INCREMENT
     , DEPOT_CODE VARCHAR(50) NOT NULL
     , DEPOT_NAME VARCHAR(50) NOT NULL
     , DEPOT_ADDRESS VARCHAR(50) NOT NULL
     , PRIMARY KEY (ID)
);

CREATE TABLE INV_MGT_CUSTOMER (
       ID INT(11) NOT NULL AUTO_INCREMENT
     , CUSTOMER_TYPE VARCHAR(50) NOT NULL
     , CUSTOMER_DESC VARCHAR(50)
     , CATEGORY VARCHAR(10)
     , PRIMARY KEY (ID)
);

