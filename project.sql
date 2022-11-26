drop table Organization cascade constraints;
drop table OrganTransplantOrganization cascade constraints;
drop table CornealTransplantOrganization cascade constraints;
drop table Hospital cascade constraints;
drop table partnerWith cascade constraints;
drop table WaitingTimeMapUrgentDeg cascade constraints;
drop table WaitingTransplantation cascade constraints;
drop table Manage cascade constraints;
drop table Donor cascade constraints;
drop table RegisterIn cascade constraints;
drop table DonorFamilyContactPerson cascade constraints;
drop table Has cascade constraints;
drop table OrganTypeInfo cascade constraints;
drop table DonateOrgan cascade constraints;
drop table Recipient cascade constraints;
drop table IndividualRecipientOperation cascade constraints;
drop table LaboratoryRecipient cascade constraints;
drop table Accept cascade constraints;


create table Organization
	(org_id int PRIMARY KEY,
	org_city char(30) not null,
	org_streetAddr char(80) UNIQUE,
	org_name char(80) not null);

create table OrganTransplantOrganization 
    (org_id int PRIMARY KEY,
    transResearchFund char(80),
    FOREIGN KEY (org_id) REFERENCES Organization(org_id)
    ON DELETE CASCADE);

create table CornealTransplantOrganization 
    (org_id int PRIMARY KEY,
    ophthaDirector char(30),
    FOREIGN KEY (org_id) REFERENCES Organization(org_id)
    ON DELETE CASCADE);

create table Hospital 
    (hospital_id int PRIMARY KEY,
    hospitalAddress char(80) UNIQUE,
    hospitalName char(50) NOT NULL);

create table partnerWith 
    (org_id int,
    hospital_id int,
    PRIMARY KEY(org_id, hospital_id),
    FOREIGN KEY (hospital_id) REFERENCES Hospital(hospital_id)
    ON DELETE CASCADE,
    FOREIGN KEY (org_id) REFERENCES Organization(org_id)
    ON DELETE CASCADE);

create table WaitingTimeMapUrgentDeg 
    (waitingTime int PRIMARY KEY,
    urgentDegree int NOT NULL);

create table WaitingTransplantation 
    (transplantationID int PRIMARY KEY,
    patientAge int,
    patientBloodType char(10) NOT NULL,
    waitingTime int NOT NULL,
    neededOrgan char(30) NOT NULL,
    patientName char(30) NOT NULL,
    FOREIGN KEY (waitingTime) REFERENCES
    WaitingTimeMapUrgentDeg(waitingTime));

create table Manage 
    (org_id int,
    transplantationID int,
    PRIMARY KEY (org_id, transplantationID),
    FOREIGN KEY (org_id) REFERENCES Organization(org_id)
    ON DELETE CASCADE,
    FOREIGN KEY (transplantationID) REFERENCES
    WaitingTransplantation(transplantationID)
    ON DELETE CASCADE);

create table Donor 
    (donorPhn int PRIMARY KEY,
    bloodType char(10) NOT NULL,
    donorStatus char(15) NOT NULL,
    donorPhone int UNIQUE,
    donorName char(50) NOT NULL,
    donorAge int,
    address char(80) NOT NULL,
    CHECK (donorStatus = 'alive' OR donorStatus = 'pass away'));

create table RegisterIn 
    (org_id int,
    donorPhn int,
    registrationType char(10) NOT NULL,
    registerDate char(20) NOT NULL,
    PRIMARY KEY(org_id, donorPhn),
    FOREIGN KEY (org_id) REFERENCES Organization(org_id)
    ON DELETE CASCADE,
    FOREIGN KEY (donorPhn) REFERENCES Donor(donorPhn)
    ON DELETE CASCADE,
    CHECK (registrationType = 'organ' OR registrationType = 'corneal'));

create table DonorFamilyContactPerson 
    (contactPhn int PRIMARY KEY,
    contactPhone int UNIQUE,
    email char(30) UNIQUE,
    contactName char(50) NOT NULL);

create table Has 
    (contactPhn int,
    donorPhn int,
    PRIMARY KEY (contactPhn, donorPhn),
    FOREIGN KEY (contactPhn) REFERENCES
    DonorFamilyContactPerson(contactPhn)
    ON DELETE CASCADE,
    FOREIGN KEY (donorPhn) REFERENCES Donor(donorPhn)
    ON DELETE CASCADE);

create table OrganTypeInfo 
    (organType char(30) PRIMARY KEY,
    organSuriveTime int NOT NULL,
    numTransTo int NOT NULL);

create table DonateOrgan 
    (organID int PRIMARY KEY,
    organStatus char(20) NOT NULL,
    organType char(30) NOT NULL,
    donorPhn int NOT NULL,
    FOREIGN KEY (donorPhn) REFERENCES Donor(donorPhn)
    ON DELETE CASCADE,
    FOREIGN KEY (organType) REFERENCES OrganTypeInfo(organType)
    ON DELETE CASCADE,
    CHECK (organStatus = 'available' OR organStatus = 'unavailable'));

create table Recipient 
    (recipientId int PRIMARY KEY,
    name char(50),
    phone int NOT NULL);

create table IndividualRecipientOperation 
    (recipientId int PRIMARY KEY,
    recipientName char(50),
    recipientPhone int NOT NULL,
    individualPhn int UNIQUE,
    hospital_id int NOT NULL,
    FOREIGN KEY (recipientId) REFERENCES Recipient(recipientId)
    ON DELETE CASCADE,
    FOREIGN KEY (hospital_id) REFERENCES Hospital(hospital_id)
    ON DELETE CASCADE);

create table LaboratoryRecipient 
    (recipientId int PRIMARY KEY,
    recipientName char(50),
    labAddress char(80) UNIQUE,
    recipientPhone int UNIQUE,
    FOREIGN KEY (recipientId) REFERENCES Recipient(recipientId)
    ON DELETE CASCADE);

create table Accept 
    (acceptDate char(20),
    organId int,
    recipientId int,
    PRIMARY KEY(organId, recipientId),
    FOREIGN KEY (recipientId) REFERENCES Recipient(recipientId)
    ON DELETE CASCADE,
    FOREIGN KEY (organId) REFERENCES DonateOrgan(organId)
    ON DELETE CASCADE);


insert into Organization
values(1, 'Vancouver', '6088 walter gage road', 'BC Transplant center');

insert into Organization
values(2, 'Beijing', '8783 Beijing Road', 'Beijing Transplant center');

insert into Organization
values(3, 'Henan', '7384 WenHua road', 'Henan Transplant center');

insert into Organization
values(4, 'Shanghai', '7783 Nanjing West road','Shanghai Transplant center');

insert into Organization
values(5, 'Vancouver', '88 hollywood road', 'BC EyeBank');

insert into OrganTransplantOrganization
values(2, 'China Organ research Foundation');

insert into OrganTransplantOrganization
values(1, 'BC Organ Transplant research Foundation');

insert into OrganTransplantOrganization
values(3, null);

insert into OrganTransplantOrganization
values(4, null);

insert into CornealTransplantOrganization
values(5, 'Jack B');

insert into Hospital
values(12, '5680 University Boulevard', 'UBC hospital');

insert into Hospital
values(65, '5738 Beijing Boulevard', 'Beijing hospital');

insert into Hospital
values(876, '1180 Zhengzhou Boulevard', 'Zhengzhou hospital');

insert into Hospital
values(234, '5680 shanghai Boulevard', 'Shanghai hospital');

insert into Hospital
values(132, '3380 No.3 Road', 'Richmond hospital');

insert into partnerWith values(1, 12);
insert into partnerWith values(1, 132);
insert into partnerWith values(5, 132);
insert into partnerWith values(2, 65);
insert into partnerWith values(4, 234);

insert into WaitingTimeMapUrgentDeg values(10000, 10);
insert into WaitingTimeMapUrgentDeg values(1, 1);
insert into WaitingTimeMapUrgentDeg values(8000, 8);
insert into WaitingTimeMapUrgentDeg values(9000, 9);
insert into WaitingTimeMapUrgentDeg values(3244, 4);
insert into WaitingTimeMapUrgentDeg values(0, 0);

insert into WaitingTransplantation values (1, 18, 'A', 1, 'liver', 'Sasa ');
insert into WaitingTransplantation values (2, 20, 'B', 10000,'kidney', 'Kelly');
insert into WaitingTransplantation values (3, 42, 'O', 8000,'corneal', 'Bibo');
insert into WaitingTransplantation values (4, 29, 'AB', 9000, 'lung','Kelly');
insert into WaitingTransplantation values (5, 77, 'O', 3244,'corneal', 'Cici');

insert into Manage values(1, 1);
insert into Manage values(2, 2);
insert into Manage values(2, 3);
insert into Manage values(3, 3);
insert into Manage values(4, 4);
insert into Manage values(5, 5);

insert into Donor values(12345, 'A', 'alive', 123767867, 'Lily',35, 'V6T1Z1');
insert into Donor values(23456, 'B', 'alive', 328247837, 'Coco', 21,'V6T1Z2');
insert into Donor values(34567,'O', 'alive', 23454545, 'Anna', 56,'V8Z1Z1');
insert into Donor values(45678, 'AB', 'pass away', 123723445, 'Someone', null, 'V6T1Z1');
insert into Donor values(56789, 'RHAB', 'pass away', 1321586, 'Rick', 61,'V6T1Z1');

insert into RegisterIn values(4, 12345, 'organ', '2022-08-01');
insert into RegisterIn values(2, 23456, 'organ', '2013-08-01');
insert into RegisterIn values(1, 34567, 'corneal', '2002-08-01');
insert into RegisterIn values(1, 45678, 'organ', '2012-09-21');
insert into RegisterIn values(5, 56789, 'corneal', '2019-01-01');
insert into RegisterIn values(4, 56789, 'organ', '2019-01-01');
insert into RegisterIn values(3,12345, 'corneal', '2019-01-01');

insert into DonorFamilyContactPerson values(12, 24254767, '143345@gmail.com', 'Kitty');
insert into DonorFamilyContactPerson values(34, 32652345, '245563@gmail.com', 'Jack');
insert into DonorFamilyContactPerson values(56, 2368754785, 'betty63@gmail.com', 'Betty');
insert into DonorFamilyContactPerson values(78, 77789654, 'kate63@gmail.com', 'Kate');
insert into DonorFamilyContactPerson values(90, 310876754, 'coco63@gmail.com', 'Coco');

insert into Has values(12, 12345);
insert into Has values(34, 23456);
insert into Has values(56, 34567);
insert into Has values(78, 45678);
insert into Has values(90, 56789);
insert into Has values(90, 45678);

insert into OrganTypeInfo values('heart', 30, 1);
insert into OrganTypeInfo values('lung', 60, 2);
insert into OrganTypeInfo values('kidney', 120, 2);
insert into OrganTypeInfo values('corneal', 100, 5);
insert into OrganTypeInfo values('liver', 35, 1);

insert into DonateOrgan values(1, 'available', 'heart', 12345);
insert into DonateOrgan values(6, 'available', 'lung', 12345);
insert into DonateOrgan values(7, 'available', 'kidney', 12345);
insert into DonateOrgan values(8, 'available', 'corneal', 12345);
insert into DonateOrgan values(9, 'available', 'liver', 12345);
insert into DonateOrgan values(2, 'unavailable', 'corneal', 23456);
insert into DonateOrgan values(3, 'available', 'kidney', 34567);
insert into DonateOrgan values(4, 'unavailable', 'lung', 45678);
insert into DonateOrgan values(5, 'available', 'kidney', 56789);

insert into Recipient values(1, 'kaka', 1233435);
insert into Recipient values(2, 'Bibo', 234545);
insert into Recipient values(3, 'Lala', 778735);
insert into Recipient values(4, 'Cici', 446574);
insert into Recipient values(5, 'Papi', 130655);
insert into Recipient values(678, 'UBC life lab', 25634589);
insert into Recipient values(778, 'SFUlife lab', 25653989);
insert into Recipient values(878, 'Uvic life lab', 1253989);
insert into Recipient values(978, 'UBC med lab', 224653989);
insert into Recipient values(378, 'UT life lab', 276546989);
insert into Recipient values(6, 'kiki', 633435);
insert into Recipient values(7, 'koko', 633445);


insert into IndividualRecipientOperation values(1, 'kaka', 1233435, 234, 12);
insert into IndividualRecipientOperation values(6, 'kiki', 633435, 235, 12);
insert into IndividualRecipientOperation values(7, 'koko', 633445, 245, 12);
insert into IndividualRecipientOperation values(2, 'Bibo', 234545, 334, 65);
insert into IndividualRecipientOperation values(3, 'Lala', 778735, 634, 876);
insert into IndividualRecipientOperation values(4, 'Cici', 446574, 934, 234);
insert into IndividualRecipientOperation values(5, 'Papi', 130655, 134, 132);

insert into LaboratoryRecipient values(678, 'UBC life lab', '6798 universityroad', 25634589);
insert into LaboratoryRecipient values(778, 'SFUlife lab', '8988 SFU road',25653989);
insert into LaboratoryRecipient values(878, 'Uvic life lab', '6238 Victoriaroad', 1253989);
insert into LaboratoryRecipient values(978, 'UBC med lab', '6799 university road', 224653989);
insert into LaboratoryRecipient values(378, 'UT life lab', '6798 Torontoroad', 276546989);
 
insert into Accept values('2022-09-06', 1, 1);
insert into Accept values('2021-08-06', 2, 2);
insert into Accept values('2020-07-06', 3, 678);
insert into Accept values('2010-09-16', 4, 878);
insert into Accept values('2018-09-26', 5, 978);
