INSERT INTO accommodations (name, cost, description) VALUES ('Commuting', 12000.00, 'Conference attendance including lunch and dinner, not including a bed');
INSERT INTO accommodations (name, cost, description) VALUES ('BTL dual occupancy', 20000.00, 'Conference attendance including full board in a double bedroom for 3 nights');
INSERT INTO accommodations (name, cost, description) VALUES ('BTL single occupancy', 23500.00, 'Conference attendance including full board in a single bedroom for 3 nights');
INSERT INTO products (name, description, cost) VALUES ('Taxi', 'Taxi between airport and conference centre on arrival and departure', 6500.00);
INSERT INTO currencies (code, name, symbol, rate, def) VALUES ('KES', 'Kenyan shilling', 'KSh', 1, 1);
INSERT INTO currencies (code, name, symbol, rate, def) VALUES ('EUR', 'Euro', '€', 0.009009, 0);
INSERT INTO currencies (code, name, symbol, rate, def) VALUES ('USD', 'US Dollar', 'US $', 0.01, 0);

INSERT INTO groups(name, org_type, address, town, zipcode, country, telephone) VALUES ('admin', 'mission', 'empty', 'empty', '12345', 'Belgium', '12345');
INSERT INTO users(name, email, password, role, group_id, accommodation_id) VALUES('admin','admin@example.org','invalid','admin',1,1);