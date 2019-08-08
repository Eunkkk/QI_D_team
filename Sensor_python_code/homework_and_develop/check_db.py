import sqlite3

conn = sqlite3.connect("aqi.db")
c = conn.cursor()
c.execute("SELECT * FROM history")
row = c.fetchall()
for r in row:
    print row
    print '\n'
    #JSON_string = "{0} {1} {2} {3} {4} {5} {6}".format(r[0], r[1], r[2], r[3], r[4], r[5], r[6])
    #print (JSON_string)

conn.commit()
conn.close()


# c.execute("CREATE TABLE IF NOT EXISTS history(time INT PRIMARY KEY NOT NULL, "
#           "TEMP REAL, sn1 REAL. sn2 REAL, sn3 REAL, sn4 REAL, pm25 REAL)")
# c.excute("INSERT INTO  history VALUES (1, 25, 30))")
# conn.comit()
# conn.close