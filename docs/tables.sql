CREATE TABLE log (
    id int NOT NULL AUTO_INCREMENT,
    ts VARCHAR(250),
    event VARCHAR(250),
    email VARCHAR(250),
    url VARCHAR(250),
    status VARCHAR(250),
    reason VARCHAR(250),
    type VARCHAR(250),
    category VARCHAR(250),
    PRIMARY KEY (id)
);

CREATE TABLE campaigns (
    id int NOT NULL AUTO_INCREMENT,
    list_id VARCHAR(250),
    campaign VARCHAR(250),
    subject VARCHAR(250),
    PRIMARY KEY (id)
);

CREATE TABLE contactLists (
    id int NOT NULL AUTO_INCREMENT,
    list_name VARCHAR(250),
    PRIMARY KEY (id)
);
