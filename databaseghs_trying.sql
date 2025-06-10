-- DATABASE & SELEKSI
CREATE DATABASE IF NOT EXISTS database_ghs;
USE database_ghs;

-- TABLE LOGIN
CREATE TABLE tblogin (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100),
  email VARCHAR(100),
  password VARCHAR(255)
);

CREATE TABLE tbadmin (
  id_admin INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL,
  password VARCHAR(255) NOT NULL
);
CREATE TABLE tbadmin (
  id_admin INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL,
  password VARCHAR(255) NOT NULL
);



CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama_customer VARCHAR(100),
  alamat VARCHAR(255),
  total DECIMAL(10,2),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- TABLE USERS (tambahan jika berbeda dari tblogin)
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL,
  password VARCHAR(255) NOT NULL
);

-- TABLE BARANG / PRODUK
CREATE TABLE IF NOT EXISTS barang (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_barang VARCHAR(100) NOT NULL,
  id_kategori INT NOT NULL,
  nama_barang VARCHAR(100) NOT NULL,
  merk VARCHAR(100),
  harga_beli VARCHAR(50),
  harga_jual VARCHAR(50),
  satuan_barang VARCHAR(50),
  stok INT,
  tgl_input DATETIME,
  tgl_update DATETIME
);

-- TABLE KATEGORI
CREATE TABLE IF NOT EXISTS kategori (
  id_kategori INT AUTO_INCREMENT PRIMARY KEY,
  nama_kategori VARCHAR(100) NOT NULL,
  tgl_input DATETIME
);

-- TABLE PRODUCTS
CREATE TABLE IF NOT EXISTS products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  price DECIMAL(10,2) NOT NULL
);

-- TABLE CHECKOUT
CREATE TABLE IF NOT EXISTS tbcheckout (
  id_pemesanan INT AUTO_INCREMENT PRIMARY KEY,
  id_user INT,
  nama_produk VARCHAR(100),
  total_harga VARCHAR(100),
  alamat_pemesanan TEXT,
  status_pemesanan VARCHAR(50),
  tanggal_pemesanan TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_user) REFERENCES tblogin(id_user)
);
