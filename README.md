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
npm run php-serve

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

---