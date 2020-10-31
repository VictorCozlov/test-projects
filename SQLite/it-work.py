import sqlite3
from os import system, name
import time
from datetime import datetime, date

#clear function 
def clear():
    if name =='nt':
        _=system('clear')
    else:
        _=system('clear')

def view_table(sql):
    sql_select = (sql)
    cursor.execute(sql_select)
            
    rows = cursor.fetchall()
    for line in rows:
        print(line)

def view_raw_table(table):
    sql_select = ("SELECT * FROM {}").format(table)
    cursor.execute(sql_select)
            
    rows = cursor.fetchall()
    for line in rows:
        print(line)

def last_id(table, col):
    sql_select = ("SELECT {} FROM {} ORDER BY {} DESC LIMIT 1").format(col, table, col)
    cursor.execute(sql_select)

    line = cursor.fetchone()
    for id in line:
        return id

try:
    sqliteConnection = sqlite3.connect('SQLite_worker.db')
    cursor = sqliteConnection.cursor()
    print("Successfully  connected to SQLite")
# initialize menu options
    menu = {}

    menu['1'] = "Initialize Database"
    menu['2'] = "Add Worker"
    menu['3'] = "Add Position"
    menu['4'] = "Add Firm"
    menu['5'] = "Add Contract"
    menu['6'] = "Add Projects"
    menu['7'] = "view raw Table data"
    menu['8'] = "Add Warkers to project"
    menu['9'] = "Reports"
    menu['0'] = "Exit"

    while True:
        clear()
        options=menu.keys()
        
        for entry in options:
            print(entry, menu[entry])

        selection = input("Execute:  ")

        if selection == '1': #**********************************************
            
            with open('C:/Users/Admin/git@github.com-VictorCozlov/test-projects/sqlite_create_tables.sql', 'r') as sqlite_file:
                sql_script = sqlite_file.read()

            cursor.executescript(sql_script)
            print("Database is initialized")
            

        elif selection == '2': #******************************************
            worker = input("Worker name:  ")
            view_table("SELECT * FROM Position")
            position = input("give position:  ")
            view_table("SELECT * FROM Contract")
            contractid = input("give contract id:  ")
            sql_insert = ("""INSERT INTO Worker 
                            (name_worker, contract_id, position_id)
                            VALUES ('{}', {}, {})""").format(worker, int(contractid), int(position))
            cursor.execute(sql_insert)
            sqliteConnection.commit() #save changes
            print ("successfully added")

 
        elif selection == '3':
            pos = input("Position:  ")
            sql_insert = ("INSERT INTO Position (position) VALUES ('{}')").format(pos)
            cursor.execute(sql_insert)
            sqliteConnection.commit() #save changes
            print ("{} successfully added".format(pos) )

        elif selection =='4':
            inp = input("Firm:  ")
            sql_insert = ("INSERT INTO Firm (name_firm) VALUES ('{}')").format(inp)
            cursor.execute(sql_insert)
            sqliteConnection.commit() #save changes
            print ("{} successfully added".format(inp))

        elif selection =='5':
            contract = input("Contract name: ")
            print ("date format YY-MM-DD")
            start = input("Contract start date:  ")
            expir = input("Contract expiration date:  ")
            sql_insert = ("""INSERT INTO Contract 
                            (contract, expir_date, start_date)
                            VALUES ('{}', '{}', '{}')""").format(contract, expir, start)
            cursor.execute(sql_insert)
            sqliteConnection.commit() #save changes
            print ("successfully added")

        elif selection =='6':
            proj = input("Project name:  ")
            view_table("""SELECT id_worker, name_worker, position
                            FROM Worker
                            LEFT JOIN Position
                            ON Worker.position_id = Position.id_position""")
            responsible = input("Choose responsible:  ")
            view_table("SELECT * FROM Firm")
            firmid = input("give Firm id:  ")
            view_table("SELECT * FROM Contract")
            contractid = input("give contract id:  ")
            sql_insert = ("""INSERT INTO Projects 
                            (project, id_responsible, firm_id, contract_id)
                            VALUES ('{}', {}, {}, {})""").format(proj, int(responsible), int(firmid), int(contractid))
            cursor.execute(sql_insert)
            sqliteConnection.commit() #save changes
            print ("successfully added")

        elif selection == '7':
            tabl = input("Give the table:  ")
            view_raw_table(tabl)
            input("")
        
        elif selection == '8':
            view_table("Select id_project, project FROM Projects")
            projid = input("Give a project:  ")
            sql = ("""SELECT id_worker, name_worker, position
                            FROM Worker
                            LEFT JOIN Position
                            ON Worker.position_id = Position.id_position
                            WHERE id_worker NOT IN
                            (SELECT worker_id FROM work_proj 
                            WHERE project_id={})""").format(int(projid))
            quest = "y"
            while quest=="y":
                clear()
                view_table(sql)
                user = input("give user id:  ")
                quest = input("some more y/n: ")
                sql_insert = ("""INSERT INTO work_proj 
                                (worker_id, project_id)
                                VALUES ({}, {})""").format(int(user), int(projid))
                cursor.execute(sql_insert)
                sqliteConnection.commit() #save changes
            print("Workers succesfully added")

        elif selection == '9':
            repo = {}

            repo['1'] = "All projects"
            repo['2'] = "Active projects"
            repo['3'] = "Workers of the active projects"
            repo['0'] = "Exit"

            while True:
                clear()
                options2 = repo.keys()

                for element in options2:
                    print(element, repo[element])

                choice = input("Execute:  ")

                if choice == '1':
                    view_table("""SELECT id_project, project, name_worker, name_firm, contract, start_date, expir_date 
                                    FROM Projects
                                    LEFT JOIN Worker
                                    ON id_responsible = id_worker
                                    LEFT JOIN Firm
                                    ON firm_id = id_firm
                                    LEFT JOIN Contract
                                    ON Projects.contract_id = id_contract""")
                elif choice == '2':
                    today = date.today()
                    sql = ("""SELECT id_project, project, name_worker, name_firm, contract, start_date, expir_date 
                                    FROM Projects
                                    LEFT JOIN Worker
                                    ON id_responsible = id_worker
                                    LEFT JOIN Firm
                                    ON firm_id = id_firm
                                    LEFT JOIN Contract
                                    ON Projects.contract_id = id_contract
                                    WHERE '{}'
                                    BETWEEN date(start_date) AND date(expir_date)""").format(today)
                    view_table(sql)
                elif choice == '3':
                    today = date.today()
                    sql = ("""SELECT id_project, project, name_worker, start_date, expir_date 
                                    FROM work_proj
                                    LEFT JOIN Worker
                                    ON worker_id = id_worker
                                    LEFT JOIN Projects
                                    ON project_id = id_project
                                    LEFT JOIN Contract
                                    ON Projects.contract_id = id_contract
                                    WHERE '{}'
                                    BETWEEN date(start_date) AND date(expir_date)""").format(today)
                    view_table(sql)

                elif choice == '0':
                    break
                else:
                    print("Unexpected selection")
        elif selection =='0':
            break
        else:
            print("Unknown selection!")

    cursor.close()


except sqlite3.Error as error:
    print("Error while executing script", error)
finally:
    if(sqliteConnection):
        sqliteConnection.close()
        print("sqlite connection is closed")
