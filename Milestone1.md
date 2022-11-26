# Project Description

- What is the domain of the application?
It is about organ donation and recipients management, in the healthcare area.

- What aspects of the domain are modeled by the database?
Our project plans to implement a database of the organ donation system. With the given available organ, our application aimed to provide suitable waiting patients. The application can be used by organizations to manage the organ donation and transplantation process.
The database focuses on the donor registration system in different organizations to respond to hospitals’ queries. Also, the database modeles the pairing process between organs and recipients with a waiting patients management system.

- Is this application domain suitable as a CPSC 304 project?
Yes.
Our database is about organ donation management and we focus on managing registered donors with corresponding organ transplant conditions and recipients. It will not focus on the hospital system.

- Database Specification

- What functionality will the database provide?
This database is designed to help the organ transplant organization to have better management on their donors and corresponding recipients while providing a clear view to process the transplant procedure.
It provides functionality that hospitals can get information about whether a person has registered as a donor from organizations after all life-saving efforts have been used and it is certain that this person will not survive. The database also has functionality that will assist organizations to filter and search suitable recipients with the given information. The database supports the information transform and update between organizations and hospitals.


Application Platform Description

- What platform will the final project be on?
The final project will use PHP as the platform to implement the user interface.

- What is your application technology stack?
We plan to use Oracle as our DBMS. (The combination of PHP/Oracle.) It may also contain HTML for UI and Java for application itself.

Comments:
Assume every Organ Transplant Organization has a unique name, that’s why we make name the primary key for Organization.
#PHN: personal health number, it is unique for each person.
Status attributes of Donor: alive/pass away 
Status attributes of Organ: used/ haven’t used
Some organs like the corneal can be transplanted to more than one recipient, so we decided to use many to many relationships between Organ and Recipient.
We choose to divide organizations into two different subclasses using ISA because some organizations only manage corneal tissue transplantation (eg: BC Eye Bank) which is separated from other organs. We choose to use “Organ” as the entity name which is general and contains all organs that can be transplanted including corneal.
