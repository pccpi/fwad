**Лабораторная работа №1. Основы HTTP**

Целью данной лабораторной работы является изучение основных принципов протокола HTTP.


*Задание №1. Анализ HTTP-запросов*

1)Вход на сайт  [http://sandbox.usm.md/login.](http://sandbox.usm.md/login) с неверными данными username: student, password: studentpass.

2)Анализ запросов и ответы на вопросы

  1.Метод POST
  
  2.content-type:text/plain;charset=UTF-8
    accept:*/*
    content-length:37
    host:sandbox.usm.md
    user-agent:Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36
    
  3.username: student
    password: studentpass
    
  4. 401 Unauthorized    
  
  5. Content-Type: application/x-www-form-urlencoded; charset=UTF-8
     User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36
    Referer: http://sandbox.usm.md/login/
    Connection: keep-alive
    Accept: */*

3)Ввод верных данных для входа и ответы на вопросы

  1.Метод POST
  
  2.content-type:text/plain;charset=UTF-8
    accept:*/*
    content-length:32
    host:sandbox.usm.md
    user-agent:Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36
    
  3.username: admin
    password: password
    
  4. 401 Unauthorized  
  
  5. Content-Type: application/x-www-form-urlencoded; charset=UTF-8
     User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36
    Referer: http://sandbox.usm.md/login/
    Connection: keep-alive
    Accept: */*


*Задание №2. Составление HTTP-запросов*

1.
GET / HTTP/1.1
Host: sandbox.com
User-Agent: Dmitrii Marsalov

2.
POST /cars HTTP/1.1
Host: sandbox.com
Content-Type: application/x-www-form-urlencoded
User-Agent: Dmitrii Marsalov

make=Toyota&model=Corolla&year=2020

3.
PUT /cars/1 HTTP/1.1
Host: sandbox.com
Content-Type: application/json
User-Agent: Dmitrii Marsalov

{
  "make": "Toyota",
  "model": "Corolla",
  "year": 2021
}


4.
HTTP/1.1 200 OK
Content-Type: application/json
Content-Length: 47

{
  "status": "success",
  "data": {
    "make": "Toyota",
    "model": "Corolla",
    "year": 2020
  }
}


*Задание №3. Дополнительное задание. HTTP_Quest*

secret: CjkdGkpxTVJiUFlGVQ==





    

  
