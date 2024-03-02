create table rides
(
    id        uuid             not null primary key,
    rider_id  uuid             not null,
    departure varchar(255)     not null,
    arrival   varchar(255)     not null,
    price     double precision not null,
    distance  double precision not null,
    uber_x    boolean          not null,
    status    varchar(255)     not null
);

create table ride_prices
(
    id              serial              not null primary key,
    direction_label varchar(255)     not null,
    price           double precision not null
)
