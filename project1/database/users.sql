CREATE TABLE User (
    userId INT primary key,
    userName TEXT unique not null,
    password TEXT not null
);

insert INTO User (userName, password) VALUES("antonioalmeida", "9613c98430aa75fcce457d97056a42c49be41c84");
insert INTO User (userName, password) VALUES("diogotorres97", "894ff497ca1c634444f1dcc66b3aa6766a78efbf");
insert INTO User (userName, password) VALUES("cyrilico", "153bca65a1343c229bce8e08d8b8d28a61f6a55a");
