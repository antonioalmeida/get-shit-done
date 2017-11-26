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
    code text,
    name text not null,
    constraint ColorPrimaryKey primary key (code),
    constraint ColorUnique unique (name)
);

create table Category(
    id integer,
    name text not null,
    color text,
    constraint CategoryPrimaryKey primary key (id),
    constraint CategoryForeignKeyColor foreign key (color) references Color(code),
    constraint CategoryUnique unique (name)
);

create table User(
    username text,
    password text not null,
    email text not null,
    picture text,
    name text,
    bio text,
    joinDate date,
    constraint UserPrimaryKey primary key (username),
    constraint UserCheckBio check (length(bio) < 140)
);

create table List(
    id integer,
    title text not null,
    creationDate date not null,
    category integer not null,
    creator text not null,
    constraint ListPrimaryKey primary key (id),
    constraint ListForeignKeyUser foreign key (creator) references User (username),
    constraint ListForeignKeyCategory foreign key (category) references Category (id)
);

create table Item(
    id integer,
    description text not null,
    dueDate date not null,
    complete integer default 0,
    color text not null,
    assignedUser text, --This one CAN be null
    list integer not null,
    constraint ItemPrimaryKey primary key (id),
    constraint ItemCheck check (complete == 0 or complete == 1),
    constraint ItemForeignKeyColor foreign key (color) references Color (code),
    constraint ItemForeignKeyUser foreign key (assignedUser) references User (username),
    constraint ItemForeignKeyList foreign key (list) references List (id)
);

create table ListAdmin(
    list integer,
    user text,
    constraint ListAdminPrimaryKey primary key (list, user),
    constraint ListAdminForeginKeyList foreign key (list) references List (id),
    constraint ListAdminForeignKeyUser foreign key (user) references User (username)
);

create table ItemPrecedence(
    preceeded integer,
    preceeding integer,
    constraint ItemPrecedencePrimaryKey primary key (preceeded, preceeding)
);

--guarantees that list creator always stays as admin
drop trigger if exists removeadmin;
create trigger removeadmin
before delete on listadmin
for each row
when old.user == (select creator from list where id == old.list)
begin
select raise(fail, 'cannot remove admin status to list creator!');
end;

--checks item precedence when trying to mark it as complete
drop trigger if exists itemprecedence;
create trigger itemprecedence
before update of complete on item
for each row
when exists (select * from itemprecedence, item where preceeded = old.id and preceeding == item.id and item.complete == 0)
begin
select raise(fail, 'at least one preceeding item to the current one must be completed before this one is!');
end;

--check item's due date is after the respective list's creation date
drop trigger if exists itemduedateinsert;
create trigger itemduedateinsert
before insert on item
for each row
when new.duedate < (select creationdate from list where new.list == list.id)
begin
select raise(fail, 'item due date must be after list creation date!');
end;

drop trigger if exists itemduedateupdate;
create trigger itemduedateupdate
before update of duedate on item
for each row
when new.duedate < (select creationdate from list where old.list == list.id)
begin
select raise(fail, 'item due dueDate must be after list creation date!');
end ;

--sets list creator automatically as list admin
drop trigger if exists listcreatoradmin;
create trigger listcreatoradmin
after insert on list
for each row
begin
insert into ListAdmin values (New.id, New.creator);
end;

--deletes list items before deleting list
--also eliminates precedences that involved items from said list
drop trigger if exists deletelistitems;
create trigger deletelistitems
before delete on List
for each row
begin
delete from Item where Item.list == old.id;
end;

drop trigger if exists deleteprecedence;
create trigger deleteprecedence
before delete on Item
for each row
begin
delete from ItemPrecedence where preceeded = old.id or preceeding = old.id;
end;

insert INTO User (userName, name, password, email) VALUES("antonioalmeida", "António Almeida", "9613c98430aa75fcce457d97056a42c49be41c84", "cenas@hotmail.com");
insert INTO User (userName, name, password, email) VALUES("diogotorres97", "Diogo Torres", "894ff497ca1c634444f1dcc66b3aa6766a78efbf", "cenas2@hotmail.com");
insert INTO User (userName, name, password, email) VALUES("cyrilico", "João Damas", "153bca65a1343c229bce8e08d8b8d28a61f6a55a","cenas3@hotmail.com");

insert INTO Color VALUES('ff0000', "Red");
insert INTO Color VALUES('ffff00', "Yellow");
insert INTO Category VALUES(0, "My First Category", 'ff0000');
insert INTO Category VALUES(1, "My Second Category", 'ffff00');
insert INTO List VALUES(0, "My First List", "2017-11-1", 0, "antonioalmeida");
insert INTO List VALUES(1, "Second List", "2017-11-11", 0, "antonioalmeida");
insert into Item (description, dueDate, color, list) values ('Finish LTW', '2017-12-12', 'ffff00', 0);
insert into Item (description, dueDate, color, list) values ('Finish LAIG', '2017-12-8', 'ffff00', 0);
