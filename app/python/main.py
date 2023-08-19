import mysql.connector
from configparser import ConfigParser

def read_db_config(filename='db_config.ini', section='mysql'):
    parser = ConfigParser()
    parser.read(filename)

    db_params = {}
    if parser.has_section(section):
        for param in parser.items(section):
            db_params[param[0]] = param[1]
    else:
        raise Exception(f"Section {section} not found in {filename}")

    return db_params

try:
    db_config = read_db_config()
    connection = mysql.connector.connect(**db_config)
    cursor = connection.cursor()

    cursor.callproc("generateBills")

    connection.commit()
    cursor.close()
    connection.close()
    print("Stored procedure executed successfully.")

except mysql.connector.Error as err:
    print("Error:", err)
