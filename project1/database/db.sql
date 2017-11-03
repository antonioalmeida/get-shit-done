PRAGMA foreign_keys = ON;

--Do NOT alter drop table order
drop table if exists ItemPrecedence;
drop table if exists ListAdmin;
drop table if exists Item;
drop table if exists List;
drop table if exists User;
drop table if exists Category;
drop table if exists Color;

create table Color(
    id integer,
    name text not null,
    constraint ColorPrimaryKey primary key (id),
    constraint ColorUnique unique (name)
);

create table Category(
    id integer,
    name text not null,
    constraint CategoryPrimaryKey primary key (id),
    constraint CategoryUnique unique (name)
);

create table User(
    username text,
    password text not null,
    email text not null,
    picture text,
    bio text,
    joinDate date not null,
    constraint UserPrimaryKey primary key (username)
);

create table List(
    id integer,
    title text not null,
    creationDate date not null,
    category integer not null,
    Color integer not null,
    creator text not null,
    constraint ListPrimaryKey primary key (id),
    constraint ListForeignKeyUser foreign key (creator) references User (username),
    constraint ListForeignKeyColor foreign key (Color) references Color (id),
    constraint ListForeignKeyCategory foreign key (category) references Category (id)
);

create table Item(
    id integer,
    description text not null,
    dueDate date not null,
    complete integer not null default 0,
    Color integer not null,
    assignedUser text, --This one CAN be null
    list integer not null,
    constraint ItemPrimaryKey primary key (id),
    constraint ItemCheck check (complete == 0 or complete == 1),
    constraint ItemForeignKeyColor foreign key (Color) references Color (id),
    constraint ItemForeignKeyUser foreign key (assignedUser) references User (username),
    constraint ItemForeignKeyList foreign key (list) references List (id)
);

create table ListAdmin(
    list integer,
    user integer,
    constraint ListAdminPrimaryKey primary key (list, user)
);

create table ItemPrecedence(
    preceeded integer,
    preceeding integer,
    constraint ItemPrecedencePrimaryKey primary key (preceeded, preceeding)
);

insert INTO User (userName, password, email) VALUES("antonioalmeida", "9613c98430aa75fcce457d97056a42c49be41c84", "cenas@hotmail.com");
insert INTO User (userName, password, email) VALUES("diogotorres97", "894ff497ca1c634444f1dcc66b3aa6766a78efbf", "cenas2@hotmail.com");
insert INTO User (userName, password, email) VALUES("cyrilico", "153bca65a1343c229bce8e08d8b8d28a61f6a55a","cenas3@hotmail.com");
