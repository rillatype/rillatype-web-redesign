# Panduan Edit Tema Rillatype V2
## Tidak Perlu Buka HTML/CSS!

Semua editing bisa dari **wp-admin** tanpa sentuh kode.

---

## 📍 Lokasi Settings

### Appearance > Customize > Rillatype Settings

| Tab | Yang Bisa Di-Edit |
|-----|-------------------|
| **Colors** | Accent color, background, text, border |
| **Typography** | Font body, font heading |
| **Logo** | Logo text |
| **Footer** | Copyright text |
| **Social Links** | Instagram, Twitter, Pinterest, TikTok, Dribbble |

---

## 🎨 Ganti Warna

1. Buka **Appearance > Customize**
2. Klik **Rillatype Settings > Colors**
3. Ubah warna yang diinginkan
4. Klik **Publish**

### Warna yang Tersedia:
| Setting | Fungsi | Default |
|---------|--------|---------|
| Accent Color | Warna tombol, link, highlight | `#C1493A` (terracotta) |
| Background Color | Warna latar belakang | `#F4F2ED` (warm cream) |
| Text Color | Warna teks utama | `#1A1814` (dark charcoal) |
| Muted Text Color | Warna teks sekunder | `#8B877A` (muted brown) |
| Border Color | Warna garis pemisah | `#E2DDD3` (light border) |

---

## 🔤 Ganti Font

1. Buka **Appearance > Customize**
2. Klik **Rillatype Settings > Typography**
3. Pilih font yang diinginkan
4. Klik **Publish**

### Font Body Tersedia:
- System Fonts (Default, paling cepat)
- Plus Jakarta Sans
- Inter
- DM Sans
- Poppins
- Montserrat

### Font Heading Tersedia:
- Georgia (Default)
- Instrument Serif
- Playfair Display
- Same as Body Font

---

## 🖼️ Ganti Logo

### Logo Image (Recommended)
1. Buka **Appearance > Customize > Site Identity**
2. Klik **Select Logo**
3. Upload logo kamu
4. Klik **Publish**

### Logo Text (Fallback)
1. Buka **Appearance > Customize > Rillatype Settings > Logo**
2. Ubah **Logo Text**
3. Klik **Publish**

---

## 📝 Ganti Text Footer

1. Buka **Appearance > Customize > Rillatype Settings > Footer**
2. Ubah **Copyright Text**
3. Klik **Publish**

**Contoh:**
- `© 2026 Rillatype. All rights reserved.`
- `© 2026 My Font Studio`

Kosongkan untuk default: `© [tahun] Rillatype. All rights reserved.`

---

## 🔗 Ganti Social Links

1. Buka **Appearance > Customize > Rillatype Settings > Social Links**
2. Masukkan URL social media kamu
3. Klik **Publish**

### Yang Tersedia:
- Instagram
- Twitter / X
- Pinterest
- TikTok
- Dribbble

---

## 📱 Ganti Menu

1. Buka **Appearance > Menus**
2. Pilih **Primary Menu** atau **Footer Menu**
3. Tambah/hapus/edit menu items
4. Klik **Save Menu**

---

## 🧩 Widget (Sidebar/Footer)

1. Buka **Appearance > Widgets**
2. Tambah widget ke **Sidebar** atau **Footer Widgets**
3. Widget akan muncul di halaman yang sesuai

---

## 🛒 WooCommerce Settings

1. Buka **WooCommerce > Settings**
2. Tab **Products** —atur display produk
3. Tab **Checkout** —atur halaman checkout
4. Tab **Accounts** —atur halaman account

### Gambar Produk
1. Buka **WooCommerce > Settings > Products > Display**
2. Atur ukuran gambar produk di sini

---

## 🚫 TIDAK PERLU EDIT INI:

| File | Kenapa Tidak Perlu |
|------|-------------------|
| `header.php` | Sudah pakai `wp_nav_menu()` |
| `footer.php` | Sudah pakai Customizer |
| `style.css` | Hanya header comment |
| `functions.php` | Sudah include customizer |
| `front-page.php` | Kontrol dari ACF Options |

---

## 🔧 Jika Ingin Edit CSS (Advanced)

Jika kamu paham CSS, edit file:
- `assets/css/base.css` — Reset & variables
- `assets/css/main.css` — Component styles
- `assets/css/home.css` — Homepage styles
- `assets/css/woocommerce.css` — WooCommerce styles

**Tapi sebenarnya tidak perlu** — semua sudah bisa dari Customizer!

---

## ⚠️ Trouble Shooting

### Warna tidak berubah?
- Clear cache browser (Ctrl+Shift+R)
- Buka Appearance > Customize > Publish ulang

### Font tidak muncul?
- Pastikan koneksi internet aktif (Google Fonts)
- Atau pilih "System Fonts" untuk offline

### Logo tidak muncul?
- Pastikan ukuran logo tidak terlalu kecil
- Upload ulang di Appearance > Customize > Site Identity

---

**Terakhir diupdate:** 12 Juni 2026
