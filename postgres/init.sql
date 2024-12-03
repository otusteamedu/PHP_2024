CREATE TABLE Departments (
    id SERIAL PRIMARY KEY,
    name TEXT,
);

CREATE TABLE Users (
    id SERIAL PRIMARY KEY,
    name TEXT,
    email TEXT,
    post TEXT,
    FOREIGN KEY (departmentId) REFERENCES Departments (id)
);