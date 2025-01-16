# API Forwarder

Ini adalah script untuk melakukan forward request API ke host yang dituju.

## Instalasi

Cukup masukkan script `index.php` ke direktori hosting kamu. Juga agar semua request yang masuk dapat diarahkan ke `index.php` perlu dilakukan peenyesuain.

### Penyesuaian Apache

Untuk server Apache, dapat langsung memasukkan `.htaccess` di direktori yang saama dengan `index.php`

## Penggunaan

Untuk penggunaannya cukup mudah.

Misal, host untuk forwarder ini ada di https://forward.test.com dan endpoint yang ingin dipanggil adalah https://api-test.com/user/detail .

Maka yang perlu dilakukan ialah:
- endpoint : https://fwd.test.com/user/detail
- pada header tambahkan key "destination" dengan value "https://api-test.com"

| Original | Forwarded |
|---|---|
| ![Original](/img/original.png) | ![Forwarded](/img/forwarded.png) |
