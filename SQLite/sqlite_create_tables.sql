CREATE TABLE Firm (
	id_firm INTEGER PRIMARY KEY AUTOINCREMENT,
	name_firm text NOT NULL
);
CREATE TABLE Position (
	id_position INTEGER PRIMARY KEY AUTOINCREMENT,
	position text NOT NULL
);
CREATE TABLE Contract (
	id_contract INTEGER PRIMARY KEY AUTOINCREMENT,
	contract text NOT NULL,
	start_date text NOT NULL,
	expir_date text NOT NULL
);
CREATE TABLE Worker (
	id_worker INTEGER PRIMARY KEY AUTOINCREMENT,
	name_worker text NOT NULL,
	contract_id INTEGER NOT NULL,
	position_id INTEGER NOT NULL,

	FOREIGN KEY (contract_id)
	REFERENCES Contract (id_contract)
	ON UPDATE SET NULL
	ON DELETE SET NULL,

	FOREIGN KEY (position_id)
	REFERENCES Position (id_position)
	ON UPDATE SET NULL
	ON DELETE SET NULL
);
CREATE TABLE Projects(
	id_project INTEGER PRIMARY KEY AUTOINCREMENT,
	project text NOT NULL,
	id_responsible INTEGER NOT NULL,
	firm_id INTEGER NOT NULL,
	contract_id INTEGER NOT NULL,

	FOREIGN KEY (firm_id)
	REFERENCES Firm (id_firm)
	ON UPDATE SET NULL
	ON DELETE SET NULL,

	FOREIGN KEY (contract_id)
	REFERENCES Contract (id_contract)
	ON UPDATE SET NULL
	ON DELETE SET NULL
);
CREATE TABLE work_proj (
	worker_id INTEGER NOT NULL,
	project_id INTEGER NOT NULL,
	PRIMARY KEY (worker_id, project_id)
);
