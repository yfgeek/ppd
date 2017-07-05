import sqlite3
import numpy as np
import matplotlib.mlab as mlab
import matplotlib as mpl
import matplotlib.pyplot as plt

conn = sqlite3.connect('LPLC 2.db')
c = conn.cursor()




c.execute('select 借款利率, count(借款利率) as 该利率累计 '
          'from lc1 '
          'group by 借款利率')

result = c.fetchall()

print(result)

xblist = []
yblist = []

for item in result:
    xblist.append(item[0])
    yblist.append(item[1])


plt.bar(range(len(yblist)), yblist, fc='red')
plt.title("Rate Ratio")
plt.xlabel("Rate")
plt.ylabel("Ratio")


plt.show()


