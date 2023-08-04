#!/usr/bin/env python
# coding: utf-8

# In[47]:


pip install datetime


# In[48]:


pip install pandas


# In[49]:


pip install pymysql


# In[33]:


import pandas as pd


# In[34]:


xls_file = 'Downloads/SABDA.xlsx'
df = pd.read_excel(xls_file)
judul = df['judul']
tanggal = df['tanggal']
summary = df['summary']
shortDesc = df['short_desc']
unique = df['unique_code']
pertanyaan = df['Pertanyaan']

print(pertanyaan)


# In[52]:


import pymysql
from datetime import datetime

mysql_config = {
    'host': 'localhost',
    'database': 'sabda',
    'user': 'root',
    'password': '',
}

connection = pymysql.connect(**mysql_config)
cursor = connection.cursor()

def generate_update_sql_script(filename, unique, judul, tanggal, summary, shortDesc, pertanyaan):
    with open(filename, 'w', encoding='utf-8') as f:
        f.write('SET NAMES utf8;\n')
        f.write('SET CHARACTER SET utf8;\n')
        for index in range(len(unique)):
            update_query = "UPDATE sabda_list_youtube_done SET judul = '{0}', tanggal = '{1}', summary = '{2}', short_desc = '{3}', Pertanyaan = '{4}' WHERE unique_code = '{5}';\n".format(
                trim(escape_quotes(judul[index])), removeTime(tanggal[index]), trim(escape_quotes(summary[index])),
                trim(escape_quotes(shortDesc[index])), trim(escape_quotes(pertanyaan[index])), trim(escape_quotes(unique[index])))
            f.write(update_query)
def trim(text):
    if(text[0:1] == " "):
        text = text[1:]
    if(text[len(text) - 1 : len(text)] == " "):
        text = text[0 : len(text) - 1]
    return text

def escape_quotes(text):
    return text.replace("'", "\\'")

def removeTime(date_now):
    timestamp_data = pd.Timestamp(date_now)
    date_now = timestamp_data.strftime("%Y-%m-%d %H:%M:%S")
    datetime_obj = datetime.strptime(date_now, "%Y-%m-%d %H:%M:%S")
    formatted_date_str = datetime_obj.strftime("%Y-%m-%d")
    return formatted_date_str
generate_update_sql_script('update_query.sql',unique,judul,tanggal,summary,shortDesc,pertanyaan)


# In[41]:


def trim(text):
    if(text[0:1] == " "):
        text = text[1:]
    if(text[len(text) - 1 : len(text)] == " "):
        text = text[0 : len(text) - 1]
    return text
print(trim(" Halo "))


# In[ ]:




