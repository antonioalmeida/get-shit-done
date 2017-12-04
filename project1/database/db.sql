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
    preceeding integer, --can be null (no preceeding items)
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
insert into User (username, password, email, picture, name, bio, joinDate) values ('hdicty0', '$2y$10$.wE1LR7rkCg4TvHBz30CHegzxlTpjfn5h.3FhPZb.YH7BoxGcocmC', 'hdicty0@blogspot.com', 'http://dummyimage.com/185x247.png/cc0000/ffffff', 'Hendrika Dicty', 'grow integrated web-readiness', '2016-12-08');
insert into User (username, password, email, picture, name, bio, joinDate) values ('dshama1', '$2y$10$z7x5efuR9D298UN2u3sF8ez2rTH/BOP0uXcgQjhwJrXkZQReFn7zm', 'dshama1@dyndns.org', 'http://dummyimage.com/141x120.bmp/ff4444/ffffff', 'Dotty Shama', 'recontextualize plug-and-play markets', '2017-02-09');
insert into User (username, password, email, picture, name, bio, joinDate) values ('yipsgrave2', '$2y$10$XfWlUG5fSpKy7AxM4rvpLupsoH7uM9Ha5FPHSnewUICf1VELhHWi2', 'yipsgrave2@ifeng.com', 'http://dummyimage.com/194x179.png/ff4444/ffffff', 'Yovonnda Ipsgrave', 'visualize one-to-one content', '2017-05-12');
insert into User (username, password, email, picture, name, bio, joinDate) values ('wstolberger3', '$2y$10$l41dnqXej1ofA6ZZ89qo4e/7ACN3xhFZhd.xWtTDXupT57VgRhuXu', 'wstolberger3@parallels.com', 'http://dummyimage.com/197x196.png/dddddd/000000', 'Waldemar Stolberger', 'implement cross-media paradigms', '2017-09-26');
insert into User (username, password, email, picture, name, bio, joinDate) values ('zdowney4', '$2y$10$XcpTm2tcxISKDzQsz5qcB..apQy0Sf/z9tprQ3RmT959rquMN.xi.', 'zdowney4@seattletimes.com', 'http://dummyimage.com/105x104.bmp/cc0000/ffffff', 'Zach Downey', 'syndicate world-class initiatives', '2017-03-11');
insert into User (username, password, email, picture, name, bio, joinDate) values ('ctinman5', '$2y$10$Z1aaNEndZye8dH4RVD8stuwsXeuwI1XSm0lfSBRnAq3chKmBbD4MG', 'ctinman5@nba.com', 'http://dummyimage.com/236x218.jpg/cc0000/ffffff', 'Cynthie Tinman', 'extend B2C functionalities', '2017-06-19');
insert into User (username, password, email, picture, name, bio, joinDate) values ('bkelley6', '$2y$10$Tvyv350G10puCnR6rXKeleBN7Jr1nLysSs2ZbtvLK/rqlEcU4mQG.', 'bkelley6@bloglines.com', 'http://dummyimage.com/185x197.jpg/5fa2dd/ffffff', 'Bartholemy Kelley', 'visualize compelling infomediaries', '2017-01-18');
insert into User (username, password, email, picture, name, bio, joinDate) values ('wgoodban7', '$2y$10$/E.O/wSRSUTo3WbujkAhEeyfqa8lqUvQpP61OMrQg4jJPq.U22DUS', 'wgoodban7@biblegateway.com', 'http://dummyimage.com/215x199.bmp/cc0000/ffffff', 'Wayland Goodban', 'whiteboard dot-com channels', '2017-09-15');
insert into User (username, password, email, picture, name, bio, joinDate) values ('bgrendon8', '$2y$10$r2gyPdDeCGA/pfFgIrgEeedPtS0gWA6OJAjFCbWu/9GhqgXAqGxX2', 'bgrendon8@drupal.org', 'http://dummyimage.com/139x204.png/cc0000/ffffff', 'Bevon Grendon', 'facilitate compelling models', '2017-05-18');
insert into User (username, password, email, picture, name, bio, joinDate) values ('lwardroper9', '$2y$10$nhM778fiVYnfVr.VnMx5pen4guEy/jv3v.EzOwhwFT5lZ.YR1deTK', 'lwardroper9@princeton.edu', 'http://dummyimage.com/123x187.bmp/dddddd/000000', 'Lauri Wardroper', 'matrix strategic methodologies', '2017-05-23');
insert into User (username, password, email, picture, name, bio, joinDate) values ('amclennana', '$2y$10$5pPFcO9f2A5oUWM..kzOKuAYc8t/bocyVewU3denIDj0wcOGcHtpi', 'amclennana@shareasale.com', 'http://dummyimage.com/238x223.jpg/dddddd/000000', 'Antin McLennan', 'synergize clicks-and-mortar vortals', '2017-11-07');
insert into User (username, password, email, picture, name, bio, joinDate) values ('dfauldsb', '$2y$10$sBrKc6XtQtwUZxI9fV9dgOW2PIcRJ5L8xhBnsqzy6ZABVpnMQUjDS', 'dfauldsb@archive.org', 'http://dummyimage.com/174x190.png/cc0000/ffffff', 'Dillie Faulds', 'disintermediate next-generation systems', '2017-09-22');
insert into User (username, password, email, picture, name, bio, joinDate) values ('nstivenc', '$2y$10$ylPR40Rk/vPPiH9A4lF20.tKJKiuS4XIhAS/TjvbGpGhRpUJwG90C', 'nstivenc@ed.gov', 'http://dummyimage.com/164x145.png/ff4444/ffffff', 'Naoma Stiven', 'drive world-class portals', '2017-03-18');
insert into User (username, password, email, picture, name, bio, joinDate) values ('ktomsad', '$2y$10$8YuofP6tTxD6WWXnjecPzOfEbxds3UBMoTPZaYLaz42OH8yIi8ibC', 'ktomsad@disqus.com', 'http://dummyimage.com/111x108.png/cc0000/ffffff', 'Kristen Tomsa', 'empower cross-platform initiatives', '2017-04-02');
insert into User (username, password, email, picture, name, bio, joinDate) values ('kmckewe', '$2y$10$nv0xkpp69EVb8rZoXkkFGezK40DG3iXT9U3wp/cCpkkHlf2vl76vW', 'kmckewe@last.fm', 'http://dummyimage.com/114x234.jpg/ff4444/ffffff', 'Katey McKew', 'deliver proactive models', '2017-01-16');
