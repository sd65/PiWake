BEGIN TRANSACTION;

CREATE TABLE 'NOMSPROFS' ('name' TEXT, 'realName' TEXT);

INSERT INTO "NOMSPROFS" ("name","realName") VALUES ('mbornerie','Bornerie');

INSERT INTO "NOMSPROFS" ("name","realName") VALUES ('dreyss','Delphine');

INSERT INTO "NOMSPROFS" ("name","realName") VALUES ('pmetayer','Philippe');

INSERT INTO "NOMSPROFS" ("name","realName") VALUES ('hkromm','Kromm');

INSERT INTO "NOMSPROFS" ("name","realName") VALUES ('vlavilleneau','Valérie');

INSERT INTO "NOMSPROFS" ("name","realName") VALUES ('jpsalmon','JP');

INSERT INTO "NOMSPROFS" ("name","realName") VALUES ('bsafarik','Brad');

COMMIT;