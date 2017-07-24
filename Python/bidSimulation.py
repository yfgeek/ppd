import sqlite3
import numpy as np
import matplotlib.mlab as mlab
import matplotlib as mpl
import matplotlib.pyplot as plt

conn = sqlite3.connect('LPLC 2.db')
c = conn.cursor()

bidUnit = 100
invesAmount = 500
invesCount = invesAmount/bidUnit

creditRate = ['A','B', 'D']
months = 12
successDate = '2015-01-04'
invesAmount = 2000

strTmp = '\' or 初始评级 = \''
sqlCreditStr = '(初始评级 = \''+strTmp.join(creditRate) + '\')'

# print(sqlCreditStr)

sql = 'select listingid, 借款金额 from lc1 where ' + sqlCreditStr + ' and 借款期限 = ' + str(months) + ' and 借款成功日期 = \'' + successDate + '\''

print(sql)

c.execute(sql)

result = c.fetchall()

print(result)

idList = []
amountList = []

for item in result:
    idList.append(item[0])
    amountList.append(item[1])

amountSum = sum(amountList)
print(amountSum)



def getTermlyInterSql(listingid, term):
    return('select (应还利息-剩余利息) as 已还利息 from normalRepay where listingid = ' + str(listingid) + ' and 期数 = ' + str(term) )
# print(getTermlyInterSql(126541, 1))



# c.execute(getTermlyInterSql(126541, 1))
# print(c.fetchall())

termlyInter= 0
interList = []
tmpInterList = []

for term in range(1, months+1):
    for lId in idList:
        sqlTermlyInter = getTermlyInterSql(lId, term)
        c.execute(sqlTermlyInter)
        result = c.fetchone()

        if result:
            print(result)
            tmpInterList.append(result[0])

    print(tmpInterList)
    interList.append(sum(tmpInterList))
    # print(interList[term-1])
    tmpInterList[:] = []

print(len(interList))
# print(interList)

def getTermlyLate(listingid):
    return('select 已还利息, newTerm from newlaterepay where listingid = \'' + str(listingid)+'\'')

def addTermlyLate(result):
    for item in result:
        if(item[1]<13):
            interList[int(item[1]-1)] += item[0]

lateinter = []
lateterm = []

for id in idList:
    termlyLateSql = getTermlyLate(id)
    c.execute(termlyLateSql)
    result=c.fetchall()
    addTermlyLate(result)
print(interList)

fenzi = interList

def getNewBadDebtSql(listingid):
    return('select 坏账始期, 坏账额 from baddebtstart where listingid = ' + str(listingid))

newBadDebtTerm = []
newBadDebtAmount = []

for id in idList:
    newBadDebtSql = getNewBadDebtSql(id)
    c.execute(newBadDebtSql)
    result = c.fetchall()
    for item in result:
        # newBadDebtTerm.append(item[0])
        # newBadDebtAmount.append(item[1])
        if(item[0]<13):
            fenzi[item[0] - 1] -= item[1]

print('The numerator array is:')
print(fenzi)

# fenmu = []

newFenzi = [0]*months
for i in range(0,months):
    for j in range(0,i):
        newFenzi[i] += fenzi[j]
    newFenzi[i] *= invesAmount/amountSum


plt.ylim(0, np.max(newFenzi))
plt.plot(range(len(newFenzi)),newFenzi)

plt.title("Accumulated Interest of Given Creditcodes and Terms")
plt.xlabel("Term")
plt.ylabel("Accumulated Interest")

plt.show()


