# Bilet Satın Alma Platformu

[![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
[![SQLite](https://img.shields.io/badge/SQLite-07405E?style=for-the-badge&logo=sqlite&logoColor=white)](https://www.sqlite.org/)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)](https://getbootstrap.com/)
[![Docker](https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white)](https://www.docker.com/)

Güvenli ve çok rollü bir otobüs bileti satış sistemi. Bu proje, Sibervatan Yavuzlar Takımı'nın bir parçası olarak, modern web teknolojilerini ve güvenli kodlama prensiplerini uygulamalı olarak öğrenmek amacıyla geliştirilmiştir.

## Proje Görselleri

### Ana Sayfa ve Sefer Arama
![Ana Sayfa](https://via.placeholder.com/800x400.png?text=Ana+Sayfa+Ekran+Görüntüsü)
*(Buraya projenizin ana sayfa ekran görüntüsünün URL'sini ekleyin)*

### Kullanıcı Paneli ve Biletler
![Kullanıcı Paneli](https://via.placeholder.com/800x400.png?text=Kullanıcı+Paneli+Ekran+Görüntüsü)
*(Buraya kullanıcı "Hesabım" sayfasının ekran görüntüsünün URL'sini ekleyin)*

## ✨ Temel Özellikler

-   **Çoklu Kullanıcı Rolü Yönetimi:** Ziyaretçi, Yolcu (User), Firma Yetkilisi (Firma Admin) ve Sistem Yöneticisi (Admin) rolleri.
-   **Güvenli Kullanıcı İşlemleri:** Kayıt olma, giriş yapma ve parola hashing ile güvenli kimlik doğrulama.
-   **Dinamik Sefer Yönetimi:** Firma yetkililerinin kendi seferlerini oluşturup yönetebileceği CRUD (Create, Read, Update, Delete) paneli.
-   **Güvenli Bilet Satın Alma ve İptal:** Kredi sistemi üzerinden bilet alımı, kalkış saatine 1 saat kala iptal engeli ve başarılı iptallerde otomatik iade.
-   **PDF Bilet Oluşturma:** Satın alınan biletlerin dinamik olarak PDF formatında indirilebilmesi.
-   **İndirim Kuponu Sistemi:** Adminlerin oluşturduğu kupon kodları ile indirim uygulama.
-   **Rol Bazlı Erişim Kontrolü:** Kullanıcıların sadece yetkili olduğu sayfalara ve verilere erişimi.

## 🛡️ Güvenlik Odaklı Geliştirme

Bu proje, sadece işlevsel olmakla kalmayıp, aynı zamanda yaygın web güvenlik zafiyetlerine karşı korunaklı olacak şekilde geliştirilmiştir. Öğrenme sürecimin merkezinde güvenlik yer aldı:

-   **SQL Injection'a Karşı Koruma:** Tüm veritabanı sorguları, kullanıcı girdilerini doğrudan sorguya eklemeden, **PDO Prepared Statements** kullanılarak gerçekleştirildi.
-   **XSS (Cross-Site Scripting) Önlemi:** Kullanıcıdan gelen veya veritabanından çekilen tüm veriler, ekrana basılırken **`htmlspecialchars()`** fonksiyonu ile temizlenerek zararlı kodların çalıştırılması engellendi.
-   **Güvenli Parola Saklama:** Kullanıcı parolaları asla düz metin olarak saklanmadı. PHP'nin **`password_hash()`** fonksiyonu ile hash'lenerek veritabanında güvenli bir şekilde muhafaza edildi.
-   **Oturum ve Yetkilendirme Yönetimi:** Güvenli session yönetimi ve rol bazlı erişim kontrolleri ile yetkisiz erişimler engellendi. Her kritik işlemde kullanıcının işlemi yapmaya yetkisi olup olmadığı kontrol edildi.

## 🛠️ Kullanılan Teknolojiler

-   **Backend:** PHP 8
-   **Frontend:** HTML5, CSS3, Bootstrap 5
-   **Veritabanı:** SQLite 3
-   **Paketleme & Dağıtım:** Docker, Docker Compose

## 🚀 Kurulum ve Çalıştırma

Projenin çalışan bir kopyasını yerel makinenizde çalıştırmak için Docker kullanmanız yeterlidir.

1.  Depoyu klonlayın:
    ```bash
    git clone https://github.com/KULLANICI_ADINIZ/bilet-satin-alma.git
    cd bilet-satin-alma
    ```

2.  Docker Compose ile projeyi çalıştırın:
    ```bash
    docker-compose up --build
    ```

3.  Tarayıcınızı açın ve `http://localhost:8080` adresine gidin.

## 📚 Bu Projede Ne Öğrendim?

Bu proje, benim için sadece bir kodlama egzersizi değil, aynı zamanda modern web geliştirmenin temel prensiplerini ve siber güvenliği uygulamalı olarak öğrenmemi sağlayan bir dönüm noktası oldu.

-   **PHP ile Uygulama Geliştirme:** Nesne yönelimli ve prosedürel PHP kullanarak dinamik web uygulamaları oluşturmayı öğrendim.
-   **Güvenli Kod Yazma:** SQL Injection, XSS gibi temel web saldırılarını ve bunlardan korunma yöntemlerini (Prepared Statements, input sanitization) derinlemesine anladım.
-   **Veritabanı Tasarımı ve Yönetimi:** SQLite kullanarak ilişkisel bir veritabanı şeması tasarladım, sorgular yazdım ve yönettim.
-   **Kimlik Doğrulama ve Yetkilendirme:** Session tabanlı giriş sistemleri ve rol bazlı erişim kontrolü gibi yetkilendirme mekanizmalarını sıfırdan kurdum.
-   **Modern Geliştirme Araçları:** Projemi Docker ile paketleyerek taşınabilir ve kolayca dağıtılabilir hale getirmeyi öğrendim.

## 📈 Gelecek Geliştirmeler

-   Gerçek zamanlı ödeme sistemi entegrasyonu (Iyzico, PayTR vb.).
-   Görsel otobüs koltuk haritası ve koltuk seçimi.
-   E-posta ile bilet gönderimi ve hatırlatmalar.
-   Daha detaylı raporlama ve analitik panelleri.

---

**Sibervatan Yavuzlar Takımı adına,**
**[Adınız Soyadınız]**

Made with ❤️ and PHP.
