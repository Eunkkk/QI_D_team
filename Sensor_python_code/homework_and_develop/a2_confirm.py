import sqlite3

conn = sqlite3.connect("aqi.db")
c = conn.cursor()
c.execute("SELECT * FROM history")
row = c.fetchall()
for r in row:
    print "{0}\n".format(r)
    #print '\t'
    #JSON_string = "{0} {1} {2} {3} {4} {5} {6}".format(r[0], r[1], r[2], r[3], r[4], r[5], r[6])
    #print (JSON_string)

conn.commit()
conn.close()

'''
import sqlite3
from datetime import datetime

conn = sqlite3.connect("aqi.db")
c = conn.cursor()

c.execute("CREATE TABLE IF NOT EXISTS history (time REAL PRIMARY KEY NOT NULL, temp REAL, sn1 REAL, sn2 REAL, sn3 REAL, sn4 REAL, pm25 REAL)")
c.execute("INSERT INTO history VALUES (1532, 24.523, 1.8764, 65.7817, 21.6671, 41.5976, 24.554)")
conn.commit()
conn.close()

#print "{0}".format(datetime.now())
'''
