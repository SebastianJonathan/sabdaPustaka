Folder ini berisi file-file untuk memindahkan data dari SQL ke Elastic Search

Langkah-langkah:
1. Membuat Index dengan mapping
2. Menarik data SQL & mengubahnya ke dalam bentuk json di text file
3. Mengubah semua data dalam text file ke ES

----------------

HALAMAN UTAMA ==> home_.php

Di dalam halaman ini, ada berbagai variabel config untuk ES, SQL, Mapping json, dan text file Directory

Di dalam halaman ini, dapat diatur ingin menjalankan langkah mana saja dengan 3 variabel (true/false)
- $is_buat_index ==> langkah 1
- $is_sql_to_txt ==> langkah 2
- $is_txt_to_es ==> langkah 3

-----------------

Halaman function_main.php berisi 3 fungsi yang diaktifkan dalam halaman utama

Halaman function_helper.php berisi fungsi-fungsi yang akan dipanggil oleh 3 fungsi pada halaman function_main.php


