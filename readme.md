# Bilet Satın Alma Platformu

Güvenli ve çok rollü bir otobüs bileti satış sistemi. Bu proje, Sibervatan Yavuzlar Takımı'nın bir parçası olarak, modern web teknolojilerini ve güvenli kodlama prensiplerini uygulamalı olarak öğrenmek amacıyla geliştirilmiştir.


## ✨ Temel Özellikler

- Ziyaretçi, Yolcu (User), Firma Yetkilisi (Firma Admin) ve Sistem Yöneticisi (Admin) rolleri.
- Kayıt olma, giriş yapma ve parola hashing ile güvenli kimlik doğrulama.
- Firma yetkililerinin kendi seferlerini oluşturup yönetebileceği paneli.
- Kredi sistemi üzerinden bilet alımı, kalkış saatine 1 saat kala iptal engeli ve başarılı iptallerde otomatik iade.
- Satın alınan biletlerin dinamik olarak PDF formatında indirilebilmesi.
- Adminlerin oluşturduğu kupon kodları ile indirim uygulama.
- Kullanıcıların sadece yetkili olduğu sayfalara ve verilere erişimi.

## 🛡️ Güvenlik Odaklı Geliştirme

Bu proje, sadece işlevsel olmakla kalmayıp, aynı zamanda yaygın web güvenlik zafiyetlerine karşı korunaklı olacak şekilde geliştirilmiştir. Öğrenme sürecimin merkezinde güvenlik yer aldı:

-   Tüm veritabanı sorguları, kullanıcı girdilerini doğrudan sorguya eklemeden, **PDO Prepared Statements** kullanılarak gerçekleştirildi.
-   Kullanıcıdan gelen veya veritabanından çekilen tüm veriler, ekrana basılırken **`htmlspecialchars()`** fonksiyonu ile temizlenerek zararlı kodların çalıştırılması engellendi.
-   Kullanıcı parolaları asla düz metin olarak saklanmadı. PHP'nin **`password_hash()`** fonksiyonu ile hash'lenerek veritabanında güvenli bir şekilde muhafaza edildi.
-   Güvenli session yönetimi ve rol bazlı erişim kontrolleri ile yetkisiz erişimler engellendi. Her kritik işlemde kullanıcının işlemi yapmaya yetkisi olup olmadığı kontrol edildi.

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

-   Nesne yönelimli ve prosedürel PHP kullanarak dinamik web uygulamaları oluşturmayı öğrendim.
-   SQL Injection, XSS gibi temel web saldırılarını ve bunlardan korunma yöntemlerini (Prepared Statements, input sanitization) derinlemesine anladım.
-   SQLite kullanarak ilişkisel bir veritabanı şeması tasarladım, sorgular yazdım ve yönettim.
-   Session tabanlı giriş sistemleri ve rol bazlı erişim kontrolü gibi yetkilendirme mekanizmalarını sıfırdan kurdum.
-   Projemi Docker ile paketleyerek taşınabilir ve kolayca dağıtılabilir hale getirmeyi öğrendim.
