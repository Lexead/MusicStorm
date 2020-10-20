drop database MusicStorm;
create database MusicStorm;
use MusicStorm;

create table Locations (
	id int unsigned auto_increment primary key,
    country varchar(30) unique not null,
    city varchar(30) not null );

create table Users (
	id int unsigned auto_increment primary key, 
    login varchar(20) unique not null,
    _password varchar(20) not null,
    _name varchar(20) not null, 
    birthdate date not null,
    gender varchar(10) not null,
    location_id int unsigned, foreign key (location_id) references Locations(id) on delete cascade on update cascade,
    avatar text not null,
    _admin bool default false, 
    signupdate timestamp default current_timestamp,
    visitdate timestamp default current_timestamp on update current_timestamp );
    
create table Performers (
	id int unsigned auto_increment primary key, 
    _name varchar(30) not null,
    avatar text not null, 
    genres text not null,
    location_id int unsigned, foreign key (location_id) references Locations(id) on delete cascade on update cascade, 
    info text);
    
create table ListenedPerformers (
	id int unsigned auto_increment primary key, 
    user_id int unsigned, foreign key (user_id) references Users(id) on delete cascade on update cascade, 
    performer_id int unsigned, foreign key (performer_id) references Performers(id) on delete cascade on update cascade, 
    listening_date timestamp default current_timestamp on update current_timestamp, 
    favourite bool default false );
    
create table Albums (
	id int unsigned auto_increment primary key, 
    _name varchar(30) not null, 
    avatar text not null, 
    _year year, 
    performer_id int unsigned, foreign key (performer_id) references Performers(id) on delete cascade on update cascade );
    
create table ListenedAlbums (
	id int unsigned auto_increment primary key, 
    user_id int unsigned, foreign key (user_id) references Users(id) on delete cascade on update cascade, 
    album_id int unsigned, foreign key (album_id) references Albums(id) on delete cascade on update cascade, 
    listening_date timestamp default current_timestamp on update current_timestamp, 
    favourite bool default false );
    
create table Tracks (
	id int unsigned auto_increment primary key, 
    _name varchar(30) not null, 
    _source text not null, 
	album_id int unsigned, foreign key (album_id) references Albums(id) on delete cascade on update cascade );
    
create table ListenedTracks (
	id int unsigned auto_increment primary key, 
	user_id int unsigned, foreign key (user_id) references Users(id) on delete cascade on update cascade, 
    track_id int unsigned, foreign key (track_id) references Tracks(id) on delete cascade on update cascade, 
    listening_date timestamp default current_timestamp on update current_timestamp, 
    favourite bool default false );
    
select * from Locations;
select * from Performers;
select * from Albums;
select * from Tracks;
select * from Users;
select * from ListenedTracks;
select * from ListenedAlbums;
select * from ListenedPerformers;

-- SELECT p.*, count(lp.user_id) FROM performers p INNER JOIN listenedperformers lp ON p.id = lp.performer_id AND lp.favourite = 1 GROUP BY p.id ORDER BY count(lp.user_id) DESC LIMIT 3;
-- SELECT a.*, count(la.user_id) FROM albums a INNER JOIN listenedalbums la ON a.id = la.album_id AND la.favourite = 1 GROUP BY a.id ORDER BY count(la.user_id) DESC limit 3;
-- SELECT t.*, count(lt.user_id) FROM tracks t INNER JOIN listenedtracks lt ON t.id = lt.track_id AND lt.favourite = 1 GROUP BY t.id ORDER BY count(lt.user_id) DESC limit 3;
