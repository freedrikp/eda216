-- Delete the tables if they exist. Set foreign_key_checks = 0 to
-- disable foreign key checks, so the tables may be dropped in
-- arbitrary order.
set foreign_key_checks = 0;
drop table if exists IngredientsInStock;
drop table if exists Recipes;
drop table if exists IngredientsInRecipes;
drop table if exists Customers;
drop table if exists Orders;
drop table if exists RecipesInOrders;
drop table if exists Pallets;
drop table if exists DeliveredPallets;
set foreign_key_checks = 1;

-- Create the tables.
create table IngredientsInStock (
	ingredientName varchar(30),
	stockAmount integer,
	primary key (ingredientName)
);
create table Recipes (
	recipeName	varchar(30),
	nbrCookies	integer,
	primary key (recipeName)
);
create table IngredientsInRecipes (
	ingredientName varchar(30),
	recipeName	varchar(30),
	ingredientAmount integer,
	primary key (ingredientName,recipeName),
	foreign key (ingredientName) references IngredientsInStock(ingredientName),
	foreign key (recipeName) references Recipes(recipeName)
);
create table Customers (
	customerName varchar(40),
	customerAddress	varchar(40),
	primary key (customerName,customerAddress)
);
create table Orders (
	orderId integer auto_increment,
	deliveryTime timestamp default current_timestamp,
	customerName varchar(40),
	customerAddress	varchar(40),
	primary key (orderId),
	foreign key (customerName,customerAddress) references Customers(customerName,customerAddress)
);
create table RecipesInOrders (
	recipeName	varchar(30),
	orderId integer,
	palletAomunt integer,
	primary key (recipeName,orderId),
	foreign key (recipeName) references Recipes(recipeName),
	foreign key (orderId) references Orders(orderId)
);
create table Pallets (
	palletId integer auto_increment,
	timeMade timestamp default current_timestamp,
	blocked boolean,
	inFreezer boolean,
	recipeName	varchar(30),
	primary key (palletId),
	foreign key (recipeName) references Recipes(recipeName)
);
create table DeliveredPallets (
	palletId integer,
	timeOfDelivery timestamp default current_timestamp,
	orderId integer,
	primary key (palletId),
	foreign key (palletId) references Pallets(palletId),
	foreign key (orderId) references Orders(orderId)
);

-- Insert data into the tables.
insert into Recipes values('Nut ring',100);
insert into Recipes values('Nut cookie',100);
insert into Recipes values('Amneris',100);
insert into Recipes values('Tango',100);
insert into Recipes values('Almond delight',100);
insert into Recipes values('Berliner',100);
insert into IngredientsInStock values('Flour',500000);
insert into IngredientsInStock values('Butter',500000);
insert into IngredientsInStock values('Icing sugar',500000);
insert into IngredientsInStock values('Roasted, chopped nuts',500000);
insert into IngredientsInStock values('Fine-ground nuts',500000);
insert into IngredientsInStock values('Ground, roasted nuts',500000);
insert into IngredientsInStock values('Bread crumbs',500000);
insert into IngredientsInStock values('Sugar',500000);
insert into IngredientsInStock values('Egg whites',500000);
insert into IngredientsInStock values('Chocolate',500000);
insert into IngredientsInStock values('Marzipan',500000);
insert into IngredientsInStock values('Eggs',500000);
insert into IngredientsInStock values('Potato starch',500000);
insert into IngredientsInStock values('Wheat flour',500000);
insert into IngredientsInStock values('Sodium bicarbonate',500000);
insert into IngredientsInStock values('Vanilla',500000);
insert into IngredientsInStock values('Chopped almonds',500000);
insert into IngredientsInStock values('Cinnamon',500000);
insert into IngredientsInStock values('Vanilla sugar',500000);
insert into IngredientsInRecipes values('Flour','Nut ring',450);
insert into IngredientsInRecipes values('Butter','Nut ring',450);
insert into IngredientsInRecipes values('Icing sugar','Nut ring',190);
insert into IngredientsInRecipes values('Roasted, chopped nuts','Nut ring',225);
insert into IngredientsInRecipes values('Fine-ground nuts','Nut cookie',750);
insert into IngredientsInRecipes values('Ground, roasted nuts','Nut cookie',625);
insert into IngredientsInRecipes values('Bread crumbs','Nut cookie',125);
insert into IngredientsInRecipes values('Sugar','Nut cookie',375);
insert into IngredientsInRecipes values('Egg whites','Nut cookie',350);
insert into IngredientsInRecipes values('Chocolate','Nut cookie',50);
insert into IngredientsInRecipes values('Marzipan','Amneris',750);
insert into IngredientsInRecipes values('Butter','Amneris',250);
insert into IngredientsInRecipes values('Eggs','Amneris',250);
insert into IngredientsInRecipes values('Potato starch','Amneris',25);
insert into IngredientsInRecipes values('Wheat flour','Amneris',25);
insert into IngredientsInRecipes values('Butter','Tango',200);
insert into IngredientsInRecipes values('Sugar','Tango',250);
insert into IngredientsInRecipes values('Flour','Tango',300);
insert into IngredientsInRecipes values('Sodium bicarbonate','Tango',4);
insert into IngredientsInRecipes values('Vanilla','Tango',2);
insert into IngredientsInRecipes values('Butter','Almond delight',400);
insert into IngredientsInRecipes values('Sugar','Almond delight',270);
insert into IngredientsInRecipes values('Chopped almonds','Almond delight',279);
insert into IngredientsInRecipes values('Flour','Almond delight',400);
insert into IngredientsInRecipes values('Cinnamon','Almond delight',10);
insert into IngredientsInRecipes values('Flour','Berliner',350);
insert into IngredientsInRecipes values('Butter','Berliner',250);
insert into IngredientsInRecipes values('Icing sugar','Berliner',100);
insert into IngredientsInRecipes values('Eggs','Berliner',50);
insert into IngredientsInRecipes values('Vanilla sugar','Berliner',5);
insert into IngredientsInRecipes values('Chocolate','Berliner',50);
insert into Customers values('Finkakor AB','Helsingborg');
insert into Customers values('Småbröd AB','Malmö');
insert into Customers values('Kaffebröd AB','Landskrona');
insert into Customers values('Bjudkakor AB','Ystad');
insert into Customers values('Kalaskakor AB','Trelleborg');
insert into Customers values('Partykakor AB','Kristianstad');
insert into Customers values('Gästkakor AB','Hässleholm');
insert into Customers values('Skånekakor AB','Perstorp');	
insert into Orders(customerName,customerAddress) values('Finkakor AB','Helsingborg');
insert into Orders(customerName,customerAddress) values('Småbröd AB','Malmö');
insert into Orders(customerName,customerAddress) values('Kaffebröd AB','Landskrona');
insert into Orders(customerName,customerAddress) values('Bjudkakor AB','Ystad');
insert into Orders(customerName,customerAddress) values('Kalaskakor AB','Trelleborg');
insert into Orders(customerName,customerAddress) values('Partykakor AB','Kristianstad');
insert into Orders(customerName,customerAddress) values('Gästkakor AB','Hässleholm');
insert into Orders(customerName,customerAddress) values('Skånekakor AB','Perstorp');
insert into RecipesInOrders values('Nut ring',1,1);
insert into RecipesInOrders values('Nut cookie',2,1);
insert into RecipesInOrders values('Amneris',3,1);
insert into RecipesInOrders values('Tango',4,1);
insert into RecipesInOrders values('Almond delight',5,1);
insert into RecipesInOrders values('Berliner',6,1);
insert into Pallets(blocked,inFreezer,recipeName) values(false,true,'Nut ring');
insert into Pallets(blocked,inFreezer,recipeName) values(false,true,'Nut cookie');
insert into Pallets(blocked,inFreezer,recipeName) values(false,true,'Amneris');
insert into Pallets(blocked,inFreezer,recipeName) values(false,true,'Tango');
insert into Pallets(blocked,inFreezer,recipeName) values(false,true,'Almond delight');
insert into Pallets(blocked,inFreezer,recipeName) values(false,true,'Berliner');
insert into Pallets(blocked,inFreezer,recipeName) values(false,true,'Nut ring');
insert into Pallets(blocked,inFreezer,recipeName) values(false,true,'Nut cookie');
insert into Pallets(blocked,inFreezer,recipeName) values(false,true,'Amneris');
insert into Pallets(blocked,inFreezer,recipeName) values(false,true,'Tango');
insert into Pallets(blocked,inFreezer,recipeName) values(false,true,'Almond delight');
insert into Pallets(blocked,inFreezer,recipeName) values(false,true,'Berliner');
insert into DeliveredPallets(palletId,orderId) values(1,1);
insert into DeliveredPallets(palletId,orderId) values(2,2);
insert into DeliveredPallets(palletId,orderId) values(3,3);
insert into DeliveredPallets(palletId,orderId) values(4,4);
insert into DeliveredPallets(palletId,orderId) values(5,5);
insert into DeliveredPallets(palletId,orderId) values(6,6);