CREATE DATABASE IF NOT EXISTS dbMall
  CHARACTER SET utf8mb4;
USE dbMall;

CREATE TABLE IF NOT EXISTS admin (
  aID       INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
  aName     VARCHAR(20)              NOT NULL UNIQUE,
  aPassword VARCHAR(32)              NOT NULL,
  aSalt     CHAR(4)                  NOT NULL
);

INSERT INTO admin
SET aName = 'admin', aPassword = MD5('123456..msho'), aSalt = 'msho';
INSERT INTO admin
SET aName = 'adMan', aPassword = MD5('123456EcX7'), aSalt = 'EcX7';

CREATE TABLE IF NOT EXISTS admin_login_log (
  adminID        INT UNSIGNED NOT NULL,
  adminLoginTime DATETIME     NOT NULL,
  adminLoginIP   VARCHAR(35)  NOT NULL,
  CONSTRAINT FK_adminID FOREIGN KEY (adminID) REFERENCES admin (aID)
    ON DELETE NO ACTION
);

CREATE VIEW viewAdminLog AS
  SELECT
    a.aName AS 'adminName',
    b.adminLoginTime,
    b.adminLoginIP
  FROM admin a,
    admin_login_log b
  WHERE a.aID = b.adminID;

CREATE TABLE IF NOT EXISTS sale_users (
  sID       INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
  sName     VARCHAR(20)              NOT NULL UNIQUE,
  sPassword VARCHAR(32)              NOT NULL,
  sSalt     CHAR(4)                  NOT NULL,
  shopName  VARCHAR(25)              NOT NULL
);

INSERT INTO sale_users
SET sID = 1, sName = 'OfficialShop', shopName = '官方自营店', sPassword = MD5('Ac183Ex7f0Qrfd'), sSalt = 'demo';
INSERT INTO sale_users
SET sID = 2, sName = 'Demo1', shopName = '测试店铺账号1', sPassword = MD5('123456demo'), sSalt = 'demo';

CREATE TABLE IF NOT EXISTS users (
  uID       BIGINT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
  uName     VARCHAR(25)                 NOT NULL UNIQUE,
  uPassword VARCHAR(32)                 NOT NULL,
  uGender   ENUM ('male', 'female')              DEFAULT 'male',
  uEmail    VARCHAR(30),
  uPhone    VARCHAR(20)
);

CREATE TABLE IF NOT EXISTS goodsType (
  tID          INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
  tName        VARCHAR(20)              NOT NULL,
  tDescription TEXT
);

INSERT INTO goodsType (tName) VALUES ('服装'), ('箱包'), ('鞋帽'), ('手机配件'), ('数码周边'), ('动漫周边'), ('其他');

CREATE TABLE IF NOT EXISTS goods (
  gID          BIGINT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
  gName        VARCHAR(35)                 NOT NULL,
  gType        INT UNSIGNED                NOT NULL,
  gPrice       DECIMAL(10, 2)              NOT NULL,
  gOriginPrice DECIMAL(10, 2),
  gCount       INT UNSIGNED                NOT NULL,
  gSoldOutNum  BIGINT UNSIGNED             NOT NULL DEFAULT 0,
  gSalesSUID   INT UNSIGNED                NOT NULL,
  gPhoto       TEXT,
  gDescription TEXT                        NOT NULL,
  gPubTime     DATETIME                    NOT NULL,
  gStatus      ENUM ('0', '1', '2')        NOT NULL DEFAULT '1',
  CONSTRAINT FK_goodsType FOREIGN KEY (gType) REFERENCES goodsType (tID),
  CONSTRAINT FK_goodsSUID FOREIGN KEY (gSalesSUID) REFERENCES sale_users (sID)
);

CREATE TABLE IF NOT EXISTS express_list (
  eID    INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
  eName  VARCHAR(20)              NOT NULL,
  ePhone VARCHAR(20)
);

INSERT INTO express_list (eName) VALUES ('顺丰速运'), ('申通快递'), ('圆通快递'), ('中通快递'), ('韵达快递'), ('EMS'), ('百世汇通');

CREATE TABLE IF NOT EXISTS order_list (
  orderID      VARCHAR(22)               NOT NULL UNIQUE,
  orderCName   VARCHAR(15)               NOT NULL,
  orderAddress TEXT                      NOT NULL,
  orderPhone   VARCHAR(20)               NOT NULL,
  expressID    INT UNSIGNED,
  expressNum   VARCHAR(30),
  orderPaid    ENUM ('0', '1')           NOT NULL DEFAULT '0',
  orderPaidBy  ENUM ('alipay', 'wechat'),
  orderStatus  ENUM ('0', '1', '2', '3') NOT NULL DEFAULT '1',
  CONSTRAINT FK_expressID FOREIGN KEY (expressID) REFERENCES express_list (eID)
);

CREATE TABLE IF NOT EXISTS order_list_item (
  orderID     VARCHAR(22)     NOT NULL,
  orderGID    BIGINT UNSIGNED NOT NULL,
  orderGCount INT UNSIGNED    NOT NULL,
  CONSTRAINT FK_orderID FOREIGN KEY (orderID) REFERENCES order_list (orderID),
  CONSTRAINT FK_orderGID FOREIGN KEY (orderGID) REFERENCES goods (gID)
);

CREATE VIEW viewGoodsDetail AS
  SELECT
    a.gID,
    a.gName,
    a.gType,
    b.tName AS 'goodsTypeName',
    a.gPrice,
    a.gOriginPrice,
    a.gCount,
    a.gSalesSUID,
    c.shopName,
    a.gPhoto,
    a.gDescription,
    a.gPubTime,
    a.gStatus
  FROM
    goods a,
    goodsType b,
    sale_users c
  WHERE a.gType = b.tID
        AND a.gSalesSUID = c.sID;