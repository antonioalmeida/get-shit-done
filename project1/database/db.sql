PRAGMA foreign_keys = ON;

--Do NOT alter drop table order
drop table if exists ListAdmin;
drop table if exists Item;
drop table if exists List;
drop table if exists User;
drop table if exists Category;

create table Category(
    id integer,
    name text not null,
    color text,
    user text, --if not null, category is local to user
    constraint CategoryPrimaryKey primary key (id),
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
    priority integer default 1,
    assignedUser text, --can be null
    list integer not null,
    constraint ItemPrimaryKey primary key (id),
    constraint ItemCheck check (complete == 0 or complete == 1),
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

--checks item precedence when trying to set one as complete
--in other words, an item can only be completed once items of higher priority have also been completed
DROP TRIGGER IF EXISTS itempriorityprecedence;
CREATE TRIGGER itempriorityprecedence
BEFORE UPDATE OF complete ON item
FOR each ROW
WHEN NEW.complete = 1 AND EXISTS (SELECT * FROM item WHERE priority > NEW.priority AND complete = 0 AND NEW.list = item.list)
BEGIN
SELECT raise(fail, 'item cannot be completed before higher priority items have been completed');
END;

--prevents user from changing item priority after it is complete
drop trigger if exists itempreventpriorityaftercompletion;
create trigger itempreventpriorityaftercompletion
before update of priority on item
for each row
when new.complete = 1
begin
select raise(fail, "Item already complete, can't change priority!");
end;

--check item's due date is after the respective list's creation date
drop trigger if exists itemduedateinsert;
create trigger itemduedateinsert
before insert on item
for each row
when new.duedate < (select creationdate from list where new.list == list.id)
begin
select raise(fail, "Due date must be after list creation date!");
end;

drop trigger if exists itemduedateupdate;
create trigger itemduedateupdate
before update of duedate on item
for each row
when new.duedate < (select creationdate from list where old.list == list.id)
begin
select raise(fail, 'Due date must be after list creation date!');
end ;

--sets list creator automatically as list admin
drop trigger if exists listcreatoradmin;
create trigger listcreatoradmin
after insert on list
for each row
begin
insert into ListAdmin values (New.id, New.creator);
end;

insert INTO User (userName, name, password, email) VALUES("antonioalmeida", "António Almeida", "$2a$12$ImZy3AAEkbMWq3ZFDSFmwOYghh7nbqzQdvvS1r/tggwgeAKOnXLQi", "cenas@hotmail.com");
insert INTO User (userName, name, password, email) VALUES("diogotorres97", "Diogo Torres", "$2a$12$YO6D3sebd305UTKc9kLf1.zkMeqeP1/2SIYdJzeSaTqzj6MguUcgy", "cenas2@hotmail.com");
insert INTO User (userName, name, password, email) VALUES("cyrilico", "João Damas", "$2a$12$TGl/9isx4.pfcurXJ4vSyes5g9LUvJ6lXh9jjfH/bGyeRcJJ/gADq","cenas3@hotmail.com");
insert into User (username, password, email, picture, name, bio) values ('hdicty0', '$2y$10$.wE1LR7rkCg4TvHBz30CHegzxlTpjfn5h.3FhPZb.YH7BoxGcocmC', 'hdicty0@blogspot.com', 'http://dummyimage.com/185x247.png/cc0000/ffffff', 'Hendrika Dicty', 'grow integrated web-readiness');
insert into User (username, password, email, picture, name, bio) values ('dshama1', '$2y$10$z7x5efuR9D298UN2u3sF8ez2rTH/BOP0uXcgQjhwJrXkZQReFn7zm', 'dshama1@dyndns.org', 'http://dummyimage.com/141x120.bmp/ff4444/ffffff', 'Dotty Shama', 'recontextualize plug-and-play markets');
insert into User (username, password, email, picture, name, bio) values ('yipsgrave2', '$2y$10$XfWlUG5fSpKy7AxM4rvpLupsoH7uM9Ha5FPHSnewUICf1VELhHWi2', 'yipsgrave2@ifeng.com', 'http://dummyimage.com/194x179.png/ff4444/ffffff', 'Yovonnda Ipsgrave', 'visualize one-to-one content');
insert into User (username, password, email, picture, name, bio) values ('wstolberger3', '$2y$10$l41dnqXej1ofA6ZZ89qo4e/7ACN3xhFZhd.xWtTDXupT57VgRhuXu', 'wstolberger3@parallels.com', 'http://dummyimage.com/197x196.png/dddddd/000000', 'Waldemar Stolberger', 'implement cross-media paradigms');
insert into User (username, password, email, picture, name, bio) values ('zdowney4', '$2y$10$XcpTm2tcxISKDzQsz5qcB..apQy0Sf/z9tprQ3RmT959rquMN.xi.', 'zdowney4@seattletimes.com', 'http://dummyimage.com/105x104.bmp/cc0000/ffffff', 'Zach Downey', 'syndicate world-class initiatives');
insert into User (username, password, email, picture, name, bio) values ('ctinman5', '$2y$10$Z1aaNEndZye8dH4RVD8stuwsXeuwI1XSm0lfSBRnAq3chKmBbD4MG', 'ctinman5@nba.com', 'http://dummyimage.com/236x218.jpg/cc0000/ffffff', 'Cynthie Tinman', 'extend B2C functionalities');

insert into Category (name, color, user) values ('Home', '4caf50', 'antonioalmeida');
insert into Category (name, color) values ('Work', '03a9f4');
insert into Category (name, color, user) values ('Shopping', '9c27b0', 'cyrilico');
insert into Category (name, color, user) values ('FEUP', 'ff9800', 'diogotorres97');
insert into Category (name, color) values ('Cooking', 'ff5722');
insert into Category (name, color) values ('Sports', '000000');

insert into List (title, creationDate, category, creator) values ('Do LAIG', '2017-05-25', 2, 'antonioalmeida');
insert into List (title, creationDate, category, creator) values ('Try to do RCOM', '2017-05-14', 1, 'antonioalmeida');
insert into List (title, creationDate, category, creator) values ('Somehow fix PLOG', '2017-05-09', 5, 'antonioalmeida');
insert into List (title, creationDate, category, creator) values ('Spit out regex', '2017-05-09', 5, 'antonioalmeida');
insert into List (title, creationDate, category, creator) values ('Understand Hyper', '2017-05-09', 5, 'antonioalmeida');
insert into List (title, creationDate, category, creator) values ('Go to ESOF', '2017-05-09', 5, 'antonioalmeida');
insert into List (title, creationDate, category, creator) values ('Depress about RCOM', '2017-05-09', 5, 'antonioalmeida');
insert into List (title, creationDate, category, creator) values ('Drive', '2017-05-09', 5, 'antonioalmeida');
insert into List (title, creationDate, category, creator) values ('Prepare that React WS', '2017-05-09', 5, 'antonioalmeida');
insert into List (title, creationDate, category, creator) values ('Do RCOM homework', '2017-05-09', 5, 'antonioalmeida');
insert into List (title, creationDate, category, creator) values ('Rest In Peace', '2017-05-09', 5, 'antonioalmeida');
insert into List (title, creationDate, category, creator) values ('Figure out titles', '2017-05-09', 5, 'antonioalmeida');
insert into List (title, creationDate, category, creator) values ('Reason with sqlite', '2017-09-25', 3, 'cyrilico');
insert into List (title, creationDate, category, creator) values ('Invent MOAR titles', '2017-06-28', 6, 'cyrilico');
insert into List (title, creationDate, category, creator) values ('Figure out more hacks', '2017-11-26', 4, 'diogotorres97');
insert into List (title, creationDate, category, creator) values ('Hack Restivo', '2017-06-25', 5, 'hdicty0');

insert into ListAdmin values (1, 'cyrilico');
insert into ListAdmin values (1, 'diogotorres97');
insert into ListAdmin values (1, 'dshama1');
insert into ListAdmin values (8, 'yipsgrave2');
insert into ListAdmin values (7, 'zdowney4');
insert into ListAdmin values (10, 'ctinman5');
insert into ListAdmin values (10, 'wstolberger3');
insert into ListAdmin values (11, 'cyrilico');
insert into ListAdmin values (12, 'diogotorres97');
insert into ListAdmin values (15, 'antonioalmeida');
