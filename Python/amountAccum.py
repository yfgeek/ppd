import sqlite3
import numpy as np
import matplotlib.mlab as mlab
import matplotlib as mpl
import matplotlib.pyplot as plt

conn = sqlite3.connect('LPLC 2.db')
c = conn.cursor()

c.execute('select 借款金额, count(借款金额) as 该金额累计 '
          'from lc1 '
          # 'where 借款金额 < 15000 '
          'group by 借款金额')

result = c.fetchall()

print(result)

xblist = []
yblist = []

for item in result:
    xblist.append(item[0])
    yblist.append(item[1])
#
# for item in xblist:
#     for

plt.plot(xblist, yblist, 'orange')
plt.title("Amount Ratio")
plt.xlabel("Amount")
plt.ylabel("Ratio")


plt.show()


