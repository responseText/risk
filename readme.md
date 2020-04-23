พัฒนาโดย framework laravel 5.7
เมื่อโหลดมาแล้ว ให้ทำการกำหนดค่าการเชื่อมต่อกับฐานข้อมูลที่ ไฟล์ .env.bak
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=risk
DB_USERNAME=root
DB_PASSWORD=****

เมื่อแก้ไขเสร็จให้ทำการบันทึก แล้วเปลียนชื่อไป โดยทำการการลบ .bak ออก ก็จะได้ไฟล์ .env 

ไฟล์สร้างฐานข้อมูลอยู่ที่ database/sql/risk.sql (เป็นฐานข้อมูลที่ใช้งานในองค์กรณ์เราเบื้องต้น)
