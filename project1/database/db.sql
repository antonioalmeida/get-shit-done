PRAGMA foreign_keys = ON;

--Do NOT alter drop table order
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
    user text, --if not null, category is local to user
    constraint CategoryPrimaryKey primary key (id),
    constraint CategoryForeignKeyColor foreign key (color) references Color(code),
    constraint CategoryForeignKeyUser foreign key (user) references User(username),
    constraint CategoryUnique unique (name)
);

create table User(
    username text,
    password text not null,
    email text not null,
    picture text,
    name text,
    bio text,
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
    preceeding integer, --can be null (no preceeding item)
    assignedUser text, --can be null
    list integer not null,
    constraint ItemPrimaryKey primary key (id),
    constraint ItemCheck check (complete == 0 or complete == 1),
    constraint ItemForeignKeyItem foreign key (preceeding) references Item (id) on delete set null,
    constraint ItemForeignKeyColor foreign key (color) references Color (code),
    constraint ItemForeignKeyUser foreign key (assignedUser) references User (username),
    constraint ItemForeignKeyList foreign key (list) references List (id) on delete cascade
);

create table ListAdmin(
    list integer,
    user text,
    constraint ListAdminPrimaryKey primary key (list, user),
    constraint ListAdminForeginKeyList foreign key (list) references List (id) on delete cascade,
    constraint ListAdminForeignKeyUser foreign key (user) references User (username)
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
when old.preceeding is not null and (select complete from item where id = old.preeceding) = 0
begin
select raise(fail, 'preceeding item to the current one must be completed before this one is!');
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

insert into Color values ('f44336', 'Red');
insert into Color values ('e91e63', 'Pink');
insert into Color values ('9c27b0', 'Purple');
insert into Color values ('673ab7', 'Deep Purple');
insert into Color values ('3f51b5', 'Indigo');
insert into Color values ('2196f3', 'Blue');
insert into Color values ('03a9f4', 'Light Blue');
insert into Color values ('00bcd4', 'Cyan');
insert into Color values ('009688', 'Teal');
insert into Color values ('4caf50', 'Green');
insert into Color values ('8bc34a', 'Light Green');
insert into Color values ('cddc39', 'Lime');
insert into Color values ('ffeb3b', 'Yellow');
insert into Color values ('ffc107', 'Amber');
insert into Color values ('ff9800', 'Orange');
insert into Color values ('ff5722', 'Deep Orange');
insert into Color values ('795548', 'Brown');
insert into Color values ('9e9e9e', 'Grey');
insert into Color values ('607d8b', 'Blue Grey');
insert into Color values ('000000', 'Black');
insert into Color values ('ffffff', 'White');

insert INTO User (userName, name, password, email) VALUES("antonioalmeida", "António Almeida", "9613c98430aa75fcce457d97056a42c49be41c84", "cenas@hotmail.com");
insert INTO User (userName, name, password, email) VALUES("diogotorres97", "Diogo Torres", "894ff497ca1c634444f1dcc66b3aa6766a78efbf", "cenas2@hotmail.com");
insert INTO User (userName, name, password, email) VALUES("cyrilico", "João Damas", "153bca65a1343c229bce8e08d8b8d28a61f6a55a","cenas3@hotmail.com");
insert into User (username, password, email, picture, name, bio) values ('hdicty0', '$2y$10$.wE1LR7rkCg4TvHBz30CHegzxlTpjfn5h.3FhPZb.YH7BoxGcocmC', 'hdicty0@blogspot.com', 'http://dummyimage.com/185x247.png/cc0000/ffffff', 'Hendrika Dicty', 'grow integrated web-readiness');
insert into User (username, password, email, picture, name, bio) values ('dshama1', '$2y$10$z7x5efuR9D298UN2u3sF8ez2rTH/BOP0uXcgQjhwJrXkZQReFn7zm', 'dshama1@dyndns.org', 'http://dummyimage.com/141x120.bmp/ff4444/ffffff', 'Dotty Shama', 'recontextualize plug-and-play markets');
insert into User (username, password, email, picture, name, bio) values ('yipsgrave2', '$2y$10$XfWlUG5fSpKy7AxM4rvpLupsoH7uM9Ha5FPHSnewUICf1VELhHWi2', 'yipsgrave2@ifeng.com', 'http://dummyimage.com/194x179.png/ff4444/ffffff', 'Yovonnda Ipsgrave', 'visualize one-to-one content');
insert into User (username, password, email, picture, name, bio) values ('wstolberger3', '$2y$10$l41dnqXej1ofA6ZZ89qo4e/7ACN3xhFZhd.xWtTDXupT57VgRhuXu', 'wstolberger3@parallels.com', 'http://dummyimage.com/197x196.png/dddddd/000000', 'Waldemar Stolberger', 'implement cross-media paradigms');
insert into User (username, password, email, picture, name, bio) values ('zdowney4', '$2y$10$XcpTm2tcxISKDzQsz5qcB..apQy0Sf/z9tprQ3RmT959rquMN.xi.', 'zdowney4@seattletimes.com', 'http://dummyimage.com/105x104.bmp/cc0000/ffffff', 'Zach Downey', 'syndicate world-class initiatives');
insert into User (username, password, email, picture, name, bio) values ('ctinman5', '$2y$10$Z1aaNEndZye8dH4RVD8stuwsXeuwI1XSm0lfSBRnAq3chKmBbD4MG', 'ctinman5@nba.com', 'http://dummyimage.com/236x218.jpg/cc0000/ffffff', 'Cynthie Tinman', 'extend B2C functionalities');

insert into Category (name, color, user) values ('demand-driven', 'f44336', 'antonioalmeida');
insert into Category (name, color) values ('budgetary management', 'e91e63');
insert into Category (name, color, user) values ('monitoring', '9c27b0', 'cyrilico');
insert into Category (name, color, user) values ('methodical', 'ff9800', 'diogotorres97');
insert into Category (name, color) values ('super discrete', 'ff5722');
insert into Category (name, color) values ('sports', '000000');
insert into Category (name, color) values ('optimizing', 'ffffff');
insert into Category (name, color) values ('homogeneous', '9e9e9e');
insert into Category (name, color) values ('secured line', '795548');
insert into Category (name, color) values ('Future-proofed', '607d8b');
insert into Category (name, color) values ('human-resource', '009688');
insert into Category (name, color) values ('Profit-focused', '00bcd4');
insert into Category (name, color) values ('customer loyalty', '03a9f4');
insert into Category (name, color) values ('Vision-oriented', '4caf50');
insert into Category (name, color, user) values ('methodology', '673ab7', 'hdicty0');
insert into Category (name, color, user) values ('policy', '673ab7', 'dshama1');
insert into Category (name, color) values ('background', 'ffc107');
insert into Category (name, color, user) values ('matrices', '8bc34a', 'ctinman5');
insert into Category (name, color) values ('Team-oriented', '2196f3');
insert into Category (name, color, user) values ('attitude', '3f51b5', 'ctinman5');
insert into Category (name, color) values ('Customer-focused', '3f51b5');
insert into Category (name, color, user) values ('discrete', '03a9f4', 'yipsgrave2');
insert into Category (name, color) values ('moderator', 'f44336');
insert into Category (name, color) values ('analyzing', '9c27b0');
insert into Category (name, color, user) values ('challenge', '000000', 'wstolberger3');
insert into Category (name, color) values ('synergy', '673ab7');
insert into Category (name, color, user) values ('strategy', 'ffffff', 'zdowney4');
insert into Category (name, color, user) values ('Secured', 'ff5722', 'wstolberger3');
insert into Category (name, color, user) values ('Profound', 'ff9800', 'hdicty0');
insert into Category (name, color) values ('Operative', 'ff9800');

insert into List (title, creationDate, category, creator) values ('Oscar', '2017-05-25', 2, 'antonioalmeida');
insert into List (title, creationDate, category, creator) values ('Woman Under the Influence, A', '2017-05-14', 1, 'antonioalmeida');
insert into List (title, creationDate, category, creator) values ('Jackass 2.5', '2017-05-09', 5, 'antonioalmeida');
insert into List (title, creationDate, category, creator) values ('Critters', '2017-09-25', 3, 'cyrilico');
insert into List (title, creationDate, category, creator) values ('Cousin Angelica (La prima Angélica)', '2017-06-28', 6, 'cyrilico');
insert into List (title, creationDate, category, creator) values ('Real Life', '2017-10-24', 11, 'cyrilico');
insert into List (title, creationDate, category, creator) values ('Cousin Angelica (La prima Angélica)', '2017-11-26', 4, 'diogotorres97');
insert into List (title, creationDate, category, creator) values ('Paan Singh Tomar', '2017-07-23', 30, 'diogotorres97');
insert into List (title, creationDate, category, creator) values ('Six Degrees of Separation', '2017-10-24', 26, 'diogotorres97');
insert into List (title, creationDate, category, creator) values ('Map For Saturday, A', '2017-06-25', 15, 'hdicty0');
insert into List (title, creationDate, category, creator) values ('Police Story 3: Supercop', '2017-04-30', 29, 'hdicty0');
insert into List (title, creationDate, category, creator) values ('From Dusk Till Dawn 2: Texas Blood Money ', '2017-10-05', 23, 'hdicty0');

insert into ListAdmin values (1, 'cyrilico');
insert into ListAdmin values (2, 'diogotorres97');
insert into ListAdmin values (4, 'antonioalmeida');
insert into ListAdmin values (5, 'dshama1');
insert into ListAdmin values (8, 'yipsgrave2');
insert into ListAdmin values (7, 'zdowney4');
insert into ListAdmin values (10, 'ctinman5');
insert into ListAdmin values (10, 'wstolberger3');
insert into ListAdmin values (11, 'cyrilico');
insert into ListAdmin values (12, 'diogotorres97');
