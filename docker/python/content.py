import pymysql
import pandas as pd
import numpy as np
import sys


conn = pymysql.connect(host='h2774525.stratoserver.net',
                       user='dataintegration',
                       password='gis7&B85',
                       db='dataintegration',
                       charset='utf8')
curs = conn.cursor()

sql_ing = 'SELECT recipeID, NDB_No,NDB_name FROM ingredients WHERE (measure_algorithm> 0.5) AND recipeID IN (SELECT recipeID FROM all_merged_dataset_with_id_copy_and_priority WHERE priority = 1)'
tdata = pd.read_sql(sql_ing, conn)


def table(r_id, sdata):
    input_data = sdata[sdata.recipeID == r_id]
    out1 = []
    out2 = []

    for i in input_data.NDB_No:
        m_id = sdata.recipeID[sdata.NDB_No == i]
        m_id = m_id.drop_duplicates()
        for j in m_id:
            out1.append(j)
            out2.append(i)
    out_data = pd.DataFrame({'recipeID': out1, 'NDB_No': out2})
    out_data = out_data.drop(index=out_data.index[out_data.recipeID == r_id])
    return out_data


def recommend(r_id, amount, sdata):
    result_table = table(r_id, sdata)
    c_table = pd.DataFrame(result_table.recipeID.value_counts())
    r = list(c_table.index[c_table.recipeID == max(c_table.recipeID)-1])
    if len(r) > amount:
        r = r[:amount]
    if len(r) < amount:
        for i in range(1, max(c_table.recipeID) + 1):
            x = max(c_table.recipeID) - i
            y = list(c_table.index[c_table.recipeID == x])
            if len(r) + len(y) > amount:
                z = np.random.choice(y, size=amount - len(r), replace=False)
                for j in z:
                    r.append(j)
            else:
                for j in y:
                    r.append(j)
            if len(r) >= amount: break

    return r


result = recommend(sys.argv[1], sys.argv[2], tdata)
print(result)
