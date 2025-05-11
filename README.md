
# [WARRIORS](https://ashuksu.github.io/warriors/public)

<details>
  <summary>Click, to show Preview</summary>


  ![WARRIORS](https://raw.githubusercontent.com/ashuksu/warriors/refs/heads/main/preview.jpg)
</details>


---

## Live Server
(установить: sudo npm install -g live-server)
npm run sere

## встроенным PHP 
(8000 port)
npm run start

---

## Docker


имя: warriors (должно быть уникальным myapp, render-test-project
)
(если нужно изменить: стопнуть, удалить старый образ, переименовать, перебилдить)

### Собрать образ
npm run docker:build

### Запустить контейнер
(изменения в локальных файлах НЕ будут видны в контейнере)
(для проверки production-версии)
npm run docker:start

### Проверить работу контейнера
curl http://localhost:8080

## Запустить в режиме разработки 
(- изменения сразу видны в контейнере)
npm run docker:dev

---

## Дополнительно

### Остановить контейнер
npm run docker:stop

### Удалить старый образ
docker rmi myapp

---

## valet
(альтернатива на nginx)

установить valet, перейти в проект, имя проекта без _
define("APP_PATH", "/"); — должен указывать на /, если в корне проекта

valet park
припарковать проект (или директорию для проектов)

valet start
Запускает все службы Valet (nginx, dnsmasq, php и т.д.)
(sudo systemctl restart dnsmasq
valet restart)
http://name-project.test

valet open
Открывает проект в браузере

valet stop
Останавливает все службы
(интернет отпадет из-за стопа dnsmasq)

valet paths
Показывает директории, где работает park

valet restart
valet status
valet log
