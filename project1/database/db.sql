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
    color integer,
    constraint CategoryPrimaryKey primary key (id),
    constraint CategoryForeignKeyColor foreign key (color) references Color(id),
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
    color integer not null,
    assignedUser text, --This one CAN be null
    list integer not null,
    constraint ItemPrimaryKey primary key (id),
    constraint ItemCheck check (complete == 0 or complete == 1),
    constraint ItemForeignKeyColor foreign key (color) references Color (id),
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
select raise(fail, 'item due date must be after list creation date!');
end;

--sets list creator automatically as list admin
drop trigger if exists listcreatoradmin;
create trigger listcreatoradmin
after insert on list
for each row
begin
insert into ListAdmin values (New.id, New.creator);
end;

insert INTO User (userName, password, email) VALUES("antonioalmeida", "9613c98430aa75fcce457d97056a42c49be41c84", "cenas@hotmail.com");
insert INTO User (userName, password, email) VALUES("diogotorres97", "894ff497ca1c634444f1dcc66b3aa6766a78efbf", "cenas2@hotmail.com");
insert INTO User (userName, password, email) VALUES("cyrilico", "153bca65a1343c229bce8e08d8b8d28a61f6a55a","cenas3@hotmail.com");

insert INTO Color VALUES(0xff00000, "Red");
insert INTO Color VALUES(0xffff00, "Yellow");
insert INTO Category VALUES(0, "My First Category", 0xff00000);
insert INTO Category VALUES(1, "My Second Category", 0xffff00);
insert INTO List VALUES(0, "My First List", "now", 0, "antonioalmeida");
