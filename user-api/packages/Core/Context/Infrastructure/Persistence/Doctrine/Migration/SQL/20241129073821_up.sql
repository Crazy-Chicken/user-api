CREATE TABLE users
(
    id                       BINARY(16)   NOT NULL PRIMARY KEY,
    login                    VARCHAR(256) NOT NULL UNIQUE,
    password                 VARCHAR(256) NOT NULL,
    name_first               VARCHAR(256) NOT NULL,
    name_second              VARCHAR(256) NOT NULL,
    name_last                VARCHAR(256) NULL,
    update_date              DATETIME     NOT NULL
);

CREATE TABLE accesses
(
    id                      BINARY(16)  NOT NULL PRIMARY KEY,
    nick                    VARCHAR(256)  NOT NULL,
    name                    VARCHAR(256)  NOT NULL
);

CREATE TABLE a_users_accesses
(
    user_id BINARY(16) NOT NULL,
    access_id BINARY(16) NOT NULL,
    PRIMARY KEY(user_id, access_id)
);

CREATE UNIQUE INDEX UNIQ_9CC89677A76ED3954FEA67CF ON a_users_accesses (user_id, access_id);

ALTER TABLE a_users_accesses
    ADD CONSTRAINT FK_9CC89677A76ED395 FOREIGN KEY (user_id) REFERENCES users (id);
ALTER TABLE a_users_accesses
    ADD CONSTRAINT FK_9CC896774FEA67CF FOREIGN KEY (access_id) REFERENCES accesses (id);
