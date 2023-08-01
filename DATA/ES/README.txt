Folder ini berisi file-file untuk memindahkan data dari SQL ke Elastic Search

1. Folder bulk berisi beberapa text file. File-file ini berisi json yang sudah diformat agar bisa masuk secara bulk ke dalam ES

2. sqlToES.php merupakan gabungan dari file buatIndex.php, sql_to_txt.php, dan cobaisiESBULK.php
3. buatIndex.php berisi scipt untuk membuat index pada Elastic Search
4. sql_to_txt.php berisi script untuk membuat semua data di sql menjadi file text dalam folder bulk agar bisa dipindahkan ke ES
5. cobaisiESBULK.php berisi script untuk memasukkan semua text file ke ES

6. mapping_es_nested_completion.json berisi mapping ES yang dipakai

Catatan :
Jika memakai sqlToES.php tidak perlu menjalankan buatIndex.php, sql_to_txt.php, dan cobaisiESBULK.php

Dengan folder bulk, hanya perlu file cobaisiESBULK.php untuk memasukkan file-file ke dalam ES.
Folder bulk harus terletak pada directory yang sama dengan cobaisiESBULK.php atau sqlToES.php 
Folder mapping harus terletak pada directory yang sama dengan buatIndex.php atau sqlToES.php 
