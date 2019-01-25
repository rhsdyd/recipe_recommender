import pymysql
import pandas as pd
import sys


conn = pymysql.connect(host='h2774525.stratoserver.net',
                       user='dataintegration',
                       password='gis7&B85',
                       db='dataintegration',
                       charset='utf8')


def save(p_recipeid, p_rating, p_user, p_conn):
    success = True
    rating = -1+((p_rating-1)/2)
    cursor = p_conn.cursor()
    sql = ('SELECT NDB_No FROM ingredients WHERE measure_algorithm > 0.5 AND recipeID = %d' % p_recipeid)
    data = pd.read_sql(sql, p_conn)
    for index, row in data.iterrows():
        tsql = ('SELECT rating, times_rated FROM user WHERE NDB_no = %d AND userID = %d' % (row['NDB_No'], p_user))
        rows = cursor.execute(tsql)
        tdata = cursor.fetchall()
        if rows < 1:
            wsql = ('INSERT INTO user VALUES (%d, %d, %d, %d)' % (p_user, row['NDB_No'], rating, 1))
            write = cursor.execute(wsql)
            p_conn.commit()
        else:
            timesrated = tdata[0][1] + 1
            trating = ((tdata[0][0] * (timesrated - 1)) + rating) / timesrated
            wsql = ('UPDATE user SET rating = %f, times_rated = %d WHERE NDB_no = %d AND userID = %d' %
                    (trating, timesrated, row['NDB_No'], p_user))
            write = cursor.execute(wsql)
            p_conn.commit()
    fsql = ('INSERT INTO user_history VALUES (%d, %d)' % (p_user, p_recipeid))
    write = cursor.execute(fsql)
    p_conn.commit()
    return success


def recommend(p_user, p_conn):
    cursor = p_conn.cursor()
    sql = ('SELECT DISTINCT recipeID FROM ingredients WHERE NDB_No IN (SELECT NDB_No FROM user WHERE userID = %d) AND '
           'recipeID NOT IN (SELECT recipeID FROM user_history WHERE userID = %d)' % (p_user, p_user))
    data = pd.read_sql(sql, p_conn)
	data = list(data['recipeID'])
	csql = ('SELECT recipeID, COUNT(NDB_No) FROM ingredients WHERE recipeID IN % GROUP BY recipeID'
                % row['recipeID'])
    cursor.execute(csql)
    cdata = cursor.fetchall()
    if len(data) > 5:
        data = data.sample(5)
    compare = []
    for index, row in data.iterrows():
        ssql = ('SELECT SUM(rating) FROM user WHERE userID = %d AND NDB_No IN '
                '(SELECT NDB_No FROM ingredients WHERE recipeID = %d)' % (p_user, row['recipeID']))
        cursor.execute(ssql)
        sdata = cursor.fetchall()
        
        score = sdata[0][0]/cdata[0][0]
        compare.append(score)
    r = data.iloc[compare.index(max(compare))]['recipeID']
    return r


result = recommend(1, conn)
#save(sys.argv[1], sys.argv[2], sys.argv[3], conn) # 1=recipeID, 2=rating, 3=userID
#result = recommend(sys.argv[3])
print(result)
